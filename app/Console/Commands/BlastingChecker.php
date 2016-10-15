<?php

namespace App\Console\Commands;

use App\Library\Repositories\BlastingRepository;
use App\User;
use Illuminate\Console\Command;

class BlastingChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blast:blasting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check every 6 minutes to post blastings by user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $blasting;
    public function __construct(BlastingRepository $repo)
    {
        parent::__construct();
        $this->blasting = $repo;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->doCheck();
    }

    protected function doCheck() {
        $users = User::all();
        foreach ($users as $user) {
            $token = $user->access_token;
            if (!is_null($token)) {
                $this->info(date('d-m-Y H:i:sA') . ' - Blasting created by '. $user->email);
                foreach ($user->blastings as $blasting) {
                    $this->blasting->scheduleBlastOut($blasting->id, $token);
                }
            }
            else {
                $this->info('No token stored for ' . $user->email);
            }
        }
    }
}
