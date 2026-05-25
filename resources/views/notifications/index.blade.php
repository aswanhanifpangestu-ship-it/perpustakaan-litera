@extends('layouts.app')

@section('title', 'Semua Notifikasi')
@section('page-title', '🔔 Semua Notifikasi')

@section('content')
<div class="card table-card">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-bold">🔔 Semua Notifikasi</h6>
        <form action="{{ route('notifications.markAllRead') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-primary">
                ✅ Tandai Semua Dibaca
            </button>
        </form>
    </div>

    <div class="card-body p-0">
        @forelse($notifications as $n)
        <div class="d-flex align-items-start gap-3 p-3 border-bottom"
             style="{{ !$n->is_read ? 'background:#f0fdf9' : '' }}">

            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1 {{ $n->iconBg() }}"
                 style="width:42px;height:42px;font-size:1.1rem">
                @if($n->type === 'petugas_baru') 🛡️
                @elseif($n->type === 'user_login') 🔑
                @else 📋
                @endif
            </div>

            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="fw-semibold small">{{ $n->judul }}</span>
                    @if(!$n->is_read)
                        <span class="badge rounded-pill bg-danger" style="font-size:.62rem">🆕 Baru</span>
                    @endif
                </div>
                <p class="mb-1 small text-muted">{{ $n->pesan }}</p>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted" style="font-size:.72rem">
                        🕐 {{ $n->created_at->diffForHumans() }}
                        &nbsp;·&nbsp; {{ $n->created_at->format('d M Y, H:i') }}
                    </span>
                    @if($n->url)
                    <a href="{{ route('notifications.read', $n) }}"
                       class="small text-decoration-none fw-semibold" style="color:#0d9488">
                        Lihat Detail →
                    </a>
                    @endif
                </div>
            </div>

            <form action="{{ route('notifications.destroy', $n) }}" method="POST"
                  onsubmit="return confirm('Hapus notifikasi ini?')" class="flex-shrink-0">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-xs btn-outline-danger" title="Hapus">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        </div>
        @empty
        <div class="text-center text-muted py-5">
            <span style="font-size:3rem">🔕</span>
            <div class="mt-2 fw-semibold">Tidak ada notifikasi.</div>
        </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
    <div class="card-footer">{{ $notifications->links() }}</div>
    @endif
</div>

@push('styles')
<style>.btn-xs { padding:.2rem .45rem; font-size:.75rem; }</style>
@endpush
@endsection
