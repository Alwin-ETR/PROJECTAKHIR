<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'mahasiswa']);
    }

    public function index()
    {
        $user = Auth::user();

        $totalPeminjaman = Peminjaman::where('user_id', $user->id)->count();
        $peminjamanAktif = Peminjaman::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->count();
        $peminjamanSelesai = Peminjaman::where('user_id', $user->id)
            ->where('status', 'dikembalikan')
            ->count();

        return view('mahasiswa.profile', compact(
            'user',
            'totalPeminjaman',
            'peminjamanAktif',
            'peminjamanSelesai'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:15',
        ]);

        Auth::user()->update($request->only('email', 'phone'));

        return redirect()->route('mahasiswa.profile')
            ->with('success', 'Data pribadi berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('mahasiswa.profile')
            ->with('success', 'Password berhasil diperbarui!');
    }
}
