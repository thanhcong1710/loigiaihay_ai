<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\CrawlTech12Controller;
use Illuminate\Console\Command;
use App\Providers\UtilityServiceProvider as u;
use Illuminate\Http\Request;
use Predis\Command\Redis\SELECT;

class JobsProcessCrawlTech12 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobsProcessCrawlTech12:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'jobsProcessCrawlTech12';

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
        $tmp = new CrawlTech12Controller();
        // $tmp->getCategory();
        // $categories = u::query("SELECT * FROM data_category WHERe status=0");
        // foreach($categories AS $cat){
        //     $tmp->getSubject($cat);
        //     $tmp->getSubject2($cat);
        //     echo $cat->id."/";
        // }
        $subjects = u::query("SELECT s.* FROM data_subject AS s LEFT JOIN data_category AS c ON c.id=s.cat_id WHERe s.status=0 AND c.type=1");
        $i=0;
        foreach($subjects AS $sub){
            $tmp->getContentType1($sub);
            echo $sub->id."/";
            $i++;
            if($i==10){
                sleep(3);
                $i=0;
            }
        };

        //update img
        // $questions = u::query("SELECT q.* FROM data_question AS q WHERe q.update_img=0 AND type=0");
        // foreach($questions AS $sub){
        //     $tmp->updateImgQuestionType0($sub);
        //     echo $sub->id."/";
        // };
        return "ok";
    }
    
}
