<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $hari = trim((string) $request->query('hari'));

        $jadwals = Jadwal::with(['dosen', 'mataKuliah'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('kelas', 'like', "%{$search}%")
                        ->orWhereHas('mataKuliah', fn ($mk) => $mk->where('nama_matakuliah', 'like', "%{$search}%"))
                        ->orWhereHas('dosen', fn ($dosen) => $dosen->where('nama', 'like', "%{$search}%"));
                });
            })
            ->when($hari, fn ($query) => $query->where('hari', $hari))
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai')
            ->paginate(10)
            ->withQueryString();

        return view('mahasiswa.jadwal.index', compact('jadwals', 'search', 'hari'));
    }
}
