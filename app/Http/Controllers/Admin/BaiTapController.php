<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\UtilityServiceProvider as u;

class BaiTapController extends Controller
{
    public function question(Request $request)
    {
        $subject_id=223;
        $subject_info=u::first("SELECT * FROM data_subject WHERE id= $subject_id");
        $ques_curr_stt = $subject_info ? $subject_info->ques_curr_stt : 0;
        $question_info = u::first("SELECT * FROM data_question WHERE subject_id = $subject_id AND stt> $ques_curr_stt");
        return view('admin.baitap.index',[
            'subject_info' => $subject_info,
            'question_info' => $question_info
        ]);
    }
}
