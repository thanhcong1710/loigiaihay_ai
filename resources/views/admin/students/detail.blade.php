@extends('admin.layouts.admin')
@section('head.title', 'Dashboard')
@section('body.content')
<?php
$date_of_birth = $student_info->date_of_birth ? date('d/m/Y', strtotime($student_info->date_of_birth)) : '';
$gud_birth_day1 = $student_info->gud_birth_day1 ? date('d/m/Y', strtotime($student_info->gud_birth_day1)) : '';
$gud_birth_day2 = $student_info->gud_birth_day2 ? date('d/m/Y', strtotime($student_info->gud_birth_day2)) : '';
?>
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        @include('admin.students.detail_head')
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
                            <input type="text" class="form-control " name="name" value="{{$student_info->name}}" disabled>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Ngày sinh</span>
                            </label>
                            <input class="form-control" placeholder="Chọn ngày sinh" id="kt_daterangepicker_1" name="date_of_birth" value="{{$date_of_birth}}" disabled />
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Giới tính</span>
                            </label>
                            <select class="form-select" name="gender" value="{{$student_info->gender}}" disabled>
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
                            <select class="form-select" name="type" value="{{$student_info->type}}" disabled>
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
                            <input type="text" class="form-control " name="name" value="{{$student_info->province_name}}" disabled>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Quận/huyện</span>
                            </label>
                            <input type="text" class="form-control " name="name" value="{{$student_info->district_name}}" disabled>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Địa chỉ</span>
                            </label>
                            <input type="text" class="form-control " name="address" value="{{$student_info->address}}" disabled>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Cấp trường</span>
                            </label>
                            <select class="form-select" name="school_level" value="{{$student_info->school_level}}" disabled>
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
                            <input type="text" class="form-control " name="school" value="{{$student_info->school}}" disabled>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Độ tuổi</span>
                            </label>
                            <input type="text" class="form-control " name="school" value="{{$student_info->school_grade}}" disabled>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Từ nguồn</span>
                            </label>
                            <input type="text" class="form-control " name="school" value="{{$student_info->source_name}}" disabled>
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
                            <input type="text" class="form-control " name="note" value="{{$student_info->note}}" disabled>
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
                            <input type="text" class="form-control " name="gud_name1" value="{{$student_info->gud_name1}}" disabled>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Số điện thoại</span>
                            </label>
                            <input type="text" class="form-control " name="gud_mobile1" value="{{$student_info->gud_mobile1}}" disabled>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Email</span>
                            </label>
                            <input type="text" class="form-control " name="gud_email1" value="{{$student_info->gud_email1}}" disabled>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Ngày sinh</span>
                            </label>
                            <input class="form-control" placeholder="Chọn ngày sinh" value="{{$gud_birth_day1}}" id="kt_daterangepicker_2" name="gud_birth_day1" disabled />
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Nghề nghiệp</span>
                            </label>
                            <input type="text" class="form-control " name="gud_email1" value="{{$student_info->gud_job1}}" disabled>
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
                            <input type="text" class="form-control " name="gud_name2" value="{{$student_info->gud_name2}}" disabled>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span>Số điện thoại</span>
                            </label>
                            <input type="text" class="form-control " name="gud_mobile2" value="{{$student_info->gud_mobile2}}" disabled>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span>Email</span>
                            </label>
                            <input type="text" class="form-control " name="gud_email2" value="{{$student_info->gud_email2}}" disabled>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span>Ngày sinh</span>
                            </label>
                            <input class="form-control" placeholder="Chọn ngày sinh" id="kt_daterangepicker_3" value="{{$gud_birth_day2}}" name="gud_birth_day2" disabled/>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span>Nghề nghiệp</span>
                            </label>
                            <input type="text" class="form-control " name="gud_email1" value="{{$student_info->gud_job2}}" disabled>
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
                            <input type="text" class="form-control " name="gud_email1" value="{{$student_info->branch_name}}" disabled>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">EC</span>
                            </label>
                            <input type="text" class="form-control " name="gud_email1" value="{{$student_info->ec_name}}" disabled>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">CS</span>
                            </label>
                            <input type="text" class="form-control " name="gud_email1" value="{{$student_info->cm_name}}" disabled>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop