@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Profil Saya</h1>
        <p class="page-description">Kelola nama akun dan keamanan password.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <section class="content-card h-100">
            <div class="card-header-clean">
                <div>
                    <h2>Informasi Akun</h2>
                    <div class="text-secondary small mt-1">Informasi dasar akun yang sedang digunakan.</div>
                </div>
            </div>

            <div class="card-body-modern">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="user-avatar" style="width:56px;height:56px;font-size:1.1rem;">
                        {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-bold">{{ $user->name }}</div>
                        <div class="text-secondary small">{{ ucfirst($user->role) }}</div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Email akun</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                    <div class="form-text">Email hanya dapat dikelola melalui administrator data mahasiswa.</div>
                </div>

                <form action="{{ route('profile.name.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label" for="name">Nama lengkap</label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}"
                            maxlength="50"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-check2 me-1"></i>Simpan Nama
                    </button>
                </form>
            </div>
        </section>
    </div>

    <div class="col-lg-7">
        <section class="content-card h-100">
            <div class="card-header-clean">
                <div>
                    <h2>Ganti Password</h2>
                    <div class="text-secondary small mt-1">Gunakan password baru minimal 8 karakter.</div>
                </div>
            </div>

            <div class="card-body-modern">
                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label" for="current_password">Password saat ini</label>
                        <div class="input-icon-wrap">
                            <i class="bi bi-key"></i>
                            <input
                                id="current_password"
                                type="password"
                                name="current_password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                autocomplete="current-password"
                                required
                            >
                            <button type="button" class="password-toggle" data-password-toggle="current_password" aria-label="Tampilkan password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="password">Password baru</label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-lock"></i>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    minlength="8"
                                    autocomplete="new-password"
                                    required
                                >
                                <button type="button" class="password-toggle" data-password-toggle="password" aria-label="Tampilkan password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="password_confirmation">Konfirmasi password</label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-lock-fill"></i>
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    minlength="8"
                                    autocomplete="new-password"
                                    required
                                >
                                <button type="button" class="password-toggle" data-password-toggle="password_confirmation" aria-label="Tampilkan password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary mt-4" type="submit">
                        <i class="bi bi-shield-check me-1"></i>Ganti Password
                    </button>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection
