@extends('layouts.app')

@section('title', 'Detail Pengguna')
@section('page-title', '👤 Detail Pengguna')

@section('content')
<div class="row g-4">
    {{-- Kartu Profil --}}
    <div class="col-lg-4">
        <div class="card table-card text-center">
            <div class="card-body p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                     style="width:80px;height:80px;background:#ccfbf1;font-size:2.5rem">
                    @if($user->role === 'admin') 👑
                    @elseif($user->role === 'petugas') 🛡️
                    @else 👤
                    @endif
                </div>
                <h5 class="fw-bold mb-1" style="color:#134e4a">{{ $user->name }}</h5>
                <p class="text-muted small mb-2">{{ $user->email }}</p>

                <div class="d-flex justify-content-center gap-2 mb-3">
                    <span class="badge rounded-pill px-3 py-2
                        @if($user->role === 'admin') badge-admin
                        @elseif($user->role === 'petugas') badge-petugas
                        @else badge-user @endif">
                        @if($user->role === 'admin') 👑 @elseif($user->role === 'petugas') 🛡️ @else 📖 @endif
                        {{ ucfirst($user->role) }}
                    </span>
                    @if($user->is_active)
                        <span class="badge rounded-pill bg-success">✅ Aktif</span>
                    @else
                        <span class="badge rounded-pill bg-secondary">⛔ Nonaktif</span>
                    @endif
                </div>

                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm w-100">
                    ✏️ Edit Pengguna
                </a>
            </div>
        </div>
    </div>

    {{-- Detail + Riwayat --}}
    <div class="col-lg-8">
        <div class="card table-card mb-4">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-bold">📋 Informasi Pengguna</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted fw-semibold small" width="140">🪪 No. Anggota</td>
                        <td class="small">{{ $user->no_anggota ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold small">📱 Telepon</td>
                        <td class="small">{{ $user->telepon ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold small">📍 Alamat</td>
                        <td class="small">{{ $user->alamat ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold small">📅 Bergabung</td>
                        <td class="small">{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card table-card">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-bold">📋 Riwayat Peminjaman</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>📗 Buku</th>
                                <th>📅 Tgl Pinjam</th>
                                <th>📅 Tgl Kembali</th>
                                <th>🔖 Status</th>
                                <th>💸 Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->peminjaman->take(10) as $p)
                            <tr>
                                <td class="small fw-semibold">{{ $p->buku->judul }}</td>
                                <td class="small">{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td class="small">{{ $p->tanggal_kembali->format('d/m/Y') }}</td>
                                <td>@include('peminjaman._badge_status', ['status' => $p->status])</td>
                                <td class="small">
                                    @if($p->total_denda > 0)
                                        <span class="{{ $p->status_denda === 'belum_bayar' ? 'text-danger fw-semibold' : 'text-success' }}">
                                            Rp {{ number_format($p->total_denda, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <span style="font-size:1.5rem">📭</span>
                                    <div class="mt-1 small">Belum ada riwayat peminjaman.</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
        ← Kembali ke Daftar Pengguna
    </a>
</div>

@push('styles')
<style>
.badge-admin   { background:#fef3c7; color:#92400e; }
.badge-petugas { background:#ccfbf1; color:#0f766e; }
.badge-user    { background:#ede9fe; color:#5b21b6; }
</style>
@endpush
@endsection
