@extends('layouts.app')

@section('title', 'Tambah KRS Mahasiswa')

@section('content')
<div class="page-header">
    <div class="page-heading">
        <div class="page-heading-icon"><i class="bi bi-clipboard2-plus-fill"></i></div>
        <div>
            <h1 class="page-title">Tambah KRS Mahasiswa</h1>
            <p class="page-description">Pilih mahasiswa dan mata kuliah yang akan ditambahkan.</p>
        </div>
    </div>
</div>

<div class="card form-card mx-auto" style="max-width:800px">
    <div class="card-header-clean">
        <div>
            <h2>Form KRS</h2>
            <div class="text-secondary small mt-1">Sistem akan mencegah pengambilan mata kuliah yang sama.</div>
        </div>
        <span class="badge-soft-primary"><i class="bi bi-journal-plus"></i> Data baru</span>
    </div>
    <div class="card-body-modern">
        <form method="POST" action="{{ route('admin.krs.store') }}">
            @csrf
            <div class="form-section-title"><i class="bi bi-clipboard-data"></i> Pilihan Akademik</div>

            <div class="mb-3">
                <label class="form-label" for="npm">Mahasiswa</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-person"></i>
                    <select id="npm" name="npm" class="form-select @error('npm') is-invalid @enderror" required>
                        <option value="">Pilih mahasiswa</option>
                        @foreach($mahasiswas as $mahasiswa)
                            <option value="{{ $mahasiswa->npm }}" @selected(old('npm') === $mahasiswa->npm)>
                                {{ $mahasiswa->npm }} - {{ $mahasiswa->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('npm')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="kode_matakuliah">Mata Kuliah</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-book"></i>
                    <select id="kode_matakuliah" name="kode_matakuliah" class="form-select @error('kode_matakuliah') is-invalid @enderror" required>
                        <option value="">Pilih mata kuliah</option>
                        @foreach($mataKuliahs as $mataKuliah)
                            <option value="{{ $mataKuliah->kode_matakuliah }}" @selected(old('kode_matakuliah') === $mataKuliah->kode_matakuliah)>
                                {{ $mataKuliah->kode_matakuliah }} - {{ $mataKuliah->nama_matakuliah }} ({{ $mataKuliah->sks }} SKS)
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('kode_matakuliah')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="alert alert-info d-flex align-items-start gap-2 mt-4 mb-0">
                <i class="bi bi-info-circle-fill"></i>
                <div class="small">Mahasiswa dapat melihat mata kuliah ini pada halaman KRS setelah data disimpan.</div>
            </div>

            <div class="form-footer">
                <button class="btn btn-primary px-4" type="submit"><i class="bi bi-check2-circle me-1"></i>Simpan KRS</button>
                <a class="btn btn-outline-secondary px-4" href="{{ route('admin.krs.index') }}"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
