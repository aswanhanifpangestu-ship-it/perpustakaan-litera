<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Buku extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'buku';

    protected $fillable = [
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'kategori_id',
        'stok',
        'stok_tersedia',
        'deskripsi',
        'sampul_buku',
        'lokasi_rak',
        'denda_per_hari',
    ];

    protected $casts = [
        'tahun_terbit'   => 'integer',
        'stok'           => 'integer',
        'stok_tersedia'  => 'integer',
        'denda_per_hari' => 'decimal:2',
    ];

    /* ------------------------------------------------------------------ */
    /* Relasi                                                               */
    /* ------------------------------------------------------------------ */

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class);
    }

    public function ratingRata(): float
    {
        return round($this->ulasan()->avg('rating') ?? 0, 1);
    }

    /* ------------------------------------------------------------------ */
    /* Scope & helper                                                       */
    /* ------------------------------------------------------------------ */

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('judul', 'like', "%{$keyword}%")
              ->orWhere('pengarang', 'like', "%{$keyword}%")
              ->orWhere('isbn', 'like', "%{$keyword}%");
        });
    }

    public function tersedia(): bool
    {
        return $this->stok_tersedia > 0;
    }

    /**
     * URL sampul buku. Kembalikan URL gambar atau null jika tidak ada.
     */
    public function sampulUrl(): ?string
    {
        if ($this->sampul_buku && Storage::disk('public')->exists($this->sampul_buku)) {
            return Storage::disk('public')->url($this->sampul_buku);
        }
        return null;
    }
}
