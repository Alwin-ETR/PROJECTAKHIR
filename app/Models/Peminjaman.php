<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // TAMBAHKAN INI - Tentukan nama tabel yang benar
    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id', 'barang_id', 'jumlah', 'tanggal_pinjam', 
        'tanggal_kembali', 'tanggal_pengembalian', 'status', 
        'alasan', 'catatan_admin'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'tanggal_pengembalian' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function isOverdue()
    {
        return $this->status === 'disetujui' && 
               now()->greaterThan($this->tanggal_kembali) && 
               !$this->tanggal_pengembalian;
    }
}