<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('links:cleanup')
                 ->everyFiveMinutes()
                 ->withoutOverlapping()
                 ->onOneServer()
                 ->appendOutputTo(storage_path('logs/links-cleanup.log'));
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
