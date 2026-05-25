<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'type',
        'target_role',
        'actor_id',
        'judul',
        'pesan',
        'url',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /* ------------------------------------------------------------------ */
    /* Relasi                                                               */
    /* ------------------------------------------------------------------ */

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    /* ------------------------------------------------------------------ */
    /* Scope                                                                */
    /* ------------------------------------------------------------------ */

    /** Notifikasi yang relevan untuk role tertentu */
    public function scopeForRole($query, string $role)
    {
        return $query->where(function ($q) use ($role) {
            $q->where('target_role', $role)
              ->orWhere('target_role', 'like', "%{$role}%");
        });
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /* ------------------------------------------------------------------ */
    /* Helper                                                               */
    /* ------------------------------------------------------------------ */

    public function icon(): string
    {
        return match ($this->type) {
            'petugas_baru'    => 'bi-person-badge-fill',
            'user_login'      => 'bi-box-arrow-in-right',
            'peminjaman_baru' => 'bi-book-fill',
            default           => 'bi-bell-fill',
        };
    }

    public function iconColor(): string
    {
        return match ($this->type) {
            'petugas_baru'    => 'text-warning',
            'user_login'      => 'text-success',
            'peminjaman_baru' => 'text-primary',
            default           => 'text-secondary',
        };
    }

    public function iconBg(): string
    {
        return match ($this->type) {
            'petugas_baru'    => 'bg-warning bg-opacity-15',
            'user_login'      => 'bg-success bg-opacity-15',
            'peminjaman_baru' => 'bg-primary bg-opacity-15',
            default           => 'bg-secondary bg-opacity-15',
        };
    }
}
