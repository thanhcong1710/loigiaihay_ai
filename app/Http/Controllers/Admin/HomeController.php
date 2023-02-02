<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\UtilityServiceProvider as u;

class HomeController extends Controller
{
    public function index()
    {
        // $user = Auth::guard('admin')->user();
        // echo 'Xin chào Admin, '. $user->name;
        return view('admin.dashboard');
    }
    public function logout()
    {
        Auth::logout();
        return view('admin.auth.login');
    }
    public function getDictricts(Request $request)
    {
        $districts = u::query("SELECT * FROM districts WHERE province_id=" . $request->province_id);
        foreach ($districts as $row) {
            $result[] = array(
                'id' => $row->id,
                'desc' => $row->name,
            );
        }
        return  json_encode($result);
    }
    public function getECCSByBranchID(Request $request)
    {
        $cms = u::query("SELECT u.id, CONCAT(u.full_name,' - ',u.hrm_id) AS title FROM term_user_branch AS t LEFT JOIN users AS u ON u.id=t.user_id WHERE t.role_id IN(55,56) AND u.status=1 AND t.status=1 AND t.branch_id=$request->branch_id");
        $ecs = u::query("SELECT u.id, CONCAT(u.full_name,' - ',u.hrm_id) AS title FROM term_user_branch AS t LEFT JOIN users AS u ON u.id=t.user_id WHERE t.role_id IN(68,69) AND u.status=1 AND t.status=1 AND t.branch_id=$request->branch_id");
        $result = array(
            'cms' => $cms,
            'ecs' => $ecs,
        );
        return  json_encode($result);
    }
}
