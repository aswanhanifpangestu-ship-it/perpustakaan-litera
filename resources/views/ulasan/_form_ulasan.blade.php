{{--
    Partial: _form_ulasan.blade.php
    Variabel:
      $peminjaman — instance Peminjaman (sudah load ulasan)
--}}
@auth
@if(auth()->user()->isUser() && $peminjaman->user_id === auth()->id() && $peminjaman->status === 'dikembalikan')

    <div class="card table-card mt-4">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-semibold">
                <i class="bi bi-star me-2 text-warning"></i>
                @if($peminjaman->ulasan) Ulasan Anda @else Berikan Ulasan @endif
            </h6>
        </div>
        <div class="card-body">

            @if($peminjaman->ulasan)
                {{-- Tampilkan ulasan yang sudah ada --}}
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:40px;height:40px">
                        <i class="bi bi-person-fill text-primary"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="fw-semibold">{{ $peminjaman->ulasan->user->name }}</span>
                            @include('ulasan._star_rating', ['rating' => $peminjaman->ulasan->rating, 'size' => 'md'])
                            <span class="text-muted small">{{ $peminjaman->ulasan->created_at->diffForHumans() }}</span>
                        </div>
                        @if($peminjaman->ulasan->komentar)
                            <p class="mb-2 text-muted">{{ $peminjaman->ulasan->komentar }}</p>
                        @else
                            <p class="mb-2 text-muted fst-italic small">Tidak ada komentar.</p>
                        @endif
                        <form action="{{ route('ulasan.destroy', $peminjaman->ulasan) }}" method="POST"
                              onsubmit="return confirm('Hapus ulasan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash me-1"></i>Hapus Ulasan
                            </button>
                        </form>
                    </div>
                </div>

            @else
                {{-- Form beri ulasan baru --}}
                <form action="{{ route('ulasan.store', $peminjaman) }}" method="POST" id="formUlasan">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Rating <span class="text-danger">*</span></label>
                        <div class="star-picker d-flex gap-1" id="starPicker">
                            @for($i = 1; $i <= 5; $i++)
                                <label class="star-label" for="star{{ $i }}" title="{{ $i }} bintang">
                                    <input type="radio" name="rating" id="star{{ $i }}"
                                           value="{{ $i }}"
                                           class="d-none"
                                           {{ old('rating') == $i ? 'checked' : '' }}>
                                    <span class="star-icon" data-value="{{ $i }}">★</span>
                                </label>
                            @endfor
                        </div>
                        @error('rating')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <div class="text-muted small mt-1" id="ratingLabel">Klik bintang untuk memberi rating</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Komentar <span class="text-muted fw-normal">(opsional)</span></label>
                        <textarea name="komentar" class="form-control @error('komentar') is-invalid @enderror"
                                  rows="3" maxlength="1000"
                                  placeholder="Bagikan pengalaman membaca buku ini...">{{ old('komentar') }}</textarea>
                        @error('komentar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="text-muted small mt-1">Maks. 1000 karakter</div>
                    </div>

                    <button type="submit" class="btn btn-warning fw-semibold">
                        <i class="bi bi-star-fill me-1"></i>Kirim Ulasan
                    </button>
                </form>
            @endif

        </div>
    </div>

@push('styles')
<style>
.star-picker { cursor: pointer; }
.star-icon {
    font-size: 2rem;
    color: #d1d5db;
    transition: color .15s, transform .1s;
    user-select: none;
}
.star-icon:hover,
.star-icon.active {
    color: #f59e0b;
    transform: scale(1.15);
}
</style>
@endpush

@push('scripts')
<script>
(function () {
    const labels = ['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Bagus', 'Sangat Bagus'];
    const stars  = document.querySelectorAll('#starPicker .star-icon');
    const lbl    = document.getElementById('ratingLabel');

    function highlight(val) {
        stars.forEach(s => {
            s.classList.toggle('active', parseInt(s.dataset.value) <= val);
        });
        lbl.textContent = val ? labels[val] + ' (' + val + '/5)' : 'Klik bintang untuk memberi rating';
    }

    // Restore old value jika ada
    const checked = document.querySelector('#starPicker input[type=radio]:checked');
    if (checked) highlight(parseInt(checked.value));

    stars.forEach(star => {
        star.addEventListener('mouseover', () => highlight(parseInt(star.dataset.value)));
        star.addEventListener('mouseleave', () => {
            const c = document.querySelector('#starPicker input[type=radio]:checked');
            highlight(c ? parseInt(c.value) : 0);
        });
        star.addEventListener('click', () => {
            const val = parseInt(star.dataset.value);
            document.getElementById('star' + val).checked = true;
            highlight(val);
        });
    });
})();
</script>
@endpush

@endif
@endauth
