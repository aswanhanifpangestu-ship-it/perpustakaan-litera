<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    const STATUS_PENDING      = 'pending';
    const STATUS_DISETUJUI    = 'disetujui';
    const STATUS_DITOLAK      = 'ditolak';
    const STATUS_DIKEMBALIKAN = 'dikembalikan';

    const DENDA_BELUM_BAYAR = 'belum_bayar';
    const DENDA_SUDAH_BAYAR = 'sudah_bayar';

    const MAX_HARI_PINJAM = 30;

    protected $fillable = [
        'user_id',
        'buku_id',
        'petugas_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'jumlah_hari_terlambat',
        'total_denda',
        'status',
        'status_denda',
        'catatan',
        'alasan_tolak',
    ];

    protected $casts = [
        'tanggal_pinjam'       => 'date',
        'tanggal_kembali'      => 'date',
        'tanggal_dikembalikan' => 'date',
        'total_denda'          => 'decimal:2',
        'jumlah_hari_terlambat'=> 'integer',
    ];

    /* ------------------------------------------------------------------ */
    /* Relasi                                                               */
    /* ------------------------------------------------------------------ */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function ulasan()
    {
        return $this->hasOne(Ulasan::class);
    }

    /* ------------------------------------------------------------------ */
    /* Helper                                                               */
    /* ------------------------------------------------------------------ */

    /**
     * Hitung denda berdasarkan tanggal aktual dikembalikan.
     * Menggunakan denda_per_hari dari buku.
     */
    public function hitungDenda(Carbon $tanggalDikembalikan): array
    {
        $hariTerlambat = 0;
        $totalDenda    = 0;

        if ($tanggalDikembalikan->gt($this->tanggal_kembali)) {
            $hariTerlambat = $this->tanggal_kembali->diffInDays($tanggalDikembalikan);
            $dendaPerHari  = $this->buku->denda_per_hari ?? 1000;
            $totalDenda    = $hariTerlambat * $dendaPerHari;
        }

        return [
            'jumlah_hari_terlambat' => $hariTerlambat,
            'total_denda'           => $totalDenda,
        ];
    }

    /* ------------------------------------------------------------------ */
    /* Scopes                                                               */
    /* ------------------------------------------------------------------ */

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', self::STATUS_DISETUJUI);
    }

    public function scopeBelumBayar($query)
    {
        return $query->where('status_denda', self::DENDA_BELUM_BAYAR)
                     ->where('total_denda', '>', 0);
    }
}
