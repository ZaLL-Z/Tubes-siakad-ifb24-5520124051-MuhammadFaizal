@extends('layouts.app')

@section('title', 'Tambah Mata Kuliah')

@section('content')
<div class="page-header">
    <div class="page-heading">
        <div class="page-heading-icon"><i class="bi bi-journal-plus"></i></div>
        <div>
            <h1 class="page-title">Tambah Mata Kuliah</h1>
            <p class="page-description">Masukkan mata kuliah baru beserta jumlah SKS.</p>
        </div>
    </div>
</div>

<div class="card form-card mx-auto" style="max-width:760px">
    <div class="card-header-clean">
        <div>
            <h2>Informasi Mata Kuliah</h2>
            <div class="text-secondary small mt-1">Kode mata kuliah harus unik.</div>
        </div>
        <span class="badge-soft-primary"><i class="bi bi-book-fill"></i> Data baru</span>
    </div>
    <div class="card-body-modern">
        <form method="POST" action="{{ route('admin.mata-kuliah.store') }}">
            @csrf
            <div class="form-section-title"><i class="bi bi-journal-text"></i> Detail Mata Kuliah</div>

            <div class="mb-3">
                <label class="form-label" for="kode_matakuliah">Kode Mata Kuliah</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-upc-scan"></i>
                    <input id="kode_matakuliah" name="kode_matakuliah" maxlength="8" value="{{ old('kode_matakuliah') }}" class="form-control @error('kode_matakuliah') is-invalid @enderror" placeholder="Contoh: IF53413" required>
                </div>
                @error('kode_matakuliah')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="nama_matakuliah">Nama Mata Kuliah</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-book"></i>
                    <input id="nama_matakuliah" name="nama_matakuliah" maxlength="50" value="{{ old('nama_matakuliah') }}" class="form-control @error('nama_matakuliah') is-invalid @enderror" placeholder="Masukkan nama mata kuliah" required>
                </div>
                @error('nama_matakuliah')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="sks">Jumlah SKS</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-bar-chart"></i>
                    <input id="sks" type="number" name="sks" min="1" max="6" value="{{ old('sks', 3) }}" class="form-control @error('sks') is-invalid @enderror" required>
                </div>
                @error('sks')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="form-footer">
                <button class="btn btn-primary px-4" type="submit"><i class="bi bi-check2-circle me-1"></i>Simpan Mata Kuliah</button>
                <a class="btn btn-outline-secondary px-4" href="{{ route('admin.mata-kuliah.index') }}"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
