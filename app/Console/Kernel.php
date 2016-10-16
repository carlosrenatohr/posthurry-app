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
        Commands\Ftw::class,
        Commands\Inspire::class,
        Commands\PostPerDayChecker::class,
        Commands\BlastingChecker::class,
        Commands\BlastingOBlasting::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule( Schedule $schedule ) {
        $schedule->command( 'blast:postPerDayChecker' )->daily();
        // $schedule->command( 'blast:winner' )->cron('*/6 * * * * *');
        // $schedule->command('blast:blasting')->cron('*/6 * * * * *');
    }
}
