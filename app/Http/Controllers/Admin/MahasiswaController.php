<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $mahasiswas = Mahasiswa::with(['dosen', 'user'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('npm', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($userQuery) => $userQuery->where('email', 'like', "%{$search}%"));
                });
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.mahasiswa.index', compact('mahasiswas', 'search'));
    }

    public function create(): View
    {
        return view('admin.mahasiswa.create', [
            'dosens' => Dosen::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'npm' => ['required', 'string', 'max:10', 'unique:mahasiswas,npm'],
            'nama' => ['required', 'string', 'max:50'],
            'nidn' => ['required', 'exists:dosens,nidn'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'mahasiswa',
            ]);

            Mahasiswa::create([
                'npm' => $validated['npm'],
                'user_id' => $user->id,
                'nidn' => $validated['nidn'],
                'nama' => $validated['nama'],
            ]);
        });

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa dan akun login berhasil ditambahkan.');
    }

    public function edit(Mahasiswa $mahasiswa): View
    {
        $mahasiswa->load('user');

        return view('admin.mahasiswa.edit', [
            'mahasiswa' => $mahasiswa,
            'dosens' => Dosen::orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        $validated = $request->validate([
            'npm' => ['required', 'string', 'max:10', Rule::unique('mahasiswas', 'npm')->ignore($mahasiswa->npm, 'npm')],
            'nama' => ['required', 'string', 'max:50'],
            'nidn' => ['required', 'exists:dosens,nidn'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($mahasiswa->user_id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        DB::transaction(function () use ($validated, $mahasiswa) {
            $mahasiswa->update([
                'nama' => $validated['nama'],
                'nidn' => $validated['nidn'],
            ]);

            $userData = [
                'name' => $validated['nama'],
                'email' => $validated['email'],
            ];

            if (! empty($validated['password'])) {
                $userData['password'] = $validated['password'];
            }

            $mahasiswa->user->update($userData);
        });

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa): RedirectResponse
    {
        DB::transaction(function () use ($mahasiswa) {
            $user = $mahasiswa->user;


            $mahasiswa->delete();
            $user?->delete();
        });

        return back()->with('success', 'Data mahasiswa dan akun login berhasil dihapus.');
    }
}
