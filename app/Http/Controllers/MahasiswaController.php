<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check() || Auth::user()->role !== 'mahasiswa') {
            return redirect('/')->with('error', 'Akses ditolak. Hanya untuk mahasiswa.');
        }

        $user = Auth::user();
        
        try {
            $peminjaman_terbaru = $user->peminjamans()
                ->with('barang')
                ->latest()
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            $peminjaman_terbaru = collect([]);
        }

        try {
            $barang_populer = Barang::withCount('peminjamans')
                ->orderBy('peminjamans_count', 'desc')
                ->take(6)
                ->get();
        } catch (\Exception $e) {
            $barang_populer = Barang::take(6)->get();
        }

        return view('mahasiswa.dashboard', compact('peminjaman_terbaru', 'barang_populer'));
    }
}