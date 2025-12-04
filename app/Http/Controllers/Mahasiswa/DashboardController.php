<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'mahasiswa']);
    }

    public function index()
    {
        $user = Auth::user();

        $totalPeminjaman = Peminjaman::where('user_id', $user->id)->count();
        $peminjamanAktifCount = Peminjaman::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->count();
        $peminjamanSelesai = Peminjaman::where('user_id', $user->id)
            ->where('status', 'dikembalikan')
            ->count();

        $peminjamanAktif = Peminjaman::with('barang')
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->whereNull('tanggal_pengembalian')
            ->get()
            ->map(function ($pinjam) {
                $today   = now()->startOfDay();
                $dueDate = $pinjam->tanggal_kembali->startOfDay();
                $pinjam->sisa_hari = $today->diffInDays($dueDate, false);
                return $pinjam;
            });

        $barangPopuler = collect(); 

        return view('mahasiswa.dashboard', [
            'user'                 => $user,
            'totalPeminjaman'      => $totalPeminjaman,
            'peminjamanAktifCount' => $peminjamanAktifCount,
            'peminjamanSelesai'    => $peminjamanSelesai,
            'barangPopuler'        => $barangPopuler,
            'peminjamanAktif'      => $peminjamanAktif,
        ]);
    }
}
