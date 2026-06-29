@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="plain-login-page">
    <div class="plain-login-card">
        <div class="plain-login-header">
            <div class="plain-login-logo">S</div>
            <div>
                <h1>SIAKAD</h1>
                <p>Sistem Informasi Akademik</p>
            </div>
        </div>

        @include('partials.alerts')

        <form method="POST" action="{{ route('login.process') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required
                    autofocus
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <div class="plain-password-wrap">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        autocomplete="current-password"
                        required
                    >
                    <button type="button" class="plain-password-toggle" data-password-toggle="password" aria-label="Tampilkan password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>

            <button class="btn btn-primary w-100" type="submit">Masuk</button>
        </form>

        <div class="plain-demo-account">
            <small>Admin: admin@siakad.test / password</small><br>
            <small>Mahasiswa: mahasiswa@siakad.test / password</small>
        </div>
    </div>
</div>
@endsection
