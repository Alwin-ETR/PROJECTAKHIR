<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('mahasiswa.dashboard');
        }
        
        return view('auth.login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('mahasiswa.dashboard');
        }
        
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()
                ->withErrors([
                    'email' => 'Email tidak terdaftar. Silakan daftar terlebih dahulu.',
                ])
                ->withInput()
                ->with('show_register', true);
        }

        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors([
                    'password' => 'Password salah. Silakan coba lagi.',
                ])
                ->withInput();
        }

        $request->session()->regenerate();
        
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->route('mahasiswa.dashboard');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'nim' => 'required|string|unique:users|size:12|regex:/^[0-9]+$/',
            'phone' => 'required|string|min:11|max:12',
            'password' => 'required|min:8|confirmed',
        ], [
            'nim.unique' => 'NIM sudah terdaftar. Gunakan NIM yang berbeda.',
            'nim.size' => 'NIM harus terdiri dari 12 digit.',
            'nim.regex' => 'NIM hanya boleh mengandung angka.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'phone.min' => 'Nomor HP minimal 11 digit.',
            'phone.max' => 'Nomor HP maksimal 12 digit.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nim' => $validated['nim'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'mahasiswa',
        ]);

        Auth::login($user);

        return redirect()->route('mahasiswa.dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang di sistem peminjaman inventaris.');
    }

    public function forgotPassword()
    {
        return view('auth.lupa-password');
    }

    public function resetPassword($token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => request()->email // dari query string
        ]);
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => 'Link reset password telah dikirim ke email Anda. Cek inbox atau folder spam.'])
            : back()->withErrors(['email' => __($status)]);
    }

    // public function resetPassword($token)
    // {
    //     return view('auth.reset-password', ['request' => (object) ['token' => $token]]);
    // }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password berhasil direset! Silakan login dengan password baru Anda.')
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}