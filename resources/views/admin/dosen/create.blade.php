@extends('layouts.app')

@section('title', 'Tambah Dosen')

@section('content')
<div class="page-header">
    <div class="page-heading">
        <div class="page-heading-icon"><i class="bi bi-person-plus-fill"></i></div>
        <div>
            <h1 class="page-title">Tambah Dosen</h1>
            <p class="page-description">Masukkan identitas dosen baru ke sistem.</p>
        </div>
    </div>
</div>

<div class="card form-card mx-auto" style="max-width:760px">
    <div class="card-header-clean">
        <div>
            <h2>Informasi Dosen</h2>
            <div class="text-secondary small mt-1">Kolom bertanda wajib harus diisi.</div>
        </div>
        <span class="badge-soft-primary"><i class="bi bi-person-badge"></i> Data baru</span>
    </div>
    <div class="card-body-modern">
        <form action="{{ route('admin.dosen.store') }}" method="POST">
            @csrf
            <div class="form-section-title"><i class="bi bi-card-heading"></i> Identitas Utama</div>

            <div class="mb-3">
                <label class="form-label" for="nidn">NIDN</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-upc-scan"></i>
                    <input id="nidn" name="nidn" class="form-control @error('nidn') is-invalid @enderror" maxlength="10" value="{{ old('nidn') }}" placeholder="Contoh: 1234567890" required>
                </div>
                @error('nidn')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="nama">Nama Dosen</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-person"></i>
                    <input id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" maxlength="50" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap dosen" required>
                </div>
                @error('nama')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="form-footer">
                <button class="btn btn-primary px-4" type="submit"><i class="bi bi-check2-circle me-1"></i>Simpan Dosen</button>
                <a class="btn btn-outline-secondary px-4" href="{{ route('admin.dosen.index') }}"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
