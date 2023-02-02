<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\UtilityServiceProvider as u;
use DOMDocument;
use Exception;
use GuzzleHttp\Client;

class CrawlVietjackController extends Controller
{
    public function getSubject(){
        $grade='CNTT';
        $link="https://vietjack.com/index.jsp";
        $data=file_get_contents($link);
        $doc = new DOMDocument();                        
        $doc->loadHTML($data,LIBXML_NOERROR);
        $content = $doc->getElementById('collapseThirteen');
        $div_nodes=$this->getElementsByClass($content, 'div', 'col-md-3');
        foreach($div_nodes AS $div){
            $subjects = $div->getElementsByTagName('h4');
            $subject_name = $subjects[0]->nodeValue;
            $list_a = $div->getElementsByTagName('a');
            for($i=0;$i< count($list_a); $i++){
                u::insertSimpleRow([
                    'title'=> $list_a[$i]->nodeValue,
                    'subject_name'=> $subject_name,
                    'grade'=> $grade,
                    'link'=> str_replace('./','https://vietjack.com/',$list_a[$i]->getAttribute('href'))
                ],'vietjack_chapter');
            }
        }
        dd("ok");
    }
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
    public function getSubSubject($chapter_id){
        $chapter_info = u::first("SELECT * FROM vietjack_chapter WHERE id=$chapter_id");
        $link=$chapter_info->link;
        $data=file_get_contents($link);
        $doc = new DOMDocument();                        
        $doc->loadHTML($data,LIBXML_NOERROR);
        // $content = $doc->getElementById('collapseThirteen');
        $vj__list=$this->getElementsByClass($doc, 'div', 'vj__list');
        foreach($vj__list AS $vj){
            $div_node_sub=$this->getElementsByClass($vj, 'div', 'col-md-6');
            foreach($div_node_sub AS $node){
                $h3 = $node->getElementsByTagName('h3');
                if(count($h3)==0){
                    $uls = $node->getElementsByTagName('ul');
                    foreach($uls AS $ul){
                        $lis = $ul->getElementsByTagName('li');
                        foreach($lis AS $li){
                            $a=$li->getElementsByTagName('a');
                            if(method_exists($a[0],'getElementsByTagName')){
                                $b=$a[0]->getElementsByTagName('b');
                                if(isset($b[0])){
                                    u::insertSimpleRow([
                                        'title'=> $b[0]->nodeValue,
                                        'subject_name'=> $chapter_info->subject_name,
                                        'grade'=> $chapter_info->grade,
                                        'link'=> str_replace(['./','../'],'https://vietjack.com/',$a[0]->getAttribute('href')),
                                        'parent_id'=>$chapter_info->id
                                    ],'vietjack_chapter');
                                }
                            }
                        }
                    }
                }elseif(count($h3)==1 || count($h3)==2 || (count($h3)==3 && count($h3[0]->getElementsByTagName('b'))) ){
                    $uls = $node->getElementsByTagName('ul');
                    foreach($uls AS $ku=> $ul){
                        $sub_parent_master = '';
                        if(count($h3[0]->getElementsByTagName('b'))){
                            if(isset($h3[$ku])){
                                $hb = $h3[$ku]->getElementsByTagName('b');
                                $sub_parent = isset($hb[0]->nodeValue) ? $hb[0]->nodeValue :'';
                            }else{
                                $hb = $h3[$ku-1]->getElementsByTagName('b');
                                $sub_parent = $hb[0]->nodeValue;
                            }
                        }else{
                            if(isset($h3[$ku+1])){
                                $hb = $h3[$ku+1]->getElementsByTagName('b');
                                if(isset($hb[0])){
                                    $sub_parent = $hb[0]->nodeValue;
                                    $sub_parent_master = $h3[0]->nodeValue;
                                }else{
                                    $sub_parent = '';
                                    $sub_parent_master = $h3[$ku]->nodeValue;
                                }
                            }else{
                                if(method_exists($h3[$ku],'getElementsByTagName')){
                                    $hb = $h3[$ku]->getElementsByTagName('b');
                                    if(isset($hb[0])){
                                        $sub_parent = $hb[0]->nodeValue;
                                        $sub_parent_master = $h3[0]->nodeValue;
                                    }else{
                                        $sub_parent = '';
                                        $sub_parent_master = $h3[$ku]->nodeValue;
                                    }
                                }else{
                                    $sub_parent = '';
                                    $sub_parent_master = isset($h3[$ku]->nodeValue) ? $h3[$ku]->nodeValue :'';
                                }
                            }
                        }
                        $lis = $ul->getElementsByTagName('li');
                        foreach($lis AS $li){
                            $a=$li->getElementsByTagName('a');
                            $b=$a[0]->getElementsByTagName('b');
                            u::insertSimpleRow([
                                'title'=> $b[0]->nodeValue,
                                'subject_name'=> $chapter_info->subject_name,
                                'grade'=> $chapter_info->grade,
                                'link'=> str_replace(['./','../'],'https://vietjack.com/',$a[0]->getAttribute('href')),
                                'parent_id'=>$chapter_info->id,
                                'sub_parent'=>$sub_parent,
                                'sub_parent_master'=>$sub_parent_master
                            ],'vietjack_chapter');
                        }
                    }
                }elseif(count($h3)==3 && !count($h3[0]->getElementsByTagName('b'))){
                    $uls = $node->getElementsByTagName('ul');
                    $sub_parent_master = $h3[0]->nodeValue;
                    foreach($uls AS $ku=> $ul){
                        if(isset($h3[$ku+1])){
                            $hb = $h3[$ku+1]->getElementsByTagName('b');
                            if(isset($hb[0])){
                                $sub_parent = $hb[0]->nodeValue;
                            }else{
                                $sub_parent = '';
                                $sub_parent_master = $h3[$ku]->nodeValue;
                            }
                        }else{
                            $hb = $h3[$ku]->getElementsByTagName('b');
                            if(isset($hb[0])){
                                $sub_parent = $hb[0]->nodeValue;
                            }else{
                                $sub_parent = '';
                                $sub_parent_master = $h3[$ku]->nodeValue;
                            }
                        }

                        $lis = $ul->getElementsByTagName('li');
                        foreach($lis AS $li){
                            $a=$li->getElementsByTagName('a');
                            $b=$a[0]->getElementsByTagName('b');
                            u::insertSimpleRow([
                                'title'=> $b[0]->nodeValue,
                                'subject_name'=> $chapter_info->subject_name,
                                'grade'=> $chapter_info->grade,
                                'link'=> str_replace(['./','../'],'https://vietjack.com/',$a[0]->getAttribute('href')),
                                'parent_id'=>$chapter_info->id,
                                'sub_parent'=>$sub_parent,
                                'sub_parent_master'=>$sub_parent_master
                            ],'vietjack_chapter');
                        }
                    }
                }else{
                    $uls = $node->getElementsByTagName('ul');
                    foreach($uls AS $ul){
                        $lis = $ul->getElementsByTagName('li');
                        foreach($lis AS $li){
                            $a=$li->getElementsByTagName('a');
                            $b=$a[0]->getElementsByTagName('b');
                            if(isset($b[0])){
                                u::insertSimpleRow([
                                    'title'=> $b[0]->nodeValue,
                                    'subject_name'=> $chapter_info->subject_name,
                                    'grade'=> $chapter_info->grade,
                                    'link'=> str_replace(['./','../'],'https://vietjack.com/',$a[0]->getAttribute('href')),
                                    'parent_id'=>$chapter_info->id
                                ],'vietjack_chapter');
                            }
                        }
                    }
                }
            }
        }
        // dd("ok");
    }
    public function getSubSubject2($chapter_id){
        $chapter_info = u::first("SELECT * FROM vietjack_chapter WHERE id=$chapter_id");
        $link=$chapter_info->link;
        $data=file_get_contents($link);
        $doc = new DOMDocument();                        
        $doc->loadHTML($data,LIBXML_NOERROR);
        // $content = $doc->getElementById('collapseThirteen');
        // $vj__list=$this->getElementsByClass($doc, 'div', 'vj__list');
        // foreach($vj__list AS $vj){
            $div_node_sub=$this->getElementsByClass($doc, 'div', 'col-md-7');
            foreach($div_node_sub AS $node){
                $uls = $node->getElementsByTagName('ul');
                foreach($uls AS $ul){
                    $lis = $ul->getElementsByTagName('li');
                    foreach($lis AS $li){
                        $a=$li->getElementsByTagName('a');
                        if(method_exists($a[0],'getElementsByTagName')){
                            $b=$a[0]->getElementsByTagName('b');
                            if(isset($b[0])){
                                u::insertSimpleRow([
                                    'title'=> $b[0]->nodeValue,
                                    'subject_name'=> $chapter_info->subject_name,
                                    'grade'=> $chapter_info->grade,
                                    'link'=> str_replace(['./','../'],'https://vietjack.com/',$a[0]->getAttribute('href')),
                                    'parent_id'=>$chapter_info->id
                                ],'vietjack_chapter');
                            }
                        }
                    }
                }
            }
        // }
        // dd("ok");
    }
    public function getContentChapter($chapter_id){
        $chapter_info = u::first("SELECT * FROM vietjack_chapter WHERE id=$chapter_id");
        $link=$chapter_info->link;
        $data=file_get_contents($link);
        dd($data);
        dd(strpos($data,'<div class="ads_ads ads_1"'));
        dd(strpos($data,'<p>Xem thêm các bài giải'));
        // u::updateSimpleRow(['content'=>$html],['id'=>$chapter_id],'vietjack_chapter');
    }
}
