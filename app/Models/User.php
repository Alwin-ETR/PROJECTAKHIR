<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'nim', 'phone'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }

    public function suspensions()
    {
        return $this->hasMany(Suspension::class);
    }

    public function activeSuspension()
    {
        return $this->hasOne(Suspension::class)
            ->where('status', 'active')
            ->where('suspended_until', '>', now());
    }

    // Check apakah user suspended
    public function isSuspended()
    {
        return Suspension::isUserSuspended($this->id);
    }

    // Get active suspension
    public function getActiveSuspension()
    {
        return Suspension::getActiveSuspension($this->id);
    }

    // Get sisa hari suspend
    public function getSuspensionDaysRemaining()
    {
        $suspension = $this->getActiveSuspension();
        return $suspension ? $suspension->getRemainingDays() : 0;
    }
}