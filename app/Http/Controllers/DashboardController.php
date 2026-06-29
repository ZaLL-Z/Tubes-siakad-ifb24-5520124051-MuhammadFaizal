<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return view('dashboard.admin', [
                'jumlahDosen' => Dosen::count(),
                'jumlahMahasiswa' => Mahasiswa::count(),
                'jumlahMataKuliah' => MataKuliah::count(),
                'jumlahJadwal' => Jadwal::count(),
                'jumlahKrs' => Krs::count(),
            ]);
        }

        $mahasiswa = $user->mahasiswa;
        abort_if(! $mahasiswa, 403, 'Data mahasiswa untuk akun ini belum tersedia.');

        $daftarKrs = Krs::with('mataKuliah')
            ->where('npm', $mahasiswa->npm)
            ->get();

        return view('dashboard.mahasiswa', [
            'mahasiswa' => $mahasiswa,
            'jumlahKrs' => $daftarKrs->count(),
            'totalSks' => $daftarKrs->sum(fn (Krs $item) => $item->mataKuliah?->sks ?? 0),
            'jumlahJadwal' => Jadwal::count(),
        ]);
    }
}
