@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', '🪪 Profil Saya')

@section('content')
<div class="row g-4 justify-content-center">
    <div class="col-lg-7">

        {{-- Info Profil --}}
        <div class="card table-card mb-4">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-bold">👤 Informasi Profil</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">👤 Nama Lengkap</label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', auth()->user()->name) }}">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">📧 Email</label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', auth()->user()->email) }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">📱 Telepon</label>
                            <input type="text" name="telepon" class="form-control"
                                   value="{{ old('telepon', auth()->user()->telepon) }}"
                                   placeholder="08xxxxxxxxxx">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">🪪 No. Anggota</label>
                            <input type="text" class="form-control"
                                   value="{{ auth()->user()->no_anggota ?? '—' }}" disabled
                                   style="background:#f0fdf9;color:#0f766e">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold small">📍 Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2"
                                      placeholder="Alamat lengkap...">{{ old('alamat', auth()->user()->alamat) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold small">🖼️ Foto Profil</label>
                            @if(auth()->user()->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . auth()->user()->foto) }}"
                                     class="rounded-circle shadow-sm"
                                     style="width:60px;height:60px;object-fit:cover;border:3px solid #ccfbf1">
                            </div>
                            @endif
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            <div class="form-text">Format JPG/PNG, maks 2MB.</div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">
                        💾 Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        {{-- Ganti Password --}}
        <div class="card table-card">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-bold">🔒 Ganti Password</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold small">🔑 Password Lama</label>
                            <input type="password" name="current_password"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   placeholder="Masukkan password lama">
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">🔒 Password Baru</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Min. 6 karakter">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">🔒 Konfirmasi Password</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control" placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning mt-3">
                        🔑 Ganti Password
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
