@extends('admin.layouts.admin')
@section('head.title', 'Dashboard')
@section('body.content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        <!--begin::Row-->
        <div class="card mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-body" style="padding-bottom: 0px;">
                <form method="get" action="{{ route('admin.students.list') }}">
                    <div class="col-md-4 d-flex flex-column mb-7 fv-row">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                            <span>Nhập từ khóa tìm kiếm</span>
                        </label>
                        <!--end::Label-->
                        <input type="text" class="form-control " placeholder="" name="keyword" value="{{$keyword}}">
                    </div>
                    <div class="text-center">
                        <a href="{{ route('admin.students.list') }}">
                            <button type="button" id="kt_modal_new_card_cancel" class="btn btn-sm btn-light me-3"><i class="fa-solid fa-ban"></i> Hủy</button>
                        </a>
                        <button type="submit" id="kt_modal_new_card_submit" class="btn btn-sm btn-primary">
                            <i class="fa-solid fa-magnifying-glass"></i>Tìm kiếm
                        </button>
                        <a href="{{ route('admin.students.add') }}">
                            <button type="button" class="btn btn-sm btn-success"></i><i class="fa-solid fa-plus"></i>Thêm mới</button>
                        </a>
                    </div>
                </form>
            </div>
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Danh sách học sinh</span>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-3">
                <!--begin::Table container-->
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 list-student">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="fw-bold text-muted bg-light" style="border-bottom: none;">
                                <th class="ps-4 min-w-60px rounded-start">STT</th>
                                <th class="min-w-250px">Học sinh</th>
                                <th class="min-w-250px">Phụ huynh</th>
                                <th class="min-w-250px">Trạng thái</th>
                                <th class="min-w-100px">Buổi học</th>
                                <th class="min-w-100px">Thao tác</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                            @foreach($list AS $k=>$row)
                            <tr>
                                <td class="text-center">{{($page-1)*$limit + $k+1}}</td>
                                <td class="text-top">
                                    <div class="d-flex align-items-center text-top">
                                        <div class="symbol symbol-45px me-5">
                                            @if($row->avatar)
                                            <img src="{{config('app.url').'/'.$row->avatar}}" class="h-75 align-self-end" alt="">
                                            @elseif($row->gender=='Nam')
                                            <img alt="Pic" src="../assets/media/svg/avatars/001-boy.svg" class="h-75 align-self-end">
                                            @else
                                            <img src="../assets/media/svg/avatars/006-girl-3.svg" class="h-75 align-self-end" alt="">
                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-start flex-column">
                                            <p class="text-dark fw-bold mb-1 fs-6">{{$row->name}}</p>
                                            <p class="text-dark fw-semibold d-block fs-7">Mã: {{$row->crm_id}}</p>
                                            <p class="text-dark fw-semibold d-block fs-7">Giới tính: {{$row->gender}}</p>
                                            <p class="text-dark fw-semibold d-block fs-7">Ngày sinh: {{$row->date_of_birth}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-top">
                                    <p class="text-dark fw-bold mb-1 fs-6">{{$row->gud_name1}}</p>
                                    <p class="text-dark fw-semibold d-block fs-7">Điện thoại: {{$row->gud_mobile1}}</p>
                                    <p class="text-dark fw-semibold d-block fs-7">Địa chỉ: {{$row->address}}</p>
                                </td>
                                <td class="text-top">
                                    <p class="text-dark fw-semibold d-block fs-7">{{$row->branch_name}}</p>
                                    <p class="text-dark fw-semibold d-block fs-7">Lớp: {{$row->class_name}}</p>
                                    <p class="text-dark fw-semibold d-block fs-7">EC: {{$row->ec_name}}</p>
                                    <p class="text-dark fw-semibold d-block fs-7">Nguồn: {{$row->source_name}}</p>
                                    <p class="text-dark fw-semibold d-block fs-7">Trạng thái: <strong{{$row->student_status}}< /strong>
                                    </p>
                                </td>
                                <td>
                                    <div class="d-flex flex-column w-100 me-2">
                                        <div class="d-flex flex-stack mb-2">
                                            <span class="text-dark me-2 fs-7 fw-bold"><span style="font-size: 18px;">64</span>/96</span>
                                        </div>
                                        <div class="progress h-6px w-100" style="background: #ccc;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.students.detail',['student_id'=>$row->id]) }}" class="btn btn-icon btn-light btn-hover-primary btn-sm"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('admin.students.edit',['student_id'=>$row->id]) }}" class="btn btn-icon btn-light btn-hover-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                @include('admin.partials.pagination')
                <!--end::Table container-->
            </div>
            <!--begin::Body-->
        </div>
    </div>
    <!--end::Content container-->
</div>
@stop