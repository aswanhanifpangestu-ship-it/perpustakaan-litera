<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('pengarang');
            $table->string('penerbit');
            $table->year('tahun_terbit');
            $table->string('isbn', 20)->nullable()->unique();
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('restrict');
            $table->integer('stok')->default(0);
            $table->integer('stok_tersedia')->default(0);
            $table->text('deskripsi')->nullable();
            $table->string('cover')->nullable();
            $table->string('lokasi_rak', 50)->nullable();
            $table->decimal('denda_per_hari', 10, 2)->default(1000);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
