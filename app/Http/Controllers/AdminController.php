<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Akses ditolak. Hanya untuk administrator.');
        }

        try {
            $stats = [
                'total_barang' => Barang::count(),
                'total_mahasiswa' => User::where('role', 'mahasiswa')->count(),
                'peminjaman_pending' => Peminjaman::where('status', 'pending')->count(),
                'peminjaman_aktif' => Peminjaman::where('status', 'disetujui')->count(),
            ];

            $peminjaman_terbaru = Peminjaman::with(['user', 'barang'])
                ->latest()
                ->take(5)
                ->get();

        } catch (\Exception $e) {
            // Jika tabel peminjaman belum ada, gunakan nilai default
            $stats = [
                'total_barang' => Barang::count(),
                'total_mahasiswa' => User::where('role', 'mahasiswa')->count(),
                'peminjaman_pending' => 0,
                'peminjaman_aktif' => 0,
            ];

            $peminjaman_terbaru = collect([]);
        }

        return view('admin.dashboard', compact('stats', 'peminjaman_terbaru'));
    }
}