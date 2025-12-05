<?php

namespace App\Jobs;

use App\Mail\SuspensionUnlocked;
use App\Models\Suspension;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CheckAndUnlockSuspensions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        // Cari semua suspend yang aktif dan sudah melewati waktu suspended_until
        $expiredSuspensions = Suspension::where('status', 'active')
            ->where('suspended_until', '<=', now())
            ->get();

        foreach ($expiredSuspensions as $suspension) {
            // Update status jadi expired
            $suspension->update(['status' => 'expired']);

            // Kirim email unlock
            Mail::to($suspension->user->email)
                ->send(new SuspensionUnlocked($suspension));

            \Log::info("User {$suspension->user_id} suspension expired and unlocked");
        }
    }
}
