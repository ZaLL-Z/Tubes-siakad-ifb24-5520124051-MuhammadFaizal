@extends('layouts.app')

@section('title', 'Persetujuan Email')

@section('content')
<div class="page-header">
    <div class="page-heading">
        <div class="page-heading-icon"><i class="bi bi-envelope-check-fill"></i></div>
        <div>
            <h1 class="page-title">Persetujuan Perubahan Email</h1>
            <p class="page-description">Tinjau permintaan email baru sebelum diterapkan ke akun mahasiswa.</p>
        </div>
    </div>
    <span class="badge-soft-warning"><i class="bi bi-hourglass-split"></i> {{ \App\Models\EmailChangeRequest::pending()->count() }} menunggu</span>
</div>

<div class="content-card">
    <div class="card-header-clean">
        <div>
            <h2>Daftar Permintaan</h2>
            <div class="text-secondary small mt-1">Setujui hanya jika identitas pengguna telah sesuai.</div>
        </div>
        <span class="badge-soft-primary"><i class="bi bi-shield-check"></i> Administrator</span>
    </div>

    <div class="card-body-modern">
        <form method="GET" action="{{ route('admin.email-requests.index') }}" class="filter-bar">
            <div class="row g-2 align-items-end">
                <div class="col-lg-7">
                    <label class="form-label" for="search">Cari pengguna atau email</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-search"></i>
                        <input
                            id="search"
                            type="search"
                            name="search"
                            class="form-control"
                            value="{{ $search }}"
                            placeholder="Nama, email lama, atau email baru"
                        >
                    </div>
                </div>
                <div class="col-lg-3">
                    <label class="form-label" for="status">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="pending" @selected($status === 'pending')>Menunggu</option>
                        <option value="approved" @selected($status === 'approved')>Disetujui</option>
                        <option value="rejected" @selected($status === 'rejected')>Ditolak</option>
                        <option value="cancelled" @selected($status === 'cancelled')>Dibatalkan</option>
                        <option value="all" @selected($status === 'all')>Semua status</option>
                    </select>
                </div>
                <div class="col-lg-2 d-grid">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                </div>
            </div>
        </form>

        @if($emailRequests->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon"><i class="bi bi-inbox"></i></div>
                <div class="empty-state-title">Belum ada permintaan</div>
                <p class="empty-state-text">Tidak ditemukan permintaan perubahan email untuk filter ini.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Perubahan Email</th>
                            <th>Diajukan</th>
                            <th>Status</th>
                            <th>Diproses Oleh</th>
                            <th class="text-end">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emailRequests as $emailRequest)
                            @php
                                $requestUser = $emailRequest->user;
                                $statusClass = match($emailRequest->status) {
                                    'approved' => 'badge-soft-success',
                                    'rejected' => 'badge-soft-warning',
                                    'cancelled' => 'badge-soft-neutral',
                                    default => 'badge-soft-info',
                                };
                                $statusIcon = match($emailRequest->status) {
                                    'approved' => 'bi-check-circle-fill',
                                    'rejected' => 'bi-x-circle-fill',
                                    'cancelled' => 'bi-dash-circle-fill',
                                    default => 'bi-hourglass-split',
                                };
                                $statusText = match($emailRequest->status) {
                                    'approved' => 'Disetujui',
                                    'rejected' => 'Ditolak',
                                    'cancelled' => 'Dibatalkan',
                                    default => 'Menunggu',
                                };
                            @endphp
                            <tr>
                                <td>
                                    <div class="person-cell">
                                        @if($requestUser?->profile_photo)
                                            <img class="person-avatar person-avatar-photo" src="{{ asset('storage/'.$requestUser->profile_photo) }}" alt="Foto {{ $requestUser->name }}">
                                        @else
                                            <div class="person-avatar">{{ $requestUser ? mb_strtoupper(mb_substr($requestUser->name, 0, 1)) : '?' }}</div>
                                        @endif
                                        <div>
                                            <div class="person-name">{{ $requestUser?->name ?? 'Akun dihapus' }}</div>
                                            <div class="person-sub">{{ ucfirst($requestUser?->role ?? '-') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="email-change-flow">
                                        <span class="email-old">{{ $emailRequest->old_email }}</span>
                                        <i class="bi bi-arrow-right"></i>
                                        <span class="email-new">{{ $emailRequest->new_email }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="small fw-semibold">{{ $emailRequest->created_at->format('d M Y') }}</div>
                                    <div class="person-sub">{{ $emailRequest->created_at->format('H:i') }} WIB</div>
                                </td>
                                <td>
                                    <span class="{{ $statusClass }}">
                                        <i class="bi {{ $statusIcon }}"></i> {{ $statusText }}
                                    </span>
                                    @if($emailRequest->admin_note)
                                        <div class="person-sub mt-1 request-note" title="{{ $emailRequest->admin_note }}">
                                            {{ \Illuminate\Support\Str::limit($emailRequest->admin_note, 45) }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($emailRequest->reviewer)
                                        <div class="small fw-semibold">{{ $emailRequest->reviewer->name }}</div>
                                        <div class="person-sub">{{ optional($emailRequest->reviewed_at)->format('d M Y, H:i') }}</div>
                                    @else
                                        <span class="text-secondary small">Belum diproses</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if($emailRequest->status === 'pending')
                                        <div class="approval-actions">
                                            <form action="{{ route('admin.email-requests.approve', $emailRequest) }}" method="POST" onsubmit="return confirm('Setujui perubahan email ke {{ $emailRequest->new_email }}?')">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-sm btn-success" type="submit">
                                                    <i class="bi bi-check-lg"></i> Setujui
                                                </button>
                                            </form>

                                            <button
                                                class="btn btn-sm btn-danger-soft"
                                                type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#rejectModal{{ $emailRequest->id }}"
                                            >
                                                <i class="bi bi-x-lg"></i> Tolak
                                            </button>
                                        </div>

                                        <div class="modal fade" id="rejectModal{{ $emailRequest->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content modern-modal">
                                                    <form action="{{ route('admin.email-requests.reject', $emailRequest) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tolak Perubahan Email</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            <p class="text-secondary small">
                                                                Permintaan dari <strong>{{ $requestUser?->name }}</strong> ke
                                                                <strong>{{ $emailRequest->new_email }}</strong> akan ditolak.
                                                            </p>
                                                            <label class="form-label" for="admin_note_{{ $emailRequest->id }}">Alasan penolakan</label>
                                                            <textarea
                                                                id="admin_note_{{ $emailRequest->id }}"
                                                                name="admin_note"
                                                                class="form-control"
                                                                rows="4"
                                                                maxlength="500"
                                                                placeholder="Contoh: Email belum dapat diverifikasi."
                                                            ></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="bi bi-x-circle me-1"></i> Tolak Permintaan
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-secondary small">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $emailRequests->links() }}
        @endif
    </div>
</div>
@endsection
