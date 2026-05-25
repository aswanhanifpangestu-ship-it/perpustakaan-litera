@extends('layouts.app')

@section('title', 'Kategori')
@section('page-title', '🏷️ Manajemen Kategori')

@section('content')
<div class="row g-4">
    {{-- Form Tambah --}}
    <div class="col-lg-4">
        <div class="card table-card">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-bold">➕ Tambah Kategori</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">🏷️ Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama') }}" placeholder="Nama kategori">
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">📝 Deskripsi</label>
                        <textarea name="deskripsi"
                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                  rows="2" placeholder="Deskripsi kategori...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">➕ Tambah Kategori</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Daftar Kategori --}}
    <div class="col-lg-8">
        <div class="card table-card">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-bold">🏷️ Daftar Kategori</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>🏷️ Nama</th>
                                <th>📝 Deskripsi</th>
                                <th>📗 Jumlah Buku</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kategori as $k)
                            <tr>
                                <td class="text-muted small">{{ $kategori->firstItem() + $loop->index }}</td>
                                <td class="fw-semibold small">{{ $k->nama }}</td>
                                <td class="text-muted small">{{ $k->deskripsi ?? '—' }}</td>
                                <td>
                                    <span class="badge rounded-pill" style="background:#ccfbf1;color:#0f766e">
                                        {{ $k->buku_count }} buku
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('kategori.edit', $k) }}"
                                           class="btn btn-xs btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('kategori.destroy', $k) }}" method="POST"
                                              onsubmit="return confirm('Hapus kategori ini?')">
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
                                <td colspan="5" class="text-center text-muted py-5">
                                    <span style="font-size:2rem">🏷️</span>
                                    <div class="mt-2">Belum ada kategori.</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($kategori->hasPages())
            <div class="card-footer">{{ $kategori->links() }}</div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>.btn-xs { padding:.2rem .45rem; font-size:.75rem; }</style>
@endpush
@endsection
