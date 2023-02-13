<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GptAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\UtilityServiceProvider as u;

class UserController extends Controller
{
    public function info(Request $request){
        $user_info = u::first("SELECT * FROM users WHERE id=".Auth::guard('admin')->user()->id);
        return view('admin.user.info', [
            'user_info' => $user_info
        ]);
    }
    public function edit(Request $request){
        $user_info = u::first("SELECT * FROM users WHERE id=".Auth::guard('admin')->user()->id);
        return view('admin.user.edit', [
            'user_info' => $user_info
        ]);
    }
    public function save(Request $request){
        $error="";
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $error = "Email không hợp lệ";
        }
        if(!preg_match('/^[0-9]{10}+$/', $request->phone)){
            $error = "Số điện thoại không hợp lệ";
        }
        if($error){
            return redirect()->route('admin.user.edit');
        }else{
            $user_info = u::first("SELECT first_update, coins_free FROM users WHERE id=".Auth::guard('admin')->user()->id);
            if($user_info->first_update){
                u::updateSimpleRow(array(
                    'full_name' => $request->full_name,
                    'email' => $request->email,
                    'address'  => $request->address,
                    'phone'  => $request->phone,
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'editor_id'=>Auth::guard('admin')->user()->id
                ),['id'=>Auth::guard('admin')->user()->id],'users');
            }else{
                u::updateSimpleRow(array(
                    'full_name' => $request->full_name,
                    'email' => $request->email,
                    'address'  => $request->address,
                    'phone'  => $request->phone,
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'editor_id'=>Auth::guard('admin')->user()->id,
                    'first_update'=> 1,
                    'coins_free'=>$user_info->coins_free + 10,
                ),['id'=>Auth::guard('admin')->user()->id],'users');
            }
            
            return redirect()->route('admin.user.info');
        }
        
    }
}
