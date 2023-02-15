<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\UtilityServiceProvider as u;
use DOMDocument;
use Exception;
use GuzzleHttp\Client;

class CrawlTech12Controller extends Controller
{
    public static function getElementsByClass(&$parentNode, $tagName, $className) {
        $nodes=array();
    
        $childNodeList = $parentNode->getElementsByTagName($tagName);
        for ($i = 0; $i < $childNodeList->length; $i++) {
            $temp = $childNodeList->item($i);
            if (stripos($temp->getAttribute('class'), $className) !== false) {
                $nodes[]=$temp;
            }
        }
    
        return $nodes;
    }
    public function getCategory(){
       //category
        for($i=2;$i<=12;$i++){
            $i=1;
            $url = "https://tech12h.com/cong-nghe/lop-$i.html";
            $data=file_get_contents($url);
            $doc = new DOMDocument();                        
            $doc->loadHTML($data,LIBXML_NOERROR);
            $content = $doc->getElementById('collapse1');
            $div_nodes=$this->getElementsByClass($content, 'div', 'col-md-4');
            foreach($div_nodes AS $div){
                $subjects = $div->getElementsByTagName('h4');
                $subject_name = $subjects[0]->nodeValue;
                $categories = $div->getElementsByTagName('a');
                foreach($categories AS $cat){
                    u::insertSimpleRow([
                        'title'=> $cat->nodeValue,
                        'link'=> $cat->getAttribute('href'),
                        'group'=> $subject_name,
                        'level'=> $i
                    ],'data_category');
                }
                echo $subject_name."/";
            }   
        }
        
        $i=1;
        $url = "https://tech12h.com/cong-nghe/lop-$i.html";
        $data=file_get_contents($url);
        $doc = new DOMDocument();                        
        $doc->loadHTML($data,LIBXML_NOERROR);
        $content = $doc->getElementById('collapse1');
        $div_nodes=$content->getElementsByTagName('td');
        foreach($div_nodes AS $div){
            $subjects = $div->getElementsByTagName('h3');
            $subject_name = $subjects[0]->nodeValue;
            $categories = $div->getElementsByTagName('a');
            foreach($categories AS $cat){
                u::insertSimpleRow([
                    'title'=> $cat->nodeValue,
                    'link'=> $cat->getAttribute('href'),
                    'group'=> $subject_name,
                    'level'=> $i
                ],'data_category');
            }
            echo $subject_name."/";
        }   
        return "ok";
    }
    public function getSubject($cat_info){
        // questions
        $url = $cat_info->link;
        $data=file_get_contents($url);
        $doc = new DOMDocument();                        
        $doc->loadHTML($data,LIBXML_NOERROR);
        $content = $doc->getElementById('accordionExample');
        $div_nodes=$this->getElementsByClass($content, 'div', 'block-content-body');
        $subjects_name = "";
        foreach($div_nodes AS $sub_node_1){
            if($sub_node_1->nodeName=='div'){
                foreach($sub_node_1->childNodes AS $sub_node_2){
                    if($sub_node_2->nodeName=='h3'){
                        $subjects_name = $sub_node_2->nodeValue;
                    }else if($sub_node_2->nodeName=='h2'){
                        $subjects_name = $sub_node_2->nodeValue;
                    }else if($sub_node_2->nodeName=='p'){
                        $list_a = $sub_node_2->getElementsByTagName('a');
                        foreach($list_a AS $a){
                            u::insertSimpleRow([
                                'title'=> $a->nodeValue,
                                'link'=> $a->getAttribute('href'),
                                'group'=> $subjects_name,
                                'cat_id'=> $cat_info->id
                            ],'data_subject');
                        }
                    }else if($sub_node_2->nodeName=='a'){
                        u::insertSimpleRow([
                            'title'=> $sub_node_2->nodeValue,
                            'link'=> $sub_node_2->getAttribute('href'),
                            'group'=> $subjects_name,
                            'cat_id'=> $cat_info->id
                        ],'data_subject');
                    }elseif($sub_node_2->nodeName=='div'){
                        foreach($sub_node_2->childNodes AS $sub_node_3){
                            if($sub_node_3->nodeName=='h3'){
                                $subjects_name = $sub_node_3->nodeValue;
                            }else if($sub_node_3->nodeName=='h2'){
                                $subjects_name = $sub_node_3->nodeValue;
                            }else if($sub_node_3->nodeName=='p'){
                                $list_a = $sub_node_3->getElementsByTagName('a');
                                foreach($list_a AS $a){
                                    u::insertSimpleRow([
                                        'title'=> $a->nodeValue,
                                        'link'=> $a->getAttribute('href'),
                                        'group'=> $subjects_name,
                                        'cat_id'=> $cat_info->id
                                    ],'data_subject');
                                }
                            }else if($sub_node_3->nodeName=='a'){
                                u::insertSimpleRow([
                                    'title'=> $sub_node_3->nodeValue,
                                    'link'=> $sub_node_3->getAttribute('href'),
                                    'group'=> $subjects_name,
                                    'cat_id'=> $cat_info->id
                                ],'data_subject');
                            }elseif($sub_node_3->nodeName=='div'){
                                foreach($sub_node_3->childNodes AS $sub_node_4){
                                    if($sub_node_4->nodeName=='h3'){
                                        $subjects_name = $sub_node_4->nodeValue;
                                    }else if($sub_node_4->nodeName=='h2'){
                                        $subjects_name = $sub_node_4->nodeValue;
                                    }else if($sub_node_4->nodeName=='p'){
                                        $list_a = $sub_node_4->getElementsByTagName('a');
                                        foreach($list_a AS $a){
                                            u::insertSimpleRow([
                                                'title'=> $a->nodeValue,
                                                'link'=> $a->getAttribute('href'),
                                                'group'=> $subjects_name,
                                                'cat_id'=> $cat_info->id
                                            ],'data_subject');
                                        }
                                    }else if($sub_node_4->nodeName=='a'){
                                        u::insertSimpleRow([
                                            'title'=> $sub_node_4->nodeValue,
                                            'link'=> $sub_node_4->getAttribute('href'),
                                            'group'=> $subjects_name,
                                            'cat_id'=> $cat_info->id
                                        ],'data_subject');
                                    }else if($sub_node_4->nodeName=='div'){
                                        foreach($sub_node_4->childNodes AS $sub_node_5){
                                            if($sub_node_5->nodeName=='h3'){
                                                $subjects_name = $sub_node_5->nodeValue;
                                            }else if($sub_node_5->nodeName=='h2'){
                                                $subjects_name = $sub_node_5->nodeValue;
                                            }else if($sub_node_5->nodeName=='p'){
                                                $list_a = $sub_node_5->getElementsByTagName('a');
                                                foreach($list_a AS $a){
                                                    u::insertSimpleRow([
                                                        'title'=> $a->nodeValue,
                                                        'link'=> $a->getAttribute('href'),
                                                        'group'=> $subjects_name,
                                                        'cat_id'=> $cat_info->id
                                                    ],'data_subject');
                                                }
                                            }else if($sub_node_5->nodeName=='a'){
                                                u::insertSimpleRow([
                                                    'title'=> $sub_node_5->nodeValue,
                                                    'link'=> $sub_node_5->getAttribute('href'),
                                                    'group'=> $subjects_name,
                                                    'cat_id'=> $cat_info->id
                                                ],'data_subject');
                                            }else if($sub_node_5->nodeName=='div'){
                                                foreach($sub_node_5->childNodes AS $sub_node_6){
                                                    if($sub_node_6->nodeName=='h3'){
                                                        $subjects_name = $sub_node_6->nodeValue;
                                                    }else if($sub_node_6->nodeName=='h2'){
                                                        $subjects_name = $sub_node_6->nodeValue;
                                                    }else if($sub_node_6->nodeName=='p'){
                                                        $list_a = $sub_node_6->getElementsByTagName('a');
                                                        foreach($list_a AS $a){
                                                            u::insertSimpleRow([
                                                                'title'=> $a->nodeValue,
                                                                'link'=> $a->getAttribute('href'),
                                                                'group'=> $subjects_name,
                                                                'cat_id'=> $cat_info->id
                                                            ],'data_subject');
                                                        }
                                                    }else if($sub_node_6->nodeName=='a'){
                                                        u::insertSimpleRow([
                                                            'title'=> $sub_node_6->nodeValue,
                                                            'link'=> $sub_node_6->getAttribute('href'),
                                                            'group'=> $subjects_name,
                                                            'cat_id'=> $cat_info->id
                                                        ],'data_subject');
                                                    }else if($sub_node_6->nodeName=='div'){
                                                        foreach($sub_node_6->childNodes AS $sub_node_7){
                                                            if($sub_node_7->nodeName=='h3'){
                                                                $subjects_name = $sub_node_7->nodeValue;
                                                            }else if($sub_node_7->nodeName=='h2'){
                                                                $subjects_name = $sub_node_7->nodeValue;
                                                            }else if($sub_node_7->nodeName=='p'){
                                                                $list_a = $sub_node_7->getElementsByTagName('a');
                                                                foreach($list_a AS $a){
                                                                    u::insertSimpleRow([
                                                                        'title'=> $a->nodeValue,
                                                                        'link'=> $a->getAttribute('href'),
                                                                        'group'=> $subjects_name,
                                                                        'cat_id'=> $cat_info->id
                                                                    ],'data_subject');
                                                                }
                                                            }else if($sub_node_7->nodeName=='a'){
                                                                u::insertSimpleRow([
                                                                    'title'=> $sub_node_7->nodeValue,
                                                                    'link'=> $sub_node_7->getAttribute('href'),
                                                                    'group'=> $subjects_name,
                                                                    'cat_id'=> $cat_info->id
                                                                ],'data_subject');
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        
        u::updateSimpleRow(['status'=>1],['id'=> $cat_info->id],'data_category');
    }
    public function getSubject2($cat_info){
        // questions
        $url = $cat_info->link;
        $data=file_get_contents($url);
        $doc = new DOMDocument();                        
        $doc->loadHTML($data,LIBXML_NOERROR);
        $content = $doc->getElementById('accordionExample');
        $div_nodes=$this->getElementsByClass($content, 'div', 'block-content-body');
        $subjects_name = "";
        foreach($div_nodes AS $sub_node_1){
            if($sub_node_1->nodeName=='div'){
                foreach($sub_node_1->childNodes AS $sub_node_2){
                    if($sub_node_2->nodeName=='h3'){
                        $subjects_name = $sub_node_2->nodeValue;
                    }else if($sub_node_2->nodeName=='h2'){
                        $subjects_name = $sub_node_2->nodeValue;
                    }elseif($sub_node_2->nodeName=='div'){
                        $list_a = $sub_node_2->getElementsByTagName('a');
                        foreach($list_a AS $a){
                            u::insertSimpleRow([
                                'title'=> $a->nodeValue,
                                'link'=> $a->getAttribute('href'),
                                'group'=> $subjects_name,
                                'cat_id'=> $cat_info->id
                            ],'data_subject');
                        }
                    }
                }
            }
        }
        
        u::updateSimpleRow(['status'=>1],['id'=> $cat_info->id],'data_category');
    }

    public function getContentType1($subject){
        try{
            $url = $subject->link;
            $data=file_get_contents($url);
            $doc = new DOMDocument();                        
            $doc->loadHTML($data,LIBXML_NOERROR);
            $noi_dung = $doc->getElementById('accordionExample');
            $noi_dung = $doc->saveHTML( $noi_dung );
            $mota="";
            foreach ($doc->getElementsByTagName('meta') as $meta) 
            {
                if ($meta->getAttribute('name') == 'description') {
                    $mota =  $meta->getAttribute('content');
                }
            }

            //questions
            $view_content = $this->getElementsByClass($doc,'div','view-content');
            if(isset($view_content[0])){
                $list_a = $view_content[0]->getElementsByTagName('a');
                $i=0;
                foreach($list_a AS $a){
                    $i++;
                    $a_url = $a->getAttribute('href');
                    if((strpos($a_url,'http://')===false && strpos($a_url,'http://')===false) || strpos($a_url,'https://tech12h.com')!==false){
                        if(strpos($a_url,'https://tech12h.com') ===false){
                            $a_url = 'https://tech12h.com'.$a_url;
                        }
                        $data_a=file_get_contents($a_url);
                        $doc_a = new DOMDocument();                        
                        $doc_a->loadHTML($data_a,LIBXML_NOERROR);
                        $noidung_a = $this->getElementsByClass($doc_a,'div','trac_nghiem');
                        $tmp_noidung = "";
                        foreach($noidung_a[0]->childNodes AS $nd){
                            if($nd->nodeName =="p"){
                                $tmp_noidung.=$doc_a->saveHTML($nd);
                            }
                        }
                        $tra_loi = $doc_a->getElementById('accordionExample');
                        $tra_loi = $doc_a->saveHTML($tra_loi);
                        u::insertSimpleRow([
                            'subject_id'=> $subject->id,
                            'noi_dung'=> $tmp_noidung,
                            'tra_loi'=> $tra_loi,
                            'stt'=> $i
                        ],'data_question');
                    }
                }
            }
            u::updateSimpleRow(['mo_ta'=>$mota,'noi_dung'=>$noi_dung,'status'=>1],['id'=> $subject->id],'data_subject');
        }catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        

    }
    public function getContentType2($subject){
        try{
            $url = $subject->link;
            $data=file_get_contents($url);
            $doc = new DOMDocument();                        
            $doc->loadHTML($data,LIBXML_NOERROR);
            $noi_dung = $doc->getElementById('accordionExample');
            $mota="";
            foreach ($doc->getElementsByTagName('meta') as $meta) 
            {
                if ($meta->getAttribute('name') == 'description') {
                    $mota =  $meta->getAttribute('content');
                }
            }
            $noidung ="";
            $i=0;
            foreach($noi_dung->childNodes AS $child){
                if($child->nodeName == "p"){
                    $noidung.= $doc->saveHTML($child);
                }elseif($child->nodeName == "ul"){
                    $i++;
                    $answer =[];
                    $list_li = $child->getElementsByTagName('li');
                    foreach($list_li AS $li){
                        $is_correct = 0;
                        if(count($li->getElementsByTagName('h6'))){
                            $is_correct = 1;
                        }
                        $text_option = $doc->saveHTML($li);
                        $text_option = str_replace(['<h6>','</h6>','A. ','B. ','C. ','D. '],'',$text_option);
                        $answer[] = [
                            'content'=>$text_option,
                            'is_correct'=>$is_correct,
                        ];
                    }
                    u::insertSimpleRow([
                        'subject_id'=> $subject->id,
                        'noi_dung'=> $noidung,
                        'tra_loi'=> json_encode($answer),
                        'stt'=> $i,
                        'type'=>1
                    ],'data_question');
                    $noidung ="";
                }
            }
            u::updateSimpleRow(['mo_ta'=>$mota,'status'=>1],['id'=> $subject->id],'data_subject');
        }catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        

    }

    public function updateImgSubject($subject_info){
        //1296
        // try{
            preg_match_all( '@src="([^"]+)"@' , $subject_info->noi_dung, $match );
            $src = array_pop($match);
            $noi_dung = $subject_info->noi_dung;
            foreach($src AS $row){
                if(strpos($row,'images/loigiai')===false){
                    $row_t = explode("?",$row);
                    $url = $row_t[0];
                    if(!strpos($row,'https://tech12h.com') !==false){
                        $url = 'https://tech12h.com'.$url;
                    }
                    try{
                    $content = file_get_contents($url);
                    $file_name = self::getNameFile($url);
                    $new_file_name = "subject_".$subject_info->id."_".$file_name['file_name'].".".$file_name['file_ext'];
                    file_put_contents(__DIR__."/../../../../public/images/loigiai/".$new_file_name, $content);
                    $noi_dung=str_replace($row,'/images/loigiai/'.$new_file_name,$noi_dung);
                    }catch (Exception $e) {
                        echo 'Caught exception: ',  $e->getMessage(), "\n";
                    }
                }
            }
            u::updateSimpleRow(['noi_dung'=>$noi_dung,'update_img'=>1],['id'=>$subject_info->id],'data_subject');
        // }catch (Exception $e) {
        //     echo 'Caught exception: ',  $e->getMessage(), "\n";
        // }
    }

    public static function getNameFile($url){
        $arr_url =  explode('/',$url);
        $file_name = $arr_url[count($arr_url)-1];
        $arr_file_name =  explode('.',$file_name);
        $data = [
            'file_ext'=>$arr_file_name[count($arr_file_name)-1],
            'file_name'=> str_replace(".".$arr_file_name[count($arr_file_name)-1],"",$file_name)
        ];
        return $data;
    }

    public function updateImgQuestionType0($ques_info){
        // try{
            preg_match_all( '@src="([^"]+)"@' , $ques_info->noi_dung, $match );
            $src = array_pop($match);
            $noi_dung = $ques_info->noi_dung;
            foreach($src AS $row){
                if(strpos($row,'images/question')===false && strpos($row,'data:image/png;base64')===false){
                    $row_t = explode("?",$row);
                    $url = $row_t[0];
                    if(!strpos($row,'https://tech12h.com') !==false && strpos($row,'https')===false && strpos($row,'http')===false){
                        $url = 'https://tech12h.com'.$url;
                    }
                    try{
                        $content = file_get_contents($url);
                        $file_name = self::getNameFile($url);
                        $new_file_name = "question_".$ques_info->id."_".$file_name['file_name'].".".$file_name['file_ext'];
                        file_put_contents(__DIR__."/../../../../public/images/question/".$new_file_name, $content);
                        $noi_dung=str_replace($row,'/images/question/'.$new_file_name,$noi_dung);
                    }catch (Exception $e) {
                        echo 'Caught exception: ',  $e->getMessage(), "\n";
                    }
                }
            }

            preg_match_all( '@src="([^"]+)"@' , $ques_info->tra_loi, $match );
            $src_tr = array_pop($match);
            $tra_loi = $ques_info->tra_loi;
            foreach($src_tr AS $row){
                if(strpos($row,'images/question')===false && strpos($row,'data:image/png;base64')===false){
                    $row_t = explode("?",$row);
                    $url = $row_t[0];
                    if(!strpos($row,'https://tech12h.com') !==false  && strpos($row,'https')===false && strpos($row,'http')===false){
                        $url = 'https://tech12h.com'.$url;
                    }
                    try{
                        $content = file_get_contents($url);
                        $file_name = self::getNameFile($url);
                        $new_file_name = "question_".$ques_info->id."_".$file_name['file_name'].".".$file_name['file_ext'];
                        file_put_contents(__DIR__."/../../../../public/images/question/".$new_file_name, $content);
                        $tra_loi=str_replace($row,'/images/question/'.$new_file_name,$tra_loi);
                    }catch (Exception $e) {
                        echo 'Caught exception: ',  $e->getMessage(), "\n";
                    }
                }
            }

            u::updateSimpleRow(['noi_dung'=>$noi_dung,'tra_loi'=>$tra_loi,'update_img'=>1],['id'=>$ques_info->id],'data_question');
        // }catch (Exception $e) {
        //     echo 'Caught exception: ',  $e->getMessage(), "\n";
        // }
    }

    public function updateImgQuestionType1($ques_info){
        try{
            preg_match_all( '@src="([^"]+)"@' , $ques_info->noi_dung, $match );
            $src = array_pop($match);
            $noi_dung = $ques_info->noi_dung;
            foreach($src AS $row){
                if(strpos($row,'images/question')===false){
                    $row_t = explode("?",$row);
                    $url = $row_t[0];
                    if(!strpos($row,'https://tech12h.com') !==false  && strpos($row,'https')===false && strpos($row,'http')===false){
                        $url = 'https://tech12h.com'.$url;
                    }
                    $content = file_get_contents($url);
                    $file_name = self::getNameFile($url);
                    $new_file_name = "question_".$ques_info->id."_".$file_name['file_name'].".".$file_name['file_ext'];
                    file_put_contents(__DIR__."/../../../../public/images/question/".$new_file_name, $content);
                    $noi_dung=str_replace($row,'/images/question/'.$new_file_name,$noi_dung);
                }
            }

            $tra_loi = json_decode($ques_info->tra_loi,true);
            foreach($tra_loi AS $k=>$row){
                $ques_content = $row['content'];
                preg_match_all( '@src="([^"]+)"@' , $row['content'], $match );
                $src_tr = array_pop($match);
                foreach($src_tr AS $row){
                    if(strpos($row,'images/question')===false){
                        $row_t = explode("?",$row);
                        $url = $row_t[0];
                        if(!strpos($row,'https://tech12h.com') !==false  && strpos($row,'https')===false && strpos($row,'http')===false){
                            $url = 'https://tech12h.com'.$url;
                        }
                        $content = file_get_contents($url);
                        $file_name = self::getNameFile($url);
                        $new_file_name = "subject_".$ques_info->id."_".$file_name['file_name'].".".$file_name['file_ext'];
                        file_put_contents(__DIR__."/../../../../public/images/question/".$new_file_name, $content);
                        $ques_content=str_replace($row,'/images/question/'.$new_file_name,$ques_content);
                    }
                }
                $tra_loi[$k]['content']=$ques_content;
            }
            

            u::updateSimpleRow(['noi_dung'=>$noi_dung,'tra_loi'=>json_encode($tra_loi),'update_img'=>1],['id'=>$ques_info->id],'data_question');
        }catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}
