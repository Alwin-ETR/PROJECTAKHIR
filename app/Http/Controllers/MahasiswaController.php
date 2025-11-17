<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class MahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('mahasiswa');
    }

    public function dashboard()
    {
        // Cookies untuk barang terakhir dilihat
        $lastViewed = json_decode(request()->cookie('last_viewed_barang', '[]'), true);
        
        // Session untuk keranjang peminjaman
        $cartItems = session('cart_peminjaman', []);
        
        // Barang tersedia - PAKAI METHOD HELPER
        $barang = Barang::tersedia()->get();

        // DEBUG: Cek data barang
        Log::info("=== DASHBOARD MAHASISWA DEBUG ===");
        foreach($barang as $item) {
            Log::info("Barang: " . $item->nama . " | Stok: " . $item->stok . " | Status: " . $item->status . " | Can Borrow: " . ($item->canBeBorrowed() ? 'YES' : 'NO'));
        }

        // Data mahasiswa
        $user = Auth::user();
        
        return view('mahasiswa.dashboard', compact('barang', 'lastViewed', 'cartItems', 'user'));
    }

    public function showBarang($id)
    {
        $barang = Barang::findOrFail($id);
        
        // Update cookies untuk last viewed
        $lastViewed = json_decode(request()->cookie('last_viewed_barang', '[]'), true);
        array_unshift($lastViewed, $id);
        $lastViewed = array_slice(array_unique($lastViewed), 0, 5);
        
        $response = response()->view('mahasiswa.barang-detail', compact('barang'));
        return $response->cookie('last_viewed_barang', json_encode($lastViewed), 60*24*7)
                       ->with('success', 'Detail barang berhasil dilihat');
    }

    public function addToCart(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        
        // VALIDASI STOK FISIK, BUKAN stok_tersedia
        if (!$barang->canBeBorrowed()) {
            return redirect()->back()->with('error', 'Barang tidak dapat dipinjam saat ini');
        }
        
        $cart = session()->get('cart_peminjaman', []);
        
        if (isset($cart[$id])) {
            // Cek apakah melebihi stok FISIK
            if (($cart[$id]['quantity'] + 1) > $barang->stok) {
                return redirect()->back()->with('error', 'Jumlah melebihi stok tersedia. Stok: ' . $barang->stok);
            }
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id" => $barang->id,
                "nama" => $barang->nama,
                "kode_barang" => $barang->kode_barang,
                "quantity" => 1,
                "max_stok" => $barang->stok, // PAKAI stok FISIK
                "gambar" => $barang->gambar,
                "status_badge" => $barang->status_badge,
                "status_text" => $barang->status_text
            ];
        }
        
        session()->put('cart_peminjaman', $cart);
        return redirect()->back()->with('success', $barang->nama . ' ditambahkan ke keranjang peminjaman');
    }

    public function updateCart(Request $request, $id)
    {
        $quantity = $request->input('quantity', 1);
        $barang = Barang::findOrFail($id);
        
        // Gunakan stok FISIK
        if ($quantity < 1 || $quantity > $barang->stok) {
            return redirect()->back()->with('error', 'Jumlah tidak valid. Stok tersedia: ' . $barang->stok);
        }
        
        $cart = session()->get('cart_peminjaman', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart_peminjaman', $cart);
            return redirect()->back()->with('success', 'Jumlah berhasil diupdate');
        }
        
        return redirect()->back();
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart_peminjaman', []);
        
        if (isset($cart[$id])) {
            $barangName = $cart[$id]['nama'];
            unset($cart[$id]);
            session()->put('cart_peminjaman', $cart);
            return redirect()->back()->with('success', $barangName . ' dihapus dari keranjang');
        }
        
        return redirect()->back();
    }

    public function clearCart()
    {
        session()->forget('cart_peminjaman');
        return redirect()->route('mahasiswa.dashboard')->with('success', 'Keranjang peminjaman dikosongkan');
    }

    public function showPengajuanForm()
    {
        $cartItems = session('cart_peminjaman', []);
        
        if (empty($cartItems)) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Keranjang peminjaman kosong');
        }
        
        // Validasi stok untuk setiap item di cart - PAKAI STOK FISIK
        foreach ($cartItems as $barangId => $item) {
            $barang = Barang::find($barangId);
            if (!$barang || !$barang->canBeBorrowed() || $item['quantity'] > $barang->stok) {
                return redirect()->route('mahasiswa.dashboard')->with('error', 'Stok ' . $item['nama'] . ' tidak mencukupi. Stok tersedia: ' . ($barang->stok ?? 0));
            }
        }
        
        return view('mahasiswa.pengajuan-form', compact('cartItems'));
    }

    public function submitPeminjaman(Request $request)
    {
        $request->validate([
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'alasan' => 'required|string|min:10|max:500'
        ]);

        $cartItems = session('cart_peminjaman', []);
        
        if (empty($cartItems)) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Keranjang peminjaman kosong');
        }
        
        try {
            // Validasi konflik tanggal dengan peminjaman lain
            foreach ($cartItems as $barangId => $item) {
                $barang = Barang::find($barangId);
                
                // VALIDASI STOK FISIK
                if (!$barang || $item['quantity'] > $barang->stok) {
                    return redirect()->back()->with('error', 'Stok ' . ($barang->nama ?? 'barang') . ' tidak mencukupi. Stok tersedia: ' . ($barang->stok ?? 0));
                }
                
                // Cek apakah ada peminjaman aktif di tanggal yang sama
                $konflikPeminjaman = Peminjaman::where('barang_id', $barangId)
                    ->whereIn('status', ['disetujui', 'pending'])
                    ->where(function($query) use ($request) {
                        $query->whereBetween('tanggal_pinjam', [$request->tanggal_pinjam, $request->tanggal_kembali])
                            ->orWhereBetween('tanggal_kembali', [$request->tanggal_pinjam, $request->tanggal_kembali])
                            ->orWhere(function($q) use ($request) {
                                $q->where('tanggal_pinjam', '<=', $request->tanggal_pinjam)
                                    ->where('tanggal_kembali', '>=', $request->tanggal_kembali);
                            });
                    })
                    ->exists();
                    
                if ($konflikPeminjaman) {
                    return redirect()->back()->with('error', 'Barang ' . $item['nama'] . ' sudah dipinjam di tanggal yang dipilih. Silakan pilih tanggal lain.');
                }
            }
            
            // Create semua peminjaman
            foreach ($cartItems as $barangId => $item) {
                $barang = Barang::find($barangId);
                
                if ($barang && $barang->canBeBorrowed() && $item['quantity'] <= $barang->stok) {
                    Peminjaman::create([
                        'user_id' => Auth::id(),
                        'barang_id' => $barangId,
                        'jumlah' => $item['quantity'],
                        'tanggal_pinjam' => $request->tanggal_pinjam,
                        'tanggal_kembali' => $request->tanggal_kembali,
                        'alasan' => $request->alasan,
                        'status' => 'pending'
                    ]);
                }
            }
            
            // Clear session
            session()->forget('cart_peminjaman');
            
            return redirect()->route('mahasiswa.riwayat')->with('success', 'Pengajuan peminjaman berhasil dikirim. Menunggu persetujuan admin.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function riwayat()
    {
        $peminjaman = Peminjaman::with('barang')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('mahasiswa.riwayat', compact('peminjaman'));
    }

    public function profile()
    {
        $user = Auth::user();
        $totalPeminjaman = Peminjaman::where('user_id', $user->id)->count();
        $peminjamanAktif = Peminjaman::where('user_id', $user->id)
                                    ->whereIn('status', ['pending', 'disetujui'])
                                    ->count();
        
        return view('mahasiswa.profile', compact('user', 'totalPeminjaman', 'peminjamanAktif'));
    }

    public function searchBarang(Request $request)
    {
        $keyword = $request->input('search');
        
        // PAKAI METHOD HELPER UNTUK SEARCH
        $barang = Barang::search($keyword)->tersedia()->get();
        
        $cartItems = session('cart_peminjaman', []);
        $lastViewed = json_decode(request()->cookie('last_viewed_barang', '[]'), true);
        $user = Auth::user();
        
        return view('mahasiswa.dashboard', compact('barang', 'lastViewed', 'cartItems', 'user'));
    }
}