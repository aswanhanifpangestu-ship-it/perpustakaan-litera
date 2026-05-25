@extends('layouts.app')

@section('title', $buku->judul)
@section('page-title', '📗 Detail Buku')

@php use Illuminate\Support\Facades\Storage; @endphp

@section('content')
<div class="row g-4">
    {{-- Kolom Kiri: Sampul + Aksi --}}
    <div class="col-lg-4">
        <div class="card table-card text-center">
            <div class="card-body p-4">
                @php $sampulUrl = $buku->sampulUrl(); @endphp
                @if($sampulUrl)
                    <img src="{{ $sampulUrl }}" alt="{{ $buku->judul }}"
                         class="img-fluid rounded-3 shadow mb-3"
                         style="max-height:280px;max-width:100%;object-fit:contain">
                @else
                    <div class="rounded-3 d-flex align-items-center justify-content-center mb-3 mx-auto"
                         style="height:200px;max-width:160px;background:#ccfbf1">
                        <div class="text-center" style="color:#0d9488">
                            <span style="font-size:3.5rem">📗</span>
                            <div class="small mt-1">Tidak ada sampul</div>
                        </div>
                    </div>
                @endif

                <h5 class="fw-bold" style="color:#134e4a">{{ $buku->judul }}</h5>
                <p class="text-muted mb-2">✍️ {{ $buku->pengarang }}</p>
                <span class="badge rounded-pill px-3" style="background:#ccfbf1;color:#0f766e">
                    🏷️ {{ $buku->kategori->nama ?? '—' }}
                </span>

                {{-- Rating rata-rata --}}
                @php $rata = $buku->ratingRata(); @endphp
                @if($rata > 0)
                <div class="mt-2 d-flex align-items-center justify-content-center gap-1">
                    <span style="color:#f59e0b;font-size:1rem">★</span>
                    <span class="fw-bold" style="color:#d97706">{{ $rata }}</span>
                    <span class="text-muted small">({{ $buku->ulasan->count() }} ulasan)</span>
                </div>
                @endif

                <div class="row g-2 mt-3">
                    <div class="col-6">
                        <div class="rounded-3 p-2" style="background:#f0fdf9">
                            <div class="fw-bold fs-5" style="color:#0f766e">{{ $buku->stok }}</div>
                            <div class="small text-muted">📦 Total Stok</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="rounded-3 p-2 {{ $buku->stok_tersedia > 0 ? '' : '' }}"
                             style="background:{{ $buku->stok_tersedia > 0 ? '#dcfce7' : '#fee2e2' }}">
                            <div class="fw-bold fs-5" style="color:{{ $buku->stok_tersedia > 0 ? '#16a34a' : '#dc2626' }}">
                                {{ $buku->stok_tersedia }}
                            </div>
                            <div class="small text-muted">✅ Tersedia</div>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->isAdminOrPetugas())
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('buku.edit', $buku) }}" class="btn btn-warning btn-sm flex-fill">
                        ✏️ Edit
                    </a>
                    <form action="{{ route('buku.destroy', $buku) }}" method="POST"
                          onsubmit="return confirm('Hapus buku ini?')" class="flex-fill">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm w-100">🗑️ Hapus</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Info + Riwayat --}}
    <div class="col-lg-8">
        <div class="card table-card mb-4">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-bold">📋 Informasi Buku</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted fw-semibold small" width="140">📗 Judul</td>
                        <td class="fw-semibold">{{ $buku->judul }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold small">✍️ Pengarang</td>
                        <td>{{ $buku->pengarang }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold small">🏢 Penerbit</td>
                        <td>{{ $buku->penerbit }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold small">📅 Tahun Terbit</td>
                        <td>{{ $buku->tahun_terbit }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold small">🔢 ISBN</td>
                        <td>{{ $buku->isbn ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold small">🏷️ Kategori</td>
                        <td>
                            <span class="badge rounded-pill" style="background:#ccfbf1;color:#0f766e">
                                {{ $buku->kategori->nama ?? '—' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold small">📍 Lokasi Rak</td>
                        <td>{{ $buku->lokasi_rak ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold small">💸 Denda/Hari</td>
                        <td>Rp {{ number_format($buku->denda_per_hari, 0, ',', '.') }}</td>
                    </tr>
                    @if($buku->deskripsi)
                    <tr>
                        <td class="text-muted fw-semibold small">📝 Deskripsi</td>
                        <td>{{ $buku->deskripsi }}</td>
                    </tr>
                    @endif
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
                                <th>👤 Peminjam</th>
                                <th>📅 Tgl Pinjam</th>
                                <th>📅 Tgl Kembali</th>
                                <th>🔖 Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($buku->peminjaman->take(10) as $p)
                            <tr>
                                <td class="small fw-semibold">{{ $p->user->name }}</td>
                                <td class="small">{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td class="small">{{ $p->tanggal_kembali->format('d/m/Y') }}</td>
                                <td>@include('peminjaman._badge_status', ['status' => $p->status])</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
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
    <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary btn-sm">
        ← Kembali ke Daftar Buku
    </a>
</div>

{{-- Daftar ulasan pembaca --}}
@include('ulasan._list_ulasan', ['buku' => $buku])

@endsection
