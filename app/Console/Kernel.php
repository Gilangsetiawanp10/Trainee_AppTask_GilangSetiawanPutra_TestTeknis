<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\UpdateLateTasksCommand::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Opsi 1: Run daily at midnight
        $schedule->command('tasks:update-late')
                 ->daily()
                 ->at('00:00');
        
        // Opsi 2: Run every hour (lebih responsif)
        // $schedule->command('tasks:update-late')->hourly();
        
        // Opsi 3: Run only on weekdays at 9 AM
        // $schedule->command('tasks:update-late')
        //          ->weekdays()
        //          ->at('09:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
