<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use App\Providers\UtilityServiceProvider as u;
class LoginController extends Controller
{
    public function login(Request $request)
    {
        if ($request->getMethod() == 'GET') {
            return view('admin.auth.login',[
                'message'=> $request->message 
            ]);
        }

        $credentials = $request->only(['username', 'password']);
        if (Auth::guard('admin')->attempt($credentials)) {
            $user_info = u::first("SELECT * FROM users WHERE id=".Auth::guard('admin')->user()->id);
            $cond_menu = "";
            $menus = u::query("SELECT * FROM menus WHERE status=1 AND level=1 $cond_menu ORDER BY stt");
            foreach($menus AS $k=>$menu){
                $sub_menu = u::query("SELECT * FROM menus WHERE status=1 AND level=2 $cond_menu AND parent_id=$menu->id ORDER BY stt");
                $menus[$k]->sub_menu = $sub_menu;
            }
            $user_info->menus = $menus;
            $life_time = 3600*8;
            $hkey = Auth::guard('admin')->user()->id."@auth";
            Redis::set($hkey, json_encode($user_info));
            Redis::expire($hkey, $life_time);
            return redirect()->route('admin.gpt.add');
        } else {
            return redirect()->route('admin.login',[
                'message'=> 'Thông tin đăng nhập không chính xác.' 
            ]);
        }
    }
}
