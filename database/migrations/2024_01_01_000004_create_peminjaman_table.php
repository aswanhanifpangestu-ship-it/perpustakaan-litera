<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('buku_id')->constrained('buku')->onDelete('restrict');
            $table->foreignId('petugas_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');          // rencana kembali (max 30 hari)
            $table->date('tanggal_dikembalikan')->nullable(); // aktual dikembalikan
            $table->integer('jumlah_hari_terlambat')->default(0);
            $table->decimal('total_denda', 10, 2)->default(0);
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'dikembalikan'])->default('pending');
            $table->enum('status_denda', ['belum_bayar', 'sudah_bayar'])->default('belum_bayar');
            $table->text('catatan')->nullable();
            $table->text('alasan_tolak')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
