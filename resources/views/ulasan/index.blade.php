@extends('layouts.app')

@section('title', 'Manajemen Ulasan')
@section('page-title', '⭐ Manajemen Ulasan')

@section('content')

{{-- Statistik --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#fef3c7">
                    <span style="font-size:1.5rem">⭐</span>
                </div>
                <div>
                    <div class="fs-3 fw-bold" style="color:#d97706">{{ $stats['total'] }}</div>
                    <div class="small text-muted">Total Ulasan</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#ccfbf1">
                    <span style="font-size:1.5rem">📊</span>
                </div>
                <div>
                    <div class="fs-3 fw-bold" style="color:#0f766e">{{ $stats['rata_rata'] }}</div>
                    <div class="small text-muted">Rata-rata Rating</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#dcfce7">
                    <span style="font-size:1.5rem">😍</span>
                </div>
                <div>
                    <div class="fs-3 fw-bold text-success">{{ $stats['bintang5'] }}</div>
                    <div class="small text-muted">Bintang 5 ★★★★★</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#fee2e2">
                    <span style="font-size:1.5rem">😞</span>
                </div>
                <div>
                    <div class="fs-3 fw-bold text-danger">{{ $stats['bintang1'] }}</div>
                    <div class="small text-muted">Bintang 1 ★</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Ulasan --}}
<div class="card table-card">
    <div class="card-header py-3">
        <div class="row g-2 align-items-center">
            <div class="col-md-9">
                <form action="{{ route('ulasan.index') }}" method="GET" class="d-flex gap-2 flex-wrap">
                    <input type="text" name="search" class="form-control form-control-sm"
                           style="min-width:180px"
                           placeholder="🔍 Cari judul buku atau nama anggota..."
                           value="{{ request('search') }}">
                    <select name="rating" class="form-select form-select-sm" style="width:auto">
                        <option value="">⭐ Semua Rating</option>
                        @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                            {{ str_repeat('★',$i) }} {{ $i }} Bintang
                        </option>
                        @endfor
                    </select>
                    <select name="buku_id" class="form-select form-select-sm" style="width:auto;max-width:200px">
                        <option value="">📗 Semua Buku</option>
                        @foreach($buku as $b)
                        <option value="{{ $b->id }}" {{ request('buku_id') == $b->id ? 'selected' : '' }}>
                            {{ Str::limit($b->judul, 35) }}
                        </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                    @if(request()->hasAny(['search','rating','buku_id']))
                        <a href="{{ route('ulasan.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-x"></i>
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>📗 Buku</th>
                        <th>👤 Anggota</th>
                        <th>⭐ Rating</th>
                        <th>💬 Komentar</th>
                        <th>📅 Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ulasan as $u)
                    <tr>
                        <td class="text-muted small">{{ $ulasan->firstItem() + $loop->index }}</td>
                        <td>
                            <a href="{{ route('buku.show', $u->buku) }}"
                               class="fw-semibold small text-decoration-none" style="color:#0f766e">
                                {{ $u->buku->judul }}
                            </a>
                            <div class="text-muted" style="font-size:.72rem">✍️ {{ $u->buku->pengarang }}</div>
                        </td>
                        <td>
                            <div class="small fw-semibold">{{ $u->user->name }}</div>
                            <div class="text-muted" style="font-size:.72rem">{{ $u->user->no_anggota ?? '—' }}</div>
                        </td>
                        <td>
                            @include('ulasan._star_rating', ['rating' => $u->rating, 'size' => 'sm'])
                            <span class="small text-muted ms-1">{{ $u->rating }}/5</span>
                        </td>
                        <td class="small text-muted" style="max-width:220px">
                            @if($u->komentar)
                                <span title="{{ $u->komentar }}">{{ Str::limit($u->komentar, 60) }}</span>
                            @else
                                <span class="fst-italic">—</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $u->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('peminjaman.show', $u->peminjaman) }}"
                                   class="btn btn-xs btn-outline-primary" title="Lihat Peminjaman">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form action="{{ route('ulasan.destroy', $u) }}" method="POST"
                                      onsubmit="return confirm('Hapus ulasan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <span style="font-size:2.5rem">⭐</span>
                            <div class="mt-2">Tidak ada ulasan ditemukan.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($ulasan->hasPages())
    <div class="card-footer">{{ $ulasan->links() }}</div>
    @endif
</div>

@push('styles')
<style>.btn-xs { padding:.2rem .45rem; font-size:.75rem; }</style>
@endpush
@endsection
