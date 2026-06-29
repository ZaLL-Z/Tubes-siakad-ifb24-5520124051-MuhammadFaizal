@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-description">Ringkasan data akademik.</p>
    </div>
</div>

@php
    $cards = [
        ['label' => 'Dosen', 'value' => $jumlahDosen, 'route' => route('admin.dosen.index'), 'icon' => 'bi-person-badge'],
        ['label' => 'Mahasiswa', 'value' => $jumlahMahasiswa, 'route' => route('admin.mahasiswa.index'), 'icon' => 'bi-people'],
        ['label' => 'Mata Kuliah', 'value' => $jumlahMataKuliah, 'route' => route('admin.mata-kuliah.index'), 'icon' => 'bi-book'],
        ['label' => 'Jadwal', 'value' => $jumlahJadwal, 'route' => route('admin.jadwal.index'), 'icon' => 'bi-calendar3'],
        ['label' => 'KRS', 'value' => $jumlahKrs, 'route' => route('admin.krs.index'), 'icon' => 'bi-clipboard-check'],
    ];
@endphp

<div class="row g-3 mb-4">
    @foreach($cards as $card)
        <div class="col-sm-6 col-xl">
            <a href="{{ $card['route'] }}" class="text-decoration-none">
                <div class="stat-card h-100">
                    <div class="stat-icon"><i class="bi {{ $card['icon'] }}"></i></div>
                    <div class="stat-label">{{ $card['label'] }}</div>
                    <div class="stat-value">{{ $card['value'] }}</div>
                </div>
            </a>
        </div>
    @endforeach
</div>

<section class="content-card">
    <div class="card-header-clean">
        <div>
            <h2>Akses Cepat</h2>
            <div class="text-secondary small mt-1">Pilih data yang ingin ditambahkan.</div>
        </div>
    </div>

    <div class="card-body-modern">
        <div class="quick-action-grid">
            <a class="quick-action" href="{{ route('admin.dosen.create') }}">
                <span class="quick-action-icon"><i class="bi bi-person-plus"></i></span>
                <span class="quick-action-title">Tambah Dosen</span>
            </a>
            <a class="quick-action" href="{{ route('admin.mahasiswa.create') }}">
                <span class="quick-action-icon"><i class="bi bi-person-add"></i></span>
                <span class="quick-action-title">Tambah Mahasiswa</span>
            </a>
            <a class="quick-action" href="{{ route('admin.mata-kuliah.create') }}">
                <span class="quick-action-icon"><i class="bi bi-journal-plus"></i></span>
                <span class="quick-action-title">Tambah Mata Kuliah</span>
            </a>
            <a class="quick-action" href="{{ route('admin.jadwal.create') }}">
                <span class="quick-action-icon"><i class="bi bi-calendar-plus"></i></span>
                <span class="quick-action-title">Tambah Jadwal</span>
            </a>
            <a class="quick-action" href="{{ route('admin.krs.create') }}">
                <span class="quick-action-icon"><i class="bi bi-clipboard-plus"></i></span>
                <span class="quick-action-title">Tambah KRS</span>
            </a>
        </div>
    </div>
</section>
@endsection
