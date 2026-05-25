

<?php $__env->startSection('title', 'Manajemen Pengguna'); ?>
<?php $__env->startSection('page-title', '👥 Manajemen Pengguna'); ?>

<?php $__env->startSection('content'); ?>


<ul class="nav nav-tabs mb-0" id="userTab" role="tablist" style="border-bottom:2px solid #ccfbf1">
    <?php if(!$isPetugas): ?>
    <li class="nav-item" role="presentation">
        <button class="nav-link <?php echo e($tab === 'petugas' ? 'active' : ''); ?> fw-semibold"
                id="tab-petugas" data-bs-toggle="tab" data-bs-target="#panel-petugas"
                type="button" role="tab">
            🛡️ Petugas
            <span class="badge rounded-pill ms-1" style="background:#ccfbf1;color:#0f766e"><?php echo e($petugas->total()); ?></span>
        </button>
    </li>
    <?php endif; ?>
    <li class="nav-item" role="presentation">
        <button class="nav-link <?php echo e($tab === 'anggota' ? 'active' : ''); ?> fw-semibold"
                id="tab-anggota" data-bs-toggle="tab" data-bs-target="#panel-anggota"
                type="button" role="tab">
            👥 Anggota
            <span class="badge rounded-pill ms-1" style="background:#ede9fe;color:#5b21b6"><?php echo e($anggota->total()); ?></span>
        </button>
    </li>
</ul>

<div class="tab-content" id="userTabContent">

    
    <?php if(!$isPetugas): ?>
    <div class="tab-pane fade <?php echo e($tab === 'petugas' ? 'show active' : ''); ?>"
         id="panel-petugas" role="tabpanel">
        <div class="card table-card border-top-0 rounded-top-0">
            <div class="card-header bg-white py-3">
                <div class="row g-2 align-items-center">
                    <div class="col-md-7">
                        <form action="<?php echo e(route('users.index')); ?>" method="GET" class="d-flex gap-2">
                            <input type="hidden" name="tab" value="petugas">
                            <input type="text" name="search_petugas"
                                   class="form-control form-control-sm"
                                   placeholder="Cari nama atau email petugas..."
                                   value="<?php echo e(request('search_petugas')); ?>">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="bi bi-search"></i>
                            </button>
                            <?php if(request('search_petugas')): ?>
                                <a href="<?php echo e(route('users.index', ['tab' => 'petugas'])); ?>"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-x"></i>
                                </a>
                            <?php endif; ?>
                        </form>
                    </div>
                    <div class="col-md-5 text-md-end">
                        <a href="<?php echo e(route('users.create', ['role' => 'petugas'])); ?>"
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
                            <?php $__empty_1 = true; $__currentLoopData = $petugas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-muted small"><?php echo e($petugas->firstItem() + $loop->index); ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-warning bg-opacity-20 d-flex align-items-center justify-content-center"
                                             style="width:32px;height:32px;flex-shrink:0">
                                            <i class="bi bi-person-badge text-warning small"></i>
                                        </div>
                                        <div class="fw-semibold small"><?php echo e($u->name); ?></div>
                                    </div>
                                </td>
                                <td class="small text-muted"><?php echo e($u->email); ?></td>
                                <td>
                                    <span class="badge rounded-pill
                                        <?php if($u->role === 'admin'): ?> badge-admin
                                        <?php else: ?> badge-petugas
                                        <?php endif; ?> px-3">
                                        <?php echo e(ucfirst($u->role)); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if($u->is_active): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="<?php echo e(route('users.show', $u)); ?>"
                                           class="btn btn-xs btn-outline-info" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('users.edit', $u)); ?>"
                                           class="btn btn-xs btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php if($u->id !== auth()->id()): ?>
                                        <form action="<?php echo e(route('users.destroy', $u)); ?>" method="POST"
                                              onsubmit="return confirm('Hapus petugas ini?')">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-xs btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-person-badge fs-2 d-block mb-2"></i>
                                    Tidak ada petugas ditemukan.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php if($petugas->hasPages()): ?>
            <div class="card-footer bg-white"><?php echo e($petugas->links()); ?></div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    
    <div class="tab-pane fade <?php echo e($tab === 'anggota' ? 'show active' : ''); ?>"
         id="panel-anggota" role="tabpanel">
        <div class="card table-card border-top-0 rounded-top-0">
            <div class="card-header bg-white py-3">
                <div class="row g-2 align-items-center">
                    <div class="col-12">
                        <form action="<?php echo e(route('users.index')); ?>" method="GET" class="d-flex gap-2">
                            <input type="hidden" name="tab" value="anggota">
                            <input type="text" name="search_anggota"
                                   class="form-control form-control-sm"
                                   placeholder="Cari nama, email, no. anggota..."
                                   value="<?php echo e(request('search_anggota')); ?>">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="bi bi-search"></i>
                            </button>
                            <?php if(request('search_anggota')): ?>
                                <a href="<?php echo e(route('users.index', ['tab' => 'anggota'])); ?>"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-x"></i>
                                </a>
                            <?php endif; ?>
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
                            <?php $__empty_1 = true; $__currentLoopData = $anggota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-muted small"><?php echo e($anggota->firstItem() + $loop->index); ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                                             style="width:32px;height:32px;flex-shrink:0">
                                            <i class="bi bi-person-fill text-primary small"></i>
                                        </div>
                                        <div class="fw-semibold small"><?php echo e($u->name); ?></div>
                                    </div>
                                </td>
                                <td class="small text-muted"><?php echo e($u->email); ?></td>
                                <td class="small"><?php echo e($u->no_anggota ?? '-'); ?></td>
                                <td class="small"><?php echo e($u->telepon ?? '-'); ?></td>
                                <td>
                                    <?php if($u->is_active): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="<?php echo e(route('users.show', $u)); ?>"
                                           class="btn btn-xs btn-outline-info" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('users.edit', $u)); ?>"
                                           class="btn btn-xs btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php if($u->id !== auth()->id()): ?>
                                        <form action="<?php echo e(route('users.destroy', $u)); ?>" method="POST"
                                              onsubmit="return confirm('Hapus anggota ini?')">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-xs btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="bi bi-people fs-2 d-block mb-2"></i>
                                    Tidak ada anggota ditemukan.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php if($anggota->hasPages()): ?>
            <div class="card-footer bg-white"><?php echo e($anggota->links()); ?></div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php $__env->startPush('styles'); ?>
<style>
.btn-xs { padding: .2rem .45rem; font-size: .75rem; }
.badge-admin   { background: #fef3c7; color: #92400e; }
.badge-petugas { background: #ccfbf1; color: #0f766e; }
.badge-user    { background: #ede9fe; color: #5b21b6; }
.nav-tabs .nav-link { color: #64748b; border-radius: .5rem .5rem 0 0; }
.nav-tabs .nav-link.active { color: #0f766e; background: #fff; border-bottom-color: #fff; font-weight: 700; }
.rounded-top-0 { border-top-left-radius: 0 !important; border-top-right-radius: 0 !important; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/users/index.blade.php ENDPATH**/ ?>