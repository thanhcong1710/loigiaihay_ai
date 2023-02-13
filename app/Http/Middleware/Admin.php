<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        $hkey = Auth::guard('admin')->user()->id."@auth";
        $user_info = Redis::get($hkey);
        if(!$user_info){
            return redirect(route('admin.login'));
        }
        return $next($request);
    }
}