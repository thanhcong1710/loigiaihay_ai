<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\CrawlVietjackController;
use Illuminate\Console\Command;
use App\Providers\UtilityServiceProvider as u;
use Illuminate\Http\Request;

class JobsProcessCrawlVietjack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobsProcessCrawlVietjack:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'JobsProcessCrawlVietjack';

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
        // $chapters = u::query("SELECT  * FROM vietjack_chapter WHERE status=0 AND parent_id =0 ");
        // foreach($chapters AS $chap){
        //     $tmp =new CrawlVietjackController();
        //     $tmp->getSubSubject2($chap->id);
        //     u::updateSimpleRow(['status'=>1],['id'=>$chap->id],'vietjack_chapter');
        //     echo $chap->id."/";
        // }
        $chapters = u::query("SELECT  * FROM vietjack_chapter WHERE  parent_id !=0 LIMIT 20");
        foreach($chapters AS $chap){
            $tmp =new CrawlVietjackController();
            $tmp->getContentChapter($chap->id);
            echo $chap->id."/";
        }
        return "ok";
    }
    
}
