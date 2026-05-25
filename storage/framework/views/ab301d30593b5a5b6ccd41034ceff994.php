
<?php
    $size   = $size   ?? 'md';
    $rating = $rating ?? 0;
    $fs     = ['sm' => '0.85rem', 'md' => '1.1rem', 'lg' => '1.4rem'][$size] ?? '1.1rem';
?>
<span class="star-display" style="font-size:<?php echo e($fs); ?>;line-height:1">
    <?php for($i = 1; $i <= 5; $i++): ?>
        <?php if($i <= $rating): ?>
            <span style="color:#f59e0b">★</span>
        <?php else: ?>
            <span style="color:#d1d5db">★</span>
        <?php endif; ?>
    <?php endfor; ?>
</span>
<?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/ulasan/_star_rating.blade.php ENDPATH**/ ?>