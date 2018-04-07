<?php

namespace App\Console;

use App\Http\Controllers\SchedullerController;
use App\Http\Controllers\TargetPriceController;
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
        $schedule->call(function ()
        {
            $telegram = new SchedullerController();
            $telegram->schedullerMessageDistribution();
        })->everyMinute();

        $schedule->call(function ()
        {
            $telegram = new TargetPriceController();
            $telegram->targetPriceMessageDistribution();
        })->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
