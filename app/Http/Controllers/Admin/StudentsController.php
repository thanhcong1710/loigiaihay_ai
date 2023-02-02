<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\UtilityServiceProvider as u;

class StudentsController extends Controller
{
    public function list(Request $request)
    {
        if(Auth::guard('admin')->user()->is_parent){
            $students=u::query("SELECT s.*,
                    (SELECT name FROM branches WHERE id=s.branch_id) AS branch_name,
                    (SELECT cl.cls_name FROM contracts AS c LEFT JOIN classes AS cl ON cl.id=c.class_id WHERE c.student_id=s.id AND c.status!=7 AND c.class_id IS NOT NULL LIMIT 1) AS class_name
                FROM students AS s 
                WHERE s.status=1 AND s.gud_mobile1=".Auth::guard('admin')->user()->phone);
            foreach($students AS $k=>$student){
                if ($student->avatar) {
                    $students[$k]->avatar = config('app.url') . "/" . $student->avatar;
                } elseif ($student->gender == "M") {
                    $students[$k]->avatar = config('app.url') . '/assets/media/svg/avatars/001-boy.svg';
                } else {
                    $students[$k]->avatar = config('app.url') . '/assets/media/svg/avatars/006-girl-3.svg';
                }
            }
            return view('admin.parents.list', [
                'students' => $students
            ]);
        }else{
            $keyword = isset($request->keyword) ? $request->keyword : '';
            $page = isset($request->page) ? (int) $request->page : 1;
            $limit = isset($request->limit) ? (int) $request->limit : 20;
            $offset = $page == 1 ? 0 : $limit * ($page - 1);
            $limitation =  $limit > 0 ? " LIMIT $offset, $limit" : "";
            $cond = " 1 ";
            if ($keyword !== '') {
                $cond .= " AND s.name LIKE '%$keyword%'";
            }
            $total = u::first("SELECT count(id) AS total FROM students AS s WHERE $cond ");
            $list = u::query("SELECT s.id, s.name, s.crm_id, s.date_of_birth, s.gud_name1, s.gud_mobile1, s.address,s.avatar,
                    IF(s.gender='F','Nữ','Nam') AS gender,
                    (SELECT name FROM branches WHERE id=s.branch_id) AS branch_name,
                    (SELECT name FROM term_student_user AS t LEFT JOIN users AS u ON u.id=t.ec_id WHERE t.student_id=s.id LIMIT 1) AS ec_name,
                    (SELECT name FROM sources WHERE id= s.source) AS source_name,
                    '' AS class_name,
                    '' AS student_status
                FROM students AS s WHERE $cond ORDER BY s.id DESC $limitation");
            return view('admin.students.list', [
                'list' => $list,
                'total' => $total->total,
                'page' => $page,
                'limit' => $limit,
                'keyword' => $keyword,
                'url'=>route('admin.students.list')
            ]);
        }
    }
    public function add(Request $request){
        $provinces = u::query("SELECT * FROM provinces");
        $school_grades = u::query("SELECT * FROM school_grades WHERE status=1");
        $sources = u::query("SELECT * FROM sources WHERE status=1");
        $jobs = u::query("SELECT * FROM jobs WHERE status=1");
        $branches = u::query("SELECT * FROM branches WHERE status=1");
        return view('admin.students.add',[
            'provinces'=>$provinces,
            'school_grades'=>$school_grades,
            'sources'=>$sources,
            'jobs'=>$jobs,
            'branches'=>$branches
        ]);
    }
    public function store(Request $request){
        $info = pathinfo($_FILES['avatar']['name']);
        $ext = $info['extension']; // get the extension of the file
        $newname = $info['filename']."_".time().".".$ext; 
        $target = 'uploads/avatar/'.$newname;
        move_uploaded_file( $_FILES['avatar']['tmp_name'], $target);
        $input = (object)$_POST;
        $data = [
            'avatar'=> 'uploads/avatar/'.$newname,
            'name'=>$input->name,
            'date_of_birth'=> $input->date_of_birth ? date('Y-m-d', strtotime(str_replace('/', '-', $input->date_of_birth))):null,
            'gender'=>$input->gender,
            'type'=>$input->type,
            'province_id'=>$input->province_id,
            'district_id'=>$input->district_id,
            'address'=>$input->address,
            'school_level'=>$input->school_level,
            'school'=>$input->school,
            'school_grade'=>$input->school_grade,
            'source'=>$input->source,
            'note'=>$input->note,
            'gud_name1'=>$input->gud_name1,
            'gud_mobile1'=>$input->gud_mobile1,
            'gud_email1'=>$input->gud_email1,
            'gud_birth_day1'=>$input->gud_birth_day1 ? date('Y-m-d', strtotime(str_replace('/', '-', $input->gud_birth_day1))):null,
            'gud_job1'=>$input->gud_job1,
            'gud_name2'=>$input->gud_name2,
            'gud_mobile2'=>$input->gud_mobile2,
            'gud_email2'=>$input->gud_email2,
            'gud_birth_day2'=>$input->gud_birth_day2 ? date('Y-m-d', strtotime(str_replace('/', '-', $input->gud_birth_day2))):null,
            'gud_job2'=>$input->gud_job2,
            'branch_id'=>$input->branch_id,
            'creator_id'=>Auth::guard('admin')->user()->id,
            'created_at'=>date('Y-m-d H:i:s'),
            'status'=>1,
        ];
        if(!$data['date_of_birth']) unset($data['date_of_birth']);
        if(!$data['gud_birth_day1']) unset($data['gud_birth_day1']);
        if(!$data['gud_birth_day2']) unset($data['gud_birth_day2']);
        $student_id=u::insertSimpleRow($data, 'students');
        $cms_id = str_pad((string)$student_id, 7, '0', STR_PAD_LEFT);
        $crm_id = "CMS$cms_id";
        u::updateSimpleRow(array('crm_id'=>$crm_id),array('id'=>$student_id),'students');
        u::insertSimpleRow([
            'student_id' => $student_id,
            'ec_id'=>$input->ec_id,
            'cm_id'=>$input->cm_id,
            'status'=>1,
            'branch_id'=>$input->branch_id,
            'created_at'=>date('Y-m-d H:i:s'),
        ], 'term_student_user');
        return redirect(route('admin.students.list'));
    }
    public function edit(Request $request,$student_id){
        $provinces = u::query("SELECT * FROM provinces");
        $school_grades = u::query("SELECT * FROM school_grades WHERE status=1");
        $sources = u::query("SELECT * FROM sources WHERE status=1");
        $jobs = u::query("SELECT * FROM jobs WHERE status=1");
        $branches = u::query("SELECT * FROM branches WHERE status=1");
        $student_info=u::first("SELECT s.*,t.cm_id,t.ec_id FROM students AS s LEFT JOIN term_student_user AS t ON t.student_id=s.id WHERE s.id=$student_id");
        return view('admin.students.edit',[
            'provinces'=>$provinces,
            'school_grades'=>$school_grades,
            'sources'=>$sources,
            'jobs'=>$jobs,
            'branches'=>$branches,
            'student_info'=>$student_info
        ]);
    }
    public function save(Request $request,$student_id){
        $input = (object)$_POST;
        $info = pathinfo($_FILES['avatar']['name']);
        $newname = '';
        if($info['filename']){
            $ext = $info['extension']; // get the extension of the file
            $newname = $info['filename']."_".time().".".$ext; 
            $target = 'uploads/avatar/'.$newname;
            move_uploaded_file( $_FILES['avatar']['tmp_name'], $target);
            $upload_avatar =1;
        }
        $data = [
            'avatar'=> 'uploads/avatar/'.$newname,
            'name'=>$input->name,
            'date_of_birth'=> $input->date_of_birth ? date('Y-m-d', strtotime(str_replace('/', '-', $input->date_of_birth))):null,
            'gender'=>$input->gender,
            'type'=>$input->type,
            'province_id'=>$input->province_id,
            'district_id'=>$input->district_id,
            'address'=>$input->address,
            'school_level'=>$input->school_level,
            'school'=>$input->school,
            'school_grade'=>$input->school_grade,
            'source'=>$input->source,
            'note'=>$input->note,
            'gud_name1'=>$input->gud_name1,
            'gud_mobile1'=>$input->gud_mobile1,
            'gud_email1'=>$input->gud_email1,
            'gud_birth_day1'=>$input->gud_birth_day1 ? date('Y-m-d', strtotime(str_replace('/', '-', $input->gud_birth_day1))):null,
            'gud_job1'=>(int)$input->gud_job1,
            'gud_name2'=>$input->gud_name2,
            'gud_mobile2'=>$input->gud_mobile2,
            'gud_email2'=>$input->gud_email2,
            'gud_birth_day2'=>$input->gud_birth_day2 ? date('Y-m-d', strtotime(str_replace('/', '-', $input->gud_birth_day2))):null,
            'gud_job2'=>(int)$input->gud_job2,
            'branch_id'=>$input->branch_id,
            'editor_id'=>Auth::guard('admin')->user()->id,
            'updated_at'=>date('Y-m-d H:i:s'),
            'status'=>1,
        ];
        if(!$newname) unset($data['avatar']);
        if(!$data['date_of_birth']) unset($data['date_of_birth']);
        if(!$data['gud_birth_day1']) unset($data['gud_birth_day1']);
        if(!$data['gud_birth_day2']) unset($data['gud_birth_day2']);
        $student_id=u::updateSimpleRow($data,['id'=>$student_id], 'students');
        u::updateSimpleRow([
            'ec_id'=>$input->ec_id,
            'cm_id'=>$input->cm_id,
            'branch_id'=>$input->branch_id,
            'updated_at'=>date('Y-m-d H:i:s'),
        ], ['id'=>$student_id],'term_student_user');
        return redirect(route('admin.students.list'));
    }
    public function detail(Request $request,$student_id){
        $student_info=u::first("SELECT s.*,t.cm_id,t.ec_id,
                (SELECT name FROM provinces WHERE id=s.province_id) AS province_name,
                (SELECT name FROM districts WHERE id=s.district_id) AS district_name,
                (SELECT name FROM school_grades WHERE id=s.school_grade) AS school_grade,
                (SELECT name FROM sources WHERE id=s.source) AS source_name,
                (SELECT name FROM jobs WHERE id=s.gud_job1) AS gud_job1,
                (SELECT name FROM jobs WHERE id=s.gud_job2) AS gud_job2,
                (SELECT name FROM branches WHERE id=s.branch_id) AS branch_name,
                (SELECT CONCAT(full_name,' - ',hrm_id) FROM users WHERE id=t.cm_id) AS cm_name,
                (SELECT CONCAT(full_name,' - ',hrm_id) FROM users WHERE id=t.ec_id) AS ec_name
            FROM students AS s LEFT JOIN term_student_user AS t ON t.student_id=s.id 
            WHERE s.id=$student_id");
        $head_info = u::first("SELECT s.id,s.name,s.gud_mobile1,s.gud_email1,s.crm_id FROM students AS s WHERE s.id =$student_id");
        return view('admin.students.detail',[
            'head_info'=>$head_info,
            'student_info'=>$student_info
        ]);
    }
}
