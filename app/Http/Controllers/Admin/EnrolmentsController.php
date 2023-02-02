<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\UtilityServiceProvider as u;

class EnrolmentsController extends Controller
{
    public function detail(Request $request)
    {
        $branches = u::query("SELECT * FROM branches WHERE status=1");
        $semesters = u::query("SELECT * FROM semesters WHERE status=1");
        return view('admin.operate.enrolments.detail', [
            'branches' => $branches,
            'semesters' => $semesters
        ]);
    }
    public function getListClass(Request $request)
    {
        $data = [];
        $programs = u::query("SELECT DISTINCT c.program_id, p.name
            FROM classes AS c INNER JOIN programs AS p ON c.program_id = p.id
            WHERE c.cls_iscancelled = 'no' AND p.status > 0 AND p.branch_id IN (0,$request->branch_id) AND p.semester_id = $request->semester_id AND DATE(c.cls_enddate) >= CURDATE()");
        foreach ($programs as $program) {
            $class = u::query("SELECT c.id, c.cls_name AS `text`,
                    IF(c.cm_id > 0, IF(c.status = 1, 'fa fa-file text-danger', 
                        IF((SELECT COUNT(u.id) FROM users u LEFT JOIN sessions s ON u.id = s.teacher_id WHERE u.status > 0 AND s.class_id = c.id) > 0, 'fa fa-file text-success', 'fa fa-file text-success')), 'fa fa-file text-danger') AS icon
            FROM classes AS c 
            WHERE c.cls_iscancelled = 'no' AND c.program_id = $program->program_id AND DATE(c.cls_enddate) >= CURDATE()");
            $data[] = (object)[
                'text' => $program->name,
                'icon' => "fa fa-folder",
                "state" => [
                    "opened" => true
                ],
                'children' => $class
            ];
        };
        return json_encode($data);
    }
    public function getClassInfo(Request $request)
    {
        $class_id = $request->class_id;
        $class_info = u::first("SELECT
              c.id,
              c.is_trial,
              c.id AS class_id,
              c.product_id,
              c.cls_name AS class_name,
              c.cls_startdate AS class_start_date,
              c.cls_enddate AS class_end_date,
              c.cls_iscancelled AS class_is_cancelled,
              c.max_students AS class_max_students,
              c.cm_id AS cm_id,
              u.status AS cm_status,
              CONCAT(u.full_name, ' - ', u.hrm_id) AS cm_name,
              (SELECT GROUP_CONCAT(CONCAT(s.id, '|', COALESCE(t.avatar, 'avatar.png'), '#', t.ins_name) SEPARATOR '@ ') FROM teachers AS t
                LEFT JOIN `sessions` AS s ON s.teacher_id = t.user_id WHERE s.class_id = $class_id) AS teachers_name,
              (SELECT GROUP_CONCAT(CONCAT(s.id, '|', r.room_name) SEPARATOR '@ ') FROM rooms AS r
                LEFT JOIN `sessions` AS s ON s.room_id = r.id WHERE s.class_id = $class_id) AS rooms_name,
              (SELECT GROUP_CONCAT(CONCAT(s.id, '|', s.class_day) SEPARATOR '@ ') FROM `sessions` AS s
                LEFT JOIN classes AS c ON s.class_id = c.id WHERE s.class_id = $class_id) AS weekdays,
              (SELECT GROUP_CONCAT(CONCAT(s.id, '|', f.start_time, '-', f.end_time) SEPARATOR ', ') FROM `sessions` AS s
                LEFT JOIN shifts AS f ON s.shift_id = f.id WHERE s.class_id = $class_id) AS shifts_name,
              (SELECT t.id FROM `sessions` AS s LEFT JOIN `teachers` AS t ON s.teacher_id = t.user_id LEFT JOIN users u ON u.id = t.user_id WHERE u.status > 0 AND s.class_id = $class_id LIMIT 1) AS teacher_id,
              (SELECT s.room_id FROM `sessions` AS s WHERE s.class_id = $class_id LIMIT 1) AS room_id,
              (SELECT s.shift_id FROM `sessions` AS s WHERE s.class_id = $class_id LIMIT 1) AS shift_id,
              (SELECT GROUP_CONCAT(s.class_day SEPARATOR ',') FROM `sessions` AS s WHERE s.class_id = $class_id) AS arr_weekdays,
               (SELECT count(cjrn_id) FROM schedules WHERE class_id=$class_id) AS num_session
            FROM classes AS c
              LEFT JOIN users AS u ON c.cm_id = u.id
            WHERE c.id = $class_id");

        $class_info->class_time = date('d/m/Y', strtotime($class_info->class_start_date)) . " - " . date('d/m/Y', strtotime($class_info->class_end_date));
        $teachers = [];
        $weekdays = [];
        $namrooms = [];
        $nashifts = [];
        $sessions = (object)[];
        $weekdays_text = '';
        $namrooms_text = '';
        $nashifts_text = '';
        $teachers_text = '';
        $displayed = [];
        if ($class_info->weekdays) {
            $weekdays = explode('@', $class_info->weekdays);
            if ($weekdays) {
                $i = 0;
                foreach ($weekdays as $weekday) {
                    $weekday_info = explode('|', $weekday);
                    $i++;
                    if ($weekday_info) {
                        $sid = "session_$weekday_info[0]";
                        $inf = $weekday_info[1];
                        $sessions->$sid = $sessions && property_exists($sessions, $sid) ? $sessions->$sid : (object)[];
                        $display = u::apax_ada_get_weekday($inf);
                        if (!in_array(md5($display), $displayed)) {
                            $sessions->$sid->weekday = u::apax_ada_get_weekday($inf);
                            $sessions->$sid->information = u::apax_ada_get_weekday($inf);
                            $weekdays_text .= $display;
                            $displayed[] = md5($display);
                            if ($i < count($weekdays)) {
                                $weekdays_text .= ', ';
                            }
                        }
                    }
                }
            }
        }
        if ($class_info->shifts_name) {
            $nashifts = explode('@', $class_info->shifts_name);
            if ($nashifts) {
                $i = 0;
                foreach ($nashifts as $nashift) {
                    $nashift_info = explode('|', $nashift);
                    $i++;
                    if ($nashift_info) {
                        $sid = "session_$nashift_info[0]";
                        $inf = $nashift_info[1];
                        $inf = explode('-', $inf);
                        $sta = $inf[0];
                        $end = $inf[1];
                        $sessions->$sid = $sessions && property_exists($sessions, $sid) ? $sessions->$sid : (object)[];
                        $lab = substr($sta, 0, 5) . '~' . substr($end, 0, 5);
                        $sessions->$sid->shift = $lab;
                        $sessions->$sid->information = property_exists($sessions->$sid, 'information') ? $sessions->$sid->information . ' ' . $lab : $lab;
                        $nashifts_text .= $lab;
                        $displayed[] = md5($lab);
                        if ($i < count($nashifts)) {
                            $nashifts_text .= ', ';
                        }
                    }
                }
            }
        }
        if ($class_info->rooms_name) {
            $namrooms = explode('@', $class_info->rooms_name);
            if ($namrooms) {
                $i = 0;
                foreach ($namrooms as $namroom) {
                    $namroom_info = explode('|', $namroom);
                    $i++;
                    if ($namroom_info && count($namroom_info)) {
                        $sid = "session_$namroom_info[0]";
                        $inf = $namroom_info[1];
                        $sessions->$sid = $sessions && property_exists($sessions, $sid) ? $sessions->$sid : (object)[];
                        if (!in_array(md5($inf), $displayed)) {
                            $sessions->$sid->room = "Room: $inf";
                            $sessions->$sid->information = property_exists($sessions->$sid, 'information') ? $sessions->$sid->information . ' ' . "Room: $inf" : "Room: $inf";
                            $namrooms_text .= $inf;
                            $displayed[] = md5($inf);
                            if ($i < count($namrooms)) {
                                $namrooms_text .= ', ';
                            }
                        }
                    }
                }
            }
        }
        
        $time_place = '';
        if ($sessions) {
            $i = 0;
            foreach ($sessions as $s => $o) {
                if (isset($o->information) && strlen($o->information) > 12) {
                    $i++;
                    $time_place .= $o->information;
                    if ($i < count((array)$sessions)) {
                        $time_place .= '<br/>';
                    }
                }
            }
        }
        $class_info->time_place = $time_place;
        if ($class_info->teachers_name) {
            $teachers = explode('@', $class_info->teachers_name);
            if ($teachers) {
                $i = 0;
                foreach ($teachers as $teacher) {
                    $teacher_info = explode('|', $teacher);
                    $i++;
                    if ($teacher_info) {
                        $sid = "session_$teacher_info[0]";
                        $inf = $teacher_info[1];
                        $inf = explode('#', $inf);
                        $ava = $inf[0];
                        $ten = $inf[1];
                        $lab = md5($ava) == md5('avatar.png') ? '<img style="border-radius:50%;width:30px;height: 30px;" src="./static/img/avatars/avatar.png"/> ' . $ten : '<img style="border-radius:50%;width:30px;height: 30px;" src="./static/img/avatars/teachers/' . $ava . '"/> ' . $ten;
                        $sessions->$sid = $sessions && property_exists($sessions, $sid) ? $sessions->$sid : (object)[];
                        if (!in_array(md5($lab), $displayed)) {
                            $sessions->$sid->teacher_avatar = $ava;
                            $sessions->$sid->teacher_name = $ten;
                            $sessions->$sid->teacher_label = $lab;
                            // $teachers_text .= $lab;
                            $teachers_text .= $ten;
                            $displayed[] = md5($lab);
                            if ($i < count($teachers)) {
                                $teachers_text .= ', ';
                            }
                        }
                    }
                }
            }
        }
        $class_info->teachers_name = $teachers_text;

        $students_list = u::query("SELECT
            c.branch_id,
            c.count_recharge,
            c.id AS contract_id,
            c.student_id,
            c.id AS contract_id,
            s.name AS student_name,
            s.cms_id AS cms_id,
            s.crm_id,    
            t.name AS tuition_fee_name,
            t.receivable AS tuition_fee_price,
            t.`session` AS tuition_fee_sessions,
            cl.cls_name AS class,
            cl.id as class_id,
            c.branch_id,
            c.product_id,
            c.enrolment_start_date,
            c.enrolment_start_date AS start_date,
            c.enrolment_end_date AS end_date,
            c.total_sessions AS total_sessions,
            c.must_charge, 
            c.bill_info,c.program_id,c.product_id,
            COALESCE(p.method, 0) AS payment_method,
            c.type AS customer_type,
            COALESCE(c.debt_amount, c.must_charge - c.total_charged) AS debt_amount,
            c.total_charged AS charged_total,
            IF(c.status = 6 AND c.enrolment_last_date <= CURDATE(), 1, 0) as withdraw,
            c.summary_sessions AS available_sessions,
            c.enrolment_expired_date,
            c.enrolment_last_date last_date,
            c.enrolment_type enrolment_status, 
            c.status,
            CONCAT(u1.full_name, ' - ', u1.username) AS ec_name,
            CONCAT(u2.full_name, ' - ', u2.username) AS cm_name,
            (SELECT CONCAT(full_name, ' - ', username) FROM users WHERE hrm_id = u1.superior_id LIMIT 1) AS ec_leader_name,
            (SELECT s.class_day FROM `sessions` AS s WHERE s.class_id = $class_id LIMIT 1) AS class_day
          FROM contracts AS c
            LEFT JOIN students AS s ON c.student_id = s.id
            LEFT JOIN payment AS p ON c.payment_id = p.id
            LEFT JOIN tuition_fee AS t ON c.tuition_fee_id = t.id
            LEFT JOIN classes AS cl ON c.class_id = cl.id
            LEFT JOIN users AS u1 ON c.ec_id = u1.id
            LEFT JOIN users AS u2 ON c.cm_id = u2.id
          WHERE c.class_id = $class_id  AND c.status = 6
            AND c.enrolment_start_date <= c.enrolment_end_date AND c.enrolment_last_date >= c.enrolment_start_date ");
        return json_encode([
            'class_info' => $class_info,
            'students_list' => $students_list
        ]);
    }
}
