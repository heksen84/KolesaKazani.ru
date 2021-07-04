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
	    Commands\DeleteAllAdverts::class,
	    Commands\DeleteExpiredAdverts::class,
	    Commands\DeleteAllImages::class,
	    Commands\GenerateSitemapLinks::class,
	    Commands\EnableModeration::class,
	    Commands\DisableModeration::class,
	    Commands\RemoveLostImages::class,
	    Commands\DeleteAdvert::class,
	    Commands\Utils::class,
	    Commands\Test::class,
            Commands\CheckSitemapsForError::class,
            Commands\ImportUserQueries::class,
            Commands\ParseOlx_phones_and_gadgets::class,
            Commands\ParseOlx_moda_and_style::class,
            Commands\ParseOlx_comps::class,
            Commands\ParseOlx_bytovye_uslugi::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
         $schedule->command('deleteAllAdverts')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
