@extends('layouts.app')

@section('title', 'Tambah Buku')
@section('page-title', '➕ Tambah Buku')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">

        @if($errors->any())
        <div class="rounded-3 p-3 mb-4 d-flex gap-2" style="background:#fff1f2;border:1px solid #fecdd3;color:#9f1239">
            <span style="font-size:1.2rem">❌</span>
            <div>
                <div class="fw-bold small">{{ $errors->count() }} kesalahan pada form:</div>
                <ul class="mb-0 mt-1 ps-3 small">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="card table-card">
            <div class="card-header py-3 d-flex align-items-center gap-2">
                <a href="{{ route('buku.index') }}" class="btn btn-sm btn-outline-secondary">← Kembali</a>
                <h6 class="mb-0 fw-bold">📗 Form Tambah Buku</h6>
                <span class="ms-auto small text-muted"><span class="text-danger">*</span> wajib diisi</span>
            </div>
            <div class="card-body">
                <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    {{-- Step 1 --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                 style="width:26px;height:26px;background:#0d9488;color:#fff;font-size:.75rem">1</div>
                            <span class="fw-bold" style="color:#0f766e">📋 Informasi Utama</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold small">📗 Judul Buku <span class="text-danger">*</span></label>
                                <input type="text" name="judul"
                                       class="form-control @error('judul') is-invalid @enderror"
                                       value="{{ old('judul') }}" placeholder="Masukkan judul buku lengkap" autofocus>
                                @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">✍️ Pengarang <span class="text-danger">*</span></label>
                                <input type="text" name="pengarang"
                                       class="form-control @error('pengarang') is-invalid @enderror"
                                       value="{{ old('pengarang') }}" placeholder="Nama pengarang">
                                @error('pengarang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">🏢 Penerbit <span class="text-danger">*</span></label>
                                <input type="text" name="penerbit"
                                       class="form-control @error('penerbit') is-invalid @enderror"
                                       value="{{ old('penerbit') }}" placeholder="Nama penerbit">
                                @error('penerbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">🔢 ISBN <span class="text-danger">*</span></label>
                                <input type="text" name="isbn"
                                       class="form-control @error('isbn') is-invalid @enderror"
                                       value="{{ old('isbn') }}" placeholder="978-xxx-xxx-xxx-x" maxlength="20">
                                @error('isbn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">🏷️ Kategori <span class="text-danger">*</span></label>
                                <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror">
                                    <option value="">— Pilih Kategori —</option>
                                    @foreach($kategori as $k)
                                        <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">📅 Tahun Terbit <span class="text-danger">*</span></label>
                                <input type="number" name="tahun_terbit"
                                       class="form-control @error('tahun_terbit') is-invalid @enderror"
                                       value="{{ old('tahun_terbit', date('Y')) }}"
                                       min="1900" max="{{ date('Y') }}">
                                @error('tahun_terbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <hr style="border-color:#ccfbf1">

                    {{-- Step 2 --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                 style="width:26px;height:26px;background:#0d9488;color:#fff;font-size:.75rem">2</div>
                            <span class="fw-bold" style="color:#0f766e">📦 Stok &amp; Denda</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">📦 Stok <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="stok"
                                           class="form-control @error('stok') is-invalid @enderror"
                                           value="{{ old('stok', 1) }}" min="1">
                                    <span class="input-group-text" style="background:#f0fdf9;border-color:#ccfbf1">buku</span>
                                    @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">💸 Denda/Hari <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background:#f0fdf9;border-color:#ccfbf1">Rp</span>
                                    <input type="number" name="denda_per_hari"
                                           class="form-control @error('denda_per_hari') is-invalid @enderror"
                                           value="{{ old('denda_per_hari', 1000) }}" min="0" step="500">
                                    @error('denda_per_hari')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">📍 Lokasi Rak</label>
                                <input type="text" name="lokasi_rak"
                                       class="form-control @error('lokasi_rak') is-invalid @enderror"
                                       value="{{ old('lokasi_rak') }}" placeholder="Contoh: A-01" maxlength="50">
                                @error('lokasi_rak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <hr style="border-color:#ccfbf1">

                    {{-- Step 3 --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                 style="width:26px;height:26px;background:#0d9488;color:#fff;font-size:.75rem">3</div>
                            <span class="fw-bold" style="color:#0f766e">📝 Deskripsi &amp; Sampul</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold small">📝 Deskripsi</label>
                                <textarea name="deskripsi" rows="3"
                                          class="form-control @error('deskripsi') is-invalid @enderror"
                                          placeholder="Deskripsi singkat tentang buku ini...">{{ old('deskripsi') }}</textarea>
                                <div class="form-text">Opsional. Maks. 2000 karakter.</div>
                                @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            @include('buku._sampul_upload', ['isEdit' => false])
                        </div>
                    </div>

                    <hr style="border-color:#ccfbf1">
                    <div class="d-flex gap-2 align-items-center">
                        <button type="submit" class="btn btn-primary px-4">💾 Simpan Buku</button>
                        <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
