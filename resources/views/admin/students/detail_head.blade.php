<?php
if ($student_info->avatar) {
    $avatar = config('app.url') . "/" . $student_info->avatar;
} elseif ($student_info->gender == "Nam") {
    $avatar = config('app.url') . '/assets/media/svg/avatars/001-boy.svg';
} else {
    $avatar = config('app.url') . '/assets/media/svg/avatars/006-girl-3.svg';
}
?>
<div class="card mb-5 mb-xl-10">
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
            <!--begin: Pic-->
            <div class="me-7 mb-4">
                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                    <img src="{{$avatar}}" alt="image">
                </div>
            </div>
            <!--end::Pic-->
            <!--begin::Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <!--begin::User-->
                    <div class="d-flex flex-column">
                        <!--begin::Name-->
                        <div class="d-flex align-items-center mb-2">
                            <a class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{$head_info->name}}</a>
                            <a href="{{ route('admin.students.edit',['student_id'=>$head_info->id]) }}">
                                <span class="svg-icon svg-icon-1 svg-icon-primary">
                                    <i style="color: #0e9c4f;font-size: 18px;margin-left: 10px" class="fa-solid fa-pen-to-square"></i>
                                </span>
                            </a>
                        </div>
                        <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                            <a href="javascript:navigator.clipboard.writeText('{{$head_info->crm_id}}');" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2" title="Copy">
                                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                <span class="svg-icon svg-icon-4 me-1">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M16.5 9C16.5 13.125 13.125 16.5 9 16.5C4.875 16.5 1.5 13.125 1.5 9C1.5 4.875 4.875 1.5 9 1.5C13.125 1.5 16.5 4.875 16.5 9Z" fill="currentColor"></path>
                                        <path d="M9 16.5C10.95 16.5 12.75 15.75 14.025 14.55C13.425 12.675 11.4 11.25 9 11.25C6.6 11.25 4.57499 12.675 3.97499 14.55C5.24999 15.75 7.05 16.5 9 16.5Z" fill="currentColor"></path>
                                        <rect x="7" y="6" width="4" height="4" rx="2" fill="currentColor"></rect>
                                    </svg>
                                </span>
                                {{$head_info->crm_id}}
                            </a>
                            <a href="javascript:navigator.clipboard.writeText('{{$head_info->gud_mobile1}}');" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2" title="Copy">
                                <i class="fa-solid fa-phone"></i>
                                {{$head_info->gud_mobile1}}
                            </a>
                            <a href="javascript:navigator.clipboard.writeText('{{$head_info->gud_email1}}');" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2" title="Copy">
                                <i class="fa-solid fa-envelope"></i>
                                {{$head_info->gud_email1}}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap">
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$" data-kt-initialized="1">15.000.000</div>
                                </div>
                                <div class="fw-semibold fs-6 text-gray-400">Phí đã đóng (VNĐ)</div>
                            </div>
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="75" data-kt-initialized="1">96</div>
                                </div>
                                <div class="fw-semibold fs-6 text-gray-400">Tổng số buổi</div>
                            </div>
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="60" data-kt-countup-prefix="%" data-kt-initialized="1">54</div>
                                </div>
                                <div class="fw-semibold fs-6 text-gray-400">Số buổi còn lại</div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                        <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                            <span class="fw-semibold fs-6 text-gray-400">Đã học</span>
                            <span class="fw-bold fs-6">40%</span>
                        </div>
                        <div class="h-5px mx-3 w-100 bg-light mb-3">
                            <div class="bg-success rounded h-5px" role="progressbar" style="width: 40%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="{{ route('admin.students.detail',['student_id'=>$head_info->id]) }}">Thông tin</a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5" href="{{ route('admin.students.detail_cares',['student_id'=>$head_info->id]) }}">Chăm sóc</a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5" href="{{ route('admin.students.detail_logs',['student_id'=>$head_info->id]) }}">Cập nhật</a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5" href="{{ route('admin.students.detail_contracts',['student_id'=>$head_info->id]) }}">Nhập học</a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5" href="{{ route('admin.students.detail_payments',['student_id'=>$head_info->id]) }}">Thu phí</a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5" href="{{ route('admin.students.detail_enrolments',['student_id'=>$head_info->id]) }}">Đăng ký lớp học</a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5" href="{{ route('admin.students.detail_attendances',['student_id'=>$head_info->id]) }}">Điểm danh</a>
            </li>
        </ul>
    </div>
</div>