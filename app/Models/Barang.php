<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang', 'nama', 'deskripsi', 'stok', 'status', 'gambar'
    ];

    protected $table = 'barangs';

    // Append calculated attributes
    protected $appends = ['stok_tersedia', 'is_available'];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    /**
     * Calculate available stock (stok fisik - yang sedang dipinjam)
     */
    public function getStokTersediaAttribute()
    {
        $dipinjam = $this->peminjamans()
            ->whereIn('status', ['disetujui', 'pending'])
            ->sum('jumlah');
            
        return max(0, $this->stok - $dipinjam);
    }

    /**
     * Check if item is available for borrowing
     */
    public function getIsAvailableAttribute()
    {
        return $this->stok > 0 && $this->status === 'tersedia';
    }

    /**
     * Update stock when item is approved
     */
    public function updateStockOnApproval($quantity)
    {
        Log::info("=== updateStockOnApproval DEBUG ===");
        Log::info("Barang: " . $this->nama);
        Log::info("Stok SEBELUM: " . $this->stok);
        Log::info("Quantity: " . $quantity);

        // Kurangi stok fisik
        $this->decrement('stok', $quantity);
        
        Log::info("Stok SESUDAH: " . $this->stok);
        
        // Update status jika stok habis
        if ($this->stok == 0) {
            $this->update(['status' => 'dipinjam']);
            Log::info("Status diubah ke: dipinjam");
        } else {
            Log::info("Status tetap: " . $this->status);
        }
        
        return $this;
    }

    /**
     * Restore stock when item is returned or rejected
     */
    public function restoreStock($quantity)
    {
        Log::info("=== restoreStock DEBUG ===");
        Log::info("Barang: " . $this->nama);
        Log::info("Stok SEBELUM: " . $this->stok);
        Log::info("Quantity: " . $quantity);

        // Tambah stok fisik
        $this->increment('stok', $quantity);
        
        Log::info("Stok SESUDAH: " . $this->stok);
        
        // Update status jika stok kembali tersedia
        if ($this->stok > 0 && $this->status === 'dipinjam') {
            $this->update(['status' => 'tersedia']);
            Log::info("Status diubah ke: tersedia");
        } else {
            Log::info("Status tetap: " . $this->status);
        }
        
        return $this;
    }

    /**
     * Check if item can be borrowed
     */
    public function canBeBorrowed()
    {
        $result = $this->status === 'tersedia' && $this->stok > 0;
        
        Log::info("=== canBeBorrowed DEBUG ===");
        Log::info("Barang: " . $this->nama);
        Log::info("Status: " . $this->status);
        Log::info("Stok: " . $this->stok);
        Log::info("Can be borrowed: " . ($result ? 'YES' : 'NO'));
        
        return $result;
    }

    /**
     * Scope for available items - TAMPILKAN SEMUA BARANG MESKIPUN DIPINJAM
     */
    public function scopeTersedia($query)
    {
        return $query->where(function($q) {
            $q->where('status', 'tersedia')
              ->orWhere('status', 'dipinjam');
        });
    }

    /**
     * Scope for items that can be borrowed (hanya yang benar-benar bisa dipinjam)
     */
    public function scopeBisaDipinjam($query)
    {
        return $query->where('status', 'tersedia')
                    ->where('stok', '>', 0);
    }

    /**
     * Scope for items with stock
     */
    public function scopeAdaStok($query)
    {
        return $query->where('stok', '>', 0);
    }

    /**
     * Scope for search
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where('nama', 'like', "%{$keyword}%")
                    ->orWhere('kode_barang', 'like', "%{$keyword}%")
                    ->orWhere('deskripsi', 'like', "%{$keyword}%");
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'tersedia' => 'success',
            'dipinjam' => 'warning',
            'perbaikan' => 'danger'
        ];

        return $statuses[$this->status] ?? 'secondary';
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        $statuses = [
            'tersedia' => 'Tersedia',
            'dipinjam' => 'Sedang Dipinjam',
            'perbaikan' => 'Dalam Perbaikan'
        ];

        return $statuses[$this->status] ?? 'Tidak Diketahui';
    }

    /**
     * Get image URL or placeholder
     */
    public function getImageUrlAttribute()
    {
        if ($this->gambar && file_exists(storage_path('app/public/' . $this->gambar))) {
            return asset('storage/' . $this->gambar);
        }
        return asset('images/placeholder-item.png');
    }

    /**
     * Check if item has image
     */
    public function getHasImageAttribute()
    {
        return !empty($this->gambar) && file_exists(storage_path('app/public/' . $this->gambar));
    }

    /**
     * Get short description
     */
    public function getDeskripsiSingkatAttribute()
    {
        return $this->deskripsi ? Str::limit($this->deskripsi, 100) : 'Tidak ada deskripsi';
    }

    /**
     * Get total times borrowed
     */
    public function getTotalDipinjamAttribute()
    {
        return $this->peminjamans()->count();
    }

    /**
     * Get active borrowings count
     */
    public function getSedangDipinjamAttribute()
    {
        return $this->peminjamans()
            ->whereIn('status', ['disetujui', 'pending'])
            ->count();
    }
}