@extends('layouts.app')

@section('title', 'Struk Saya')
@section('page-title', '🧾 Struk Peminjaman Saya')

@section('content')
<div class="card table-card">
    <div class="card-header py-3">
        <h6 class="mb-0 fw-bold">🧾 Daftar Struk Peminjaman</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>📗 Buku</th>
                        <th>📅 Tgl Pinjam</th>
                        <th>📅 Tgl Kembali</th>
                        <th>🔖 Status</th>
                        <th>💸 Denda</th>
                        <th>🧾 Struk</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $p)
                    <tr>
                        <td class="text-muted small">{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-semibold small">{{ $p->buku->judul }}</div>
                            <div class="text-muted" style="font-size:.72rem">✍️ {{ $p->buku->pengarang }}</div>
                        </td>
                        <td class="small">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                        <td class="small">{{ $p->tanggal_kembali->format('d M Y') }}</td>
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
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('struk.show', $p) }}"
                                   class="btn btn-xs btn-outline-primary" title="Lihat Struk">
                                    🧾
                                </a>
                                <a href="{{ route('struk.pdf', $p) }}"
                                   class="btn btn-xs btn-outline-danger" title="PDF Peminjaman" target="_blank">
                                    📄
                                </a>
                                @if($p->status === 'dikembalikan')
                                <a href="{{ route('struk.pengembalianPdf', $p) }}"
                                   class="btn btn-xs btn-outline-success" title="PDF Pengembalian" target="_blank">
                                    📦
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <span style="font-size:2.5rem">🧾</span>
                            <div class="mt-2">Belum ada struk peminjaman.</div>
                            <a href="{{ route('peminjaman.create') }}" class="btn btn-sm btn-primary mt-2">
                                📝 Ajukan Peminjaman
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($peminjaman->hasPages())
    <div class="card-footer">{{ $peminjaman->links() }}</div>
    @endif
</div>

@push('styles')
<style>.btn-xs { padding:.2rem .45rem; font-size:.75rem; }</style>
@endpush
@endsection
