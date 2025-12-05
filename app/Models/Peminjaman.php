<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id', 
        'barang_id', 
        'jumlah', 
        'tanggal_pinjam', 
        'tanggal_kembali', 
        'tanggal_pengembalian', 
        'status', 
        'alasan', 
        'catatan_admin'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'datetime',
        'tanggal_pengembalian' => 'datetime',
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

    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'pending' => 'warning',
            'disetujui' => 'success',
            'ditolak' => 'danger',
            'menunggu_verifikasi' => 'orange',
            'dikembalikan' => 'info'
        ];

        return $statuses[$this->status] ?? 'secondary';
    }

    public function getStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'Menunggu',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'dikembalikan' => 'Dikembalikan'
        ];

        return $statuses[$this->status] ?? 'Tidak Diketahui';
    }

    public function suspension()
    {
        return $this->hasOne(Suspension::class, 'user_id', 'user_id')
            ->where('status', 'active')
            ->where('suspended_until', '>', now());
    }

    // Method untuk check apakah peminjaman telat
    public function isLate()
    {
        return $this->tanggal_pengembalian === null && 
            now()->gt($this->tanggal_kembali);
    }

    // Hitung hari telat
    public function getDaysLate()
    {
        if ($this->tanggal_pengembalian) {
            return \Carbon\Carbon::parse($this->tanggal_kembali)
                ->diffInDays(\Carbon\Carbon::parse($this->tanggal_pengembalian));
        }
        
        return now()->diffInDays($this->tanggal_kembali);
    }
}