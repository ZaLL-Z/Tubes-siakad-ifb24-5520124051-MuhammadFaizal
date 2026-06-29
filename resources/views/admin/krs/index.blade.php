@extends('layouts.app')

@section('title', 'Data KRS')

@section('content')
<div class="page-header">
    <div class="page-heading">
        <div class="page-heading-icon"><i class="bi bi-clipboard2-check-fill"></i></div>
        <div>
            <h1 class="page-title">Data KRS Mahasiswa</h1>
            <p class="page-description">Lihat dan kelola mata kuliah yang diambil seluruh mahasiswa.</p>
        </div>
    </div>
    <a href="{{ route('admin.krs.create') }}" class="btn btn-primary px-3 py-2">
        <i class="bi bi-clipboard2-plus-fill me-1"></i> Tambah KRS
    </a>
</div>

<div class="card content-card">
    <div class="card-header-clean">
        <div>
            <h2>Daftar KRS</h2>
            <div class="text-secondary small mt-1">Cari berdasarkan NPM, nama mahasiswa, kode, atau mata kuliah.</div>
        </div>
        <span class="badge-soft-primary"><i class="bi bi-database-fill"></i> {{ $daftarKrs->total() }} data</span>
    </div>

    <div class="card-body-modern">
        <form class="filter-bar" method="GET">
            <div class="row g-2 align-items-center">
                <div class="col-lg-7">
                    <div class="input-icon-wrap">
                        <i class="bi bi-search"></i>
                        <input class="form-control" name="search" value="{{ $search }}" placeholder="Cari NPM, mahasiswa, kode, atau mata kuliah...">
                    </div>
                </div>
                <div class="col-sm-auto"><button class="btn btn-outline-primary w-100"><i class="bi bi-search me-1"></i>Cari</button></div>
                <div class="col-sm-auto"><a class="btn btn-outline-secondary w-100" href="{{ route('admin.krs.index') }}"><i class="bi bi-arrow-counterclockwise me-1"></i>Reset</a></div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width:70px">No</th>
                        <th>Mahasiswa</th>
                        <th>Mata Kuliah</th>
                        <th>SKS</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($daftarKrs as $krs)
                    <tr>
                        <td>{{ $daftarKrs->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="person-cell">
                                <div class="person-avatar">{{ mb_strtoupper(mb_substr($krs->mahasiswa?->nama ?? 'M', 0, 1)) }}</div>
                                <div>
                                    <div class="person-name">{{ $krs->mahasiswa?->nama ?? '-' }}</div>
                                    <div class="person-sub">NPM {{ $krs->npm }}</div>
                                </div>
                            </div>
                        </td>
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
                        <td class="text-end">
                            <form class="d-inline" method="POST" action="{{ route('admin.krs.destroy', $krs) }}" onsubmit="return confirm('Hapus KRS ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger-soft btn-icon" title="Hapus"><i class="bi bi-trash3"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="bi bi-clipboard2-x"></i></div>
                                <div class="empty-state-title">Data KRS belum tersedia</div>
                                <p class="empty-state-text">Tambahkan mata kuliah ke KRS mahasiswa untuk menampilkan data.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $daftarKrs->links() }}
    </div>
</div>
@endsection
