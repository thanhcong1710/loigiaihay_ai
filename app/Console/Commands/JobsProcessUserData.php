<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Providers\UtilityServiceProvider as u;
use Illuminate\Http\Request;
use Predis\Command\Redis\SELECT;

class JobsProcessUserData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobsProcessUserData:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'jobsProcessUserData';

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
    public function handle(Request $request)
    {
        $users = u::query("SELECT * FROM users WHERE status=1");
        foreach($users AS $user){
            if($user->coins_free < config('app.coins_free_day')){
                u::updateSimpleRow([
                    'coins_free'=>config('app.coins_free_day')
                ],['id'=>$user->id],'users');
            }
        }
        
        return "ok";
    }
    
}
