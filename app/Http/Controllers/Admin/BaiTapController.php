<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\UtilityServiceProvider as u;

class BaiTapController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.baitap.index');
    }
}
