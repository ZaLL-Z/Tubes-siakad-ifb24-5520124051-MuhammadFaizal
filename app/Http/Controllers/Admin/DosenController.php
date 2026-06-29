<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DosenController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $dosens = Dosen::query()
            ->when($search, function ($query) use ($search) {
                $query->where('nidn', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%");
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.dosen.index', compact('dosens', 'search'));
    }

    public function create(): View
    {
        return view('admin.dosen.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nidn' => ['required', 'string', 'max:10', 'unique:dosens,nidn'],
            'nama' => ['required', 'string', 'max:50'],
        ]);

        Dosen::create($validated);

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function edit(Dosen $dosen): View
    {
        return view('admin.dosen.edit', compact('dosen'));
    }

    public function update(Request $request, Dosen $dosen): RedirectResponse
    {
        $validated = $request->validate([
            'nidn' => [
                'required',
                'string',
                'max:10',
                Rule::unique('dosens', 'nidn')->ignore($dosen->nidn, 'nidn'),
            ],
            'nama' => ['required', 'string', 'max:50'],
        ]);

        // NIDN sengaja tidak diubah agar relasi dengan mahasiswa/jadwal tetap aman.
        $dosen->update(['nama' => $validated['nama']]);

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy(Dosen $dosen): RedirectResponse
    {
        if ($dosen->mahasiswas()->exists() || $dosen->jadwals()->exists()) {
            return back()->with('error', 'Dosen tidak dapat dihapus karena masih terhubung dengan mahasiswa atau jadwal.');
        }

        $dosen->delete();

        return back()->with('success', 'Data dosen berhasil dihapus.');
    }
}
