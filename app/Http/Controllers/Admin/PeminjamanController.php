<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $peminjaman = Peminjaman::with('user', 'barang')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function approve(Peminjaman $peminjaman)
    {
        $peminjaman->update(['status' => 'disetujui']);
        return redirect()->back()->with('success', 'Peminjaman disetujui');
    }

    public function reject(Peminjaman $peminjaman)
    {
        $peminjaman->update(['status' => 'ditolak']);
        return redirect()->back()->with('success', 'Peminjaman ditolak');
    }

    public function complete(Peminjaman $peminjaman)
    {
        $peminjaman->update(['status' => 'dikembalikan']);
        return redirect()->back()->with('success', 'Peminjaman selesai');
    }

    public function verifikasi_kembali($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu_verifikasi') {
            return redirect()->back()->with('error', 
                'Peminjaman tidak dalam status menunggu verifikasi.');
        }

        // Admin verifikasi → status jadi "dikembalikan"
        $peminjaman->status = 'dikembalikan';
        $peminjaman->tanggal_pengembalian = now()->toDateString();
        $peminjaman->save();

        return redirect()->back()->with('success', 
            'Pengembalian barang berhasil diverifikasi.');
    }

}
