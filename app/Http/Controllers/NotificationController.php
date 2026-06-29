<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        return view('notifications.index', [
            'notifications' => $request->user()
                ->notifications()
                ->latest()
                ->paginate(15),
            'unreadCount' => $request->user()->unreadNotifications()->count(),
        ]);
    }

    public function open(Request $request, string $notification): RedirectResponse
    {
        $item = $request->user()
            ->notifications()
            ->whereKey($notification)
            ->firstOrFail();

        if (is_null($item->read_at)) {
            $item->markAsRead();
        }

        $targetUrl = (string) data_get($item->data, 'url', route('notifications.index'));

        if (! str_starts_with($targetUrl, url('/'))) {
            $targetUrl = route('notifications.index');
        }

        return redirect()->to($targetUrl);
    }

    public function markAsRead(Request $request, string $notification): RedirectResponse
    {
        $item = $request->user()
            ->notifications()
            ->whereKey($notification)
            ->firstOrFail();

        $item->markAsRead();

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function markAllAsRead(Request $request): RedirectResponse
    {
        $request->user()->unreadNotifications()->update([
            'read_at' => now(),
        ]);

        return back()->with('success', 'Semua notifikasi telah ditandai sudah dibaca.');
    }

    public function destroy(Request $request, string $notification): RedirectResponse
    {
        $item = $request->user()
            ->notifications()
            ->whereKey($notification)
            ->firstOrFail();

        $item->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    public function clearRead(Request $request): RedirectResponse
    {
        $request->user()->readNotifications()->delete();

        return back()->with('success', 'Notifikasi yang sudah dibaca berhasil dibersihkan.');
    }
}
