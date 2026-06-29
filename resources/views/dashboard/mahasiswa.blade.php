@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="hero-card">
    <div class="hero-eyebrow"><i class="bi bi-mortarboard-fill"></i> Portal Mahasiswa</div>
    <h1 class="hero-title">Halo, {{ $mahasiswa->nama }}!</h1>
    <p class="hero-text">
        NPM {{ $mahasiswa->npm }} · Kelola KRS dan lihat jadwal perkuliahanmu dari satu tempat.
    </p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card" style="--stat-color:#6366f1; --stat-soft:#eef2ff;">
            <div class="stat-icon"><i class="bi bi-journal-check"></i></div>
            <div class="stat-label">Mata Kuliah Diambil</div>
            <div class="stat-value">{{ $jumlahKrs }}</div>
            <a class="stat-link" href="{{ route('mahasiswa.krs.index') }}">Lihat KRS <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="--stat-color:#10b981; --stat-soft:#ecfdf5;">
            <div class="stat-icon"><i class="bi bi-bar-chart-fill"></i></div>
            <div class="stat-label">Total SKS</div>
            <div class="stat-value">{{ $totalSks }}</div>
            <span class="stat-link text-success"><i class="bi bi-check-circle-fill"></i> Terhitung otomatis</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="--stat-color:#0ea5e9; --stat-soft:#f0f9ff;">
            <div class="stat-icon"><i class="bi bi-calendar2-week-fill"></i></div>
            <div class="stat-label">Jadwal Tersedia</div>
            <div class="stat-value">{{ $jumlahJadwal }}</div>
            <a class="stat-link" href="{{ route('mahasiswa.jadwal.index') }}">Lihat jadwal <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</div>

<div class="card content-card">
    <div class="card-header-clean">
        <div>
            <h2>Menu Cepat</h2>
            <div class="text-secondary small mt-1">Akses kebutuhan akademikmu dengan cepat.</div>
        </div>
        <span class="badge-soft-primary"><i class="bi bi-lightning-charge-fill"></i> Pintasan</span>
    </div>
    <div class="card-body-modern">
        <div class="quick-action-grid">
            <a class="quick-action" href="{{ route('mahasiswa.krs.create') }}">
                <span class="quick-action-icon"><i class="bi bi-plus-circle-fill"></i></span>
                <span>
                    <span class="quick-action-title d-block">Ambil Mata Kuliah</span>
                    <span class="quick-action-text d-block">Tambahkan mata kuliah ke KRS</span>
                </span>
            </a>
            <a class="quick-action" href="{{ route('mahasiswa.krs.index') }}">
                <span class="quick-action-icon"><i class="bi bi-clipboard2-check-fill"></i></span>
                <span>
                    <span class="quick-action-title d-block">KRS Saya</span>
                    <span class="quick-action-text d-block">Lihat daftar mata kuliah diambil</span>
                </span>
            </a>
            <a class="quick-action" href="{{ route('mahasiswa.jadwal.index') }}">
                <span class="quick-action-icon"><i class="bi bi-calendar2-week-fill"></i></span>
                <span>
                    <span class="quick-action-title d-block">Jadwal Kuliah</span>
                    <span class="quick-action-text d-block">Cek hari, kelas, dan jam kuliah</span>
                </span>
            </a>
        </div>
    </div>
</div>
@endsection
