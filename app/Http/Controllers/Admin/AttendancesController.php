<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\UtilityServiceProvider as u;

class AttendancesController extends Controller
{
    public function detail(Request $request)
    {
        $branches = u::query("SELECT * FROM branches WHERE status=1");
        $semesters = u::query("SELECT * FROM semesters WHERE status=1");
        return view('admin.operate.attendances.detail', [
            'branches' => $branches,
            'semesters' => $semesters
        ]);
    }
    public function getListProgram(Request $request)
    {
        $data = u::query("SELECT pr.* 
                FROM programs as pr
                    LEFT JOIN branches as br ON pr.branch_id = br.id
                    LEFT JOIN term_program_product AS term ON term.program_id = pr.id
                WHERE pr.id > 0 AND br.id = $request->branch_id AND term.product_id=$request->product_id  AND pr.status=1
            ");
        return json_encode($data);
    }
    public function getListClass(Request $request)
    {
        $data = u::query("SELECT c.`cls_name` AS name,c.id AS id
                FROM classes AS c
            WHERE c.branch_id = $request->branch_id
                AND c.`program_id` = $request->program_id
                AND c.cls_iscancelled = 'no'
                AND c.`cls_enddate` > CURDATE()
                AND c.cm_id IS NOT NULL
                AND c.teacher_id IS NOT NULL");
        return json_encode($data);
    }
    public function getStudent(Request $request)
    {
        $data = u::query("SELECT s.id, s.crm_id, s.name
                FROM contracts AS c LEFT JOIN students AS s ON s.id=c.student_id
            WHERE c.class_id = $request->class_id
                AND c.`status` != 7
                AND c.enrolment_last_date >= CURRENT_DATE");
        return json_encode($data);
    }
}
