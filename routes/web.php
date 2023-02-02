<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/login', [LoginController::class, 'login'])->name('admin.login');
Route::match(['get'], '/logout', [HomeController::class, 'logout'])->name('admin.logout');
Route::middleware(['auth:admin','admin:admin'])->group(function (){
    Route::get('/', [HomeController::class, 'index'])->name('admin.dashboard');
});