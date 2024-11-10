<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function index()
    {
        return view('login');
    }

    // Mengautentikasi pengguna
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.login')
                ->withInput()
                ->withErrors($validator);
        }

        \Log::info('Login attempt', ['email' => $request->email]);

        // Cek apakah pengguna ada di database
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                \Log::info('Password match for user', ['email' => $user->email]);
                // Jika password cocok, login berhasil
                Auth::login($user);

                // Cek role pengguna
                if ($user->role === 'admin') {
                    return redirect()->route('dashboard.owner'); // Redirect ke dashboard owner
                } else if ($user->role === 'pelanggan') {
                    return redirect()->route('login.dashboard'); // Redirect ke dashboard pelanggan
                }

                // Default redirect jika role tidak dikenali
                return redirect()->route('login.dashboard');
            } else {
                \Log::warning('Password mismatch for user', ['email' => $user->email]);
                return redirect()->back()->withErrors(['login_error' => 'Email atau password salah']);
            }
        } else {
            \Log::warning('User not found', ['email' => $request->email]);
            return redirect()->back()->withErrors(['login_error' => 'Email atau password salah']);
        }
    }


    // Menampilkan halaman register
    public function register()
    {
        return view('login'); // Pastikan rute tampilan ini sesuai dengan rute view untuk halaman registrasi
    }

    // Proses registrasi
    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.register')
                ->withInput()
                ->withErrors($validator);
        }

        // Jika validasi berhasil, simpan pengguna baru
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password); // Hash password
        $user->role = 'Pelanggan'; // Sesuaikan dengan peran default Anda
        $user->save();

        \Log::info('User registered successfully', ['email' => $user->email]);

        return redirect()->route('account.login')->with('sukses', 'Anda telah berhasil mendaftar. Silakan login.');
    }
}
