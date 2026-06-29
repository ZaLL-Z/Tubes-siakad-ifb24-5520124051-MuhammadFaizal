@extends('layouts.app')

@section('title', 'Tambah Jadwal')

@section('content')
<div class="page-header">
    <div class="page-heading">
        <div class="page-heading-icon"><i class="bi bi-calendar2-plus-fill"></i></div>
        <div>
            <h1 class="page-title">Tambah Jadwal</h1>
            <p class="page-description">Atur mata kuliah, dosen, kelas, hari, dan waktu kuliah.</p>
        </div>
    </div>
</div>

<div class="card form-card mx-auto" style="max-width:920px">
    <div class="card-header-clean">
        <div>
            <h2>Informasi Jadwal</h2>
            <div class="text-secondary small mt-1">Pastikan waktu selesai lebih besar dari waktu mulai.</div>
        </div>
        <span class="badge-soft-primary"><i class="bi bi-calendar-plus"></i> Jadwal baru</span>
    </div>
    <div class="card-body-modern">
        <form method="POST" action="{{ route('admin.jadwal.store') }}">
            @csrf

            <div class="form-section-title"><i class="bi bi-book-half"></i> Mata Kuliah dan Pengajar</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="kode_matakuliah">Mata Kuliah</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-journal-bookmark"></i>
                        <select id="kode_matakuliah" name="kode_matakuliah" class="form-select @error('kode_matakuliah') is-invalid @enderror" required>
                            <option value="">Pilih mata kuliah</option>
                            @foreach($mataKuliahs as $mk)
                                <option value="{{ $mk->kode_matakuliah }}" @selected(old('kode_matakuliah') === $mk->kode_matakuliah)>{{ $mk->kode_matakuliah }} - {{ $mk->nama_matakuliah }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('kode_matakuliah')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="nidn">Dosen Pengajar</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-person-badge"></i>
                        <select id="nidn" name="nidn" class="form-select @error('nidn') is-invalid @enderror" required>
                            <option value="">Pilih dosen pengajar</option>
                            @foreach($dosens as $dosen)
                                <option value="{{ $dosen->nidn }}" @selected(old('nidn') === $dosen->nidn)>{{ $dosen->nidn }} - {{ $dosen->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('nidn')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr class="my-4 border-light-subtle">
            <div class="form-section-title"><i class="bi bi-calendar2-week"></i> Waktu dan Kelas</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="kelas">Kelas</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-door-open"></i>
                        <input id="kelas" name="kelas" maxlength="10" value="{{ old('kelas') }}" class="form-control @error('kelas') is-invalid @enderror" placeholder="Contoh: A" required>
                    </div>
                    @error('kelas')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="hari">Hari</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-calendar-day"></i>
                        <select id="hari" name="hari" class="form-select @error('hari') is-invalid @enderror" required>
                            <option value="">Pilih hari</option>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $item)
                                <option value="{{ $item }}" @selected(old('hari') === $item)>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('hari')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-2 col-6">
                    <label class="form-label" for="jam_mulai">Jam Mulai</label>
                    <input id="jam_mulai" type="time" name="jam_mulai" value="{{ old('jam_mulai') }}" class="form-control @error('jam_mulai') is-invalid @enderror" required>
                    @error('jam_mulai')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-2 col-6">
                    <label class="form-label" for="jam_selesai">Jam Selesai</label>
                    <input id="jam_selesai" type="time" name="jam_selesai" value="{{ old('jam_selesai') }}" class="form-control @error('jam_selesai') is-invalid @enderror" required>
                    @error('jam_selesai')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-footer">
                <button class="btn btn-primary px-4" type="submit"><i class="bi bi-check2-circle me-1"></i>Simpan Jadwal</button>
                <a class="btn btn-outline-secondary px-4" href="{{ route('admin.jadwal.index') }}"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
