@extends('layouts.app')

@section('title', 'KRS Saya')

@section('content')
<div class="page-header">
    <div class="page-heading">
        <div class="page-heading-icon"><i class="bi bi-clipboard2-check-fill"></i></div>
        <div>
            <h1 class="page-title">KRS Saya</h1>
            <p class="page-description">{{ $mahasiswa->npm }} · {{ $mahasiswa->nama }}</p>
        </div>
    </div>
    <a href="{{ route('mahasiswa.krs.create') }}" class="btn btn-primary px-3 py-2">
        <i class="bi bi-plus-lg me-1"></i> Ambil Mata Kuliah
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-4">
        <div class="stat-card" style="--stat-color:#6366f1; --stat-soft:#eef2ff;">
            <div class="stat-icon"><i class="bi bi-journal-check"></i></div>
            <div class="stat-label">Mata Kuliah Diambil</div>
            <div class="stat-value">{{ $daftarKrs->count() }}</div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="stat-card" style="--stat-color:#10b981; --stat-soft:#ecfdf5;">
            <div class="stat-icon"><i class="bi bi-bar-chart-fill"></i></div>
            <div class="stat-label">Total SKS</div>
            <div class="stat-value">{{ $totalSks }}</div>
        </div>
    </div>
</div>

<div class="card content-card">
    <div class="card-header-clean">
        <div>
            <h2>Daftar Mata Kuliah</h2>
            <div class="text-secondary small mt-1">Mata kuliah yang telah masuk ke KRS semester ini.</div>
        </div>
        <span class="badge-soft-success"><i class="bi bi-check-circle-fill"></i> Aktif</span>
    </div>

    <div class="card-body-modern">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width:70px">No</th>
                        <th>Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Jadwal</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($daftarKrs as $krs)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="person-cell">
                                <div class="person-avatar"><i class="bi bi-book"></i></div>
                                <div>
                                    <div class="person-name">{{ $krs->mataKuliah?->nama_matakuliah ?? '-' }}</div>
                                    <div class="person-sub">{{ $krs->kode_matakuliah }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge-soft-success"><i class="bi bi-bar-chart"></i>{{ $krs->mataKuliah?->sks ?? 0 }} SKS</span></td>
                        <td>
                            @if($krs->mataKuliah?->jadwals?->isNotEmpty())
                                <div class="schedule-list">
                                    @foreach($krs->mataKuliah->jadwals as $jadwal)
                                        <span class="schedule-chip">
                                            <i class="bi bi-calendar2-event"></i>
                                            {{ $jadwal->hari }}, {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}, Kelas {{ $jadwal->kelas }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="badge-soft-warning"><i class="bi bi-clock-history"></i>Belum dijadwalkan</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('mahasiswa.krs.destroy', $krs) }}" onsubmit="return confirm('Batalkan mata kuliah ini dari KRS?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger-soft btn-sm"><i class="bi bi-x-circle me-1"></i>Batalkan</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="bi bi-clipboard2-x"></i></div>
                                <div class="empty-state-title">KRS masih kosong</div>
                                <p class="empty-state-text">Ambil mata kuliah untuk mulai menyusun rencana studi.</p>
                                <a href="{{ route('mahasiswa.krs.create') }}" class="btn btn-primary btn-sm mt-3"><i class="bi bi-plus-lg me-1"></i>Ambil Mata Kuliah</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
