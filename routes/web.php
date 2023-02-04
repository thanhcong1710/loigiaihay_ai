<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\GPTController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/login', [LoginController::class, 'login'])->name('admin.login');
Route::match(['get'], '/logout', [HomeController::class, 'logout'])->name('admin.logout');
Route::match(['get', 'post'], '/register', [HomeController::class, 'register'])->name('admin.register');
Route::middleware(['auth:admin','admin:admin'])->group(function (){
    Route::get('/', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('/gpt', [GPTController::class, 'list'])->name('admin.gpt.list');
    Route::get('/gpt/add', [GPTController::class, 'add'])->name('admin.gpt.add');
    Route::post('/gpt/store', [GPTController::class, 'store'])->name('admin.gpt.store');
    Route::get('/gpt/detail/{chat_id}', [GPTController::class, 'detail'])->name('admin.gpt.detail');
    Route::get('/payment', [PaymentController::class, 'list'])->name('admin.payment.list');
    Route::get('/payment/add', [PaymentController::class, 'add'])->name('admin.payment.add');
    Route::get('/payment/create/{fee_id}', [PaymentController::class, 'create'])->name('admin.payment.create');
    Route::get('/payment/detail/{payment_id}', [PaymentController::class, 'detail'])->name('admin.payment.detail');
    Route::get('/payment/transfer/{payment_id}', [PaymentController::class, 'transfer'])->name('admin.payment.transfer');
    Route::get('/user/info', [UserController::class, 'info'])->name('admin.user.info');
    Route::get('/user/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::post('/user/save', [UserController::class, 'save'])->name('admin.user.save');
});