@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="page-header">
    <div class="page-heading">
        <div class="page-heading-icon">
            <i class="bi bi-bell-fill"></i>
        </div>
        <div>
            <h1 class="page-title">Pusat Notifikasi</h1>
            <p class="page-description">
                Lihat pemberitahuan terbaru mengenai KRS, profil, dan persetujuan email.
            </p>
        </div>
    </div>

    <div class="d-flex flex-wrap gap-2">
        @if($unreadCount > 0)
            <form action="{{ route('notifications.read-all') }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-check2-all me-1"></i> Tandai Semua Dibaca
                </button>
            </form>
        @endif

        <form action="{{ route('notifications.clear-read') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-secondary"
                    onclick="return confirm('Hapus semua notifikasi yang sudah dibaca?')">
                <i class="bi bi-trash3 me-1"></i> Bersihkan Dibaca
            </button>
        </form>
    </div>
</div>

<div class="content-card">
    <div class="card-header-clean">
        <h2>
            <i class="bi bi-inbox-fill me-2 text-primary"></i>
            Semua Notifikasi
        </h2>
        <span class="badge-soft-primary">{{ $unreadCount }} belum dibaca</span>
    </div>

    <div class="notification-page-list">
        @forelse($notifications as $notification)
            @php
                $type = data_get($notification->data, 'type', 'primary');
                $icon = data_get($notification->data, 'icon', 'bi-bell-fill');
                $title = data_get($notification->data, 'title', 'Notifikasi');
                $message = data_get($notification->data, 'message', '');
            @endphp

            <article class="notification-page-item {{ is_null($notification->read_at) ? 'is-unread' : '' }}">
                <a href="{{ route('notifications.open', $notification->id) }}"
                   class="notification-page-main">
                    <span class="notification-icon notification-icon-{{ $type }}">
                        <i class="bi {{ $icon }}"></i>
                    </span>
                    <span class="notification-page-copy">
                        <span class="notification-page-title">
                            {{ $title }}
                            @if(is_null($notification->read_at))
                                <span class="notification-new-dot" title="Belum dibaca"></span>
                            @endif
                        </span>
                        <span class="notification-page-message">{{ $message }}</span>
                        <span class="notification-page-time">
                            <i class="bi bi-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                        </span>
                    </span>
                </a>

                <div class="notification-page-actions">
                    @if(is_null($notification->read_at))
                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-primary" title="Tandai dibaca">
                                <i class="bi bi-check2"></i>
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger-soft" title="Hapus notifikasi"
                                onclick="return confirm('Hapus notifikasi ini?')">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </form>
                </div>
            </article>
        @empty
            <div class="empty-state">
                <div class="empty-state-icon"><i class="bi bi-bell-slash"></i></div>
                <div class="empty-state-title">Belum ada notifikasi</div>
                <p class="empty-state-text">Notifikasi baru akan muncul di halaman ini.</p>
            </div>
        @endforelse
    </div>
</div>

@if($notifications->hasPages())
    <div class="mt-3">
        {{ $notifications->links() }}
    </div>
@endif
@endsection
