<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\MataKuliah;
use Illuminate\Http\RedirectResponse;
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

        return view('admin.jadwal.index', compact('jadwals', 'search', 'hari'));
    }

    public function create(): View
    {
        return view('admin.jadwal.create', [
            'dosens' => Dosen::orderBy('nama')->get(),
            'mataKuliahs' => MataKuliah::orderBy('nama_matakuliah')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_matakuliah' => ['required', 'exists:mata_kuliahs,kode_matakuliah'],
            'nidn' => ['required', 'exists:dosens,nidn'],
            'kelas' => ['required', 'string', 'max:10'],
            'hari' => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
        ]);

        Jadwal::create($validated);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Jadwal $jadwal): View
    {
        return view('admin.jadwal.edit', [
            'jadwal' => $jadwal,
            'dosens' => Dosen::orderBy('nama')->get(),
            'mataKuliahs' => MataKuliah::orderBy('nama_matakuliah')->get(),
        ]);
    }

    public function update(Request $request, Jadwal $jadwal): RedirectResponse
    {
        $validated = $request->validate([
            'kode_matakuliah' => ['required', 'exists:mata_kuliahs,kode_matakuliah'],
            'nidn' => ['required', 'exists:dosens,nidn'],
            'kelas' => ['required', 'string', 'max:10'],
            'hari' => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
        ]);

        $jadwal->update($validated);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal): RedirectResponse
    {
        $jadwal->delete();

        return back()->with('success', 'Jadwal berhasil dihapus.');
    }
}
