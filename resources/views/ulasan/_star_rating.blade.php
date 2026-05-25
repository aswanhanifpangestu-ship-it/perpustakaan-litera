{{--
    Partial: _star_rating.blade.php
    Variabel:
      $rating  — nilai integer 1–5 (untuk tampil statis)
      $size    — 'sm' | 'md' | 'lg'  (opsional, default 'md')
--}}
@php
    $size   = $size   ?? 'md';
    $rating = $rating ?? 0;
    $fs     = ['sm' => '0.85rem', 'md' => '1.1rem', 'lg' => '1.4rem'][$size] ?? '1.1rem';
@endphp
<span class="star-display" style="font-size:{{ $fs }};line-height:1">
    @for($i = 1; $i <= 5; $i++)
        @if($i <= $rating)
            <span style="color:#f59e0b">★</span>
        @else
            <span style="color:#d1d5db">★</span>
        @endif
    @endfor
</span>
