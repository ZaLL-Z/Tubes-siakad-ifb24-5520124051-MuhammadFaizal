@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')

@section('content')
<div class="page-header">
    <div class="page-heading">
        <div class="page-heading-icon"><i class="bi bi-person-plus-fill"></i></div>
        <div>
            <h1 class="page-title">Tambah Mahasiswa</h1>
            <p class="page-description">Buat data mahasiswa sekaligus akun login baru.</p>
        </div>
    </div>
</div>

<div class="card form-card mx-auto" style="max-width:860px">
    <div class="card-header-clean">
        <div>
            <h2>Form Mahasiswa</h2>
            <div class="text-secondary small mt-1">Lengkapi identitas akademik dan keamanan akun.</div>
        </div>
        <span class="badge-soft-primary"><i class="bi bi-person-fill-add"></i> Data baru</span>
    </div>
    <div class="card-body-modern">
        <form method="POST" action="{{ route('admin.mahasiswa.store') }}">
            @csrf

            <div class="form-section-title"><i class="bi bi-person-vcard"></i> Identitas Akademik</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="npm">NPM</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-upc-scan"></i>
                        <input id="npm" name="npm" maxlength="10" value="{{ old('npm') }}" class="form-control @error('npm') is-invalid @enderror" placeholder="Masukkan NPM" required>
                    </div>
                    @error('npm')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="nama">Nama Lengkap</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-person"></i>
                        <input id="nama" name="nama" maxlength="50" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama lengkap mahasiswa" required>
                    </div>
                    @error('nama')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label" for="nidn">Dosen Wali</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-person-badge"></i>
                        <select id="nidn" name="nidn" class="form-select @error('nidn') is-invalid @enderror" required>
                            <option value="">Pilih dosen wali</option>
                            @foreach($dosens as $dosen)
                                <option value="{{ $dosen->nidn }}" @selected(old('nidn') === $dosen->nidn)>{{ $dosen->nidn }} - {{ $dosen->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('nidn')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr class="my-4 border-light-subtle">
            <div class="form-section-title"><i class="bi bi-shield-lock"></i> Informasi Akun</div>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label" for="email">Email Login</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-envelope"></i>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="nama@email.com" required>
                    </div>
                    @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-key"></i>
                        <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
                        <button type="button" class="password-toggle" data-password-toggle="password" aria-label="Tampilkan password"><i class="bi bi-eye"></i></button>
                    </div>
                    @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-key-fill"></i>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                        <button type="button" class="password-toggle" data-password-toggle="password_confirmation" aria-label="Tampilkan password"><i class="bi bi-eye"></i></button>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <button class="btn btn-primary px-4" type="submit"><i class="bi bi-check2-circle me-1"></i>Simpan Mahasiswa</button>
                <a class="btn btn-outline-secondary px-4" href="{{ route('admin.mahasiswa.index') }}"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
