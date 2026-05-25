<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ──────────────────────────────────────────────────────────
        $admin = User::create([
            'name'      => 'Administrator',
            'email'     => 'admin@perpustakaan.com',
            'password'  => Hash::make('@nunai12345'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        $petugas = User::create([
            'name'      => 'Petugas Satu',
            'email'     => 'petugas@perpustakaan.com',
            'password'  => Hash::make('@nunai12345'),
            'role'      => 'petugas',
            'is_active' => true,
        ]);

        $budi = User::create([
            'name'       => 'Budi Santoso',
            'email'      => 'budi@example.com',
            'password'   => Hash::make('@nunai12345'),
            'role'       => 'user',
            'no_anggota' => 'ANG-001',
            'telepon'    => '081234567890',
            'is_active'  => true,
        ]);

        $siti = User::create([
            'name'       => 'Siti Rahayu',
            'email'      => 'siti@example.com',
            'password'   => Hash::make('@nunai12345'),
            'role'       => 'user',
            'no_anggota' => 'ANG-002',
            'telepon'    => '089876543210',
            'is_active'  => true,
        ]);

        // ── Kategori ───────────────────────────────────────────────────────
        $kategoriList = [
            ['nama' => 'Fiksi',             'deskripsi' => 'Novel dan cerita fiksi'],
            ['nama' => 'Non-Fiksi',         'deskripsi' => 'Buku berdasarkan fakta'],
            ['nama' => 'Sains & Teknologi', 'deskripsi' => 'Ilmu pengetahuan dan teknologi'],
            ['nama' => 'Sejarah',           'deskripsi' => 'Buku sejarah dan biografi'],
            ['nama' => 'Pendidikan',        'deskripsi' => 'Buku pelajaran dan referensi'],
            ['nama' => 'Agama',             'deskripsi' => 'Buku keagamaan'],
        ];

        foreach ($kategoriList as $k) {
            Kategori::create($k);
        }

        // ── Buku ───────────────────────────────────────────────────────────
        $bukuList = [
            [
                'judul'          => 'Laskar Pelangi',
                'pengarang'      => 'Andrea Hirata',
                'penerbit'       => 'Bentang Pustaka',
                'tahun_terbit'   => 2005,
                'isbn'           => '978-979-1227-00-1',
                'kategori_id'    => 1,
                'stok'           => 5,
                'stok_tersedia'  => 4,
                'lokasi_rak'     => 'A-01',
                'denda_per_hari' => 1000,
            ],
            [
                'judul'          => 'Bumi Manusia',
                'pengarang'      => 'Pramoedya Ananta Toer',
                'penerbit'       => 'Lentera Dipantara',
                'tahun_terbit'   => 1980,
                'isbn'           => '978-979-97312-3-4',
                'kategori_id'    => 1,
                'stok'           => 3,
                'stok_tersedia'  => 3,
                'lokasi_rak'     => 'A-02',
                'denda_per_hari' => 1000,
            ],
            [
                'judul'          => 'Sapiens: Riwayat Singkat Umat Manusia',
                'pengarang'      => 'Yuval Noah Harari',
                'penerbit'       => 'KPG',
                'tahun_terbit'   => 2017,
                'isbn'           => '978-602-424-694-5',
                'kategori_id'    => 4,
                'stok'           => 4,
                'stok_tersedia'  => 4,
                'lokasi_rak'     => 'B-01',
                'denda_per_hari' => 2000,
            ],
            [
                'judul'          => 'Pemrograman Web dengan Laravel',
                'pengarang'      => 'Ridwan Sanjaya',
                'penerbit'       => 'Elex Media',
                'tahun_terbit'   => 2022,
                'isbn'           => '978-623-00-1234-5',
                'kategori_id'    => 3,
                'stok'           => 6,
                'stok_tersedia'  => 6,
                'lokasi_rak'     => 'C-01',
                'denda_per_hari' => 1500,
            ],
            [
                'judul'          => 'Matematika Dasar',
                'pengarang'      => 'Prof. Dr. Suyono',
                'penerbit'       => 'Erlangga',
                'tahun_terbit'   => 2020,
                'isbn'           => '978-602-298-765-4',
                'kategori_id'    => 5,
                'stok'           => 10,
                'stok_tersedia'  => 10,
                'lokasi_rak'     => 'D-01',
                'denda_per_hari' => 500,
            ],
        ];

        foreach ($bukuList as $b) {
            Buku::create($b);
        }

        // ── Peminjaman Contoh ──────────────────────────────────────────────

        // 1. Peminjaman aktif (disetujui) — Budi meminjam Laskar Pelangi
        Peminjaman::create([
            'user_id'        => $budi->id,
            'buku_id'        => 1,
            'petugas_id'     => $petugas->id,
            'tanggal_pinjam' => Carbon::today()->subDays(5),
            'tanggal_kembali'=> Carbon::today()->addDays(9),
            'status'         => Peminjaman::STATUS_DISETUJUI,
            'status_denda'   => Peminjaman::DENDA_BELUM_BAYAR,
        ]);

        // 2. Pengajuan pending — Siti mengajukan
        Peminjaman::create([
            'user_id'        => $siti->id,
            'buku_id'        => 3,
            'tanggal_pinjam' => Carbon::today(),
            'tanggal_kembali'=> Carbon::today()->addDays(14),
            'status'         => Peminjaman::STATUS_PENDING,
            'status_denda'   => Peminjaman::DENDA_BELUM_BAYAR,
            'catatan'        => 'Untuk keperluan tugas akhir.',
        ]);

        // 3. Dikembalikan terlambat — denda belum bayar
        Peminjaman::create([
            'user_id'               => $budi->id,
            'buku_id'               => 2,
            'petugas_id'            => $petugas->id,
            'tanggal_pinjam'        => Carbon::today()->subDays(20),
            'tanggal_kembali'       => Carbon::today()->subDays(10),
            'tanggal_dikembalikan'  => Carbon::today()->subDays(5),
            'jumlah_hari_terlambat' => 5,
            'total_denda'           => 5000,
            'status'                => Peminjaman::STATUS_DIKEMBALIKAN,
            'status_denda'          => Peminjaman::DENDA_BELUM_BAYAR,
        ]);

        // 4. Dikembalikan tepat waktu — lunas
        Peminjaman::create([
            'user_id'               => $siti->id,
            'buku_id'               => 4,
            'petugas_id'            => $admin->id,
            'tanggal_pinjam'        => Carbon::today()->subDays(15),
            'tanggal_kembali'       => Carbon::today()->subDays(1),
            'tanggal_dikembalikan'  => Carbon::today()->subDays(2),
            'jumlah_hari_terlambat' => 0,
            'total_denda'           => 0,
            'status'                => Peminjaman::STATUS_DIKEMBALIKAN,
            'status_denda'          => Peminjaman::DENDA_SUDAH_BAYAR,
        ]);
    }
}
