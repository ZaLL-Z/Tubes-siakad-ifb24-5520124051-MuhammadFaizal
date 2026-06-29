<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MataKuliahController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $mataKuliahs = MataKuliah::query()
            ->when($search, function ($query) use ($search) {
                $query->where('kode_matakuliah', 'like', "%{$search}%")
                    ->orWhere('nama_matakuliah', 'like', "%{$search}%");
            })
            ->orderBy('nama_matakuliah')
            ->paginate(10)
            ->withQueryString();

        return view('admin.mata-kuliah.index', compact('mataKuliahs', 'search'));
    }

    public function create(): View
    {
        return view('admin.mata-kuliah.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_matakuliah' => ['required', 'string', 'max:8', 'unique:mata_kuliahs,kode_matakuliah'],
            'nama_matakuliah' => ['required', 'string', 'max:50'],
            'sks' => ['required', 'integer', 'min:1', 'max:6'],
        ]);

        MataKuliah::create($validated);

        return redirect()->route('admin.mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function edit(MataKuliah $mataKuliah): View
    {
        return view('admin.mata-kuliah.edit', compact('mataKuliah'));
    }

    public function update(Request $request, MataKuliah $mataKuliah): RedirectResponse
    {
        $validated = $request->validate([
            'kode_matakuliah' => [
                'required',
                'string',
                'max:8',
                Rule::unique('mata_kuliahs', 'kode_matakuliah')->ignore($mataKuliah->kode_matakuliah, 'kode_matakuliah'),
            ],
            'nama_matakuliah' => ['required', 'string', 'max:50'],
            'sks' => ['required', 'integer', 'min:1', 'max:6'],
        ]);

        $mataKuliah->update([
            'nama_matakuliah' => $validated['nama_matakuliah'],
            'sks' => $validated['sks'],
        ]);

        return redirect()->route('admin.mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function destroy(MataKuliah $mataKuliah): RedirectResponse
    {
        if ($mataKuliah->jadwals()->exists() || $mataKuliah->krs()->exists()) {
            return back()->with('error', 'Mata kuliah tidak dapat dihapus karena masih dipakai pada jadwal atau KRS.');
        }

        $mataKuliah->delete();

        return back()->with('success', 'Mata kuliah berhasil dihapus.');
    }
}
