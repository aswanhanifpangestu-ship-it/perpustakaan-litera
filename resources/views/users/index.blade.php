@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page-title', '👥 Manajemen Pengguna')

@section('content')

{{-- Tab Navigation --}}
<ul class="nav nav-tabs mb-0" id="userTab" role="tablist" style="border-bottom:2px solid #ccfbf1">
    @if(!$isPetugas)
    <li class="nav-item" role="presentation">
        <button class="nav-link {{ $tab === 'petugas' ? 'active' : '' }} fw-semibold"
                id="tab-petugas" data-bs-toggle="tab" data-bs-target="#panel-petugas"
                type="button" role="tab">
            🛡️ Petugas
            <span class="badge rounded-pill ms-1" style="background:#ccfbf1;color:#0f766e">{{ $petugas->total() }}</span>
        </button>
    </li>
    @endif
    <li class="nav-item" role="presentation">
        <button class="nav-link {{ $tab === 'anggota' ? 'active' : '' }} fw-semibold"
                id="tab-anggota" data-bs-toggle="tab" data-bs-target="#panel-anggota"
                type="button" role="tab">
            👥 Anggota
            <span class="badge rounded-pill ms-1" style="background:#ede9fe;color:#5b21b6">{{ $anggota->total() }}</span>
        </button>
    </li>
</ul>

<div class="tab-content" id="userTabContent">

    {{-- ===================== TAB PETUGAS ===================== --}}
    @if(!$isPetugas)
    <div class="tab-pane fade {{ $tab === 'petugas' ? 'show active' : '' }}"
         id="panel-petugas" role="tabpanel">
        <div class="card table-card border-top-0 rounded-top-0">
            <div class="card-header bg-white py-3">
                <div class="row g-2 align-items-center">
                    <div class="col-md-7">
                        <form action="{{ route('users.index') }}" method="GET" class="d-flex gap-2">
                            <input type="hidden" name="tab" value="petugas">
                            <input type="text" name="search_petugas"
                                   class="form-control form-control-sm"
                                   placeholder="Cari nama atau email petugas..."
                                   value="{{ request('search_petugas') }}">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="bi bi-search"></i>
                            </button>
                            @if(request('search_petugas'))
                                <a href="{{ route('users.index', ['tab' => 'petugas']) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-x"></i>
                                </a>
                            @endif
                        </form>
                    </div>
                    <div class="col-md-5 text-md-end">
                        <a href="{{ route('users.create', ['role' => 'petugas']) }}"
                           class="btn btn-sm btn-warning text-dark">
                            <i class="bi bi-person-plus me-1"></i>➕ Tambah Petugas
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-warning">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($petugas as $u)
                            <tr>
                                <td class="text-muted small">{{ $petugas->firstItem() + $loop->index }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-warning bg-opacity-20 d-flex align-items-center justify-content-center"
                                             style="width:32px;height:32px;flex-shrink:0">
                                            <i class="bi bi-person-badge text-warning small"></i>
                                        </div>
                                        <div class="fw-semibold small">{{ $u->name }}</div>
                                    </div>
                                </td>
                                <td class="small text-muted">{{ $u->email }}</td>
                                <td>
                                    <span class="badge rounded-pill
                                        @if($u->role === 'admin') badge-admin
                                        @else badge-petugas
                                        @endif px-3">
                                        {{ ucfirst($u->role) }}
                                    </span>
                                </td>
                                <td>
                                    @if($u->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('users.show', $u) }}"
                                           class="btn btn-xs btn-outline-info" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('users.edit', $u) }}"
                                           class="btn btn-xs btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if($u->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $u) }}" method="POST"
                                              onsubmit="return confirm('Hapus petugas ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-person-badge fs-2 d-block mb-2"></i>
                                    Tidak ada petugas ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($petugas->hasPages())
            <div class="card-footer bg-white">{{ $petugas->links() }}</div>
            @endif
        </div>
    </div>
    @endif

    {{-- ===================== TAB ANGGOTA ===================== --}}
    <div class="tab-pane fade {{ $tab === 'anggota' ? 'show active' : '' }}"
         id="panel-anggota" role="tabpanel">
        <div class="card table-card border-top-0 rounded-top-0">
            <div class="card-header bg-white py-3">
                <div class="row g-2 align-items-center">
                    <div class="col-12">
                        <form action="{{ route('users.index') }}" method="GET" class="d-flex gap-2">
                            <input type="hidden" name="tab" value="anggota">
                            <input type="text" name="search_anggota"
                                   class="form-control form-control-sm"
                                   placeholder="Cari nama, email, no. anggota..."
                                   value="{{ request('search_anggota') }}">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="bi bi-search"></i>
                            </button>
                            @if(request('search_anggota'))
                                <a href="{{ route('users.index', ['tab' => 'anggota']) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-x"></i>
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No. Anggota</th>
                                <th>Telepon</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($anggota as $u)
                            <tr>
                                <td class="text-muted small">{{ $anggota->firstItem() + $loop->index }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                                             style="width:32px;height:32px;flex-shrink:0">
                                            <i class="bi bi-person-fill text-primary small"></i>
                                        </div>
                                        <div class="fw-semibold small">{{ $u->name }}</div>
                                    </div>
                                </td>
                                <td class="small text-muted">{{ $u->email }}</td>
                                <td class="small">{{ $u->no_anggota ?? '-' }}</td>
                                <td class="small">{{ $u->telepon ?? '-' }}</td>
                                <td>
                                    @if($u->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('users.show', $u) }}"
                                           class="btn btn-xs btn-outline-info" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('users.edit', $u) }}"
                                           class="btn btn-xs btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if($u->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $u) }}" method="POST"
                                              onsubmit="return confirm('Hapus anggota ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="bi bi-people fs-2 d-block mb-2"></i>
                                    Tidak ada anggota ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($anggota->hasPages())
            <div class="card-footer bg-white">{{ $anggota->links() }}</div>
            @endif
        </div>
    </div>

</div>{{-- end tab-content --}}

@push('styles')
<style>
.btn-xs { padding: .2rem .45rem; font-size: .75rem; }
.badge-admin   { background: #fef3c7; color: #92400e; }
.badge-petugas { background: #ccfbf1; color: #0f766e; }
.badge-user    { background: #ede9fe; color: #5b21b6; }
.nav-tabs .nav-link { color: #64748b; border-radius: .5rem .5rem 0 0; }
.nav-tabs .nav-link.active { color: #0f766e; background: #fff; border-bottom-color: #fff; font-weight: 700; }
.rounded-top-0 { border-top-left-radius: 0 !important; border-top-right-radius: 0 !important; }
</style>
@endpush

@push('scripts')
<script>
// Simpan tab aktif ke URL saat klik tab
document.querySelectorAll('#userTab button[data-bs-toggle="tab"]').forEach(function(btn) {
    btn.addEventListener('shown.bs.tab', function(e) {
        var tabName = e.target.id === 'tab-petugas' ? 'petugas' : 'anggota';
        var url = new URL(window.location.href);
        url.searchParams.set('tab', tabName);
        // Hapus search parameter tab lain agar tidak campur
        if (tabName === 'petugas') url.searchParams.delete('search_anggota');
        else url.searchParams.delete('search_petugas');
        window.history.replaceState({}, '', url.toString());
    });
});
</script>
@endpush

@endsection
