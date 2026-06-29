@extends('layouts.app')

@section('title', 'Data Mata Kuliah')

@section('content')
<div class="page-header">
    <div class="page-heading">
        <div class="page-heading-icon"><i class="bi bi-journal-bookmark-fill"></i></div>
        <div>
            <h1 class="page-title">Data Mata Kuliah</h1>
            <p class="page-description">Kelola kode, nama mata kuliah, dan jumlah SKS.</p>
        </div>
    </div>
    <a href="{{ route('admin.mata-kuliah.create') }}" class="btn btn-primary px-3 py-2">
        <i class="bi bi-journal-plus me-1"></i> Tambah Mata Kuliah
    </a>
</div>

<div class="card content-card">
    <div class="card-header-clean">
        <div>
            <h2>Daftar Mata Kuliah</h2>
            <div class="text-secondary small mt-1">Cari berdasarkan kode atau nama mata kuliah.</div>
        </div>
        <span class="badge-soft-primary"><i class="bi bi-database-fill"></i> {{ $mataKuliahs->total() }} data</span>
    </div>

    <div class="card-body-modern">
        <form class="filter-bar" method="GET">
            <div class="row g-2 align-items-center">
                <div class="col-lg-6">
                    <div class="input-icon-wrap">
                        <i class="bi bi-search"></i>
                        <input class="form-control" name="search" value="{{ $search }}" placeholder="Cari kode atau nama mata kuliah...">
                    </div>
                </div>
                <div class="col-sm-auto"><button class="btn btn-outline-primary w-100"><i class="bi bi-search me-1"></i>Cari</button></div>
                <div class="col-sm-auto"><a class="btn btn-outline-secondary w-100" href="{{ route('admin.mata-kuliah.index') }}"><i class="bi bi-arrow-counterclockwise me-1"></i>Reset</a></div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width:70px">No</th>
                        <th>Kode</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($mataKuliahs as $mataKuliah)
                    <tr>
                        <td>{{ $mataKuliahs->firstItem() + $loop->index }}</td>
                        <td><span class="table-id">{{ $mataKuliah->kode_matakuliah }}</span></td>
                        <td>
                            <div class="person-cell">
                                <div class="person-avatar"><i class="bi bi-book"></i></div>
                                <div class="person-name">{{ $mataKuliah->nama_matakuliah }}</div>
                            </div>
                        </td>
                        <td><span class="badge-soft-success"><i class="bi bi-bar-chart"></i>{{ $mataKuliah->sks }} SKS</span></td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a class="btn btn-warning btn-icon" href="{{ route('admin.mata-kuliah.edit', $mataKuliah) }}" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.mata-kuliah.destroy', $mataKuliah) }}" onsubmit="return confirm('Hapus mata kuliah ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger-soft btn-icon" title="Hapus"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="bi bi-journal-x"></i></div>
                                <div class="empty-state-title">Data mata kuliah belum tersedia</div>
                                <p class="empty-state-text">Tambahkan mata kuliah agar dapat digunakan pada jadwal dan KRS.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $mataKuliahs->links() }}
    </div>
</div>
@endsection
