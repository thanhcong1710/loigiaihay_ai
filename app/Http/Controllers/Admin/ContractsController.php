<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\UtilityServiceProvider as u;

class ContractsController extends Controller
{
    public function list(Request $request)
    {
        $keyword = isset($request->keyword) ? $request->keyword : '';
        $page = isset($request->page) ? (int) $request->page : 1;
        $limit = isset($request->limit) ? (int) $request->limit : 20;
        $offset = $page == 1 ? 0 : $limit * ($page - 1);
        $limitation =  $limit > 0 ? " LIMIT $offset, $limit" : "";
        $cond = " 1 ";
        if ($keyword !== '') {
            $cond .= " AND (s.name LIKE '%$keyword%' OR s.crm_id LIKE '%$keyword%')";
        }
        $total = u::first("SELECT count(c.id) AS total FROM contracts AS c LEFT JOIN students AS s ON s.id=c.student_id WHERE $cond ");
        $list = u::query("SELECT s.id, s.name, s.crm_id, c.accounting_id AS contract_code,
                IF(c.type=0,'Học thử', 'Chính thức') AS type_name,
                c.start_date, 
                (SELECT name FROM branches WHERE id=c.branch_id) AS branch_name,
                (SELECT CONCAT(full_name,' - ',hrm_id) FROM users WHERE id=c.cm_id) AS cm_name,
                (SELECT CONCAT(full_name,' - ',hrm_id) FROM users WHERE id=c.ec_id) AS ec_name,
                (SELECT name FROM tuition_fee WHERE id=c.tuition_fee_id) AS tuition_fee_name,
                (SELECT price FROM tuition_fee WHERE id=c.tuition_fee_id) AS tuition_fee_price,
                c.must_charge, c.debt_amount, c.total_sessions, c.bonus_sessions
            FROM contracts AS c LEFT JOIN students AS s ON s.id=c.student_id 
            WHERE $cond ORDER BY c.id DESC $limitation");
        return view('admin.operate.contracts.list', [
            'list' => $list,
            'total' => $total->total,
            'page' => $page,
            'limit' => $limit,
            'keyword' => $keyword,
            'url'=>route('admin.operate.contracts.list')
        ]);
    }
    public function add(Request $request){
        $branches = u::query("SELECT * FROM branches WHERE status=1");
        $products = u::query("SELECT * FROM products WHERE status=1");
        $shifts = u::query("SELECT * FROM shifts WHERE status=1");
        return view('admin.operate.contracts.add',[
            'branches'=>$branches,
            'products'=>$products,
            'shifts'=>$shifts
        ]);
    }
    public function searchStudent(Request $request){
        $students = u::query("SELECT s.id AS student_id,CONCAT(s.name,' - ',s.crm_id) AS label FROM students AS s 
            WHERE s.branch_id = $request->branch_id AND (s.name LIKE '%$request->q%' OR s.crm_id LIKE '%$request->q%') LIMIT 10");
        return json_encode($students);
    }
    public function getStudentInfo(Request $request){
        $student_info = u::first("SELECT s.id,s.name,s.crm_id,s.gud_name1,
            gud_mobile1,gud_email1,`address`,school,
            (SELECT name FROM branches WHERE id=s.branch_id) AS branch_name,
            (SELECT CONCAT(full_name,' - ',hrm_id) FROM users WHERE id=t.ec_id LIMIT 1) AS ec_name,
            (SELECT CONCAT(full_name,' - ',hrm_id) FROM users WHERE id=t.ec_leader_id LIMIT 1) AS ecl_name,
            (SELECT CONCAT(full_name,' - ',hrm_id) FROM users WHERE id=t.ceo_branch_id LIMIT 1) AS gdtt
        FROM students AS s 
            LEFT JOIN term_student_user AS t ON s.id=t.student_id
        WHERE s.id=$request->student_id");
        return json_encode($student_info);
    }
    public function getListTuitionFee(Request $request){
        $product_id = (int)$request->product_id;
        $branch_id = (int)$request->branch_id;
        $tuition_fees = u::query("SELECT t.id,t.name,t.price,t.session,t.receivable
                FROM tuition_fee AS t 
            WHERE t.product_id=$product_id AND t.status=1 AND t.expired_date >= CURRENT_DATE AND t.available_date<= CURRENT_DATE
                AND (t.branch_id LIKE '%,$branch_id,%' OR t.branch_id LIKE '%$branch_id,%' OR t.branch_id LIKE '%,$branch_id%' OR t.branch_id LIKE '%$branch_id%')");
        return json_encode($tuition_fees);
    }
    public function getTuitionFeeInfo(Request $request){
        $tuition_fees = u::first("SELECT t.id,t.name,t.price,t.session,t.receivable
                FROM tuition_fee AS t WHERE t.id=$request->tuition_fee_id");
        return json_encode($tuition_fees);
    }
    public function store(Request $request){
        $student_info = u::first("SELECT s.id,s.name,s.branch_id,t.ec_leader_id,t.ec_id,t.cm_id,t.om_id,t.ceo_branch_id, 
                (SELECT name FROM branches WHERE id=s.branch_id) AS branch_name,
                (SELECT full_name FROM users WHERE id=t.ec_id) AS ec_name
            FROM students AS s LEFT JOIN term_student_user AS t ON t.student_id=s.id WHERE s.id=$request->student_id");
        $tuition_fee_info = u::first("SELECT * FROM tuition_fee WHERE id=$request->tuition_fee_id");
        $total_sessions =$tuition_fee_info->session;
        $holidays = u::getPublicHolidays(0, $student_info->branch_id, $request->product_id);
        $classdays = [2];
        $start_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->start_date)));
        $schedule = u::calculatorSessionsByNumberOfSessions($start_date, $total_sessions, $holidays, $classdays);
        $end_date = $schedule->end_date;

        $data = array(
            'code'=>u::apax_ada_gen_contract_code($student_info->name, $student_info->ec_name, $student_info->branch_name),
            'type'=>$request->contract_type,
            'student_id'=>$request->student_id,
            'branch_id'=>$student_info->branch_id,
            'ec_id'=>$student_info->ec_id,
            'ec_leader_id'=>$student_info->ec_leader_id,
            'cm_id'=>$student_info->cm_id,
            'om_id'=>$student_info->om_id,
            'ceo_branch_id'=>$student_info->ceo_branch_id,
            'product_id'=>$request->product_id,
            'tuition_fee_id'=>$request->tuition_fee_id,
            'receivable'=>$tuition_fee_info->receivable,
            'tuition_fee_price'=>$tuition_fee_info->price,
            'must_charge'=>$request->must_charge,
            'total_discount'=>0,
            'description'=>'',
            'start_date'=>$start_date,
            'end_date'=>$end_date,
            'total_sessions'=>$tuition_fee_info->session,
            'real_sessions'=>$tuition_fee_info->session,
            'status'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'creator_id'=>Auth::guard('admin')->user()->id,
            'note'=>$request->note,
            'shift'=>$request->shift,
            'bonus_sessions'=>0,
            'summary_sessions'=>0,
            'count_recharge'=>$request->contract_type == 0 ? -1 : 0
        );
        u::insertSimpleRow($data, 'contracts');
        return redirect(route('admin.operate.contracts.list'));
    }
}
