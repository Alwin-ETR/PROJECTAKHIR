<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\User;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $stats = [
            'total_barang'       => Barang::count(),
            'total_mahasiswa'    => User::where('role', 'mahasiswa')->count(),
            'peminjaman_pending' => Peminjaman::where('status', 'pending')->count(),
            'peminjaman_aktif'   => Peminjaman::where('status', 'disetujui')->count(),
        ];

        $peminjaman_terbaru = Peminjaman::with(['user', 'barang'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'peminjaman_terbaru'));
    }
}
