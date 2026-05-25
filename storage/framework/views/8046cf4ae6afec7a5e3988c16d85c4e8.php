
<?php if(auth()->check() && auth()->user()->isAdminOrPetugas()): ?>
<?php
    $role      = auth()->user()->role;
    $notifList = \App\Models\Notification::forRole($role)
                    ->with('actor')
                    ->latest()
                    ->take(6)
                    ->get();
    $unread    = \App\Models\Notification::forRole($role)->unread()->count();
?>

<div class="px-3 mb-2">
    <div class="notif-wrapper" style="position:relative">
        <button class="btn w-100 text-start d-flex align-items-center gap-2 notif-toggle-btn"
                type="button" id="sidebarNotifToggle"
                style="background:rgba(255,255,255,.08);border:none;border-radius:.5rem;padding:.55rem .85rem;color:rgba(255,255,255,.85);font-size:.875rem;font-weight:500">
            <span>🔔</span>
            <span class="flex-grow-1">Notifikasi</span>
            <?php if($unread > 0): ?>
                <span class="badge rounded-pill bg-danger" style="font-size:.68rem">
                    <?php echo e($unread > 99 ? '99+' : $unread); ?>

                </span>
            <?php endif; ?>
            <i class="bi bi-chevron-down notif-chevron" style="font-size:.7rem;transition:transform .2s"></i>
        </button>

        
        <div id="sidebarNotifPanel"
             style="display:none;background:rgba(15,30,60,.97);border-radius:.5rem;margin-bottom:.25rem;overflow:hidden;position:absolute;bottom:100%;left:.75rem;right:.75rem;max-height:340px;overflow-y:auto;box-shadow:0 -4px 20px rgba(0,0,0,.4);z-index:1050">

            
            <div class="d-flex align-items-center justify-content-between px-3 py-2"
                 style="border-bottom:1px solid rgba(255,255,255,.1)">
                <span style="font-size:.75rem;color:rgba(255,255,255,.5);font-weight:600;text-transform:uppercase;letter-spacing:.06em">
                    Terbaru
                </span>
                <?php if($unread > 0): ?>
                <form action="<?php echo e(route('notifications.markAllRead')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                            style="background:none;border:none;font-size:.7rem;color:rgba(255,255,255,.5);cursor:pointer;padding:0"
                            title="Tandai semua dibaca">
                        Baca semua
                    </button>
                </form>
                <?php endif; ?>
            </div>

            
            <?php $__empty_1 = true; $__currentLoopData = $notifList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('notifications.read', $n)); ?>"
               class="d-flex align-items-start gap-2 px-3 py-2 notif-item <?php echo e($n->is_read ? '' : 'notif-unread'); ?>"
               style="text-decoration:none;border-bottom:1px solid rgba(255,255,255,.06)">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1"
                     style="width:28px;height:28px;<?php echo e($n->type === 'petugas_baru' ? 'background:rgba(245,158,11,.2)' : ($n->type === 'user_login' ? 'background:rgba(34,197,94,.2)' : 'background:rgba(59,130,246,.2)')); ?>">
                    <i class="bi <?php echo e($n->icon()); ?> <?php echo e($n->iconColor()); ?>" style="font-size:.7rem"></i>
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <div style="font-size:.78rem;font-weight:<?php echo e($n->is_read ? '400' : '600'); ?>;color:<?php echo e($n->is_read ? 'rgba(255,255,255,.6)' : '#fff'); ?>;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                        <?php echo e($n->judul); ?>

                    </div>
                    <div style="font-size:.7rem;color:rgba(255,255,255,.45);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                        <?php echo e($n->pesan); ?>

                    </div>
                    <div style="font-size:.65rem;color:rgba(255,255,255,.3);margin-top:.1rem">
                        <?php echo e($n->created_at->diffForHumans()); ?>

                    </div>
                </div>
                <?php if(!$n->is_read): ?>
                <div class="flex-shrink-0 mt-2">
                    <span style="width:7px;height:7px;background:#ef4444;border-radius:50%;display:inline-block"></span>
                </div>
                <?php endif; ?>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-3" style="color:rgba(255,255,255,.4);font-size:.8rem">
                <i class="bi bi-bell-slash d-block mb-1" style="font-size:1.2rem"></i>
                Tidak ada notifikasi
            </div>
            <?php endif; ?>

            
            <a href="<?php echo e(route('notifications.index')); ?>"
               class="d-block text-center py-2"
               style="font-size:.75rem;color:rgba(255,255,255,.5);text-decoration:none;border-top:1px solid rgba(255,255,255,.1)">
                Lihat semua notifikasi
            </a>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    const btn   = document.getElementById('sidebarNotifToggle');
    const panel = document.getElementById('sidebarNotifPanel');
    const chev  = btn?.querySelector('.notif-chevron');

    if (!btn || !panel) return;

    btn.addEventListener('click', function () {
        const open = panel.style.display !== 'none';
        panel.style.display = open ? 'none' : 'block';
        if (chev) chev.style.transform = open ? 'rotate(0deg)' : 'rotate(180deg)';
    });
})();
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.notif-item { transition: background .15s; }
.notif-item:hover { background: rgba(255,255,255,.08) !important; }
.notif-unread { background: rgba(255,255,255,.04); }
.notif-toggle-btn:hover { background: rgba(255,255,255,.15) !important; }
</style>
<?php $__env->stopPush(); ?>

<?php endif; ?>
<?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/notifications/_sidebar_bell.blade.php ENDPATH**/ ?>