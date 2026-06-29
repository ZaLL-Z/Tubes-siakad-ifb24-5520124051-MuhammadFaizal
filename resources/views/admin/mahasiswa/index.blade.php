@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="page-header">
    <div class="page-heading">
        <div class="page-heading-icon"><i class="bi bi-people-fill"></i></div>
        <div>
            <h1 class="page-title">Data Mahasiswa</h1>
            <p class="page-description">Kelola identitas, akun login, dan dosen wali mahasiswa.</p>
        </div>
    </div>
    <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary px-3 py-2">
        <i class="bi bi-person-plus-fill me-1"></i> Tambah Mahasiswa
    </a>
</div>

<div class="card content-card">
    <div class="card-header-clean">
        <div>
            <h2>Daftar Mahasiswa</h2>
            <div class="text-secondary small mt-1">Cari berdasarkan NPM, nama, atau alamat email.</div>
        </div>
        <span class="badge-soft-primary"><i class="bi bi-database-fill"></i> {{ $mahasiswas->total() }} data</span>
    </div>

    <div class="card-body-modern">
        <form class="filter-bar" method="GET">
            <div class="row g-2 align-items-center">
                <div class="col-lg-6">
                    <div class="input-icon-wrap">
                        <i class="bi bi-search"></i>
                        <input class="form-control" name="search" value="{{ $search }}" placeholder="Cari NPM, nama, atau email...">
                    </div>
                </div>
                <div class="col-sm-auto"><button class="btn btn-outline-primary w-100"><i class="bi bi-search me-1"></i>Cari</button></div>
                <div class="col-sm-auto"><a class="btn btn-outline-secondary w-100" href="{{ route('admin.mahasiswa.index') }}"><i class="bi bi-arrow-counterclockwise me-1"></i>Reset</a></div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width:70px">No</th>
                        <th>NPM</th>
                        <th>Mahasiswa</th>
                        <th>Email</th>
                        <th>Dosen Wali</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($mahasiswas as $mahasiswa)
                    <tr>
                        <td>{{ $mahasiswas->firstItem() + $loop->index }}</td>
                        <td><span class="table-id">{{ $mahasiswa->npm }}</span></td>
                        <td>
                            <div class="person-cell">
                                <div class="person-avatar">{{ mb_strtoupper(mb_substr($mahasiswa->nama, 0, 1)) }}</div>
                                <div>
                                    <div class="person-name">{{ $mahasiswa->nama }}</div>
                                    <div class="person-sub">Mahasiswa aktif</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge-soft-info"><i class="bi bi-envelope"></i>{{ $mahasiswa->user?->email }}</span></td>
                        <td>{{ $mahasiswa->dosen?->nama ?? '-' }}</td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a class="btn btn-warning btn-icon" href="{{ route('admin.mahasiswa.edit', $mahasiswa) }}" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.mahasiswa.destroy', $mahasiswa) }}" onsubmit="return confirm('Hapus mahasiswa beserta akun dan KRS-nya?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger-soft btn-icon" title="Hapus"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="bi bi-people"></i></div>
                                <div class="empty-state-title">Data mahasiswa belum tersedia</div>
                                <p class="empty-state-text">Tambahkan mahasiswa untuk membuat akun akademik baru.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $mahasiswas->links() }}
    </div>
</div>
@endsection
