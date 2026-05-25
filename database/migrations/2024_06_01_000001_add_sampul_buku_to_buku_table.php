<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            // Tambah kolom sampul_buku jika belum ada
            if (!Schema::hasColumn('buku', 'sampul_buku')) {
                $table->string('sampul_buku')->nullable()->after('deskripsi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            if (Schema::hasColumn('buku', 'sampul_buku')) {
                $table->dropColumn('sampul_buku');
            }
        });
    }
};
