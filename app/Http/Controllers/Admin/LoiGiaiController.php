<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GptAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\UtilityServiceProvider as u;

class LoiGiaiController extends Controller
{
    public function level(Request $request, $level_id)
    {
        $list_category = u::query("SELECT c.*,m.title AS mon_hoc FROM data_category AS c LEFT JOIN data_mon_hoc AS m ON m.id=c.mon 
            WHERE c.status=1 AND c.level=$level_id AND c.type=1 ORDER BY m.stt");
        $list_mon_hoc = [];
        $mon_hoc ='';
        $tmp_arr =[];
        foreach($list_category AS $row){
            if($mon_hoc==''&& $row->mon_hoc!=''){
                $mon_hoc= $row->mon_hoc;
            }elseif($mon_hoc!=''&& $row->mon_hoc!=$mon_hoc){
                $list_mon_hoc[$mon_hoc]=$tmp_arr;
                $tmp_arr=[];
                $mon_hoc= $row->mon_hoc;
            }
            $tmp_arr[]=$row;
        }
        return view('admin.loigiai.level', [
            'list_mon_hoc' => $list_mon_hoc,
            'category_name' => "Lớp ".$level_id
        ]);
    }
    public function category(Request $request, $category_id)
    {
        $cat_info = u::first("SELECT * FROM data_category WHERE id= $category_id");
        $list_subject = u::query("SELECT * FROM data_subject WHERE status=1 AND cat_id=$category_id AND status=1");
        return view('admin.loigiai.category', [
            'list_subject' => $list_subject,
            'cat_info' => $cat_info
        ]);
    }
    public function subject(Request $request, $subject_id)
    {
        $subject_info = u::first("SELECT s.*, c.id AS cat_id,c.title AS cat_title, c.level AS cat_level FROM data_subject AS s LEFT JOIN data_category AS c ON c.id=s.cat_id WHERE s.id= $subject_id");
        $questions = u::query("SELECT * FROM data_question WHERE subject_id=$subject_id AND type=0 AND status=1");
        return view('admin.loigiai.subject', [
            'subject_info' => $subject_info,
            'questions' =>$questions,
            'meta_title'=>$subject_info->title,
            'meta_description'=>$subject_info->mo_ta
        ]);
    }
}
