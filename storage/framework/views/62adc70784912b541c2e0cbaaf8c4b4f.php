

<?php $__env->startSection('title', 'Detail Peminjaman'); ?>
<?php $__env->startSection('page-title', '📋 Detail Peminjaman'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card table-card">
            <div class="card-header py-3 d-flex align-items-center gap-2">
                <a href="<?php echo e(route('peminjaman.index')); ?>" class="btn btn-sm btn-outline-secondary">
                    ← Kembali
                </a>
                <h6 class="mb-0 fw-bold">📋 Peminjaman #<?php echo e($peminjaman->id); ?></h6>
                <div class="ms-auto">
                    <?php echo $__env->make('peminjaman._badge_status', ['status' => $peminjaman->status], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            <div class="card-body">

                <?php if($peminjaman->status === 'ditolak' && $peminjaman->alasan_tolak): ?>
                <div class="rounded-3 p-3 mb-4 d-flex gap-2" style="background:#fff1f2;border:1px solid #fecdd3;color:#9f1239">
                    <span style="font-size:1.2rem">❌</span>
                    <div>
                        <div class="fw-bold small">Alasan Penolakan</div>
                        <div class="small mt-1"><?php echo e($peminjaman->alasan_tolak); ?></div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="rounded-3 p-3 h-100" style="background:#f0fdf9;border:1px solid #ccfbf1">
                            <div class="fw-bold small mb-3" style="color:#0f766e;text-transform:uppercase;letter-spacing:.05em">
                                👤 Informasi Anggota
                            </div>
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <td class="text-muted small" width="110">Nama</td>
                                    <td class="fw-semibold small"><?php echo e($peminjaman->user->name); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted small">No. Anggota</td>
                                    <td class="small"><?php echo e($peminjaman->user->no_anggota ?? '—'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted small">Email</td>
                                    <td class="small"><?php echo e($peminjaman->user->email); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="rounded-3 p-3 h-100" style="background:#fffbeb;border:1px solid #fef3c7">
                            <div class="fw-bold small mb-3" style="color:#d97706;text-transform:uppercase;letter-spacing:.05em">
                                📗 Informasi Buku
                            </div>
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <td class="text-muted small" width="110">Judul</td>
                                    <td class="fw-semibold small"><?php echo e($peminjaman->buku->judul); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted small">Pengarang</td>
                                    <td class="small"><?php echo e($peminjaman->buku->pengarang); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted small">Denda/Hari</td>
                                    <td class="small">Rp <?php echo e(number_format($peminjaman->buku->denda_per_hari, 0, ',', '.')); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <hr style="border-color:#ccfbf1;margin:1.5rem 0">

                <div class="fw-bold small mb-3" style="color:#0f766e;text-transform:uppercase;letter-spacing:.05em">
                    📅 Informasi Peminjaman
                </div>
                <div class="row g-3">
                    <div class="col-sm-3">
                        <div class="rounded-3 p-3 text-center" style="background:#f0fdf9">
                            <div class="small text-muted mb-1">📅 Tgl Pinjam</div>
                            <div class="fw-bold small"><?php echo e($peminjaman->tanggal_pinjam->format('d M Y')); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="rounded-3 p-3 text-center" style="background:#f0fdf9">
                            <div class="small text-muted mb-1">📅 Tgl Kembali</div>
                            <div class="fw-bold small"><?php echo e($peminjaman->tanggal_kembali->format('d M Y')); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="rounded-3 p-3 text-center"
                             style="background:<?php echo e($peminjaman->tanggal_dikembalikan ? '#dcfce7' : '#f1f5f9'); ?>">
                            <div class="small text-muted mb-1">✅ Dikembalikan</div>
                            <div class="fw-bold small">
                                <?php echo e($peminjaman->tanggal_dikembalikan
                                    ? $peminjaman->tanggal_dikembalikan->format('d M Y')
                                    : '—'); ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="rounded-3 p-3 text-center"
                             style="background:<?php echo e($peminjaman->jumlah_hari_terlambat > 0 ? '#fee2e2' : '#f0fdf9'); ?>">
                            <div class="small text-muted mb-1">⏰ Terlambat</div>
                            <div class="fw-bold <?php echo e($peminjaman->jumlah_hari_terlambat > 0 ? 'text-danger' : ''); ?>">
                                <?php echo e($peminjaman->jumlah_hari_terlambat); ?> hari
                            </div>
                        </div>
                    </div>
                </div>

                <?php if($peminjaman->total_denda > 0): ?>
                <div class="mt-4 p-3 rounded-3 d-flex align-items-center justify-content-between"
                     style="background:<?php echo e($peminjaman->status_denda === 'sudah_bayar' ? '#dcfce7' : '#fee2e2'); ?>;
                            border:1px solid <?php echo e($peminjaman->status_denda === 'sudah_bayar' ? '#bbf7d0' : '#fecdd3'); ?>">
                    <div>
                        <div class="fw-bold <?php echo e($peminjaman->status_denda === 'sudah_bayar' ? 'text-success' : 'text-danger'); ?>">
                            💸 Total Denda: Rp <?php echo e(number_format($peminjaman->total_denda, 0, ',', '.')); ?>

                        </div>
                        <div class="small text-muted mt-1">
                            <?php echo e($peminjaman->jumlah_hari_terlambat); ?> hari ×
                            Rp <?php echo e(number_format($peminjaman->buku->denda_per_hari, 0, ',', '.')); ?>/hari
                        </div>
                    </div>
                    <?php if($peminjaman->status_denda === 'sudah_bayar'): ?>
                        <span class="badge bg-success px-3 py-2">✅ Lunas</span>
                    <?php else: ?>
                        <span class="badge bg-danger px-3 py-2">🔴 Belum Bayar</span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if($peminjaman->catatan): ?>
                <div class="mt-3 p-3 rounded-3" style="background:#f0fdf9;border:1px solid #ccfbf1">
                    <div class="fw-bold small mb-1" style="color:#0f766e">📝 Catatan</div>
                    <p class="mb-0 small"><?php echo e($peminjaman->catatan); ?></p>
                </div>
                <?php endif; ?>

                <?php if($peminjaman->petugas): ?>
                <div class="mt-3 text-muted small">
                    🛡️ Diproses oleh: <strong><?php echo e($peminjaman->petugas->name); ?></strong>
                </div>
                <?php endif; ?>

                
                <?php if(in_array($peminjaman->status, ['disetujui', 'dikembalikan'])): ?>
                <div class="mt-4 pt-3" style="border-top:1px solid #ccfbf1">
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('struk.show', $peminjaman)); ?>"
                           class="btn btn-sm btn-outline-primary">
                            🧾 Lihat Struk
                        </a>
                        <a href="<?php echo e(route('struk.pdf', $peminjaman)); ?>"
                           class="btn btn-sm btn-danger" target="_blank">
                            📄 Download Struk PDF
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<div class="row justify-content-center">
    <div class="col-lg-8">
        <?php echo $__env->make('ulasan._form_ulasan', ['peminjaman' => $peminjaman], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php if(auth()->user()->isAdminOrPetugas() && $peminjaman->ulasan): ?>
        <div class="card table-card mt-4">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-bold">⭐ Ulasan Anggota</h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:42px;height:42px;background:#ccfbf1;font-size:1.1rem">
                        👤
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="fw-semibold"><?php echo e($peminjaman->ulasan->user->name); ?></span>
                            <?php echo $__env->make('ulasan._star_rating', ['rating' => $peminjaman->ulasan->rating, 'size' => 'md'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <span class="text-muted small"><?php echo e($peminjaman->ulasan->created_at->diffForHumans()); ?></span>
                        </div>
                        <?php if($peminjaman->ulasan->komentar): ?>
                            <p class="mb-2 text-muted small"><?php echo e($peminjaman->ulasan->komentar); ?></p>
                        <?php else: ?>
                            <p class="mb-2 text-muted fst-italic small">Tidak ada komentar.</p>
                        <?php endif; ?>
                        <form action="<?php echo e(route('ulasan.destroy', $peminjaman->ulasan)); ?>" method="POST"
                              onsubmit="return confirm('Hapus ulasan ini?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Hapus Ulasan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/peminjaman/show.blade.php ENDPATH**/ ?>