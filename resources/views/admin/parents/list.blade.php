@extends('admin.layouts.admin')
@section('head.title', 'Dashboard')
@section('body.content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="row g-6 g-xl-9">
            @foreach($students AS $student)
            <!--begin::Col-->
            <div class="col-md-6 col-xl-6">
                <!--begin::Card-->
                <a href="{{ route('admin.students.detail',['student_id'=>$student->id]) }}" class="card border-hover-primary">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-9">
                        <!--begin::Card Title-->
                        <div class="card-title m-0">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-100px w-100px bg-light">
                                <img src="{{$student->avatar}}" alt="image" class="p-3">
                            </div>
                            <!--end::Avatar-->
                        </div>
                        <!--end::Car Title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar" style="width: calc(100% - 120px); align-items: normal;">
                            <p class="fs-3 fw-bold text-dark" style="width: 100%; margin-bottom: 0px;">{{$student->name}}</p>
                            <p class="text-dark fs-5" style="width: 100%; margin-bottom: 0px;">{{$student->branch_name}}</p>
                            <p class="text-dark fs-5" style="width: 100%; margin-bottom: 0px;">Lớp {{$student->class_name}}</p>
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end:: Card header-->
                    <!--begin:: Card body-->
                    <div class="card-body p-9">
                        <div class="d-flex flex-wrap mb-5">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                <div class="fs-6 text-gray-800 fw-bold">15.000.000</div>
                                <div class="fw-semibold text-gray-400">Phí đã đóng (VNĐ)</div>
                            </div>
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                <div class="fs-6 text-gray-800 fw-bold">96</div>
                                <div class="fw-semibold text-gray-400">Tổng số buổi</div>
                            </div>
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                <div class="fs-6 text-gray-800 fw-bold">56</div>
                                <div class="fw-semibold text-gray-400">Số buổi còn lại</div>
                            </div>
                        </div>
                        <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" aria-label="This project 50% completed" data-kt-initialized="1">
                            <div class="bg-primary rounded h-4px" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
<style>
a.card.border-hover-primary:hover{
    background-color: #deefdc;
}
</style>
@stop