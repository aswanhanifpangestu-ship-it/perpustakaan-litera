@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('page-title', '➕ Tambah Pengguna')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card table-card">
            <div class="card-header py-3 d-flex align-items-center gap-2">
                <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary">← Kembali</a>
                <h6 class="mb-0 fw-bold">➕ Form Tambah Pengguna</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">👤 Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" placeholder="Nama lengkap">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">📧 Email <span class="text-danger">*</span></label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="email@contoh.com">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">🔒 Password <span class="text-danger">*</span></label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Min. 6 karakter">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">🔒 Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation"
                                   class="form-control" placeholder="Ulangi password">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">🎭 Role <span class="text-danger">*</span></label>
                            @php $defaultRole = old('role', request('role', '')); @endphp
                            @if($isPetugas)
                                <input type="hidden" name="role" value="user">
                                <input type="text" class="form-control" value="👥 Anggota" disabled
                                       style="background:#f0fdf9;color:#0f766e">
                            @else
                                <select name="role" class="form-select @error('role') is-invalid @enderror">
                                    <option value="">— Pilih Role —</option>
                                    <option value="admin"   {{ $defaultRole === 'admin'   ? 'selected' : '' }}>👑 Admin</option>
                                    <option value="petugas" {{ $defaultRole === 'petugas' ? 'selected' : '' }}>🛡️ Petugas</option>
                                    <option value="user"    {{ $defaultRole === 'user'    ? 'selected' : '' }}>👥 Anggota</option>
                                </select>
                                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">🪪 No. Anggota</label>
                            <input type="text" name="no_anggota"
                                   class="form-control @error('no_anggota') is-invalid @enderror"
                                   value="{{ old('no_anggota') }}" placeholder="ANG-001">
                            @error('no_anggota')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">📱 Telepon</label>
                            <input type="text" name="telepon"
                                   class="form-control @error('telepon') is-invalid @enderror"
                                   value="{{ old('telepon') }}" placeholder="08xxxxxxxxxx">
                            @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">📍 Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2"
                                      placeholder="Alamat lengkap...">{{ old('alamat') }}</textarea>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">➕ Tambah Pengguna</button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
