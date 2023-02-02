<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\StudentsController;
use App\Http\Controllers\Admin\ContractsController;
use App\Http\Controllers\Admin\EnrolmentsController;
use App\Http\Controllers\Admin\AttendancesController;
use App\Http\Controllers\Admin\CrawlVungOiController;
use App\Http\Controllers\Admin\CrawlVietjackController;
use App\Http\Controllers\Admin\AppMobileController;
use App\Http\Controllers\Admin\QuestionController;
use Illuminate\Support\Facades\Route;

Route::match(['get'], '/crawl/vung-oi', [CrawlVungOiController::class, 'vungOi'])->name('admin.logout');
Route::match(['get'], '/crawl/viet-jack/{chapter_id}', [CrawlVietjackController::class, 'getContentChapter'])->name('admin.logout');
Route::match(['get', 'post'], '/login', [LoginController::class, 'login'])->name('admin.login');
Route::match(['get'], '/logout', [HomeController::class, 'logout'])->name('admin.logout');
Route::match(['get'], '/app/getData', [AppMobileController::class, 'getDataApp']);
Route::middleware(['auth:admin','admin:admin'])->group(function (){
    Route::get('/', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::post('/systems/get-dictrict-by-province', [HomeController::class, 'getDictricts'])->name('admin.systems.get_dictrict');
    Route::post('/systems/get-ec-cs-by-branch', [HomeController::class, 'getECCSByBranchID'])->name('admin.systems.get_ec_cs');
    Route::get('/students', [StudentsController::class, 'list'])->name('admin.students.list');
    Route::get('/students/add', [StudentsController::class, 'add'])->name('admin.students.add');
    Route::post('/students/store', [StudentsController::class, 'store'])->name('admin.students.store');
    Route::get('/students/edit/{student_id}', [StudentsController::class, 'edit'])->name('admin.students.edit');
    Route::post('/students/save/{student_id}', [StudentsController::class, 'save'])->name('admin.students.save');
    Route::get('/students/detail/{student_id}', [StudentsController::class, 'detail'])->name('admin.students.detail');
    Route::get('/students/detail_cares/{student_id}', [StudentsController::class, 'detailCares'])->name('admin.students.detail_cares');
    Route::get('/students/detail_logs/{student_id}', [StudentsController::class, 'detailLogs'])->name('admin.students.detail_logs');
    Route::get('/students/detail_contracts/{student_id}', [StudentsController::class, 'detailContracts'])->name('admin.students.detail_contracts');
    Route::get('/students/detail_payments/{student_id}', [StudentsController::class, 'detailPayments'])->name('admin.students.detail_payments');
    Route::get('/students/detail_enrolments/{student_id}', [StudentsController::class, 'detailEnrolments'])->name('admin.students.detail_enrolments');
    Route::get('/students/detail_attendances/{student_id}', [StudentsController::class, 'detailAttendances'])->name('admin.students.detail_attendances');

    Route::get('/operate/contracts', [ContractsController::class, 'list'])->name('admin.operate.contracts.list');
    Route::get('/operate/contracts/add', [ContractsController::class, 'add'])->name('admin.operate.contracts.add');
    Route::get('/operate/contracts/search_student', [ContractsController::class, 'searchStudent'])->name('admin.operate.contracts.search_student');
    Route::get('/operate/contracts/get_student_info', [ContractsController::class, 'getStudentInfo'])->name('admin.operate.contracts.get_student_info');
    Route::post('/operate/contracts/get_list_tuititon_fee', [ContractsController::class, 'getListTuitionFee'])->name('admin.operate.contracts.get_list_tuititon_fee');
    Route::post('/operate/contracts/get_tuititon_fee_info', [ContractsController::class, 'getTuitionFeeInfo'])->name('admin.operate.contracts.get_tuititon_fee_info');
    Route::post('/operate/contracts/store', [ContractsController::class, 'store'])->name('admin.operate.contracts.store');

    Route::get('/operate/enrolments', [EnrolmentsController::class, 'detail'])->name('admin.operate.enrolment.detail');
    Route::post('/operate/enrolments/get_list_class', [EnrolmentsController::class, 'getListClass'])->name('admin.operate.enrolment.get_list_class');
    Route::post('/operate/enrolments/get_info_class', [EnrolmentsController::class, 'getClassInfo'])->name('admin.operate.enrolment.get_info_class');

    Route::get('/operate/attendances', [AttendancesController::class, 'detail'])->name('admin.operate.attendance.detail');
    Route::post('/operate/attendances/get_list_program', [AttendancesController::class, 'getListProgram'])->name('admin.operate.attendance.get_list_program');
    Route::post('/operate/attendances/get_list_class', [AttendancesController::class, 'getListClass'])->name('admin.operate.attendance.get_list_class');
    Route::post('/operate/attendances/get_student', [AttendancesController::class, 'getStudent'])->name('admin.operate.attendance.get_student');

    Route::get('/vungoi/question', [QuestionController::class, 'view'])->name('admin.vungoi.question');
});