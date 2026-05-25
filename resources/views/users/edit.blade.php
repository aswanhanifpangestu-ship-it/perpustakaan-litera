@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('page-title', '✏️ Edit Pengguna')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card table-card">
            <div class="card-header py-3 d-flex align-items-center gap-2">
                <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary">← Kembali</a>
                <h6 class="mb-0 fw-bold">✏️ Edit: {{ $user->name }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">👤 Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">📧 Email <span class="text-danger">*</span></label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">🔒 Password Baru</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Kosongkan jika tidak diubah">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">🔒 Konfirmasi Password</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control" placeholder="Ulangi password baru">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">🎭 Role <span class="text-danger">*</span></label>
                            @if($isPetugas)
                                <input type="hidden" name="role" value="user">
                                <input type="text" class="form-control" value="👥 Anggota" disabled
                                       style="background:#f0fdf9;color:#0f766e">
                            @else
                                <select name="role" class="form-select @error('role') is-invalid @enderror">
                                    <option value="admin"   {{ old('role', $user->role) === 'admin'   ? 'selected' : '' }}>👑 Admin</option>
                                    <option value="petugas" {{ old('role', $user->role) === 'petugas' ? 'selected' : '' }}>🛡️ Petugas</option>
                                    <option value="user"    {{ old('role', $user->role) === 'user'    ? 'selected' : '' }}>👥 Anggota</option>
                                </select>
                                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">🪪 No. Anggota</label>
                            <input type="text" name="no_anggota"
                                   class="form-control @error('no_anggota') is-invalid @enderror"
                                   value="{{ old('no_anggota', $user->no_anggota) }}">
                            @error('no_anggota')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">📱 Telepon</label>
                            <input type="text" name="telepon" class="form-control"
                                   value="{{ old('telepon', $user->telepon) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">📍 Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $user->alamat) }}</textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active"
                                       id="isActive" value="1"
                                       {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                       style="border-color:#0d9488">
                                <label class="form-check-label fw-semibold small" for="isActive"
                                       style="color:#0f766e">✅ Akun Aktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">💾 Perbarui</button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
