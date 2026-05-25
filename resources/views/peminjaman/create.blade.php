@extends('layouts.app')

@section('title', auth()->user()->isUser() ? 'Ajukan Peminjaman' : 'Catat Peminjaman')
@section('page-title', auth()->user()->isUser() ? '📝 Ajukan Peminjaman' : '➕ Catat Peminjaman')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card table-card">
            <div class="card-header py-3 d-flex align-items-center gap-2">
                <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-secondary">← Kembali</a>
                <h6 class="mb-0 fw-bold">
                    {{ auth()->user()->isUser() ? '📝 Form Pengajuan Peminjaman' : '➕ Form Peminjaman Buku' }}
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf

                    @if(auth()->user()->isAdminOrPetugas())
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">👤 Anggota <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                            <option value="">— Pilih Anggota —</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }} {{ $u->no_anggota ? '('.$u->no_anggota.')' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">📗 Buku <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3 align-items-start">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                                 style="width:70px;height:90px;background:#ccfbf1;overflow:hidden" id="bukuSampulWrap">
                                <img id="bukuSampulImg" src="" alt="" class="d-none w-100 h-100" style="object-fit:cover">
                                <span id="bukuSampulIcon" style="font-size:2rem">📗</span>
                            </div>
                            <div class="flex-grow-1">
                                <select name="buku_id" id="selectBuku"
                                        class="form-select @error('buku_id') is-invalid @enderror">
                                    <option value="">— Pilih Buku —</option>
                                    @foreach($buku as $b)
                                        <option value="{{ $b->id }}"
                                                data-denda="{{ number_format($b->denda_per_hari, 0, ',', '.') }}"
                                                data-sampul="{{ $b->sampulUrl() ?? '' }}"
                                                {{ old('buku_id') == $b->id ? 'selected' : '' }}>
                                            {{ $b->judul }} — {{ $b->pengarang }}
                                            (Tersedia: {{ $b->stok_tersedia }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('buku_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div id="infoDenda" class="form-text d-none" style="color:#0d9488">
                                    💸 Denda keterlambatan: <strong id="nilaiDenda"></strong>/hari
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">📅 Tanggal Pinjam <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pinjam" id="tglPinjam"
                                   class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                                   value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                                   min="{{ date('Y-m-d') }}">
                            @error('tanggal_pinjam')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">
                                📅 Tanggal Kembali <span class="text-danger">*</span>
                                <span class="text-muted fw-normal">(maks. 30 hari)</span>
                            </label>
                            <input type="date" name="tanggal_kembali" id="tglKembali"
                                   class="form-control @error('tanggal_kembali') is-invalid @enderror"
                                   value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+7 days'))) }}">
                            @error('tanggal_kembali')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div id="infoHari" class="form-text"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold small">📝 Catatan</label>
                        <textarea name="catatan" class="form-control" rows="2"
                                  placeholder="Catatan tambahan...">{{ old('catatan') }}</textarea>
                    </div>

                    @if(auth()->user()->isUser())
                    <div class="rounded-3 p-3 mb-4 small" style="background:#f0fdf9;border:1px solid #ccfbf1;color:#0f766e">
                        ℹ️ Pengajuan akan diproses oleh petugas. Anda bisa meminjam setelah disetujui.
                    </div>
                    @endif

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            🚀 {{ auth()->user()->isUser() ? 'Kirim Pengajuan' : 'Catat Peminjaman' }}
                        </button>
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const tglPinjam  = document.getElementById('tglPinjam');
const tglKembali = document.getElementById('tglKembali');
const infoHari   = document.getElementById('infoHari');
const selectBuku = document.getElementById('selectBuku');
const infoDenda  = document.getElementById('infoDenda');
const nilaiDenda = document.getElementById('nilaiDenda');
const sampulImg  = document.getElementById('bukuSampulImg');
const sampulIcon = document.getElementById('bukuSampulIcon');
const MAX_HARI   = 30;

function updateInfo() {
    if (!tglPinjam.value || !tglKembali.value) return;
    const p = new Date(tglPinjam.value);
    const k = new Date(tglKembali.value);
    const minK = new Date(p); minK.setDate(minK.getDate() + 1);
    const maxK = new Date(p); maxK.setDate(maxK.getDate() + MAX_HARI);
    tglKembali.min = minK.toISOString().split('T')[0];
    tglKembali.max = maxK.toISOString().split('T')[0];
    const diff = Math.round((k - p) / 86400000);
    if (diff > 0 && diff <= MAX_HARI) {
        infoHari.textContent = '✅ Durasi: ' + diff + ' hari';
        infoHari.style.color = '#16a34a';
    } else if (diff > MAX_HARI) {
        infoHari.textContent = '❌ Melebihi batas ' + MAX_HARI + ' hari!';
        infoHari.style.color = '#dc2626';
    }
}

selectBuku.addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    if (this.value && opt.dataset.denda) {
        nilaiDenda.textContent = 'Rp ' + opt.dataset.denda;
        infoDenda.classList.remove('d-none');
    } else {
        infoDenda.classList.add('d-none');
    }
    if (this.value && opt.dataset.sampul) {
        sampulImg.src = opt.dataset.sampul;
        sampulImg.classList.remove('d-none');
        sampulIcon.classList.add('d-none');
    } else {
        sampulImg.src = '';
        sampulImg.classList.add('d-none');
        sampulIcon.classList.remove('d-none');
    }
});

tglPinjam.addEventListener('change', updateInfo);
tglKembali.addEventListener('change', updateInfo);
updateInfo();

if (selectBuku.value) {
    selectBuku.dispatchEvent(new Event('change'));
}
</script>
@endpush
@endsection
