<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\CrawlVungOiController;
use Illuminate\Console\Command;
use App\Providers\UtilityServiceProvider as u;
use Illuminate\Http\Request;

class JobsProcessCrawlCoPhieu68 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobsProcessCrawlVungOi:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'jobsProcessCrawlVungOi';

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
        // $chapters = u::query("SELECT  * FROM vung_oi_chapter WHERE is_crawl=0 AND parent_id IS NOT NULL AND parent_id!=''");
        // foreach($chapters AS $chap){
        //     $tmp =new CrawlController();
        //     $tmp->vungOiQuestion($chap->_id);
        //     echo $chap->_id."/";
        // }
        $chapters = u::query("SELECT  * FROM vung_oi_chapter WHERE is_crawl=2 AND parent_id IS NOT NULL AND parent_id!=''");
        foreach($chapters AS $chap){
            $tmp =new CrawlVungOiController();
            $tmp->recrawlVungOiQuestion($chap->_id);
            echo $chap->_id."/";
        }
        return "ok";
    }
    
}
