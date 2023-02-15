<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\CrawlTech12Controller;
use Illuminate\Console\Command;
use App\Providers\UtilityServiceProvider as u;
use Illuminate\Http\Request;
use Predis\Command\Redis\SELECT;

class JobsProcessUpdateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobsProcessUpdateData:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'jobsProcessUpdateData';

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
        $categories = u::query("SELECT * FROM data_subject WHERe slug IS NULL");
        foreach($categories AS $cat){
            u::updateSimpleRow([
                'slug'=>u::createSlug($cat->title)
            ],['id'=>$cat->id],'data_subject');
            echo $cat->id."/";
        }
        
        return "ok";
    }
    
}
