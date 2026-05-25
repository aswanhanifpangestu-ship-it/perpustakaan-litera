@extends('layouts.app')

@section('title', 'Daftar Buku')
@section('page-title', '📗 Daftar Buku')

@php use Illuminate\Support\Facades\Storage; @endphp

@section('content')
<div class="card table-card">
    <div class="card-header py-3">
        <div class="row g-2 align-items-center">
            <div class="col-md-7">
                <form action="{{ route('buku.index') }}" method="GET" class="d-flex gap-2 flex-wrap">
                    <input type="text" name="search" class="form-control form-control-sm"
                           placeholder="🔍 Cari judul, pengarang, ISBN..." value="{{ request('search') }}"
                           style="min-width:200px">
                    <select name="kategori" class="form-select form-select-sm" style="width:auto">
                        <option value="">🏷️ Semua Kategori</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                    @if(request()->hasAny(['search','kategori']))
                        <a href="{{ route('buku.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-x"></i>
                        </a>
                    @endif
                </form>
            </div>
            @if(auth()->user()->isAdminOrPetugas())
            <div class="col-md-5 text-md-end">
                <a href="{{ route('buku.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>➕ Tambah Buku
                </a>
            </div>
            @endif
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="40">#</th>
                        <th width="55">Sampul</th>
                        <th>📗 Judul</th>
                        <th>✍️ Pengarang</th>
                        <th>🏷️ Kategori</th>
                        <th>📅 Tahun</th>
                        <th>⭐ Rating</th>
                        <th>📦 Stok</th>
                        <th>✅ Tersedia</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buku as $b)
                    <tr>
                        <td class="text-muted small">{{ $buku->firstItem() + $loop->index }}</td>
                        <td>
                            @if($b->sampul_buku && Storage::disk('public')->exists($b->sampul_buku))
                                <img src="{{ Storage::disk('public')->url($b->sampul_buku) }}"
                                     alt="{{ $b->judul }}"
                                     class="rounded shadow-sm"
                                     style="width:38px;height:50px;object-fit:cover">
                            @else
                                <div class="rounded d-flex align-items-center justify-content-center"
                                     style="width:38px;height:50px;background:#ccfbf1">
                                    <span style="font-size:1.1rem">📗</span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold small">{{ $b->judul }}</div>
                            @if($b->isbn)
                                <small class="text-muted">ISBN: {{ $b->isbn }}</small>
                            @endif
                        </td>
                        <td class="small">{{ $b->pengarang }}</td>
                        <td>
                            <span class="badge rounded-pill"
                                  style="background:#ccfbf1;color:#0f766e;font-size:.72rem">
                                {{ $b->kategori->nama ?? '—' }}
                            </span>
                        </td>
                        <td class="small">{{ $b->tahun_terbit }}</td>
                        <td>
                            @php $rata = $b->ratingRata(); @endphp
                            @if($rata > 0)
                                <div class="d-flex align-items-center gap-1">
                                    <span style="color:#f59e0b">★</span>
                                    <span class="small fw-semibold">{{ $rata }}</span>
                                    <span class="text-muted" style="font-size:.7rem">({{ $b->ulasan->count() }})</span>
                                </div>
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                        <td class="small fw-semibold">{{ $b->stok }}</td>
                        <td>
                            @if($b->stok_tersedia > 0)
                                <span class="badge rounded-pill bg-success">{{ $b->stok_tersedia }}</span>
                            @else
                                <span class="badge rounded-pill bg-danger">Habis</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('buku.show', $b) }}"
                                   class="btn btn-xs btn-outline-primary" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(auth()->user()->isAdminOrPetugas())
                                <a href="{{ route('buku.edit', $b) }}"
                                   class="btn btn-xs btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('buku.destroy', $b) }}" method="POST"
                                      onsubmit="return confirm('Hapus buku ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-5">
                            <span style="font-size:2.5rem">📭</span>
                            <div class="mt-2">Tidak ada buku ditemukan.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($buku->hasPages())
    <div class="card-footer">{{ $buku->links() }}</div>
    @endif
</div>

@push('styles')
<style>.btn-xs { padding:.2rem .45rem; font-size:.75rem; }</style>
@endpush
@endsection
