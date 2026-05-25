@extends('layouts.app')

@section('title', 'Struk Peminjaman #' . $peminjaman->id)
@section('page-title', '🧾 Struk Peminjaman')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">

        {{-- Tombol aksi --}}
        <div class="d-flex gap-2 mb-3">
            <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-secondary">
                ← Kembali
            </a>
            <a href="{{ route('struk.pdf', $peminjaman) }}"
               class="btn btn-sm btn-danger ms-auto" target="_blank">
                📄 Download PDF
            </a>
            <button onclick="window.print()" class="btn btn-sm btn-primary">
                🖨️ Cetak
            </button>
        </div>

        {{-- Struk --}}
        <div class="card table-card" id="struk-area">
            <div class="card-body p-4">

                {{-- Header --}}
                <div class="text-center mb-4">
                    <div style="font-size:2.5rem">📚</div>
                    <h4 class="fw-bold mb-0" style="color:#134e4a">PERPUSTAKAAN LITERA</h4>
                    <div class="text-muted small">Sistem Perpustakaan Digital</div>
                    <div class="text-muted small">Jl. Perpustakaan No. 1 | litera@perpustakaan.com</div>
                    <hr style="border-color:#ccfbf1;border-width:2px">
                    <h6 class="fw-bold mb-0" style="color:#0f766e">
                        STRUK PEMINJAMAN BUKU
                    </h6>
                    <div class="text-muted small">No. #{{ str_pad($peminjaman->id, 6, '0', STR_PAD_LEFT) }}</div>
                </div>

                {{-- Status badge --}}
                <div class="text-center mb-3">
                    @if($peminjaman->status === 'disetujui')
                        <span class="badge rounded-pill px-4 py-2 bg-success fs-6">✅ DISETUJUI</span>
                    @elseif($peminjaman->status === 'dikembalikan')
                        <span class="badge rounded-pill px-4 py-2 bg-primary fs-6">📦 DIKEMBALIKAN</span>
                    @elseif($peminjaman->status === 'pending')
                        <span class="badge rounded-pill px-4 py-2 bg-warning text-dark fs-6">⏳ PENDING</span>
                    @else
                        <span class="badge rounded-pill px-4 py-2 bg-danger fs-6">❌ DITOLAK</span>
                    @endif
                </div>

                {{-- Info Anggota --}}
                <div class="rounded-3 p-3 mb-3" style="background:#f0fdf9;border:1px solid #ccfbf1">
                    <div class="fw-bold small mb-2" style="color:#0f766e">👤 INFORMASI ANGGOTA</div>
                    <table class="w-100" style="font-size:.875rem">
                        <tr>
                            <td class="text-muted" width="130">Nama</td>
                            <td>: <strong>{{ $peminjaman->user->name }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">No. Anggota</td>
                            <td>: {{ $peminjaman->user->no_anggota ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email</td>
                            <td>: {{ $peminjaman->user->email }}</td>
                        </tr>
                    </table>
                </div>

                {{-- Info Buku --}}
                <div class="rounded-3 p-3 mb-3" style="background:#fffbeb;border:1px solid #fef3c7">
                    <div class="fw-bold small mb-2" style="color:#d97706">📗 INFORMASI BUKU</div>
                    <table class="w-100" style="font-size:.875rem">
                        <tr>
                            <td class="text-muted" width="130">Judul</td>
                            <td>: <strong>{{ $peminjaman->buku->judul }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Pengarang</td>
                            <td>: {{ $peminjaman->buku->pengarang }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Kategori</td>
                            <td>: {{ $peminjaman->buku->kategori->nama ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">ISBN</td>
                            <td>: {{ $peminjaman->buku->isbn ?? '—' }}</td>
                        </tr>
                    </table>
                </div>

                {{-- Info Peminjaman --}}
                <div class="rounded-3 p-3 mb-3" style="background:#f0fdf9;border:1px solid #ccfbf1">
                    <div class="fw-bold small mb-2" style="color:#0f766e">📅 DETAIL PEMINJAMAN</div>
                    <table class="w-100" style="font-size:.875rem">
                        <tr>
                            <td class="text-muted" width="130">Tgl Pinjam</td>
                            <td>: <strong>{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tgl Kembali</td>
                            <td>: <strong>{{ $peminjaman->tanggal_kembali->format('d M Y') }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Durasi</td>
                            <td>: {{ $peminjaman->tanggal_pinjam->diffInDays($peminjaman->tanggal_kembali) }} hari</td>
                        </tr>
                        @if($peminjaman->tanggal_dikembalikan)
                        <tr>
                            <td class="text-muted">Tgl Dikembalikan</td>
                            <td>: {{ $peminjaman->tanggal_dikembalikan->format('d M Y') }}</td>
                        </tr>
                        @endif
                        @if($peminjaman->petugas)
                        <tr>
                            <td class="text-muted">Diproses oleh</td>
                            <td>: {{ $peminjaman->petugas->name }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="text-muted">Denda/Hari</td>
                            <td>: Rp {{ number_format($peminjaman->buku->denda_per_hari, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>

                {{-- Denda --}}
                @if($peminjaman->total_denda > 0)
                <div class="rounded-3 p-3 mb-3"
                     style="background:{{ $peminjaman->status_denda === 'sudah_bayar' ? '#dcfce7' : '#fee2e2' }};
                            border:1px solid {{ $peminjaman->status_denda === 'sudah_bayar' ? '#bbf7d0' : '#fecdd3' }}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold small">💸 DENDA KETERLAMBATAN</div>
                            <div class="text-muted small">{{ $peminjaman->jumlah_hari_terlambat }} hari × Rp {{ number_format($peminjaman->buku->denda_per_hari, 0, ',', '.') }}</div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold fs-5 {{ $peminjaman->status_denda === 'sudah_bayar' ? 'text-success' : 'text-danger' }}">
                                Rp {{ number_format($peminjaman->total_denda, 0, ',', '.') }}
                            </div>
                            <span class="badge {{ $peminjaman->status_denda === 'sudah_bayar' ? 'bg-success' : 'bg-danger' }}">
                                {{ $peminjaman->status_denda === 'sudah_bayar' ? '✅ Lunas' : '🔴 Belum Bayar' }}
                            </span>
                        </div>
                    </div>
                </div>
                @else
                <div class="rounded-3 p-3 mb-3 text-center" style="background:#dcfce7;border:1px solid #bbf7d0">
                    <span class="fw-bold text-success">✅ Tidak ada denda</span>
                </div>
                @endif

                {{-- Footer --}}
                <hr style="border-color:#ccfbf1">
                <div class="text-center text-muted small">
                    <div>Dicetak: {{ now()->format('d M Y, H:i') }} WIB</div>
                    <div class="mt-1">Terima kasih telah menggunakan layanan Perpustakaan Litera 📚</div>
                </div>

            </div>
        </div>

    </div>
</div>

@push('styles')
<style>
@media print {
    #sidebar, .topbar, .btn, nav { display: none !important; }
    #main-content { margin-left: 0 !important; }
    #struk-area { box-shadow: none !important; border: 1px solid #ccc !important; }
    body { background: white !important; }
}
</style>
@endpush
@endsection
