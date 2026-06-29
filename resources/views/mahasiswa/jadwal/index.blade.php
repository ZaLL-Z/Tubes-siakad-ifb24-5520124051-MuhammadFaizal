@extends('layouts.app')

@section('title', 'Jadwal Perkuliahan')

@section('content')
<div class="page-header">
    <div class="page-heading">
        <div class="page-heading-icon"><i class="bi bi-calendar2-week-fill"></i></div>
        <div>
            <h1 class="page-title">Jadwal Perkuliahan</h1>
            <p class="page-description">Lihat seluruh jadwal mata kuliah yang tersedia.</p>
        </div>
    </div>
</div>

<div class="card content-card">
    <div class="card-header-clean">
        <div>
            <h2>Daftar Jadwal</h2>
            <div class="text-secondary small mt-1">Gunakan pencarian atau filter hari untuk menemukan jadwal.</div>
        </div>
        <span class="badge-soft-primary"><i class="bi bi-calendar-check-fill"></i> {{ $jadwals->total() }} jadwal</span>
    </div>

    <div class="card-body-modern">
        <form class="filter-bar" method="GET">
            <div class="row g-2 align-items-center">
                <div class="col-lg-5">
                    <div class="input-icon-wrap">
                        <i class="bi bi-search"></i>
                        <input class="form-control" name="search" value="{{ $search }}" placeholder="Cari mata kuliah, dosen, atau kelas...">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input-icon-wrap">
                        <i class="bi bi-calendar-day"></i>
                        <select class="form-select" name="hari">
                            <option value="">Semua hari</option>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $item)
                                <option value="{{ $item }}" @selected($hari === $item)>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-auto"><button class="btn btn-outline-primary w-100"><i class="bi bi-funnel me-1"></i>Filter</button></div>
                <div class="col-sm-auto"><a class="btn btn-outline-secondary w-100" href="{{ route('mahasiswa.jadwal.index') }}"><i class="bi bi-arrow-counterclockwise me-1"></i>Reset</a></div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width:70px">No</th>
                        <th>Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Dosen</th>
                        <th>Kelas</th>
                        <th>Hari</th>
                        <th>Jam</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($jadwals as $jadwal)
                    <tr>
                        <td>{{ $jadwals->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="person-cell">
                                <div class="person-avatar"><i class="bi bi-book"></i></div>
                                <div>
                                    <div class="person-name">{{ $jadwal->mataKuliah?->nama_matakuliah ?? '-' }}</div>
                                    <div class="person-sub">{{ $jadwal->kode_matakuliah }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge-soft-success">{{ $jadwal->mataKuliah?->sks ?? 0 }} SKS</span></td>
                        <td>{{ $jadwal->dosen?->nama ?? '-' }}</td>
                        <td><span class="badge-soft-primary"><i class="bi bi-door-open"></i>{{ $jadwal->kelas }}</span></td>
                        <td><span class="badge-soft-info"><i class="bi bi-calendar-day"></i>{{ $jadwal->hari }}</span></td>
                        <td><span class="badge-soft-neutral"><i class="bi bi-clock"></i>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="bi bi-calendar2-x"></i></div>
                                <div class="empty-state-title">Jadwal belum tersedia</div>
                                <p class="empty-state-text">Belum ada jadwal yang cocok dengan pencarianmu.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $jadwals->links() }}
    </div>
</div>
@endsection
