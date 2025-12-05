<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //
    ];

    protected function schedule(Schedule $schedule)
    {
        // Check & suspend late returns - jalankan setiap hari jam 2 pagi
        $schedule->job(\App\Jobs\CheckAndSuspendLateReturns::class)
            ->dailyAt('02:00')
            ->timezone('Asia/Jakarta');

        // Check & unlock expired suspensions - jalankan setiap hari jam 3 pagi
        $schedule->job(\App\Jobs\CheckAndUnlockSuspensions::class)
            ->dailyAt('03:00')
            ->timezone('Asia/Jakarta');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
