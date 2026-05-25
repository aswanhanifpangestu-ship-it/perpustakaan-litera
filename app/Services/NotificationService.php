<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Peminjaman;
use App\Models\User;

class NotificationService
{
    /**
     * Notifikasi ke admin: petugas baru didaftarkan.
     */
    public static function petugasBaru(User $petugas): void
    {
        Notification::create([
            'type'        => 'petugas_baru',
            'target_role' => 'admin',
            'actor_id'    => $petugas->id,
            'judul'       => 'Petugas Baru Ditambahkan',
            'pesan'       => "Akun petugas baru atas nama \"{$petugas->name}\" ({$petugas->email}) telah ditambahkan ke sistem.",
            'url'         => route('users.index', ['tab' => 'petugas']),
        ]);
    }

    /**
     * Notifikasi ke admin & petugas: user/petugas login pertama kali
     * (atau setiap login — bisa dikontrol dari caller).
     */
    public static function userLogin(User $user): void
    {
        $label = $user->role === 'petugas' ? 'Petugas' : 'Anggota';

        Notification::create([
            'type'        => 'user_login',
            'target_role' => 'admin,petugas',
            'actor_id'    => $user->id,
            'judul'       => "{$label} Login",
            'pesan'       => "\"{$user->name}\" ({$user->email}) baru saja masuk ke sistem.",
            'url'         => route('users.show', $user->id),
        ]);
    }

    /**
     * Notifikasi ke admin & petugas: user mengajukan peminjaman buku.
     */
    public static function peminjamanBaru(Peminjaman $peminjaman): void
    {
        $peminjaman->loadMissing(['user', 'buku']);

        Notification::create([
            'type'        => 'peminjaman_baru',
            'target_role' => 'admin,petugas',
            'actor_id'    => $peminjaman->user_id,
            'judul'       => 'Pengajuan Peminjaman Baru',
            'pesan'       => "\"{$peminjaman->user->name}\" mengajukan peminjaman buku \"{$peminjaman->buku->judul}\".",
            'url'         => route('peminjaman.show', $peminjaman->id),
        ]);
    }
}
