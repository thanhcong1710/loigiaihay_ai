<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\UtilityServiceProvider as u;

class QuestionController extends Controller
{
    public function view(Request $request)
    {
        $question =u::first("SELECT * FROM vung_oi_question WHERE id=246");
        if($question->question_type == 1){
            $content  = json_decode($question->content);
            $solution_suggesstion = json_decode($question->solution_suggesstion);
            $answer = json_decode($question->answer);
            return view('admin.vungoi.question_1', [
                'content'=>$content,
                'solution_suggesstion'=>$solution_suggesstion,
                'answer'=>$answer
            ]);
        }
    }
}
