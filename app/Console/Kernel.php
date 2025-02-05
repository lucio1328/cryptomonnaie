<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\GenerateCryptoPrices::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('generate:crypto-prices')
                 ->everyMinute()
                 ->appendOutputTo(storage_path('logs/crypto.log'));
    }

    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
