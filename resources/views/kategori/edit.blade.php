@extends('layouts.app')

@section('title', 'Edit Kategori')
@section('page-title', '✏️ Edit Kategori')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card table-card">
            <div class="card-header py-3 d-flex align-items-center gap-2">
                <a href="{{ route('kategori.index') }}" class="btn btn-sm btn-outline-secondary">← Kembali</a>
                <h6 class="mb-0 fw-bold">✏️ Edit Kategori</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('kategori.update', $kategori) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">🏷️ Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama', $kategori->nama) }}">
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold small">📝 Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"
                                  placeholder="Deskripsi kategori...">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">💾 Perbarui</button>
                        <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
