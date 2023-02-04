<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GptAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\UtilityServiceProvider as u;

class PaymentController extends Controller
{
    public function list(Request $request)
    {
        $page = isset($request->page) ? (int) $request->page : 1;
        $limit = isset($request->limit) ? (int) $request->limit : 20;
        $offset = $page == 1 ? 0 : $limit * ($page - 1);
        $limitation =  $limit > 0 ? " LIMIT $offset, $limit" : "";
        $cond = " user_id = ".Auth::guard('admin')->user()->id;
        $total = u::first("SELECT count(p.id) AS total FROM payments AS p WHERE $cond ");
        $list = u::query("SELECT p.* , (SELECT title FROM fee_packages WHERE id= p.fee_package_id) AS fee_name
            FROM payments AS p WHERE $cond ORDER BY p.id DESC $limitation");
        return view('admin.payment.list', [
            'list' => $list,
            'total' => $total->total,
            'page' => $page,
            'limit' => $limit,
            'url'=>route('admin.payment.list')
        ]);
    }
    public function add(Request $request){
        $list = u::query("SELECT f.*
            FROM fee_packages AS f WHERE f.status=1 AND CURRENT_DATE>=start_date AND CURRENT_DATE<=end_date ORDER BY f.stt ");
        return view('admin.payment.add', [
            'list_payment' => $list
        ]);
    }
    public function create(Request $request,$fee_id){
        $fee_package_info = u::first("SELECT * FROM fee_packages WHERE id=$fee_id");
        $payment_id = u::insertSimpleRow(array(
            'user_id' => Auth::guard('admin')->user()->id,
            'coins' => $fee_package_info->coins,
            'amount' => $fee_package_info->amount,
            'fee_package_id' =>  $fee_id,
            'created_at'=>date('Y-m-d H:i:s'),
            'creator_id'=>Auth::guard('admin')->user()->id,
            'status'=>0
        ),'payments');
        $code = 230000+$payment_id;
        u::updateSimpleRow(['code'=>$code],['id'=>$payment_id],'payments');
        return redirect(route('admin.payment.detail',['payment_id'=>$payment_id]));
    }
    public function detail(Request $request,$payment_id){
        $payment_info=u::first("SELECT p.*
                FROM payments AS p
            WHERE p.id=$payment_id");
        return view('admin.payment.detail',[
            'payment_info'=>$payment_info
        ]);
    }
    public function transfer(Request $request,$payment_id){
        u::updateSimpleRow(array(
            'status'=>1,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updator_id'=>Auth::guard('admin')->user()->id,
        ),['id'=>$payment_id],'payments');
        return redirect(route('admin.payment.list'));
    }
}
