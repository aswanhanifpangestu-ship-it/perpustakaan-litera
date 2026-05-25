<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StrukController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // ── Buku ──────────────────────────────────────────────────────────────
    // PENTING: route statis (create) harus didefinisikan SEBELUM route parameter ({buku})
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');

    Route::middleware('role:admin,petugas')->group(function () {
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    });

    // Route dengan parameter {buku} — harus setelah route statis
    Route::get('/buku/{buku}', [BukuController::class, 'show'])->name('buku.show');

    Route::middleware('role:admin,petugas')->group(function () {
        Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
    });

    // ── Kategori ──────────────────────────────────────────────────────────
    Route::middleware('role:admin,petugas')->group(function () {
        Route::resource('kategori', KategoriController::class)->except(['show']);
    });

    // ── Peminjaman ────────────────────────────────────────────────────────
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])->name('peminjaman.show');

    Route::middleware('role:admin,petugas')->group(function () {
        Route::post('/peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
        Route::post('/peminjaman/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
        Route::post('/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
        Route::post('/peminjaman/{peminjaman}/bayar-denda', [PeminjamanController::class, 'bayarDenda'])->name('peminjaman.bayarDenda');
        Route::delete('/peminjaman/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
    });

    // ── Manajemen User (Admin: semua, Petugas: hanya anggota) ────────────
    Route::middleware('role:admin,petugas')->group(function () {
        Route::resource('users', UserController::class);
    });

    // ── Laporan (Admin & Petugas) ─────────────────────────────────────────
    Route::middleware('role:admin,petugas')->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.exportExcel');
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.exportPdf');
        Route::get('/laporan/cetak-buku', [LaporanController::class, 'exportPdfBuku'])->name('laporan.cetakBuku');
        Route::get('/laporan/cetak-petugas', [LaporanController::class, 'exportPdfPetugas'])->name('laporan.cetakPetugas');
        Route::get('/laporan/cetak-user', [LaporanController::class, 'exportPdfUser'])->name('laporan.cetakUser');
        Route::get('/laporan/cetak-peminjaman', [LaporanController::class, 'exportPdfPeminjaman'])->name('laporan.cetakPeminjaman');
        Route::get('/laporan/cetak-pengembalian', [LaporanController::class, 'exportPdfPengembalian'])->name('laporan.cetakPengembalian');
    });

    // ── Struk Peminjaman ──────────────────────────────────────────────────
    Route::get('/struk', [StrukController::class, 'index'])->name('struk.index');
    Route::get('/struk/{peminjaman}', [StrukController::class, 'show'])->name('struk.show');
    Route::get('/struk/{peminjaman}/pdf', [StrukController::class, 'pdf'])->name('struk.pdf');
    Route::get('/struk/{peminjaman}/pengembalian-pdf', [StrukController::class, 'pengembalianPdf'])->name('struk.pengembalianPdf');

    // ── Profil (semua role) ───────────────────────────────────────────────
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // ── Ulasan ────────────────────────────────────────────────────────────
    // User: beri ulasan dari halaman detail peminjaman
    Route::post('/peminjaman/{peminjaman}/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
    // User: hapus ulasan milik sendiri
    Route::delete('/ulasan/{ulasan}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');
    // Admin & Petugas: lihat semua ulasan
    Route::middleware('role:admin,petugas')->group(function () {
        Route::get('/ulasan', [UlasanController::class, 'index'])->name('ulasan.index');
    });

    // ── Notifikasi (Admin & Petugas) ──────────────────────────────────────
    Route::middleware('role:admin,petugas')->group(function () {
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
        Route::get('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
        Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    });
});
