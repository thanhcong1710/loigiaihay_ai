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
}
