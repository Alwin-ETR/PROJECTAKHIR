<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'mahasiswa']);
    }

    public function index(Request $request)
    {
        $search = $request->get('search');

        $barang = Barang::where('status', '!=', 'perbaikan')
            ->when($search, function ($query) use ($search) {
                return $query->where('nama', 'like', "%$search%")
                    ->orWhere('kode_barang', 'like', "%$search%")
                    ->orWhere('deskripsi', 'like', "%$search%");
            })
            ->orderBy('nama')
            ->get();

        return view('mahasiswa.katalog', compact('barang'));
    }

    public function show($id)
    {
        $barang = Barang::findOrFail($id);

        if (request()->ajax()) {
            return view('mahasiswa.barang-detail', compact('barang'));
        }

        return redirect()->route('mahasiswa.katalog');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('search');

        $barang = Barang::where('status', '!=', 'perbaikan')
            ->where(function ($query) use ($keyword) {
                $query->where('nama', 'like', "%{$keyword}%")
                    ->orWhere('kode_barang', 'like', "%{$keyword}%")
                    ->orWhere('deskripsi', 'like', "%{$keyword}%");
            })
            ->orderBy('nama')
            ->get();

        $cartItems = session('cart_peminjaman', []);

        return view('mahasiswa.dashboard', compact('barang', 'cartItems'));
    }
}
