<?php
namespace App\Console;
use App\Comparison;
use App\Comparison_data;
use App\Library\Helpers\MediaHelper;
use App\Library\Repositories\PostsPerDayRepository;
use App\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Inspire::class,
        Commands\Ftw::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule( Schedule $schedule ) {
        //$schedule->call($SchedulerBlasting)->cron('*/6 * * * * *');
        //$schedule->call($setPostsPerDay)->daily();
        $schedule->command( 'blast:winner' )->cron('*/6 * * * * *');
    }
}
