<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type');                          // 'petugas_baru' | 'user_login' | 'peminjaman_baru'
            $table->string('target_role');                   // 'admin' | 'petugas' | 'admin,petugas'
            $table->foreignId('actor_id')->nullable()        // user yang memicu notifikasi
                  ->constrained('users')->onDelete('cascade');
            $table->string('judul');
            $table->text('pesan');
            $table->string('url')->nullable();               // link tujuan klik
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
