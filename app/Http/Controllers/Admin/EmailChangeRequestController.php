<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailChangeRequest;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EmailChangeRequestController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $status = (string) $request->query('status', 'pending');
        $allowedStatuses = ['all', 'pending', 'approved', 'rejected', 'cancelled'];

        if (! in_array($status, $allowedStatuses, true)) {
            $status = 'pending';
        }

        $emailRequests = EmailChangeRequest::with(['user', 'reviewer'])
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('old_email', 'like', "%{$search}%")
                        ->orWhere('new_email', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.email-change-requests.index', compact(
            'emailRequests',
            'search',
            'status'
        ));
    }

    public function approve(EmailChangeRequest $emailChangeRequest): RedirectResponse
    {
        if (! $emailChangeRequest->isPending()) {
            return back()->withErrors([
                'email_request' => 'Permintaan ini sudah diproses sebelumnya.',
            ]);
        }

        $emailChangeRequest->load('user');

        if (! $emailChangeRequest->user) {
            return back()->withErrors([
                'email_request' => 'Akun pengguna sudah tidak tersedia.',
            ]);
        }

        if ($emailChangeRequest->user->email !== $emailChangeRequest->old_email) {
            return back()->withErrors([
                'email_request' => 'Email akun pengguna sudah berubah. Permintaan ini tidak dapat disetujui.',
            ]);
        }

        $emailAlreadyUsed = User::where('email', $emailChangeRequest->new_email)
            ->where('id', '!=', $emailChangeRequest->user_id)
            ->exists();

        if ($emailAlreadyUsed) {
            return back()->withErrors([
                'email_request' => 'Email baru sudah digunakan oleh akun lain.',
            ]);
        }

        DB::transaction(function () use ($emailChangeRequest): void {
            $emailChangeRequest->user->forceFill([
                'email' => $emailChangeRequest->new_email,
                'email_verified_at' => null,
            ])->save();

            $emailChangeRequest->update([
                'status' => 'approved',
                'admin_note' => 'Permintaan disetujui administrator.',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);
        });

        $emailChangeRequest->user->notify(new SystemNotification(
            title: 'Perubahan email disetujui',
            message: 'Email akun Anda berhasil diubah menjadi '.$emailChangeRequest->new_email.'.',
            icon: 'bi-envelope-check-fill',
            type: 'success',
            url: route('profile.show'),
        ));

        return back()->with('success', 'Perubahan email berhasil disetujui.');
    }

    public function reject(Request $request, EmailChangeRequest $emailChangeRequest): RedirectResponse
    {
        if (! $emailChangeRequest->isPending()) {
            return back()->withErrors([
                'email_request' => 'Permintaan ini sudah diproses sebelumnya.',
            ]);
        }

        $validated = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:500'],
        ]);

        $note = $validated['admin_note'] ?: 'Permintaan ditolak administrator.';

        $emailChangeRequest->update([
            'status' => 'rejected',
            'admin_note' => $note,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        $emailChangeRequest->user?->notify(new SystemNotification(
            title: 'Perubahan email ditolak',
            message: 'Permintaan perubahan email Anda ditolak. Alasan: '.$note,
            icon: 'bi-envelope-x-fill',
            type: 'danger',
            url: route('profile.show'),
        ));

        return back()->with('success', 'Permintaan perubahan email telah ditolak.');
    }
}
