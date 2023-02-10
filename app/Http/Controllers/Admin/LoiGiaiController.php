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
        $list_category = u::query("SELECT * FROM data_category WHERE status=1 AND level=$level_id AND type=1");
        return view('admin.loigiai.level', [
            'list_category' => $list_category,
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
        return view('admin.loigiai.subject', [
            'subject_info' => $subject_info
        ]);
    }
}
