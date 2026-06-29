<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIAKAD')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/siakad.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plain-ui.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
@if(auth()->check())
    @php
        $user = auth()->user();
        $initial = mb_strtoupper(mb_substr($user->name, 0, 1));
    @endphp

    <div class="app-shell">
        <aside class="app-sidebar" aria-label="Navigasi utama">
            <a class="sidebar-brand" href="{{ route('dashboard') }}">
                <span class="plain-brand-icon">S</span>
                <span class="brand-title">SIAKAD</span>
            </a>

            <nav class="sidebar-nav">
                <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-house"></i>
                    <span>Dashboard</span>
                </a>

                @if($user->isAdmin())
                    <a class="sidebar-link {{ request()->routeIs('admin.dosen.*') ? 'active' : '' }}" href="{{ route('admin.dosen.index') }}">
                        <i class="bi bi-person-badge"></i>
                        <span>Data Dosen</span>
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}" href="{{ route('admin.mahasiswa.index') }}">
                        <i class="bi bi-people"></i>
                        <span>Data Mahasiswa</span>
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('admin.mata-kuliah.*') ? 'active' : '' }}" href="{{ route('admin.mata-kuliah.index') }}">
                        <i class="bi bi-book"></i>
                        <span>Mata Kuliah</span>
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}" href="{{ route('admin.jadwal.index') }}">
                        <i class="bi bi-calendar3"></i>
                        <span>Jadwal Kuliah</span>
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('admin.krs.*') ? 'active' : '' }}" href="{{ route('admin.krs.index') }}">
                        <i class="bi bi-clipboard-check"></i>
                        <span>Data KRS</span>
                    </a>
                @else
                    <a class="sidebar-link {{ request()->routeIs('mahasiswa.jadwal.*') ? 'active' : '' }}" href="{{ route('mahasiswa.jadwal.index') }}">
                        <i class="bi bi-calendar3"></i>
                        <span>Jadwal Kuliah</span>
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('mahasiswa.krs.*') ? 'active' : '' }}" href="{{ route('mahasiswa.krs.index') }}">
                        <i class="bi bi-clipboard-check"></i>
                        <span>KRS Saya</span>
                    </a>
                @endif
            </nav>

            <div class="sidebar-bottom">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="logout-button" type="submit">
                        <i class="bi bi-box-arrow-left"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="app-main">
            <header class="app-topbar">
                <div class="topbar-title">@yield('title', 'Dashboard')</div>

                <a class="plain-profile-link" href="{{ route('profile.show') }}">
                    <span class="plain-avatar">{{ $initial }}</span>
                    <span>{{ $user->name }}</span>
                </a>
            </header>

            <main class="app-content">
                @include('partials.alerts')
                @yield('content')
            </main>
        </div>
    </div>
@else
    @yield('content')
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/siakad.js') }}"></script>
@stack('scripts')
</body>
</html>
