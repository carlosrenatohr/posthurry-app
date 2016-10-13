<?php

namespace App\Console\Commands;

use App\Library\Repositories\PostsPerDayRepository;
use App\User;
use Illuminate\Console\Command;

class PostPerDayChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blast:postPerDayChecker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if user has reach limit of post per day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->doCheck( new PostsPerDayRepository() );
    }

    public function doCheck( $postPerDay ) {
        foreach (User::all() as $user) {
            $postsPerDay->createOrUpdatePostsPerDay($user->id);
        }
    }

}
