<?php

namespace App\Jobs;

use App\Mail\SuspensionWarning;
use App\Mail\UserSuspended;
use App\Models\Peminjaman;
use App\Models\Suspension;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CheckAndSuspendLateReturns implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        // Ambil semua peminjaman yang belum dikembalikan dan sudah telat
        $lateReturns = Peminjaman::whereNull('tanggal_pengembalian')
            ->where('tanggal_kembali', '<', now())
            ->get();

        foreach ($lateReturns as $peminjaman) {
            $daysLate = $peminjaman->getDaysLate();
            $userId = $peminjaman->user_id;

            // Check apakah user sudah pernah dikasih warning
            $existingWarning = \DB::table('suspension_warnings')
                ->where('user_id', $userId)
                ->where('peminjaman_id', $peminjaman->id)
                ->exists();

            // HARI 1 TELAT - Kirim Email Warning
            if ($daysLate == 1 && !$existingWarning) {
                Mail::to($peminjaman->user->email)
                    ->send(new SuspensionWarning($peminjaman, $daysLate));

                // Log warning ini
                \DB::table('suspension_warnings')->insert([
                    'user_id' => $userId,
                    'peminjaman_id' => $peminjaman->id,
                    'created_at' => now(),
                ]);

                \Log::info("Warning email sent to {$peminjaman->user->email} for peminjaman {$peminjaman->id}");
            }

            // HARI 3 TELAT - Suspend 7 hari
            if ($daysLate >= 3) {
                $existingSuspension = Suspension::where('user_id', $userId)
                    ->where('status', 'active')
                    ->first();

                if (!$existingSuspension) {
                    // Suspend 7 hari
                    $suspension = Suspension::create([
                        'user_id' => $userId,
                        'reason' => "Peminjaman terlambat {$daysLate} hari. Barang: {$peminjaman->barang->nama_barang}",
                        'suspended_at' => now(),
                        'suspended_until' => now()->addDays(7),
                        'status' => 'active',
                    ]);

                    Mail::to($peminjaman->user->email)
                        ->send(new UserSuspended($suspension));

                    \Log::info("User {$userId} suspended for 7 days");
                } else if ($daysLate >= 7) {
                    // HARI 7 TELAT - Upgrade suspend jadi 1 bulan
                    $existingSuspension->update([
                        'suspended_until' => now()->addMonth(),
                        'reason' => "Peminjaman terlambat {$daysLate} hari (Upgrade dari 7 hari). Barang: {$peminjaman->barang->nama_barang}",
                    ]);

                    Mail::to($peminjaman->user->email)
                        ->send(new UserSuspended($existingSuspension));

                    \Log::info("User {$userId} suspend upgraded to 1 month");
                }
            }
        }
    }
}
