<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|max:255|unique:users,email',
            'telepon'               => 'nullable|string|max:15',
            'alamat'                => 'nullable|string|max:500',
            'password'              => 'required|string|min:8|confirmed',
        ], [
            'name.required'                  => 'Nama lengkap wajib diisi.',
            'name.max'                       => 'Nama maksimal 255 karakter.',
            'email.required'                 => 'Email wajib diisi.',
            'email.email'                    => 'Format email tidak valid.',
            'email.unique'                   => 'Email sudah terdaftar, gunakan email lain.',
            'telepon.max'                    => 'Nomor telepon maksimal 15 karakter.',
            'alamat.max'                     => 'Alamat maksimal 500 karakter.',
            'password.required'              => 'Password wajib diisi.',
            'password.min'                   => 'Password minimal 8 karakter.',
            'password.confirmed'             => 'Konfirmasi password tidak cocok.',
        ]);

        // Generate nomor anggota otomatis: ANG-XXXX
        $lastUser   = User::where('no_anggota', 'like', 'ANG-%')->orderByDesc('id')->first();
        $nextNumber = $lastUser
            ? (int) substr($lastUser->no_anggota, 4) + 1
            : 1;
        $noAnggota = 'ANG-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $user = User::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
            'telepon'    => $validated['telepon'] ?? null,
            'alamat'     => $validated['alamat'] ?? null,
            'role'       => User::ROLE_USER,
            'no_anggota' => $noAnggota,
            'is_active'  => true,
        ]);

        // Login otomatis setelah register
        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Selamat datang, ' . $user->name . '! Akun Anda berhasil dibuat. No. Anggota: ' . $noAnggota);
    }
}
