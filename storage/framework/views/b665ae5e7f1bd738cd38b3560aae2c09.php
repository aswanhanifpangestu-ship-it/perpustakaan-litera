

<?php $__env->startSection('title', 'Laporan Denda'); ?>
<?php $__env->startSection('page-title', '📊 Laporan Denda Bulanan'); ?>

<?php $__env->startSection('content'); ?>


<div class="card table-card mb-4">
    <div class="card-body py-3">
        <form action="<?php echo e(route('laporan.index')); ?>" method="GET" class="d-flex gap-2 align-items-center flex-wrap">
            <label class="fw-semibold small mb-0">Periode:</label>
            <select name="bulan" class="form-select form-select-sm" style="width:auto">
                <?php $__currentLoopData = $daftarBulan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $nama): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($num); ?>" <?php echo e($bulan == $num ? 'selected' : ''); ?>><?php echo e($nama); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="tahun" class="form-select form-select-sm" style="width:auto">
                <?php for($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                    <option value="<?php echo e($y); ?>" <?php echo e($tahun == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit" class="btn btn-sm btn-primary">
                <i class="bi bi-filter me-1"></i>Tampilkan
            </button>
            <div class="ms-auto d-flex gap-2 flex-wrap">
                <a href="<?php echo e(route('laporan.exportExcel', ['bulan' => $bulan, 'tahun' => $tahun])); ?>"
                   class="btn btn-sm btn-success">
                    <i class="bi bi-file-earmark-excel me-1"></i>Excel Denda
                </a>
                <a href="<?php echo e(route('laporan.exportPdf', ['bulan' => $bulan, 'tahun' => $tahun])); ?>"
                   class="btn btn-sm btn-danger">
                    <i class="bi bi-file-earmark-pdf me-1"></i>PDF Denda
                </a>
            </div>
        </form>
    </div>
</div>


<div class="card table-card mb-4">
    <div class="card-header py-3">
        <h6 class="mb-0 fw-bold">🖨️ Cetak Laporan PDF</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="rounded-3 p-3 h-100 d-flex flex-column" style="border:1px solid #ccfbf1;background:#f0fdf9">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="rounded-2 d-flex align-items-center justify-content-center"
                             style="width:40px;height:40px;background:#ccfbf1;font-size:1.3rem;flex-shrink:0">📗</div>
                        <div>
                            <div class="fw-bold small" style="color:#0f766e">Laporan Buku</div>
                            <div class="text-muted" style="font-size:.72rem">Seluruh koleksi buku</div>
                        </div>
                    </div>
                    <p class="text-muted small mb-3">Daftar lengkap koleksi buku beserta stok, kategori, dan status ketersediaan.</p>
                    <a href="<?php echo e(route('laporan.cetakBuku')); ?>" class="btn btn-sm btn-primary mt-auto" target="_blank">
                        📄 Cetak PDF Buku
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="rounded-3 p-3 h-100 d-flex flex-column" style="border:1px solid #fef3c7;background:#fffbeb">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="rounded-2 d-flex align-items-center justify-content-center"
                             style="width:40px;height:40px;background:#fef3c7;font-size:1.3rem;flex-shrink:0">🛡️</div>
                        <div>
                            <div class="fw-bold small" style="color:#d97706">Laporan Petugas</div>
                            <div class="text-muted" style="font-size:.72rem">Admin &amp; petugas aktif</div>
                        </div>
                    </div>
                    <p class="text-muted small mb-3">Daftar seluruh petugas dan admin beserta jumlah peminjaman yang diproses.</p>
                    <a href="<?php echo e(route('laporan.cetakPetugas')); ?>" class="btn btn-sm btn-warning text-dark mt-auto" target="_blank">
                        📄 Cetak PDF Petugas
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="rounded-3 p-3 h-100 d-flex flex-column" style="border:1px solid #ede9fe;background:#faf5ff">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="rounded-2 d-flex align-items-center justify-content-center"
                             style="width:40px;height:40px;background:#ede9fe;font-size:1.3rem;flex-shrink:0">👥</div>
                        <div>
                            <div class="fw-bold small" style="color:#5b21b6">Laporan Anggota</div>
                            <div class="text-muted" style="font-size:.72rem">Seluruh anggota terdaftar</div>
                        </div>
                    </div>
                    <p class="text-muted small mb-3">Daftar anggota perpustakaan beserta riwayat peminjaman dan status denda.</p>
                    <a href="<?php echo e(route('laporan.cetakUser')); ?>" class="btn btn-sm mt-auto" target="_blank"
                       style="background:#5b21b6;color:#fff">
                        📄 Cetak PDF Anggota
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card table-card mb-4">
    <div class="card-header py-3">
        <h6 class="mb-0 fw-bold">📋 Laporan Peminjaman &amp; Pengembalian</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="rounded-3 p-3 h-100 d-flex flex-column" style="border:1px solid #ccfbf1;background:#f0fdf9">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="rounded-2 d-flex align-items-center justify-content-center"
                             style="width:40px;height:40px;background:#ccfbf1;font-size:1.3rem;flex-shrink:0">📋</div>
                        <div>
                            <div class="fw-bold small" style="color:#0f766e">Laporan Peminjaman</div>
                            <div class="text-muted" style="font-size:.72rem">Semua data peminjaman</div>
                        </div>
                    </div>
                    <p class="text-muted small mb-3">Rekap seluruh transaksi peminjaman buku beserta status dan denda.</p>
                    <div class="d-flex gap-2 mt-auto flex-wrap">
                        <a href="<?php echo e(route('laporan.cetakPeminjaman')); ?>"
                           class="btn btn-sm btn-primary" target="_blank">
                            📄 Semua Periode
                        </a>
                        <a href="<?php echo e(route('laporan.cetakPeminjaman', ['bulan' => $bulan, 'tahun' => $tahun])); ?>"
                           class="btn btn-sm btn-outline-primary" target="_blank">
                            📄 Periode Ini
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="rounded-3 p-3 h-100 d-flex flex-column" style="border:1px solid #fef3c7;background:#fffbeb">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="rounded-2 d-flex align-items-center justify-content-center"
                             style="width:40px;height:40px;background:#fef3c7;font-size:1.3rem;flex-shrink:0">📦</div>
                        <div>
                            <div class="fw-bold small" style="color:#d97706">Laporan Pengembalian</div>
                            <div class="text-muted" style="font-size:.72rem">Semua data pengembalian</div>
                        </div>
                    </div>
                    <p class="text-muted small mb-3">Rekap seluruh pengembalian buku beserta keterlambatan dan status denda.</p>
                    <div class="d-flex gap-2 mt-auto flex-wrap">
                        <a href="<?php echo e(route('laporan.cetakPengembalian')); ?>"
                           class="btn btn-sm btn-warning text-dark" target="_blank">
                            📄 Semua Periode
                        </a>
                        <a href="<?php echo e(route('laporan.cetakPengembalian', ['bulan' => $bulan, 'tahun' => $tahun])); ?>"
                           class="btn btn-sm btn-outline-warning" target="_blank">
                            📄 Periode Ini
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#ccfbf1">
                    <span style="font-size:1.5rem">📋</span>
                </div>
                <div>
                    <div class="fs-3 fw-bold" style="color:#0f766e"><?php echo e($data['totalPeminjaman']); ?></div>
                    <div class="small text-muted">Total Peminjaman</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#fee2e2">
                    <span style="font-size:1.5rem">⏰</span>
                </div>
                <div>
                    <div class="fs-3 fw-bold text-danger"><?php echo e($data['totalTerlambat']); ?></div>
                    <div class="small text-muted">Kasus Terlambat</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#fef3c7">
                    <span style="font-size:1.5rem">💸</span>
                </div>
                <div>
                    <div class="fw-bold text-danger" style="font-size:1rem">Rp <?php echo e(number_format($data['belumBayar'], 0, ',', '.')); ?></div>
                    <div class="small text-muted">Denda Belum Bayar</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#dcfce7">
                    <span style="font-size:1.5rem">✅</span>
                </div>
                <div>
                    <div class="fw-bold text-success" style="font-size:1rem">Rp <?php echo e(number_format($data['sudahBayar'], 0, ',', '.')); ?></div>
                    <div class="small text-muted">Denda Sudah Bayar</div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="rounded-3 shadow-sm mb-4 p-4 d-flex align-items-center justify-content-between"
     style="background:linear-gradient(135deg,#134e4a,#0d9488);color:#fff">
    <div>
        <div class="fw-bold fs-5">
            💰 Total Denda <?php echo e($daftarBulan[str_pad($bulan,2,'0',STR_PAD_LEFT)]); ?> <?php echo e($tahun); ?>

        </div>
        <div class="small" style="opacity:.75"><?php echo e($data['jumlahKasus']); ?> kasus keterlambatan</div>
    </div>
    <div class="fs-3 fw-bold">
        Rp <?php echo e(number_format($data['totalDenda'], 0, ',', '.')); ?>

    </div>
</div>

<div class="row g-4 mb-4">
    
    <div class="col-lg-6">
        <div class="card table-card h-100">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-bold">🏆 Buku Paling Banyak Dipinjam</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr><th>#</th><th>📗 Judul</th><th class="text-center">📊 Dipinjam</th></tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $data['bukuPopuler']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-muted small"><?php echo e($i + 1); ?></td>
                                <td>
                                    <div class="fw-semibold small"><?php echo e($b->judul); ?></div>
                                    <div class="text-muted" style="font-size:.72rem">✍️ <?php echo e($b->pengarang); ?></div>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill" style="background:#ccfbf1;color:#0f766e">
                                        <?php echo e($b->peminjaman_count); ?>x
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="3" class="text-center text-muted py-4">📭 Tidak ada data.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-lg-6">
        <div class="card table-card h-100">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-bold">🌟 Anggota Paling Aktif</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr><th>#</th><th>👤 Nama</th><th class="text-center">📊 Peminjaman</th></tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $data['anggotaAktif']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-muted small"><?php echo e($i + 1); ?></td>
                                <td>
                                    <div class="fw-semibold small"><?php echo e($a->name); ?></div>
                                    <div class="text-muted" style="font-size:.72rem"><?php echo e($a->no_anggota ?? $a->email); ?></div>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill" style="background:#ede9fe;color:#5b21b6">
                                        <?php echo e($a->peminjaman_count); ?>x
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="3" class="text-center text-muted py-4">📭 Tidak ada data.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card table-card">
    <div class="card-header py-3">
        <h6 class="mb-0 fw-bold">
            💸 Detail Denda — <?php echo e($daftarBulan[str_pad($bulan,2,'0',STR_PAD_LEFT)]); ?> <?php echo e($tahun); ?>

        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>👤 Anggota</th>
                        <th>📗 Buku</th>
                        <th>📅 Tgl Kembali</th>
                        <th>📅 Tgl Dikembalikan</th>
                        <th>⏰ Terlambat</th>
                        <th>💰 Total Denda</th>
                        <th>🔖 Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $data['detailDenda']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted small"><?php echo e($i + 1); ?></td>
                        <td class="small fw-semibold"><?php echo e($p->user->name); ?></td>
                        <td class="small text-truncate" style="max-width:140px"><?php echo e($p->buku->judul); ?></td>
                        <td class="small"><?php echo e($p->tanggal_kembali->format('d/m/Y')); ?></td>
                        <td class="small"><?php echo e($p->tanggal_dikembalikan ? $p->tanggal_dikembalikan->format('d/m/Y') : '—'); ?></td>
                        <td class="small text-danger fw-semibold">⏰ <?php echo e($p->jumlah_hari_terlambat); ?> hari</td>
                        <td class="small fw-semibold text-danger">Rp <?php echo e(number_format($p->total_denda, 0, ',', '.')); ?></td>
                        <td>
                            <?php if($p->status_denda === 'sudah_bayar'): ?>
                                <span class="badge rounded-pill bg-success">✅ Lunas</span>
                            <?php else: ?>
                                <span class="badge rounded-pill bg-danger">🔴 Belum Bayar</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <span style="font-size:2rem">📭</span>
                            <div class="mt-2">Tidak ada denda pada periode ini.</div>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/laporan/index.blade.php ENDPATH**/ ?>