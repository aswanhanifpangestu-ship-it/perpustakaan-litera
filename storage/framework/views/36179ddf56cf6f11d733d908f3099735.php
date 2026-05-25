

<?php $__env->startSection('title', 'Peminjaman'); ?>
<?php $__env->startSection('page-title', '📋 Data Peminjaman'); ?>

<?php $__env->startSection('content'); ?>
<div class="card table-card">
    <div class="card-header py-3">
        <div class="row g-2 align-items-center">
            <div class="col-md-8">
                <form action="<?php echo e(route('peminjaman.index')); ?>" method="GET" class="d-flex gap-2 flex-wrap">
                    <input type="text" name="search" class="form-control form-control-sm"
                           placeholder="🔍 Cari nama anggota / judul buku..."
                           value="<?php echo e(request('search')); ?>" style="min-width:180px">
                    <select name="status" class="form-select form-select-sm" style="width:auto">
                        <option value="">🔖 Semua Status</option>
                        <option value="pending"      <?php echo e(request('status') === 'pending'      ? 'selected' : ''); ?>>⏳ Pending</option>
                        <option value="disetujui"    <?php echo e(request('status') === 'disetujui'    ? 'selected' : ''); ?>>📖 Dipinjam</option>
                        <option value="ditolak"      <?php echo e(request('status') === 'ditolak'      ? 'selected' : ''); ?>>❌ Ditolak</option>
                        <option value="dikembalikan" <?php echo e(request('status') === 'dikembalikan' ? 'selected' : ''); ?>>✅ Dikembalikan</option>
                    </select>
                    <?php if(auth()->user()->isAdminOrPetugas()): ?>
                    <select name="status_denda" class="form-select form-select-sm" style="width:auto">
                        <option value="">💸 Semua Denda</option>
                        <option value="belum_bayar" <?php echo e(request('status_denda') === 'belum_bayar' ? 'selected' : ''); ?>>🔴 Belum Bayar</option>
                        <option value="sudah_bayar" <?php echo e(request('status_denda') === 'sudah_bayar' ? 'selected' : ''); ?>>🟢 Sudah Bayar</option>
                    </select>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                    <?php if(request()->hasAny(['search','status','status_denda'])): ?>
                        <a href="<?php echo e(route('peminjaman.index')); ?>" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-x"></i>
                        </a>
                    <?php endif; ?>
                </form>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="<?php echo e(route('peminjaman.create')); ?>" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>
                    <?php echo e(auth()->user()->isUser() ? '📝 Ajukan Peminjaman' : '➕ Catat Peminjaman'); ?>

                </a>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>👤 Anggota</th>
                        <th>📗 Buku</th>
                        <th>📅 Tgl Pinjam</th>
                        <th>📅 Tgl Kembali</th>
                        <th>🔖 Status</th>
                        <th>💸 Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $peminjaman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted small"><?php echo e($peminjaman->firstItem() + $loop->index); ?></td>
                        <td>
                            <div class="fw-semibold small"><?php echo e($p->user->name); ?></div>
                            <div class="text-muted" style="font-size:.7rem"><?php echo e($p->user->no_anggota ?? '—'); ?></div>
                        </td>
                        <td class="small" style="max-width:160px">
                            <div class="text-truncate"><?php echo e($p->buku->judul); ?></div>
                        </td>
                        <td class="small"><?php echo e($p->tanggal_pinjam->format('d/m/Y')); ?></td>
                        <td class="small">
                            <?php echo e($p->tanggal_kembali->format('d/m/Y')); ?>

                            <?php if($p->status === 'disetujui' && $p->tanggal_kembali->isPast()): ?>
                                <span class="badge bg-danger ms-1" style="font-size:.65rem">⚠️ Lewat</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $__env->make('peminjaman._badge_status', ['status' => $p->status], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></td>
                        <td class="small">
                            <?php if($p->total_denda > 0): ?>
                                <div class="<?php echo e($p->status_denda === 'belum_bayar' ? 'text-danger fw-semibold' : 'text-success'); ?>">
                                    Rp <?php echo e(number_format($p->total_denda, 0, ',', '.')); ?>

                                </div>
                                <?php if($p->status_denda === 'sudah_bayar'): ?>
                                    <span class="badge bg-success" style="font-size:.65rem">✅ Lunas</span>
                                <?php else: ?>
                                    <span class="badge bg-danger" style="font-size:.65rem">🔴 Belum Bayar</span>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="<?php echo e(route('peminjaman.show', $p)); ?>"
                                   class="btn btn-xs btn-outline-primary" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <?php if(in_array($p->status, ['disetujui', 'dikembalikan'])): ?>
                                <a href="<?php echo e(route('struk.show', $p)); ?>"
                                   class="btn btn-xs btn-outline-success" title="Struk Peminjaman">
                                    🧾
                                </a>
                                <?php endif; ?>
                                <?php if($p->status === 'dikembalikan'): ?>
                                <a href="<?php echo e(route('struk.pengembalianPdf', $p)); ?>"
                                   class="btn btn-xs btn-outline-success" title="Struk Pengembalian" target="_blank">
                                    📦
                                </a>
                                <?php endif; ?>
                                <?php if(auth()->user()->isAdminOrPetugas()): ?>
                                    <?php if($p->status === 'pending'): ?>
                                    <form action="<?php echo e(route('peminjaman.approve', $p)); ?>" method="POST"
                                          onsubmit="return confirm('Setujui peminjaman ini?')">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-xs btn-outline-success" title="Setujui">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-xs btn-outline-danger"
                                            data-bs-toggle="modal" data-bs-target="#modalTolak"
                                            data-id="<?php echo e($p->id); ?>" data-judul="<?php echo e($p->buku->judul); ?>"
                                            title="Tolak">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                    <?php endif; ?>

                                    <?php if($p->status === 'disetujui'): ?>
                                    <button type="button" class="btn btn-xs btn-outline-warning"
                                            data-bs-toggle="modal" data-bs-target="#modalKembali"
                                            data-id="<?php echo e($p->id); ?>" data-judul="<?php echo e($p->buku->judul); ?>"
                                            data-tgl="<?php echo e($p->tanggal_pinjam->format('Y-m-d')); ?>"
                                            title="Kembalikan">
                                        <i class="bi bi-arrow-return-left"></i>
                                    </button>
                                    <?php endif; ?>

                                    <?php if($p->status === 'dikembalikan' && $p->total_denda > 0 && $p->status_denda === 'belum_bayar'): ?>
                                    <form action="<?php echo e(route('peminjaman.bayarDenda', $p)); ?>" method="POST"
                                          onsubmit="return confirm('Tandai denda sebagai lunas?')">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-xs btn-outline-success" title="Bayar Denda">
                                            <i class="bi bi-cash-coin"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>

                                    <?php if(!in_array($p->status, ['disetujui'])): ?>
                                    <form action="<?php echo e(route('peminjaman.destroy', $p)); ?>" method="POST"
                                          onsubmit="return confirm('Hapus data ini?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-xs btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <span style="font-size:2.5rem">📭</span>
                            <div class="mt-2">Tidak ada data peminjaman.</div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if($peminjaman->hasPages()): ?>
    <div class="card-footer"><?php echo e($peminjaman->links()); ?></div>
    <?php endif; ?>
</div>


<div class="modal fade" id="modalTolak" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold text-danger">❌ Tolak Peminjaman</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formTolak" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <p class="text-muted small mb-3">📗 Buku: <strong id="judulBukuTolak"></strong></p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="alasan_tolak" class="form-control" rows="3"
                                  placeholder="Tuliskan alasan penolakan..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-sm">❌ Tolak Peminjaman</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="modalKembali" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold">📦 Proses Pengembalian</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formKembali" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <p class="text-muted small mb-3">📗 Buku: <strong id="judulBukuKembali"></strong></p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">📅 Tanggal Dikembalikan</label>
                        <input type="date" name="tanggal_dikembalikan" class="form-control"
                               value="<?php echo e(date('Y-m-d')); ?>" required id="inputTglKembali">
                    </div>
                    <div class="rounded-3 p-3 small" style="background:#ccfbf1;color:#0f766e">
                        ℹ️ Denda dihitung otomatis berdasarkan <strong>denda per hari</strong> masing-masing buku.
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">✅ Konfirmasi Kembali</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>.btn-xs { padding:.2rem .45rem; font-size:.75rem; }</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('modalTolak').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('judulBukuTolak').textContent = btn.dataset.judul;
    document.getElementById('formTolak').action = '/peminjaman/' + btn.dataset.id + '/reject';
});
document.getElementById('modalKembali').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('judulBukuKembali').textContent = btn.dataset.judul;
    document.getElementById('formKembali').action = '/peminjaman/' + btn.dataset.id + '/kembalikan';
    document.getElementById('inputTglKembali').min = btn.dataset.tgl;
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/peminjaman/index.blade.php ENDPATH**/ ?>