<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KrsController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $daftarKrs = Krs::with(['mahasiswa', 'mataKuliah'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('npm', 'like', "%{$search}%")
                        ->orWhere('kode_matakuliah', 'like', "%{$search}%")
                        ->orWhereHas('mahasiswa', fn ($mhs) => $mhs->where('nama', 'like', "%{$search}%"))
                        ->orWhereHas('mataKuliah', fn ($mk) => $mk->where('nama_matakuliah', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.krs.index', compact('daftarKrs', 'search'));
    }

    public function create(): View
    {
        return view('admin.krs.create', [
            'mahasiswas' => Mahasiswa::orderBy('nama')->get(),
            'mataKuliahs' => MataKuliah::orderBy('nama_matakuliah')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'npm' => ['required', 'exists:mahasiswas,npm'],
            'kode_matakuliah' => ['required', 'exists:mata_kuliahs,kode_matakuliah'],
        ]);

        $sudahAda = Krs::where('npm', $validated['npm'])
            ->where('kode_matakuliah', $validated['kode_matakuliah'])
            ->exists();

        if ($sudahAda) {
            return back()->withInput()->with('error', 'Mata kuliah tersebut sudah ada pada KRS mahasiswa.');
        }

        Krs::create($validated);

        return redirect()->route('admin.krs.index')
            ->with('success', 'KRS mahasiswa berhasil ditambahkan.');
    }

    public function destroy(Krs $krs): RedirectResponse
    {
        $krs->delete();

        return back()->with('success', 'KRS berhasil dihapus.');
    }
}
