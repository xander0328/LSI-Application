<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Assignment;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('assignment:check')->everyMinute();
        // ->withoutOverlapping()->skip(function () {
        //     return intval(date('s')) % 10 !== 0;
        // });

        // $schedule->call(function(){
        //     Assignment::whereNull('due_date')->delete();
        // })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
