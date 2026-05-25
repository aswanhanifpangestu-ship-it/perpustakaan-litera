{{--
    Partial: _list_ulasan.blade.php
    Variabel:
      $buku — instance Buku (sudah load ulasan.user)
--}}
@if($buku->ulasan->count() > 0)
<div class="card table-card mt-4">
    <div class="card-header bg-white py-3">
        <div class="d-flex align-items-center justify-content-between">
            <h6 class="mb-0 fw-semibold">
                <i class="bi bi-star-fill text-warning me-2"></i>Ulasan Pembaca
            </h6>
            <div class="d-flex align-items-center gap-2">
                @include('ulasan._star_rating', ['rating' => round($buku->ratingRata()), 'size' => 'md'])
                <span class="fw-bold">{{ $buku->ratingRata() }}</span>
                <span class="text-muted small">({{ $buku->ulasan->count() }} ulasan)</span>
            </div>
        </div>
    </div>

    {{-- Distribusi bintang --}}
    @php
        $total = $buku->ulasan->count();
        $dist  = [];
        for ($i = 5; $i >= 1; $i--) {
            $dist[$i] = $buku->ulasan->where('rating', $i)->count();
        }
    @endphp
    <div class="card-body border-bottom pb-3">
        <div class="row g-1" style="max-width:360px">
            @foreach($dist as $star => $count)
            <div class="col-12">
                <div class="d-flex align-items-center gap-2">
                    <span class="small text-muted" style="width:14px">{{ $star }}</span>
                    <span style="color:#f59e0b;font-size:.85rem">★</span>
                    <div class="progress flex-grow-1" style="height:8px">
                        <div class="progress-bar bg-warning"
                             style="width:{{ $total > 0 ? round($count/$total*100) : 0 }}%"></div>
                    </div>
                    <span class="small text-muted" style="width:20px">{{ $count }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="card-body p-0">
        @foreach($buku->ulasan->sortByDesc('created_at') as $u)
        <div class="p-3 border-bottom">
            <div class="d-flex align-items-start gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:38px;height:38px">
                    <i class="bi bi-person-fill text-primary small"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                        <span class="fw-semibold small">{{ $u->user->name }}</span>
                        @include('ulasan._star_rating', ['rating' => $u->rating, 'size' => 'sm'])
                        <span class="text-muted" style="font-size:.75rem">{{ $u->created_at->diffForHumans() }}</span>
                    </div>
                    @if($u->komentar)
                        <p class="mb-1 small">{{ $u->komentar }}</p>
                    @else
                        <p class="mb-1 small text-muted fst-italic">Tidak ada komentar.</p>
                    @endif
                </div>
                {{-- Tombol hapus untuk admin/petugas atau pemilik ulasan --}}
                @if(auth()->check() && (auth()->user()->isAdminOrPetugas() || auth()->id() === $u->user_id))
                <form action="{{ route('ulasan.destroy', $u) }}" method="POST"
                      onsubmit="return confirm('Hapus ulasan ini?')" class="flex-shrink-0">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-outline-danger" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@else
<div class="card table-card mt-4">
    <div class="card-body text-center text-muted py-4">
        <i class="bi bi-star fs-2 d-block mb-2 text-warning opacity-50"></i>
        Belum ada ulasan untuk buku ini.
    </div>
</div>
@endif

@push('styles')
<style>
.btn-xs { padding: .2rem .45rem; font-size: .75rem; }
</style>
@endpush
