<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with(['kategori', 'ulasan']);

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        $buku     = $query->latest()->paginate(10)->withQueryString();
        $kategori = Kategori::orderBy('nama')->get();

        return view('buku.index', compact('buku', 'kategori'));
    }

    public function create()
    {
        $kategori = Kategori::orderBy('nama')->get();
        return view('buku.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'          => 'required|string|max:255',
            'pengarang'      => 'required|string|max:255',
            'penerbit'       => 'required|string|max:255',
            'tahun_terbit'   => 'required|integer|min:1900|max:' . date('Y'),
            'isbn'           => 'required|string|max:20|unique:buku,isbn',
            'kategori_id'    => 'required|exists:kategori,id',
            'stok'           => 'required|integer|min:1',
            'deskripsi'      => 'nullable|string|max:2000',
            'lokasi_rak'     => 'nullable|string|max:50',
            'denda_per_hari' => 'required|numeric|min:0',
            'sampul_buku'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'judul.required'          => 'Judul buku wajib diisi.',
            'judul.max'               => 'Judul buku maksimal 255 karakter.',
            'pengarang.required'      => 'Nama pengarang wajib diisi.',
            'penerbit.required'       => 'Nama penerbit wajib diisi.',
            'tahun_terbit.required'   => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer'    => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.min'        => 'Tahun terbit tidak boleh sebelum tahun 1900.',
            'tahun_terbit.max'        => 'Tahun terbit tidak boleh melebihi tahun ' . date('Y') . '.',
            'isbn.required'           => 'ISBN wajib diisi.',
            'isbn.unique'             => 'ISBN sudah terdaftar, gunakan ISBN yang berbeda.',
            'isbn.max'                => 'ISBN maksimal 20 karakter.',
            'kategori_id.required'    => 'Kategori wajib dipilih.',
            'kategori_id.exists'      => 'Kategori yang dipilih tidak valid.',
            'stok.required'           => 'Jumlah stok wajib diisi.',
            'stok.integer'            => 'Stok harus berupa angka bulat.',
            'stok.min'                => 'Stok minimal 1 buku.',
            'denda_per_hari.required' => 'Denda per hari wajib diisi.',
            'denda_per_hari.numeric'  => 'Denda per hari harus berupa angka.',
            'denda_per_hari.min'      => 'Denda per hari tidak boleh negatif.',
            'sampul_buku.image'       => 'File sampul harus berupa gambar.',
            'sampul_buku.mimes'       => 'Hanya file JPG, PNG, WEBP yang diperbolehkan.',
            'sampul_buku.max'         => 'Ukuran file maksimal 2MB.',
        ]);

        $validated['stok_tersedia'] = $validated['stok'];

        if ($request->hasFile('sampul_buku')) {
            $validated['sampul_buku'] = $request->file('sampul_buku')
                ->store('sampul_buku', 'public');
        }

        Buku::create($validated);

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Buku $buku)
    {
        $buku->load(['kategori', 'peminjaman.user', 'ulasan.user']);
        return view('buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        $kategori = Kategori::orderBy('nama')->get();
        return view('buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'judul'          => 'required|string|max:255',
            'pengarang'      => 'required|string|max:255',
            'penerbit'       => 'required|string|max:255',
            'tahun_terbit'   => 'required|integer|min:1900|max:' . date('Y'),
            'isbn'           => 'required|string|max:20|unique:buku,isbn,' . $buku->id,
            'kategori_id'    => 'required|exists:kategori,id',
            'stok'           => 'required|integer|min:1',
            'deskripsi'      => 'nullable|string|max:2000',
            'lokasi_rak'     => 'nullable|string|max:50',
            'denda_per_hari' => 'required|numeric|min:0',
            'sampul_buku'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'judul.required'          => 'Judul buku wajib diisi.',
            'pengarang.required'      => 'Nama pengarang wajib diisi.',
            'penerbit.required'       => 'Nama penerbit wajib diisi.',
            'tahun_terbit.required'   => 'Tahun terbit wajib diisi.',
            'tahun_terbit.min'        => 'Tahun terbit tidak boleh sebelum tahun 1900.',
            'tahun_terbit.max'        => 'Tahun terbit tidak boleh melebihi tahun ' . date('Y') . '.',
            'isbn.required'           => 'ISBN wajib diisi.',
            'isbn.unique'             => 'ISBN sudah terdaftar, gunakan ISBN yang berbeda.',
            'kategori_id.required'    => 'Kategori wajib dipilih.',
            'stok.required'           => 'Jumlah stok wajib diisi.',
            'stok.min'                => 'Stok minimal 1 buku.',
            'denda_per_hari.required' => 'Denda per hari wajib diisi.',
            'denda_per_hari.min'      => 'Denda per hari tidak boleh negatif.',
            'sampul_buku.image'       => 'File sampul harus berupa gambar.',
            'sampul_buku.mimes'       => 'Hanya file JPG, PNG, WEBP yang diperbolehkan.',
            'sampul_buku.max'         => 'Ukuran file maksimal 2MB.',
        ]);

        // Sesuaikan stok_tersedia relatif terhadap perubahan stok
        $selisih = $validated['stok'] - $buku->stok;
        $validated['stok_tersedia'] = max(0, $buku->stok_tersedia + $selisih);

        if ($request->hasFile('sampul_buku')) {
            if ($buku->sampul_buku) {
                Storage::disk('public')->delete($buku->sampul_buku);
            }
            $validated['sampul_buku'] = $request->file('sampul_buku')
                ->store('sampul_buku', 'public');
        }

        if ($request->boolean('hapus_sampul') && $buku->sampul_buku) {
            Storage::disk('public')->delete($buku->sampul_buku);
            $validated['sampul_buku'] = null;
        }

        $buku->update($validated);

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        $dipinjam = $buku->peminjaman()
            ->whereIn('status', ['pending', 'disetujui'])
            ->count();

        if ($dipinjam > 0) {
            return back()->with('error', 'Buku tidak dapat dihapus karena sedang dipinjam atau ada pengajuan aktif.');
        }

        if ($buku->sampul_buku) {
            Storage::disk('public')->delete($buku->sampul_buku);
        }

        $buku->delete();

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}
