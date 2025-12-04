<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $mahasiswa = User::where('role', 'mahasiswa')->get();
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function peminjaman(User $user)
    {
        $peminjaman = Peminjaman::with('barang')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.mahasiswa.peminjaman', compact('user', 'peminjaman'));
    }
}
