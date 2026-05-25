<?php
    $map = [
        'pending'      => ['bg-warning text-dark',  '⏳ Pending'],
        'disetujui'    => ['bg-info text-dark',      '📖 Dipinjam'],
        'ditolak'      => ['bg-danger',              '❌ Ditolak'],
        'dikembalikan' => ['bg-success',             '✅ Dikembalikan'],
    ];
    [$cls, $label] = $map[$status] ?? ['bg-light text-dark', $status];
?>
<span class="badge rounded-pill <?php echo e($cls); ?>" style="font-size:.72rem"><?php echo e($label); ?></span>
<?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/peminjaman/_badge_status.blade.php ENDPATH**/ ?>