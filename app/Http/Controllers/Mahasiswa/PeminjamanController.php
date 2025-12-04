<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'mahasiswa']);
    }

    public function showPengajuanForm()
    {
        $cartItems = session('cart_peminjaman', []);

        if (empty($cartItems)) {
            return redirect()->route('mahasiswa.katalog')
                ->with('error', 'Keranjang peminjaman kosong');
        }

        foreach ($cartItems as $barangId => $item) {
            $barang = Barang::find($barangId);
            if (! $barang || ! $barang->canBeBorrowed() || $item['quantity'] > $barang->stok_tersedia) {
                return redirect()->route('mahasiswa.katalog')->with('error',
                    'Stok ' . ($item['nama'] ?? 'barang') . ' tidak mencukupi. Stok tersedia: ' . ($barang->stok_tersedia ?? 0)
                );
            }
        }

        return view('mahasiswa.pengajuan-form', compact('cartItems'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'tanggal_pinjam'   => 'required|date|after_or_equal:today',
            'tanggal_kembali'  => 'required|date|after:tanggal_pinjam',
            'alasan'           => 'required|string|min:10|max:500',
        ]);

        $cartItems = session('cart_peminjaman', []);

        if (empty($cartItems)) {
            return redirect()->route('mahasiswa.katalog')
                ->with('error', 'Keranjang peminjaman kosong');
        }

        try {
            foreach ($cartItems as $barangId => $item) {
                $barang = Barang::find($barangId);

                if (! $barang || ! $barang->canBeBorrowed() || $item['quantity'] > $barang->stok_tersedia) {
                    return back()->with('error',
                        'Stok ' . ($barang->nama ?? 'barang') . ' tidak mencukupi. Stok tersedia: ' . ($barang->stok_tersedia ?? 0)
                    );
                }
            }

            foreach ($cartItems as $barangId => $item) {
                Peminjaman::create([
                    'user_id'         => Auth::id(),
                    'barang_id'       => $barangId,
                    'jumlah'          => $item['quantity'],
                    'tanggal_pinjam'  => $request->tanggal_pinjam,
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'alasan'          => $request->alasan,
                    'status'          => 'pending',
                ]);
            }

            session()->forget('cart_peminjaman');

            return redirect()->route('mahasiswa.riwayat')->with('success',
                'Pengajuan peminjaman berhasil dikirim. Menunggu persetujuan admin.'
            );
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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

    public function confirmReturn($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($peminjaman->status !== 'disetujui') {
            return redirect()->route('mahasiswa.riwayat')
                ->with('error', 'Peminjaman tidak dapat dikembalikan.');
        }

        $peminjaman->status = 'menunggu_verifikasi';
        $peminjaman->tanggal_pengembalian = now()->toDateString();
        $peminjaman->save();

        return redirect()->route('mahasiswa.riwayat')
            ->with('success', 'Permintaan pengembalian dikirim. Tunggu verifikasi admin.');
    }

    public function downloadBuktiPDF($id)
    {
        $peminjaman = Peminjaman::with('user', 'barang')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $pdf = Pdf::loadView('mahasiswa.bukti-peminjaman-pdf', [
            'peminjaman'   => $peminjaman,
            'tanggalCetak' => Carbon::now(),
        ]);

        return $pdf->download('Bukti-Peminjaman-' . $peminjaman->id . '.pdf');
    }
}
