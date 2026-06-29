<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use App\Models\MataKuliah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KrsController extends Controller
{
    public function index(): View
    {
        $mahasiswa = $this->getMahasiswa();

        $daftarKrs = Krs::with('mataKuliah.jadwals.dosen')
            ->where('npm', $mahasiswa->npm)
            ->latest()
            ->get();

        $totalSks = $daftarKrs->sum(fn (Krs $item) => $item->mataKuliah?->sks ?? 0);

        return view('mahasiswa.krs.index', compact('mahasiswa', 'daftarKrs', 'totalSks'));
    }

    public function create(): View
    {
        $mahasiswa = $this->getMahasiswa();

        $kodeSudahDiambil = Krs::where('npm', $mahasiswa->npm)
            ->pluck('kode_matakuliah');

        $mataKuliahs = MataKuliah::with(['jadwals.dosen'])
            ->whereNotIn('kode_matakuliah', $kodeSudahDiambil)
            ->orderBy('nama_matakuliah')
            ->get();

        return view('mahasiswa.krs.create', compact('mahasiswa', 'mataKuliahs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $mahasiswa = $this->getMahasiswa();

        $validated = $request->validate([
            'kode_matakuliah' => ['required', 'exists:mata_kuliahs,kode_matakuliah'],
        ]);

        $sudahAda = Krs::where('npm', $mahasiswa->npm)
            ->where('kode_matakuliah', $validated['kode_matakuliah'])
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Mata kuliah tersebut sudah ada di KRS Anda.');
        }

        Krs::create([
            'npm' => $mahasiswa->npm,
            'kode_matakuliah' => $validated['kode_matakuliah'],
        ]);

        return redirect()->route('mahasiswa.krs.index')
            ->with('success', 'Mata kuliah berhasil ditambahkan ke KRS.');
    }

    public function destroy(Krs $krs): RedirectResponse
    {
        $mahasiswa = $this->getMahasiswa();

        abort_if($krs->npm !== $mahasiswa->npm, 403, 'Anda tidak boleh menghapus KRS milik mahasiswa lain.');

        $krs->delete();

        return back()->with('success', 'Mata kuliah berhasil dibatalkan dari KRS.');
    }

    private function getMahasiswa()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        abort_if(! $mahasiswa, 403, 'Data mahasiswa untuk akun ini belum tersedia.');

        return $mahasiswa;
    }
}
