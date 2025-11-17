<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
            $stats = [
                'total_barang' => 0,
                'total_mahasiswa' => 0,
                'peminjaman_pending' => 0,
                'peminjaman_aktif' => 0,
            ];

            $peminjaman_terbaru = collect([]);
        }

        return view('admin.dashboard', compact('stats', 'peminjaman_terbaru'));
    }

    // ==================== CRUD BARANG ====================

    public function barangIndex()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        $barangs = Barang::all();
        return view('admin.barang.index', compact('barangs'));
    }

    public function barangCreate()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        return view('admin.barang.create');
    }

    public function barangStore(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        $validated = $request->validate([
            'kode_barang' => 'required|unique:barangs',
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,dipinjam,perbaikan',
            'gambar' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('barang-images', 'public');
        }

        Barang::create($validated);

        return redirect()->route('admin.barang.index')
            ->with('success', 'Barang berhasil ditambahkan!');
    }

    public function barangEdit(Barang $barang)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        return view('admin.barang.edit', compact('barang'));
    }

    public function barangUpdate(Request $request, Barang $barang)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        $validated = $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang,' . $barang->id,
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,dipinjam,perbaikan',
            'gambar' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($barang->gambar) {
                Storage::disk('public')->delete($barang->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('barang-images', 'public');
        }

        $barang->update($validated);

        return redirect()->route('admin.barang.index')
            ->with('success', 'Barang berhasil diupdate!');
    }

    public function barangDestroy(Barang $barang)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        // Cek apakah barang sedang dipinjam
        $peminjaman_aktif = Peminjaman::where('barang_id', $barang->id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->exists();
            
        if ($peminjaman_aktif) {
            return redirect()->back()
                ->with('error', 'Tidak bisa menghapus barang yang sedang dipinjam!');
        }

        // Hapus gambar jika ada
        if ($barang->gambar) {
            Storage::disk('public')->delete($barang->gambar);
        }

        $barang->delete();

        return redirect()->route('admin.barang.index')
            ->with('success', 'Barang berhasil dihapus!');
    }

    // ==================== MANAJEMEN MAHASISWA ====================

    public function mahasiswaIndex()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        $mahasiswa = User::where('role', 'mahasiswa')->get();
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function mahasiswaPeminjaman(User $user)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        $peminjaman = $user->peminjamans()
            ->with('barang')
            ->latest()
            ->get();

        return view('admin.mahasiswa.peminjaman', compact('user', 'peminjaman'));
    }

    // ==================== MANAJEMEN PEMINJAMAN ====================

    public function peminjamanIndex()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        $peminjaman = Peminjaman::with(['user', 'barang'])
            ->latest()
            ->get();

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function approvePeminjaman(Peminjaman $peminjaman)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        try {
            // Validasi stok sebelum approve
            $barang = $peminjaman->barang;
            
            Log::info("=== APPROVE PEMINJAMAN DEBUG ===");
            Log::info("Barang: " . $barang->nama);
            Log::info("Stok SEBELUM: " . $barang->stok);
            Log::info("Jumlah dipinjam: " . $peminjaman->jumlah);
            
            if ($peminjaman->jumlah > $barang->stok) {
                return back()->with('error', 'Stok barang tidak mencukupi! Stok tersedia: ' . $barang->stok);
            }

            // Update status peminjaman
            $peminjaman->update([
                'status' => 'disetujui',
                'catatan_admin' => request('catatan_admin', 'Peminjaman disetujui')
            ]);

            // KURANGI STOK BARANG - CARA MANUAL UNTUK DEBUG
            $stokSebelum = $barang->stok;
            $stokSesudah = $stokSebelum - $peminjaman->jumlah;
            
            Log::info("Stok SESUDAH (perhitungan): " . $stokSesudah);
            
            // Update stok manual
            $barang->update([
                'stok' => $stokSesudah
            ]);
            
            // Refresh model untuk baca data terbaru
            $barang->refresh();
            
            Log::info("Stok SESUDAH (dari database): " . $barang->stok);
            
            // HANYA UBAH STATUS JIKA STOK = 0
            if ($barang->stok == 0) {
                $barang->update(['status' => 'dipinjam']);
                Log::info("Status diubah ke: dipinjam");
            } else {
                Log::info("Status tetap: " . $barang->status);
            }

            return back()->with('success', 
                'Peminjaman disetujui! ' . 
                'Stok ' . $barang->nama . ' berkurang dari ' . $stokSebelum . ' menjadi ' . $barang->stok
            );

        } catch (\Exception $e) {
            Log::error("Error approve peminjaman: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function rejectPeminjaman(Peminjaman $peminjaman)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        try {
            // KEMBALIKAN STOK JIKA SUDAH DIPINJAM SEBELUMNYA
            if ($peminjaman->status === 'disetujui') {
                $barang = $peminjaman->barang;
                
                Log::info("=== REJECT PEMINJAMAN DEBUG ===");
                Log::info("Barang: " . $barang->nama);
                Log::info("Stok SEBELUM: " . $barang->stok);
                Log::info("Jumlah dikembalikan: " . $peminjaman->jumlah);
                
                $barang->restoreStock($peminjaman->jumlah);
                
                Log::info("Stok SESUDAH: " . $barang->stok);
            }

            $peminjaman->update([
                'status' => 'ditolak',
                'catatan_admin' => request('catatan_admin', 'Peminjaman ditolak')
            ]);

            return back()->with('success', 'Peminjaman ditolak!');

        } catch (\Exception $e) {
            Log::error("Error reject peminjaman: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ==================== TAMBAHAN: PENGEMBALIAN BARANG ====================

    public function completePeminjaman(Peminjaman $peminjaman)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        try {
            // Kembalikan stok barang
            $barang = $peminjaman->barang;
            
            Log::info("=== COMPLETE PEMINJAMAN DEBUG ===");
            Log::info("Barang: " . $barang->nama);
            Log::info("Stok SEBELUM: " . $barang->stok);
            Log::info("Jumlah dikembalikan: " . $peminjaman->jumlah);

            $barang->restoreStock($peminjaman->jumlah);

            // Update status peminjaman
            $peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_pengembalian' => now(),
                'catatan_admin' => request('catatan_admin', 'Barang telah dikembalikan')
            ]);

            Log::info("Stok SESUDAH: " . $barang->stok);

            return back()->with('success', 
                'Barang berhasil dikembalikan! ' .
                'Stok ' . $barang->nama . ' bertambah menjadi ' . $barang->stok
            );

        } catch (\Exception $e) {
            Log::error("Error complete peminjaman: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}