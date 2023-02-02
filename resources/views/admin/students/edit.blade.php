@extends('admin.layouts.admin')
@section('head.title', 'Dashboard')
@section('body.content')
<?php
$avatar =config('app.url')."/".$student_info->avatar;
$date_of_birth = $student_info->date_of_birth ? date('d/m/Y',strtotime($student_info->date_of_birth)):'';
$gud_birth_day1 = $student_info->gud_birth_day1 ? date('d/m/Y',strtotime($student_info->gud_birth_day1)):'';
$gud_birth_day2 = $student_info->gud_birth_day2 ? date('d/m/Y',strtotime($student_info->gud_birth_day2)):'';
?>
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card card-flush h-lg-100" id="kt_contacts_main">
            <!--begin::Card header-->
            <div class="card-header pt-7" id="kt_chat_contacts_header">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                    <span class="svg-icon svg-icon-1 me-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="currentColor"></path>
                            <path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="currentColor"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <h2>Thông tin học sinh</h2>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <form method="post" action="{{ route('admin.students.save',['student_id'=>$student_info->id]) }}" enctype="multipart/form-data" class="form fv-plugins-bootstrap5 fv-plugins-framework">
                    @csrf
                    <div class="mb-7">
                        <label class="fs-6 fw-semibold mb-3">
                            <span>Update Avatar</span>
                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" aria-label="Allowed file types: png, jpg, jpeg." data-kt-initialized="1"></i>
                        </label>
                        <div class="mt-1">
                            <style>
                                .image-input-placeholder {
                                    background-image: url('assets/media/svg/files/blank-image.svg');
                                }

                                [data-theme="dark"] .image-input-placeholder {
                                    background-image: url('assets/media/svg/files/blank-image-dark.svg');
                                }
                            </style>
                            <div class="image-input image-input-outline image-input-placeholder image-input-empty image-input-empty" data-kt-image-input="true">
                                <div class="image-input-wrapper w-100px h-100px" style="background-image: url('{{$avatar}}')"></div>
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar" data-kt-initialized="1">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
                                    <input type="hidden" name="avatar_remove">
                                </label>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel avatar" data-kt-initialized="1">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove avatar" data-kt-initialized="1">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-sm-3 rol-cols-md-1 row-cols-lg-3">
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>Mã học sinh</span>
                                </label>
                                <input type="text" class="form-control " name="ma_crm" value="{{$student_info->crm_id}}" disabled>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Tên học sinh</span>

                                </label>
                                <input type="text" class="form-control " name="name" value="{{$student_info->name}}" required>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Ngày sinh</span>
                                </label>
                                <input class="form-control" placeholder="Chọn ngày sinh" id="kt_daterangepicker_1" name="date_of_birth" value="{{$date_of_birth}}" required />
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Giới tính</span>
                                </label>
                                <select class="form-select" name="gender" value="{{$student_info->gender}}"  required>
                                    <option>Chọn giới tính</option>
                                    <option value="M" {{$student_info->type=='M'?'selected':''}}>Nam</option>
                                    <option value="F" {{$student_info->type=='F'?'selected':''}}>Nữ</option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Đối tượng khách hàng</span>
                                </label>
                                <select class="form-select" name="type" value="{{$student_info->type}}" required>
                                    <option>Chọn đối tượng khách hàng</option>
                                    <option value="0" {{$student_info->type==0?'selected':''}}>Thường</option>
                                    <option value="1" {{$student_info->type==1?'selected':''}}>VIP</option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Tỉnh/thành phố</span>
                                </label>
                                <select class="form-select" name="province_id" id="province_id" value="{{$student_info->province_id}}" data-control="select2" data-placeholder="Chọn tỉnh thành phố" data-allow-clear="true" onchange="loadDistricts()" required>
                                    <option></option>
                                    @foreach($provinces As $province)
                                    <option value="{{$province->id}}" {{$student_info->province_id==$province->id?'selected':''}}>{{$province->name}}</option>
                                    @endforeach
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Quận/huyện</span>
                                </label>
                                <select class="form-select" name="district_id" id="district_id" data-control="select2" data-placeholder="Chọn tỉnh quận huyện" data-allow-clear="true" required>
                                    <option></option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Địa chỉ</span>
                                </label>
                                <input type="text" class="form-control " name="address" value="{{$student_info->address}}">
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Cấp trường</span>
                                </label>
                                <select class="form-select" name="school_level" value="{{$student_info->school_level}}" required>
                                    <option>Chọn cấp trường</option>
                                    <option value="Mẫu giáo" {{$student_info->school_level=='Mẫu giáo'?'selected':''}}>Mẫu giáo</option>
                                    <option value="Tiểu học" {{$student_info->school_level=='Tiểu học'?'selected':''}}>Tiểu học</option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>Trường học</span>
                                </label>
                                <input type="text" class="form-control " name="school" value="{{$student_info->school}}">
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Độ tuổi</span>
                                </label>
                                <select class="form-select" name="school_grade" value="{{$student_info->school_grade}}" id="school_grade" data-control="select2" data-placeholder="Chọn độ tuổi" data-allow-clear="true" required>
                                    <option></option>
                                    @foreach($school_grades As $school_grade)
                                    <option value="{{$school_grade->id}}" {{$student_info->school_grade==$school_grade->id?'selected':''}}>{{$school_grade->name}}</option>
                                    @endforeach
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Từ nguồn</span>
                                </label>
                                <select class="form-select" name="source" id="source" value="{{$student_info->source}}" data-control="select2" data-placeholder="Chọn nguồn" data-allow-clear="true" required>
                                    <option></option>
                                    @foreach($sources As $source)
                                    <option value="{{$source->id}}" {{$student_info->source==$source->id?'selected':''}}>{{$source->name}}</option>
                                    @endforeach
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-sm-1 rol-cols-md-1 row-cols-lg-1">
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>Ghi chú</span>
                                </label>
                                <input type="text" class="form-control " name="note" value="{{$student_info->note}}">
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-title" style="overflow: auto;">
                        <span class="svg-icon svg-icon-1 me-2" style="float: left;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="currentColor"></path>
                                <path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="currentColor"></path>
                            </svg>
                        </span>
                        <h2 style="float: left;">Thông tin phụ huynh</h2>
                    </div>
                    <div class="row row-cols-1 row-cols-sm-3 rol-cols-md-1 row-cols-lg-3">
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Họ tên phụ huynh 1</span>
                                </label>
                                <input type="text" class="form-control " name="gud_name1" value="{{$student_info->gud_name1}}" required>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Số điện thoại</span>
                                </label>
                                <input type="text" class="form-control " name="gud_mobile1" value="{{$student_info->gud_mobile1}}" required>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Email</span>
                                </label>
                                <input type="text" class="form-control " name="gud_email1" value="{{$student_info->gud_email1}}" required>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Ngày sinh</span>
                                </label>
                                <input class="form-control" placeholder="Chọn ngày sinh" value="{{$gud_birth_day1}}" id="kt_daterangepicker_2" name="gud_birth_day1" required />
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Nghề nghiệp</span>
                                </label>
                                <select class="form-select" name="gud_job1" id="gud_job1" value="{{$student_info->gud_job1}}" data-control="select2" data-placeholder="Chọn nghề nghiệp" data-allow-clear="true" required>
                                    <option></option>
                                    @foreach($jobs As $job)
                                    <option value="{{$job->id}}" {{$student_info->gud_job1==$job->id?'selected':''}}>{{$job->title}}</option>
                                    @endforeach
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-sm-3 rol-cols-md-1 row-cols-lg-3">
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>Họ tên phụ huynh 2</span>
                                </label>
                                <input type="text" class="form-control " name="gud_name2" value="{{$student_info->gud_name2}}">
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>Số điện thoại</span>
                                </label>
                                <input type="text" class="form-control " name="gud_mobile2" value="{{$student_info->gud_mobile2}}">
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>Email</span>
                                </label>
                                <input type="text" class="form-control " name="gud_email2" value="{{$student_info->gud_email2}}">
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>Ngày sinh</span>
                                </label>
                                <input class="form-control" placeholder="Chọn ngày sinh" id="kt_daterangepicker_3" value="{{$gud_birth_day2}}" name="gud_birth_day2"  />
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>Nghề nghiệp</span>
                                </label>
                                <select class="form-select" name="gud_job2" id="gud_job2" value="{{$student_info->gud_job2}}" data-control="select2" data-placeholder="Chọn nghề nghiệp" data-allow-clear="true" >
                                    <option></option>
                                    @foreach($jobs As $job)
                                    <option value="{{$job->id}}"  {{$student_info->gud_job2==$job->id?'selected':''}}>{{$job->title}}</option>
                                    @endforeach
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-title" style="overflow: auto;">
                        <span class="svg-icon svg-icon-1 me-2" style="float: left;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="currentColor"></path>
                                <path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="currentColor"></path>
                            </svg>
                        </span>
                        <h2 style="float: left;">Thông tin trung tâm</h2>
                    </div>
                    <div class="row row-cols-1 row-cols-sm-3 rol-cols-md-1 row-cols-lg-3">
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Trung tâm</span>
                                </label>
                                <select class="form-select" name="branch_id" id="branch_id" value="$student_info->branch_id" data-control="select2" data-placeholder="Chọn trung tâm" data-allow-clear="true" onchange="loadBranchInfo()" required>
                                    <option></option>
                                    @foreach($branches As $branch)
                                    <option value="{{$branch->id}}" {{$student_info->branch_id==$branch->id?'selected':''}}>{{$branch->name}}</option>
                                    @endforeach
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">EC</span>
                                </label>
                                <select class="form-select" name="ec_id" id="ec_id" data-control="select2" data-placeholder="Chọn EC" data-allow-clear="true" required>
                                    <option></option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">CS</span>
                                </label>
                                <select class="form-select" name="cm_id" id="cm_id" data-control="select2" data-placeholder="Chọn CM" data-allow-clear="true" required>
                                    <option></option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.students.list') }}">
                            <button type="button" id="kt_modal_new_card_cancel" class="btn btn-light me-3"><i class="fa-solid fa-ban"></i>Hủy</button>
                        </a>
                        <button type="submit" id="kt_modal_new_card_submit" class="btn btn-success">
                            <span class="indicator-label"><i class="fa-solid fa-floppy-disk"></i>Lưu</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $( document ).ready(function() {
        loadDistricts("{{$student_info->district_id}}");
        loadBranchInfo("{{$student_info->ec_id}}","{{$student_info->cm_id}}");
    });
    $("#kt_daterangepicker_3").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format("YYYY"), 12),
        locale: {
            format: "DD/MM/YYYY"
        }
    }, function(start, end, label) {
        var years = moment().diff(start, "years");
    });
    $("#kt_daterangepicker_1").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format("YYYY"), 12),
        locale: {
            format: "DD/MM/YYYY"
        }
    }, function(start, end, label) {
        var years = moment().diff(start, "years");
    });
    $("#kt_daterangepicker_2").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format("YYYY"), 12),
        locale: {
            format: "DD/MM/YYYY"
        }
    }, function(start, end, label) {
        var years = moment().diff(start, "years");
    });

    function loadDistricts(district_id="") {
        $.ajax({
            type: "POST",
            url: "{{route('admin.systems.get_dictrict')}}",
            dataType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                province_id: $('#province_id').val()
            },
            error: function(err) {},
            success: function(data) {
                var sel = $("#district_id");
                sel.empty();
                sel.append('<option></option>');
                for (var i = 0; i < data.length; i++) {
                    sel.append('<option value="' + data[i].id + '">' + data[i].desc + '</option>');
                }
                $("#district_id").val(district_id)
            }
        });
    };
    function loadBranchInfo(ec_id="",cm_id=""){
        $.ajax({
            type: "POST",
            url: "{{route('admin.systems.get_ec_cs')}}",
            dataType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                branch_id: $('#branch_id').val()
            },
            error: function(err) {},
            success: function(data) {
                var sel = $("#ec_id");
                sel.empty();
                sel.append('<option></option>');
                for (var i = 0; i < data.ecs.length; i++) {
                    sel.append('<option value="' + data.ecs[i].id + '">' + data.ecs[i].title + '</option>');
                }
                var tmp_cm = $("#cm_id");
                tmp_cm.empty();
                tmp_cm.append('<option></option>');
                for (var i = 0; i < data.cms.length; i++) {
                    if( data.cms[i].id==cm_id){
                        tmp_cm.append('<option value="' + data.cms[i].id + '" selected>' + data.cms[i].title + '</option>');
                    }else{
                        tmp_cm.append('<option value="' + data.cms[i].id + '">' + data.cms[i].title + '</option>');
                    }
                }
                $("#ec_id").val(ec_id)
                $("#cs_id").val(cm_id)
            }
        });
    }
</script>
@stop