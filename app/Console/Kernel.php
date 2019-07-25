<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->command('timbanca:magazine-features')
            ->dailyAt("04:00")
            ->timezone('America/Sao_Paulo');

        $schedule->command('report:active-users vivonews')
            ->dailyAt("04:00")
            ->timezone('America/Sao_Paulo');

        $schedule->command('report:active-users oijornais')
            ->dailyAt("05:00")
            ->timezone('America/Sao_Paulo');

        $schedule->command('report:active-users timbanca')
            ->dailyAt("06:00")
            ->timezone('America/Sao_Paulo');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        $this->load(__DIR__.'/Commands/OiJornais');
        $this->load(__DIR__.'/Commands/TimBanca');

        require base_path('routes/console.php');
    }
}
