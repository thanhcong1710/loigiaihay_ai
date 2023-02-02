<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\UtilityServiceProvider as u;
use DOMDocument;
use Exception;
use GuzzleHttp\Client;

class CrawlVungOiController extends Controller
{
    public function vungOi(){
        // anv123 / abcd1234
        // subject
        // for($i=4;$i<13;$i++){
        //     $url = "https://api.vungoi.vn/admin/v1/chapters/grade/".$i;
        //     $params = [];
        //     $headers = [
        //         'x-access-token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImFubnYxMjMiLCJpZCI6IjYzNzM1M2Y5YjlhYjRhNzNjMjlmM2M5MyIsImlzR3Vlc3QiOmZhbHNlLCJpc190ZXN0IjpmYWxzZSwiaWF0IjoxNjY4NTAyNTM1LCJleHAiOjE2NzEwOTQ1MzV9.xbXrNGI4f7Yyu_H4fRZRA3ZMgXcBiQszGQ8Nee9InLU'
        //     ];
        //     $client = new Client();
        //     $response = $client->request('GET',$url,[
        //         'headers' => $headers,
        //         'verify' => false,
        //         'form_params' => $params,
        //     ]);
        //     $data = json_decode($response->getBody()->getContents(), true);
        //     foreach($data['subjects'] AS $subject){
        //         u::insertSimpleRow([
        //             'book_id' => $subject['book']['id'],
        //             'grade_id' => $i,
        //             'type' => $subject['type'],
        //             '_id' => $subject['_id'],
        //             'name'=>$subject['name'],
        //         ],'vung_oi_subject');
        //     }   
        // }


        // chapters
        $list_subject = u::query("SELECT * FROM vung_oi_subject WHERE is_crawl=0");
        foreach($list_subject AS $subject){
            $url = "https://api.vungoi.vn/admin/v1/chapters_quiz/subject/".$subject->_id;
            $params = [];
            $headers = [
                'x-access-token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImFubnYxMjMiLCJpZCI6IjYzNzM1M2Y5YjlhYjRhNzNjMjlmM2M5MyIsImlzR3Vlc3QiOmZhbHNlLCJpc190ZXN0IjpmYWxzZSwiaWF0IjoxNjY4NTAyNTM1LCJleHAiOjE2NzEwOTQ1MzV9.xbXrNGI4f7Yyu_H4fRZRA3ZMgXcBiQszGQ8Nee9InLU'
            ];
            $client = new Client();
            $response = $client->request('GET',$url,[
                'headers' => $headers,
                'verify' => false,
                'form_params' => $params,
            ]);
            $data = json_decode($response->getBody()->getContents(), true);
            foreach($data['chapters'] AS $chapter){
                u::insertSimpleRow([
                    '_id' => $chapter['_id'],
                    'title'=>$chapter['title'],
                    'order' => $chapter['order'],
                    'icon' => $chapter['icon'],
                    'parent_id' => $chapter['parent_id'],
                    'subject_id'=>$subject->_id
                ],'vung_oi_chapter');
                foreach($chapter['childs'] AS $child){
                    u::insertSimpleRow([
                        '_id' => $child['_id'],
                        'title'=>$child['title'],
                        'order' => $child['order'],
                        'icon' => $child['icon'],
                        'parent_id' => $child['parent_id'],
                        'subject_id'=>$subject->_id
                    ],'vung_oi_chapter');
                };
            }
            u::updateSimpleRow([
                'order'=>$data['order'],
                'data_response' =>json_encode($data),
                'is_crawl'=>1
            ],array('id'=>$subject->id),'vung_oi_subject');   
        }
        
        return "ok";
    }
    public function vungOiQuestion($chapter_id){
        try{
            // questions
            $url = "https://api.vungoi.vn/admin/v1/quiz/startNew/chapter/$chapter_id?exerciseType=0";
            $params = [];
            $headers = [
                'x-access-token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImFubnYxMjMiLCJpZCI6IjYzNzM1M2Y5YjlhYjRhNzNjMjlmM2M5MyIsImlzR3Vlc3QiOmZhbHNlLCJpc190ZXN0IjpmYWxzZSwiaWF0IjoxNjY4NTAyNTM1LCJleHAiOjE2NzEwOTQ1MzV9.xbXrNGI4f7Yyu_H4fRZRA3ZMgXcBiQszGQ8Nee9InLU'
            ];
            $client = new Client();
            $response = $client->request('GET',$url,[
                'headers' => $headers,
                'verify' => false,
                'form_params' => $params,
            ]);
            $data = json_decode($response->getBody()->getContents(), true);
            u::insertSimpleRow([
                '_id'=>$data['quiz']['_id'],
                'content'=>json_encode($data['quiz']['question']),
                'difficult_degree'=>isset($data['quiz']['difficult_degree']) ? $data['quiz']['difficult_degree'] : $data['quiz']['question']['difficult_degree'],
                'question_type'=>$data['quiz']['question_type'],
                'solution_suggesstion'=>isset($data['quiz']['solution_suggesstion'])? json_encode($data['quiz']['solution_suggesstion']) : json_encode($data['quiz']['question']['solution_suggesstion']),
                'parent_id'=>isset($data['quiz']['parent']['id']) ? $data['quiz']['parent']['id'] : $data['quiz']['question']['parent']['id'],
                'chapter_id'=>$chapter_id
            ],'vung_oi_question');
            $quiz_id = $data['quiz']['_id'];
            $session = $data['session'];
            $option = $data['quiz']['question'];
            $run=1;
            while($run == 1) {
                $url = "https://api.vungoi.vn/admin/v1/quiz_session/$session/answer";
                $choice = [];
                if(isset($option['quiz']['option']['items'])){
                    foreach($option['quiz']['option']['items'] AS $op){
                        $choice[]=[
                            'id'=>$op['id'],
                            "answer"=> false
                        ];
                    }
                }if(isset($option['quiz']['option']['items'])){
                    foreach($option['quiz']['option']['items'] AS $op){
                        $choice[]=[
                            'id'=>$op['id'],
                            "answer"=> false
                        ];
                    }
                }else if(isset($option['quiz']['mathquill_content']['items'])){
                    foreach($option['quiz']['mathquill_content']['items'] AS $k=> $op){
                        $choice[]=[
                            'id'=>'mInputText_'.($k+1),
                            "answer"=> ""
                        ];
                    }
                }else if(isset($option['quiz']['paragraph']['items'])){
                    foreach($option['quiz']['paragraph']['items'] AS $k=> $op){
                        $choice[]=[
                            'id'=>$op['id'],
                            "answer"=> [
                                "index"=>$k+1
                            ]
                        ];
                    }
                }else if(isset($option['answers'])){
                    $i=rand(0,(count($option['answers'])-1));
                    $choice =[
                        'answer_key'=>$option['answers'][$i]['answer_key']
                    ];
                }else{
                    $i=rand(0,(count($option['question']['answers'])-1));
                    $choice =[
                        'answer_key'=>$option['question']['answers'][$i]['answer_key']
                    ];
                }
                $params = [
                    "question_id"=> $quiz_id,
                    "learning_time"=> 90,
                    "choice"=> $choice
                ];
                $headers = [
                    'x-access-token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImFubnYxMjMiLCJpZCI6IjYzNzM1M2Y5YjlhYjRhNzNjMjlmM2M5MyIsImlzR3Vlc3QiOmZhbHNlLCJpc190ZXN0IjpmYWxzZSwiaWF0IjoxNjY4NTAyNTM1LCJleHAiOjE2NzEwOTQ1MzV9.xbXrNGI4f7Yyu_H4fRZRA3ZMgXcBiQszGQ8Nee9InLU'
                ];
                    $client = new Client();
                    $response = $client->request('POST',$url,[
                        'headers' => $headers,
                        'verify' => false,
                        'form_params' => $params,
                    ]);
                
                $data = json_decode($response->getBody()->getContents(), true);
                u::updateSimpleRow(['answer'=>json_encode($data['answer'])],['_id'=>$quiz_id],'vung_oi_question');
                
                if(!empty($data['quiz'])){
                    $quiz_id = $data['quiz']['_id'];
                    $session = $data['session'];
                    $option = $data['quiz']['question'];
                    u::insertSimpleRow([
                        '_id'=>$data['quiz']['_id'],
                        'content'=>json_encode($data['quiz']['question']),
                        'difficult_degree'=> isset($data['quiz']['difficult_degree']) ? $data['quiz']['difficult_degree'] : $data['quiz']['question']['difficult_degree'],
                        'question_type'=>$data['quiz']['question_type'],
                        'solution_suggesstion'=>isset($data['quiz']['solution_suggesstion'])? json_encode($data['quiz']['solution_suggesstion']) : json_encode($data['quiz']['question']['solution_suggesstion']),
                        'parent_id'=> isset($data['quiz']['parent']['id']) ? $data['quiz']['parent']['id'] : $data['quiz']['question']['parent']['id'],
                        'chapter_id'=>$chapter_id
                    ],'vung_oi_question');
                }else{
                    $run=0;
                }
            
                
            }
            u::updateSimpleRow(['is_crawl'=>1],['_id'=>$chapter_id],'vung_oi_chapter');
        }catch(Exception $e){
            u::updateSimpleRow(['is_crawl'=>2],['_id'=>$chapter_id],'vung_oi_chapter');
        }
    }

    function  recrawlVungOiQuestion($chapter_id){
        try{
            u::query("DELETE FROM vung_oi_question WHERE chapter_id='$chapter_id'");
            // questions
            $url = "https://api.vungoi.vn/admin/v1/quiz/startNew/chapter/$chapter_id?exerciseType=0";
            $params = [];
            $headers = [
                'x-access-token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImFubnYxMjMiLCJpZCI6IjYzNzM1M2Y5YjlhYjRhNzNjMjlmM2M5MyIsImlzR3Vlc3QiOmZhbHNlLCJpc190ZXN0IjpmYWxzZSwiaWF0IjoxNjY4NTAyNTM1LCJleHAiOjE2NzEwOTQ1MzV9.xbXrNGI4f7Yyu_H4fRZRA3ZMgXcBiQszGQ8Nee9InLU'
            ];
            $client = new Client();
            $response = $client->request('GET',$url,[
                'headers' => $headers,
                'verify' => false,
                'form_params' => $params,
            ]);
            $data = json_decode($response->getBody()->getContents(), true);
            u::insertSimpleRow([
                '_id'=>$data['quiz']['_id'],
                'content'=>json_encode($data['quiz']['question']),
                'difficult_degree'=>isset($data['quiz']['difficult_degree']) ? $data['quiz']['difficult_degree'] : $data['quiz']['question']['difficult_degree'],
                'question_type'=>$data['quiz']['question_type'],
                'solution_suggesstion'=>isset($data['quiz']['solution_suggesstion'])? json_encode($data['quiz']['solution_suggesstion']) : json_encode($data['quiz']['question']['solution_suggesstion']),
                'parent_id'=>isset($data['quiz']['parent']['id']) ? $data['quiz']['parent']['id'] : $data['quiz']['question']['parent']['id'],
                'chapter_id'=>$chapter_id
            ],'vung_oi_question');
            $quiz_id = $data['quiz']['_id'];
            $session = $data['session'];
            $option = $data['quiz']['question'];
            $run=1;
            while($run == 1) {
                $url = "https://api.vungoi.vn/admin/v1/quiz_session/$session/answer";
                $choice = [];
                $unset = 0;
                if(isset($option['quiz']['option']['items'])){
                    foreach($option['quiz']['option']['items'] AS $op){
                        $choice[]=[
                            'id'=>$op['id'],
                            "answer"=> false
                        ];
                    }
                }if(isset($option['quiz']['option']['items'])){
                    foreach($option['quiz']['option']['items'] AS $op){
                        $choice[]=[
                            'id'=>$op['id'],
                            "answer"=> false
                        ];
                    }
                }else if(isset($option['quiz']['mathquill_content']['items'])){
                    foreach($option['quiz']['mathquill_content']['items'] AS $k=> $op){
                        $choice[]=[
                            'id'=>'mInputText_'.($k+1),
                            "answer"=> ""
                        ];
                    }
                }else if(isset($option['quiz']['paragraph']['items'])){
                    foreach($option['quiz']['paragraph']['items'] AS $k=> $op){
                        $choice[]=[
                            'id'=>$op['id'],
                            "answer"=> [
                                "index"=>$k+1
                            ]
                        ];
                    }
                }else if(isset($option['answers'])){
                    $i=rand(0,(count($option['answers'])-1));
                    $choice =[
                        'answer_key'=>$option['answers'][$i]['answer_key']
                    ];
                }else if(isset($option['question']['answers'])){
                    $i=rand(0,(count($option['question']['answers'])-1));
                    $choice =[
                        'answer_key'=>$option['question']['answers'][$i]['answer_key']
                    ];
                }else if(isset($option['quiz']['targets']['items'][0]['id'])){
                    $choice =[
                        0 =>[
                            'id'=>$option['quiz']['targets']['items'][0]['id'],
                            'answer'=>[
                                'index'=>0
                            ]
                        ]
                    ];
                }else{
                    $choice =[
                        0 =>[
                            'id'=>$option['quiz']['secondParagraph']['items'][0]['id'],
                            'answer'=>$option['quiz']['firstParagraph']['items'][0]['content']
                        ]
                    ];
                }
                $params = [
                    "question_id"=> $quiz_id,
                    "learning_time"=> 90,
                    "choice"=> $choice
                ];
                if($unset) unset($params['choice']);
                $headers = [
                    'x-access-token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImFubnYxMjMiLCJpZCI6IjYzNzM1M2Y5YjlhYjRhNzNjMjlmM2M5MyIsImlzR3Vlc3QiOmZhbHNlLCJpc190ZXN0IjpmYWxzZSwiaWF0IjoxNjY4NTAyNTM1LCJleHAiOjE2NzEwOTQ1MzV9.xbXrNGI4f7Yyu_H4fRZRA3ZMgXcBiQszGQ8Nee9InLU'
                ];
                    $client = new Client();
                    $response = $client->request('POST',$url,[
                        'headers' => $headers,
                        'verify' => false,
                        'form_params' => $params,
                    ]);
                
                $data = json_decode($response->getBody()->getContents(), true);
                u::updateSimpleRow(['answer'=>json_encode($data['answer'])],['_id'=>$quiz_id],'vung_oi_question');
                
                if(!empty($data['quiz'])){
                    $quiz_id = $data['quiz']['_id'];
                    $session = $data['session'];
                    $option = $data['quiz']['question'];
                    u::insertSimpleRow([
                        '_id'=>$data['quiz']['_id'],
                        'content'=>json_encode($data['quiz']['question']),
                        'difficult_degree'=> isset($data['quiz']['difficult_degree']) ? $data['quiz']['difficult_degree'] : $data['quiz']['question']['difficult_degree'],
                        'question_type'=>$data['quiz']['question_type'],
                        'solution_suggesstion'=>isset($data['quiz']['solution_suggesstion'])? json_encode($data['quiz']['solution_suggesstion']) : json_encode($data['quiz']['question']['solution_suggesstion']),
                        'parent_id'=> isset($data['quiz']['parent']['id']) ? $data['quiz']['parent']['id'] : $data['quiz']['question']['parent']['id'],
                        'chapter_id'=>$chapter_id
                    ],'vung_oi_question');
                }else{
                    $run=0;
                }
            
                
            }
            u::updateSimpleRow(['is_crawl'=>1],['_id'=>$chapter_id],'vung_oi_chapter');
        }catch(Exception $e){
            u::updateSimpleRow(['is_crawl'=>3],['_id'=>$chapter_id],'vung_oi_chapter');
        }
    }
}
