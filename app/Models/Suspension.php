<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Suspension extends Model
{
    protected $fillable = [
        'user_id',
        'reason',
        'suspended_at',
        'suspended_until',
        'status',
        'created_by',
        'notes'
    ];

    protected $casts = [
        'suspended_at' => 'datetime',
        'suspended_until' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Check apakah user masih suspend
    public static function isUserSuspended($userId)
    {
        $suspension = self::where('user_id', $userId)
            ->where('status', 'active')
            ->where('suspended_until', '>', now())
            ->first();

        return $suspension ? true : false;
    }

    // Get active suspension untuk user
    public static function getActiveSuspension($userId)
    {
        return self::where('user_id', $userId)
            ->where('status', 'active')
            ->where('suspended_until', '>', now())
            ->first();
    }

    // Hitung sisa hari suspend
    public function getRemainingDays()
    {
        return now()->diffInDays($this->suspended_until, false);
    }
}
