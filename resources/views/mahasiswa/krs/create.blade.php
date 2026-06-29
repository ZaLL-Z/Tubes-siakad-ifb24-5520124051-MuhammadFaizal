@extends('layouts.app')

@section('title', 'Ambil Mata Kuliah')

@section('content')
<div class="page-header">
    <div class="page-heading">
        <div class="page-heading-icon"><i class="bi bi-journal-plus"></i></div>
        <div>
            <h1 class="page-title">Ambil Mata Kuliah</h1>
            <p class="page-description">Pilih satu mata kuliah untuk ditambahkan ke KRS.</p>
        </div>
    </div>
</div>

<div class="card form-card mx-auto" style="max-width:820px">
    <div class="card-header-clean">
        <div>
            <h2>Pilihan Mata Kuliah</h2>
            <div class="text-secondary small mt-1">Mata kuliah yang sudah diambil tidak akan muncul lagi.</div>
        </div>
        <span class="badge-soft-primary"><i class="bi bi-mortarboard-fill"></i> KRS</span>
    </div>

    <div class="card-body-modern">
        @if($mataKuliahs->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon"><i class="bi bi-check2-circle"></i></div>
                <div class="empty-state-title">Tidak ada mata kuliah yang dapat dipilih</div>
                <p class="empty-state-text">Semua mata kuliah sudah diambil atau data mata kuliah belum tersedia.</p>
                <a class="btn btn-outline-secondary mt-3" href="{{ route('mahasiswa.krs.index') }}"><i class="bi bi-arrow-left me-1"></i>Kembali ke KRS</a>
            </div>
        @else
            <form method="POST" action="{{ route('mahasiswa.krs.store') }}">
                @csrf
                <div class="form-section-title"><i class="bi bi-book-half"></i> Mata Kuliah</div>

                <div class="mb-3">
                    <label class="form-label" for="kode_matakuliah">Pilih Mata Kuliah</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-book"></i>
                        <select id="kode_matakuliah" class="form-select @error('kode_matakuliah') is-invalid @enderror" name="kode_matakuliah" required>
                            <option value="">Pilih mata kuliah</option>
                            @foreach($mataKuliahs as $mk)
                                <option value="{{ $mk->kode_matakuliah }}" @selected(old('kode_matakuliah') === $mk->kode_matakuliah)>
                                    {{ $mk->kode_matakuliah }} - {{ $mk->nama_matakuliah }} ({{ $mk->sks }} SKS)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('kode_matakuliah')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="alert alert-info d-flex align-items-start gap-2 mt-4 mb-0">
                    <i class="bi bi-info-circle-fill"></i>
                    <div class="small">Setelah disimpan, jadwal mata kuliah dapat dilihat pada halaman KRS Saya atau Jadwal Kuliah.</div>
                </div>

                <div class="form-footer">
                    <button class="btn btn-primary px-4" type="submit"><i class="bi bi-plus-circle me-1"></i>Tambahkan ke KRS</button>
                    <a class="btn btn-outline-secondary px-4" href="{{ route('mahasiswa.krs.index') }}"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
