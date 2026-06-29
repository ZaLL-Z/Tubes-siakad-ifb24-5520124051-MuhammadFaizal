@extends('layouts.app')

@section('title', 'Edit Mahasiswa')

@section('content')
<div class="page-header">
    <div class="page-heading">
        <div class="page-heading-icon"><i class="bi bi-pencil-square"></i></div>
        <div>
            <h1 class="page-title">Edit Mahasiswa</h1>
            <p class="page-description">Perbarui identitas akademik atau akun mahasiswa.</p>
        </div>
    </div>
</div>

<div class="card form-card mx-auto" style="max-width:860px">
    <div class="card-header-clean">
        <div>
            <h2>Form Mahasiswa</h2>
            <div class="text-secondary small mt-1">Pastikan data baru telah sesuai.</div>
        </div>
        <span class="badge-soft-warning"><i class="bi bi-pencil-fill"></i> Mode edit</span>
    </div>
    <div class="card-body-modern">
        <form method="POST" action="{{ route('admin.mahasiswa.update', $mahasiswa) }}">
            @csrf @method('PUT')

            <div class="form-section-title"><i class="bi bi-person-vcard"></i> Identitas Akademik</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="npm">NPM</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-lock"></i>
                        <input id="npm" name="npm" value="{{ old('npm', $mahasiswa->npm) }}" class="form-control" readonly>
                    </div>
                    <div class="form-text">NPM dikunci agar relasi data tetap aman.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="nama">Nama Lengkap</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-person"></i>
                        <input id="nama" name="nama" maxlength="50" value="{{ old('nama', $mahasiswa->nama) }}" class="form-control @error('nama') is-invalid @enderror" required>
                    </div>
                    @error('nama')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label" for="nidn">Dosen Wali</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-person-badge"></i>
                        <select id="nidn" name="nidn" class="form-select @error('nidn') is-invalid @enderror" required>
                            @foreach($dosens as $dosen)
                                <option value="{{ $dosen->nidn }}" @selected(old('nidn', $mahasiswa->nidn) === $dosen->nidn)>{{ $dosen->nidn }} - {{ $dosen->nama }}</option>
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
                        <input id="email" type="email" name="email" value="{{ old('email', $mahasiswa->user?->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                    </div>
                    @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="password">Password Baru</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-key"></i>
                        <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak diubah">
                        <button type="button" class="password-toggle" data-password-toggle="password" aria-label="Tampilkan password"><i class="bi bi-eye"></i></button>
                    </div>
                    <div class="form-text">Kosongkan apabila password tidak ingin diubah.</div>
                    @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-key-fill"></i>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                        <button type="button" class="password-toggle" data-password-toggle="password_confirmation" aria-label="Tampilkan password"><i class="bi bi-eye"></i></button>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <button class="btn btn-primary px-4" type="submit"><i class="bi bi-check2-circle me-1"></i>Simpan Perubahan</button>
                <a class="btn btn-outline-secondary px-4" href="{{ route('admin.mahasiswa.index') }}"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
