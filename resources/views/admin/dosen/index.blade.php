@extends('layouts.app')

@section('title', 'Data Dosen')

@section('content')
<div class="page-header">
    <div class="page-heading">
        <div class="page-heading-icon"><i class="bi bi-person-badge-fill"></i></div>
        <div>
            <h1 class="page-title">Data Dosen</h1>
            <p class="page-description">Kelola identitas dan daftar dosen yang terdaftar.</p>
        </div>
    </div>
    <a href="{{ route('admin.dosen.create') }}" class="btn btn-primary px-3 py-2">
        <i class="bi bi-plus-lg me-1"></i> Tambah Dosen
    </a>
</div>

<div class="card content-card">
    <div class="card-header-clean">
        <div>
            <h2>Daftar Dosen</h2>
            <div class="text-secondary small mt-1">Temukan dosen berdasarkan NIDN atau nama.</div>
        </div>
        <span class="badge-soft-primary"><i class="bi bi-database-fill"></i> {{ $dosens->total() }} data</span>
    </div>

    <div class="card-body-modern">
        <form class="filter-bar" method="GET">
            <div class="row g-2 align-items-center">
                <div class="col-lg-6">
                    <div class="input-icon-wrap">
                        <i class="bi bi-search"></i>
                        <input class="form-control" name="search" value="{{ $search }}" placeholder="Cari NIDN atau nama dosen...">
                    </div>
                </div>
                <div class="col-sm-auto"><button class="btn btn-outline-primary w-100"><i class="bi bi-search me-1"></i>Cari</button></div>
                <div class="col-sm-auto"><a class="btn btn-outline-secondary w-100" href="{{ route('admin.dosen.index') }}"><i class="bi bi-arrow-counterclockwise me-1"></i>Reset</a></div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width:70px">No</th>
                        <th>NIDN</th>
                        <th>Nama Dosen</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($dosens as $dosen)
                    <tr>
                        <td>{{ $dosens->firstItem() + $loop->index }}</td>
                        <td><span class="table-id">{{ $dosen->nidn }}</span></td>
                        <td>
                            <div class="person-cell">
                                <div class="person-avatar">{{ mb_strtoupper(mb_substr($dosen->nama, 0, 1)) }}</div>
                                <div class="person-name">{{ $dosen->nama }}</div>
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.dosen.edit', $dosen) }}" class="btn btn-warning btn-icon" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.dosen.destroy', $dosen) }}" method="POST" onsubmit="return confirm('Hapus data dosen ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger-soft btn-icon" title="Hapus"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="bi bi-person-x"></i></div>
                                <div class="empty-state-title">Data dosen belum tersedia</div>
                                <p class="empty-state-text">Tambahkan dosen pertama untuk mulai mengelola data akademik.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $dosens->links() }}
    </div>
</div>
@endsection
