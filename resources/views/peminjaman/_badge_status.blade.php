@php
    $map = [
        'pending'      => ['bg-warning text-dark',  '⏳ Pending'],
        'disetujui'    => ['bg-info text-dark',      '📖 Dipinjam'],
        'ditolak'      => ['bg-danger',              '❌ Ditolak'],
        'dikembalikan' => ['bg-success',             '✅ Dikembalikan'],
    ];
    [$cls, $label] = $map[$status] ?? ['bg-light text-dark', $status];
@endphp
<span class="badge rounded-pill {{ $cls }}" style="font-size:.72rem">{{ $label }}</span>
