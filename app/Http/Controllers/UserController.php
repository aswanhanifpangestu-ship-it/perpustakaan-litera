<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /** Apakah user yang login adalah petugas (bukan admin) */
    private function isPetugas(): bool
    {
        return Auth::user()->role === 'petugas';
    }

    public function index(Request $request)
    {
        $isPetugas = $this->isPetugas();

        // Petugas langsung ke tab anggota, tidak bisa lihat tab petugas
        $tab = $isPetugas ? 'anggota' : $request->get('tab', 'petugas');

        // Query Petugas (admin + petugas) — hanya untuk admin
        $petugas = collect();
        if (!$isPetugas) {
            $petugasQuery = User::whereIn('role', ['admin', 'petugas']);
            if ($request->filled('search_petugas')) {
                $s = $request->search_petugas;
                $petugasQuery->where(function ($q) use ($s) {
                    $q->where('name', 'like', '%' . $s . '%')
                      ->orWhere('email', 'like', '%' . $s . '%');
                });
            }
            $petugas = $petugasQuery->latest()->paginate(10, ['*'], 'petugas_page')->withQueryString();
        }

        // Query Anggota (user) — admin & petugas
        $anggotaQuery = User::where('role', 'user');
        if ($request->filled('search_anggota')) {
            $s = $request->search_anggota;
            $anggotaQuery->where(function ($q) use ($s) {
                $q->where('name', 'like', '%' . $s . '%')
                  ->orWhere('email', 'like', '%' . $s . '%')
                  ->orWhere('no_anggota', 'like', '%' . $s . '%');
            });
        }
        $anggota = $anggotaQuery->latest()->paginate(10, ['*'], 'anggota_page')->withQueryString();

        return view('users.index', compact('petugas', 'anggota', 'tab', 'isPetugas'));
    }

    public function create()
    {
        return view('users.create', ['isPetugas' => $this->isPetugas()]);
    }

    public function store(Request $request)
    {
        $isPetugas = $this->isPetugas();

        // Petugas hanya boleh membuat akun role 'user'
        $allowedRoles = $isPetugas ? 'in:user' : 'in:admin,petugas,user';

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6|confirmed',
            'role'       => ['required', $allowedRoles],
            'no_anggota' => 'nullable|string|max:20|unique:users,no_anggota',
            'alamat'     => 'nullable|string',
            'telepon'    => 'nullable|string|max:15',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required'      => 'Role wajib dipilih.',
            'role.in'            => 'Role tidak valid.',
        ]);

        $validated['password']  = Hash::make($validated['password']);
        $validated['is_active'] = true;

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        $user = User::create($validated);

        // Notifikasi ke admin jika petugas baru ditambahkan
        if (in_array($user->role, ['admin', 'petugas'])) {
            NotificationService::petugasBaru($user);
        }

        $tab = in_array($user->role, ['admin', 'petugas']) ? 'petugas' : 'anggota';

        return redirect()->route('users.index', ['tab' => $tab])
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        // Petugas hanya boleh lihat detail anggota
        if ($this->isPetugas() && $user->role !== 'user') {
            abort(403);
        }

        $user->load('peminjaman.buku');
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        // Petugas hanya boleh edit anggota
        if ($this->isPetugas() && $user->role !== 'user') {
            abort(403);
        }

        return view('users.edit', ['user' => $user, 'isPetugas' => $this->isPetugas()]);
    }

    public function update(Request $request, User $user)
    {
        $isPetugas = $this->isPetugas();

        // Petugas hanya boleh update anggota
        if ($isPetugas && $user->role !== 'user') {
            abort(403);
        }

        $allowedRoles = $isPetugas ? 'in:user' : 'in:admin,petugas,user';

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'password'   => 'nullable|min:6|confirmed',
            'role'       => ['required', $allowedRoles],
            'no_anggota' => 'nullable|string|max:20|unique:users,no_anggota,' . $user->id,
            'alamat'     => 'nullable|string',
            'telepon'    => 'nullable|string|max:15',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $validated['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        $user->update($validated);

        $tab = in_array($user->role, ['admin', 'petugas']) ? 'petugas' : 'anggota';

        return redirect()->route('users.index', ['tab' => $tab])
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Petugas hanya boleh hapus anggota
        if ($this->isPetugas() && $user->role !== 'user') {
            abort(403);
        }

        if ($user->peminjaman()->where('status', 'dipinjam')->count() > 0) {
            return back()->with('error', 'Pengguna tidak dapat dihapus karena masih memiliki peminjaman aktif.');
        }

        $tab = in_array($user->role, ['admin', 'petugas']) ? 'petugas' : 'anggota';

        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->delete();

        return redirect()->route('users.index', ['tab' => $tab])
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
