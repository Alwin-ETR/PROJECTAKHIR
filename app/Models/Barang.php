<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang', 'nama', 'deskripsi', 'stok', 'status', 'gambar' // UBAH JADI 'nama'
    ];

    protected $table = 'barangs';

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function getStokTersediaAttribute()
    {
        $dipinjam = $this->peminjamans()
            ->whereIn('status', ['disetujui', 'pending'])
            ->sum('jumlah');
            
        return $this->stok - $dipinjam;
    }
}