<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ADMIN   = 'admin';
    const ROLE_PETUGAS = 'petugas';
    const ROLE_USER    = 'user';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_anggota',
        'alamat',
        'telepon',
        'foto',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Laravel 9: casts sebagai array biasa (bukan property typed).
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active'         => 'boolean',
    ];

    /* ------------------------------------------------------------------ */
    /* Relasi                                                               */
    /* ------------------------------------------------------------------ */

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    /* ------------------------------------------------------------------ */
    /* Helper role                                                          */
    /* ------------------------------------------------------------------ */

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isPetugas(): bool
    {
        return $this->role === self::ROLE_PETUGAS;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function isAdminOrPetugas(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_PETUGAS]);
    }
}
