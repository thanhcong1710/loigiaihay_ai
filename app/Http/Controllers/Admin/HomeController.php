<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\UtilityServiceProvider as u;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }
    public function logout()
    {
        Auth::logout();
        return view('admin.auth.login');
    }
    public function register(Request $request)
    {
        if ($request->getMethod() == 'GET') {
            return view('admin.auth.register',['message'=>$request->message]);
        }
        $error="";
        if($request->password != $request->confirm_password){
            $error = "Mật khẩu không khớp nhau";
        }
        if(!$request->username){
            $error = "Tên đăng nhập không hợp lệ";
        }
        $user_info = u::first("SELECT id FROM users WHERE username='$request->username'");
        if($user_info){
            $error = "Tên đăng nhập đã tồn tại";
        }
        if($error){
            return redirect()->route('admin.register',['message'=>$error]);
        }else{
            $user_id = u::insertSimpleRow(array(
                'full_name'=>$request->username,
                'username'=>$request->username,
                'password'=> Hash::make($request->password),
                'status'=>1,
                'created_at'=>date('Y-m-d H:i:s'),
                'ip_address' => u::get_client_ip(),
                'coins_free'=>5
            ),'users');

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
            }
        }
    }

    public function dashboard(){
        return redirect()->route('admin.gpt.add');
    }
}
