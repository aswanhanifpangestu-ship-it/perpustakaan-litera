@extends('layouts.app')

@section('title', 'Peminjaman')
@section('page-title', '📋 Data Peminjaman')

@section('content')
<div class="card table-card">
    <div class="card-header py-3">
        <div class="row g-2 align-items-center">
            <div class="col-md-8">
                <form action="{{ route('peminjaman.index') }}" method="GET" class="d-flex gap-2 flex-wrap">
                    <input type="text" name="search" class="form-control form-control-sm"
                           placeholder="🔍 Cari nama anggota / judul buku..."
                           value="{{ request('search') }}" style="min-width:180px">
                    <select name="status" class="form-select form-select-sm" style="width:auto">
                        <option value="">🔖 Semua Status</option>
                        <option value="pending"      {{ request('status') === 'pending'      ? 'selected' : '' }}>⏳ Pending</option>
                        <option value="disetujui"    {{ request('status') === 'disetujui'    ? 'selected' : '' }}>📖 Dipinjam</option>
                        <option value="ditolak"      {{ request('status') === 'ditolak'      ? 'selected' : '' }}>❌ Ditolak</option>
                        <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>✅ Dikembalikan</option>
                    </select>
                    @if(auth()->user()->isAdminOrPetugas())
                    <select name="status_denda" class="form-select form-select-sm" style="width:auto">
                        <option value="">💸 Semua Denda</option>
                        <option value="belum_bayar" {{ request('status_denda') === 'belum_bayar' ? 'selected' : '' }}>🔴 Belum Bayar</option>
                        <option value="sudah_bayar" {{ request('status_denda') === 'sudah_bayar' ? 'selected' : '' }}>🟢 Sudah Bayar</option>
                    </select>
                    @endif
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                    @if(request()->hasAny(['search','status','status_denda']))
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-x"></i>
                        </a>
                    @endif
                </form>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('peminjaman.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>
                    {{ auth()->user()->isUser() ? '📝 Ajukan Peminjaman' : '➕ Catat Peminjaman' }}
                </a>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>👤 Anggota</th>
                        <th>📗 Buku</th>
                        <th>📅 Tgl Pinjam</th>
                        <th>📅 Tgl Kembali</th>
                        <th>🔖 Status</th>
                        <th>💸 Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $p)
                    <tr>
                        <td class="text-muted small">{{ $peminjaman->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="fw-semibold small">{{ $p->user->name }}</div>
                            <div class="text-muted" style="font-size:.7rem">{{ $p->user->no_anggota ?? '—' }}</div>
                        </td>
                        <td class="small" style="max-width:160px">
                            <div class="text-truncate">{{ $p->buku->judul }}</div>
                        </td>
                        <td class="small">{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                        <td class="small">
                            {{ $p->tanggal_kembali->format('d/m/Y') }}
                            @if($p->status === 'disetujui' && $p->tanggal_kembali->isPast())
                                <span class="badge bg-danger ms-1" style="font-size:.65rem">⚠️ Lewat</span>
                            @endif
                        </td>
                        <td>@include('peminjaman._badge_status', ['status' => $p->status])</td>
                        <td class="small">
                            @if($p->total_denda > 0)
                                <div class="{{ $p->status_denda === 'belum_bayar' ? 'text-danger fw-semibold' : 'text-success' }}">
                                    Rp {{ number_format($p->total_denda, 0, ',', '.') }}
                                </div>
                                @if($p->status_denda === 'sudah_bayar')
                                    <span class="badge bg-success" style="font-size:.65rem">✅ Lunas</span>
                                @else
                                    <span class="badge bg-danger" style="font-size:.65rem">🔴 Belum Bayar</span>
                                @endif
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route('peminjaman.show', $p) }}"
                                   class="btn btn-xs btn-outline-primary" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(in_array($p->status, ['disetujui', 'dikembalikan']))
                                <a href="{{ route('struk.show', $p) }}"
                                   class="btn btn-xs btn-outline-success" title="Struk Peminjaman">
                                    🧾
                                </a>
                                @endif
                                @if($p->status === 'dikembalikan')
                                <a href="{{ route('struk.pengembalianPdf', $p) }}"
                                   class="btn btn-xs btn-outline-success" title="Struk Pengembalian" target="_blank">
                                    📦
                                </a>
                                @endif
                                @if(auth()->user()->isAdminOrPetugas())
                                    @if($p->status === 'pending')
                                    <form action="{{ route('peminjaman.approve', $p) }}" method="POST"
                                          onsubmit="return confirm('Setujui peminjaman ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-xs btn-outline-success" title="Setujui">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-xs btn-outline-danger"
                                            data-bs-toggle="modal" data-bs-target="#modalTolak"
                                            data-id="{{ $p->id }}" data-judul="{{ $p->buku->judul }}"
                                            title="Tolak">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                    @endif

                                    @if($p->status === 'disetujui')
                                    <button type="button" class="btn btn-xs btn-outline-warning"
                                            data-bs-toggle="modal" data-bs-target="#modalKembali"
                                            data-id="{{ $p->id }}" data-judul="{{ $p->buku->judul }}"
                                            data-tgl="{{ $p->tanggal_pinjam->format('Y-m-d') }}"
                                            title="Kembalikan">
                                        <i class="bi bi-arrow-return-left"></i>
                                    </button>
                                    @endif

                                    @if($p->status === 'dikembalikan' && $p->total_denda > 0 && $p->status_denda === 'belum_bayar')
                                    <form action="{{ route('peminjaman.bayarDenda', $p) }}" method="POST"
                                          onsubmit="return confirm('Tandai denda sebagai lunas?')">
                                        @csrf
                                        <button type="submit" class="btn btn-xs btn-outline-success" title="Bayar Denda">
                                            <i class="bi bi-cash-coin"></i>
                                        </button>
                                    </form>
                                    @endif

                                    @if(!in_array($p->status, ['disetujui']))
                                    <form action="{{ route('peminjaman.destroy', $p) }}" method="POST"
                                          onsubmit="return confirm('Hapus data ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <span style="font-size:2.5rem">📭</span>
                            <div class="mt-2">Tidak ada data peminjaman.</div>
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

{{-- Modal Tolak --}}
<div class="modal fade" id="modalTolak" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold text-danger">❌ Tolak Peminjaman</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formTolak" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted small mb-3">📗 Buku: <strong id="judulBukuTolak"></strong></p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="alasan_tolak" class="form-control" rows="3"
                                  placeholder="Tuliskan alasan penolakan..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-sm">❌ Tolak Peminjaman</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Kembalikan --}}
<div class="modal fade" id="modalKembali" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold">📦 Proses Pengembalian</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formKembali" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted small mb-3">📗 Buku: <strong id="judulBukuKembali"></strong></p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">📅 Tanggal Dikembalikan</label>
                        <input type="date" name="tanggal_dikembalikan" class="form-control"
                               value="{{ date('Y-m-d') }}" required id="inputTglKembali">
                    </div>
                    <div class="rounded-3 p-3 small" style="background:#ccfbf1;color:#0f766e">
                        ℹ️ Denda dihitung otomatis berdasarkan <strong>denda per hari</strong> masing-masing buku.
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">✅ Konfirmasi Kembali</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>.btn-xs { padding:.2rem .45rem; font-size:.75rem; }</style>
@endpush

@push('scripts')
<script>
document.getElementById('modalTolak').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('judulBukuTolak').textContent = btn.dataset.judul;
    document.getElementById('formTolak').action = '/peminjaman/' + btn.dataset.id + '/reject';
});
document.getElementById('modalKembali').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('judulBukuKembali').textContent = btn.dataset.judul;
    document.getElementById('formKembali').action = '/peminjaman/' + btn.dataset.id + '/kembalikan';
    document.getElementById('inputTglKembali').min = btn.dataset.tgl;
});
</script>
@endpush
@endsection
