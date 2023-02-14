<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\GPTController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LoiGiaiController;
use App\Http\Controllers\Admin\CrawlTech12Controller;
use Illuminate\Support\Facades\Route;

Route::match(['get'], '/', [HomeController::class, 'index'])->name('home.index');
Route::match(['get', 'post'], '/login', [LoginController::class, 'login'])->name('admin.login');
Route::match(['get'], '/logout', [HomeController::class, 'logout'])->name('admin.logout');
Route::match(['get', 'post'], '/register', [HomeController::class, 'register'])->name('admin.register');
Route::match(['get'], '/craw', [CrawlTech12Controller::class, 'updateImgSubject']);
Route::middleware(['auth:admin','admin:admin'])->group(function (){
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/danh-sach-hoi-dap-gpt.html', [GPTController::class, 'list'])->name('admin.gpt.list');
    Route::get('/hoi-dap-gpt.html', [GPTController::class, 'add'])->name('admin.gpt.add');
    Route::post('/gpt/store', [GPTController::class, 'store'])->name('admin.gpt.store');
    Route::get('/gpt/detail/{chat_id}', [GPTController::class, 'detail'])->name('admin.gpt.detail');
    Route::get('/lich-su-giao-dich.html', [PaymentController::class, 'list'])->name('admin.payment.list');
    Route::get('/nap-ruby.html', [PaymentController::class, 'add'])->name('admin.payment.add');
    Route::get('/payment/create/{fee_id}', [PaymentController::class, 'create'])->name('admin.payment.create');
    Route::get('/thong-tin-giao-dich-{payment_id}.html', [PaymentController::class, 'detail'])->name('admin.payment.detail');
    Route::get('/payment/transfer/{payment_id}', [PaymentController::class, 'transfer'])->name('admin.payment.transfer');
    Route::get('/thong-tin-tai-khoan.html', [UserController::class, 'info'])->name('admin.user.info');
    Route::get('/cap-nhat-tai-khoan.html', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::post('/user/save', [UserController::class, 'save'])->name('admin.user.save');
    Route::get('/loi-giai-sgk-lop-{level_id}.html', [LoiGiaiController::class, 'level'])->name('admin.loigiai.level');
    Route::get('/loigiai/category/{category_id}', [LoiGiaiController::class, 'category'])->name('admin.loigiai.category');
    Route::get('/loigiai/subject/{subject_id}', [LoiGiaiController::class, 'subject'])->name('admin.loigiai.subject');
});