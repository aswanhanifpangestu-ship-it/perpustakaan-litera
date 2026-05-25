@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', '🏠 Dashboard')

@section('content')

{{-- ── Stat Cards ── --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#ccfbf1">
                    <span style="font-size:1.5rem">📗</span>
                </div>
                <div>
                    <div class="fs-3 fw-bold" style="color:#0f766e">{{ $data['totalBuku'] }}</div>
                    <div class="small text-muted">Total Buku</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#ede9fe">
                    <span style="font-size:1.5rem">👥</span>
                </div>
                <div>
                    <div class="fs-3 fw-bold" style="color:#5b21b6">{{ $data['totalAnggota'] }}</div>
                    <div class="small text-muted">Total Anggota</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#fef3c7">
                    <span style="font-size:1.5rem">📋</span>
                </div>
                <div>
                    <div class="fs-3 fw-bold" style="color:#d97706">{{ $data['totalDipinjam'] }}</div>
                    <div class="small text-muted">Sedang Dipinjam</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#fce7f3">
                    <span style="font-size:1.5rem">⏳</span>
                </div>
                <div>
                    <div class="fs-3 fw-bold" style="color:#be185d">{{ $data['totalPending'] }}</div>
                    <div class="small text-muted">Menunggu Persetujuan</div>
                </div>
            </div>
        </div>
    </div>

    @if($user->isUser())
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100 {{ $data['dendaPribadi'] > 0 ? 'border-danger' : '' }}">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#fee2e2">
                    <span style="font-size:1.5rem">💸</span>
                </div>
                <div>
                    <div class="fw-bold {{ $data['dendaPribadi'] > 0 ? 'text-danger' : '' }}" style="font-size:1.1rem">
                        Rp {{ number_format($data['dendaPribadi'], 0, ',', '.') }}
                    </div>
                    <div class="small text-muted">Denda Belum Bayar</div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100 {{ $data['totalDendaBelumBayar'] > 0 ? 'border-danger' : '' }}">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#fee2e2">
                    <span style="font-size:1.5rem">💰</span>
                </div>
                <div>
                    <div class="fw-bold {{ $data['totalDendaBelumBayar'] > 0 ? 'text-danger' : '' }}" style="font-size:1.1rem">
                        Rp {{ number_format($data['totalDendaBelumBayar'], 0, ',', '.') }}
                    </div>
                    <div class="small text-muted">Total Denda Belum Bayar</div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@if($user->isUser())
{{-- ── View Anggota ── --}}
<div class="card table-card">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">📋 Peminjaman Saya</h6>
        <a href="{{ route('peminjaman.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Ajukan Peminjaman
        </a>
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
                    @forelse($data['peminjamanSaya'] as $p)
                    <tr>
                        <td class="fw-semibold small">{{ $p->buku->judul }}</td>
                        <td class="small">{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                        <td class="small">{{ $p->tanggal_kembali->format('d/m/Y') }}</td>
                        <td>@include('peminjaman._badge_status', ['status' => $p->status])</td>
                        <td class="small">
                            @if($p->total_denda > 0)
                                <span class="{{ $p->status_denda === 'belum_bayar' ? 'text-danger fw-semibold' : 'text-success' }}">
                                    Rp {{ number_format($p->total_denda, 0, ',', '.') }}
                                    @if($p->status_denda === 'sudah_bayar') ✅ @endif
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <span style="font-size:2rem">📭</span>
                            <div class="mt-2">Belum ada peminjaman.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-primary">
            Lihat Semua Peminjaman →
        </a>
    </div>
</div>

@else
{{-- ── View Admin/Petugas ── --}}

@if($data['pengajuanPending']->count() > 0)
<div class="alert border-0 rounded-3 shadow-sm mb-4 d-flex align-items-center gap-3"
     style="background:#fef3c7;color:#92400e">
    <span style="font-size:1.5rem">⏳</span>
    <div>
        <strong>{{ $data['totalPending'] }} pengajuan peminjaman</strong> menunggu persetujuan.
        <a href="{{ route('peminjaman.index', ['status' => 'pending']) }}"
           class="ms-2 fw-semibold" style="color:#92400e">Proses sekarang →</a>
    </div>
</div>
@endif

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card table-card">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">📋 Peminjaman Terbaru</h6>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>👤 Anggota</th>
                                <th>📗 Buku</th>
                                <th>📅 Tgl Kembali</th>
                                <th>🔖 Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['peminjamanTerbaru'] as $p)
                            <tr>
                                <td class="small fw-semibold">{{ $p->user->name }}</td>
                                <td class="small text-truncate" style="max-width:150px">{{ $p->buku->judul }}</td>
                                <td class="small">{{ $p->tanggal_kembali->format('d/m/Y') }}</td>
                                <td>@include('peminjaman._badge_status', ['status' => $p->status])</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <span style="font-size:1.5rem">📭</span><div class="mt-1">Belum ada data.</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card table-card">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">📗 Buku Terbaru</h6>
                <a href="{{ route('buku.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($data['bukuTerbaru'] as $b)
                    <li class="list-group-item px-3 py-2" style="border-color:#ccfbf1">
                        <div class="fw-semibold small text-truncate">{{ $b->judul }}</div>
                        <div class="text-muted" style="font-size:.75rem">
                            ✍️ {{ $b->pengarang }} &bull;
                            <span class="badge" style="background:#ccfbf1;color:#0f766e">{{ $b->kategori->nama ?? '-' }}</span>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center text-muted py-4">
                        <span style="font-size:1.5rem">📭</span><div class="mt-1">Belum ada buku.</div>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
