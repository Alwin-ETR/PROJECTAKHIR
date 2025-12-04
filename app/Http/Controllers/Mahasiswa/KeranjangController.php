<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'mahasiswa']);
    }

    public function add(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        if (! $barang->canBeBorrowed()) {
            return back()->with('error',
                'Barang tidak dapat dipinjam. Stok tersedia: ' . $barang->stok_tersedia
            );
        }

        $cart = session()->get('cart_peminjaman', []);

        if (isset($cart[$id])) {
            $totalAkanDipinjam = $cart[$id]['quantity'] + 1;
            if ($totalAkanDipinjam > $barang->stok_tersedia) {
                return back()->with('error',
                    'Jumlah melebihi stok tersedia. Stok tersedia: ' . $barang->stok_tersedia
                );
            }
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id"           => $barang->id,
                "nama"         => $barang->nama,
                "kode_barang"  => $barang->kode_barang,
                "quantity"     => 1,
                "max_stok"     => $barang->stok_tersedia,
                "gambar"       => $barang->gambar,
                "status_badge" => $barang->status_badge,
                "status_text"  => $barang->status_text,
            ];
        }

        session()->put('cart_peminjaman', $cart);

        return back()->with('success', $barang->nama . ' ditambahkan ke keranjang.');
    }

    public function update(Request $request, $id)
    {
        $quantity = $request->input('quantity', 1);
        $barang   = Barang::findOrFail($id);

        if ($quantity < 1 || $quantity > $barang->stok_tersedia) {
            $msg = 'Jumlah tidak valid. Stok tersedia: ' . $barang->stok_tersedia;

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }

            return back()->with('error', $msg);
    }

        $cart = session()->get('cart_peminjaman', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            $cart[$id]['max_stok'] = $barang->stok_tersedia;
            session()->put('cart_peminjaman', $cart);

            if ($request->ajax()) {
                return response()->json([
                    'success'  => true,
                    'message'  => 'Jumlah berhasil diupdate',
                    'max_stok' => $barang->stok_tersedia,
                ]);
            }

            return back()->with('success', 'Jumlah berhasil diupdate');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan di keranjang',
            ], 404);
        }

        return back()->with('error', 'Item tidak ditemukan di keranjang');
    }

    public function remove($id)
    {
        $cart = session()->get('cart_peminjaman', []);

        if (isset($cart[$id])) {
            $barangName = $cart[$id]['nama'];
            unset($cart[$id]);
            session()->put('cart_peminjaman', $cart);
            return back()->with('success', $barangName . ' dihapus dari keranjang');
        }

        return back()->with('error', 'Item tidak ditemukan di keranjang');
    }

    public function clear()
    {
        session()->forget('cart_peminjaman');
        return back()->with('success', 'Keranjang peminjaman dikosongkan');
    }
}
