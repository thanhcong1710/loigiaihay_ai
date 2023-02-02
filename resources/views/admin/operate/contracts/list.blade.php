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
                <form method="get" action="{{ route('admin.operate.contracts.list') }}">
                    <div class="col-md-4 d-flex flex-column mb-7 fv-row">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                            <span>Nhập từ khóa tìm kiếm</span>
                        </label>
                        <!--end::Label-->
                        <input type="text" class="form-control " placeholder="" name="keyword" value="{{$keyword}}">
                    </div>
                    <div class="text-center">
                        <a href="{{ route('admin.operate.contracts.list') }}">
                            <button type="button" id="kt_modal_new_card_cancel" class="btn btn-sm btn-light me-3"><i class="fa-solid fa-ban"></i> Hủy</button>
                        </a>
                        <button type="submit" id="kt_modal_new_card_submit" class="btn btn-sm btn-primary">
                            <i class="fa-solid fa-magnifying-glass"></i>Tìm kiếm
                        </button>
                        <a href="{{ route('admin.operate.contracts.add') }}">
                            <button type="button" class="btn btn-sm btn-success"></i><i class="fa-solid fa-plus"></i>Thêm mới</button>
                        </a>
                    </div>
                </form>
            </div>
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Danh sách nhập học</span>
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
                                <th class="min-w-200px">Học sinh</th>
                                <th class="min-w-200px">Thông tin nhập học</th>
                                <th class="min-w-200px">Thông tin đóng phí</th>
                                <th class="min-w-100px">Số buổi</th>
                                <th class="min-w-100px">Thao tác</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                            @foreach($list AS $k=>$row)
                            <tr>
                                <td class="text-top text-center">{{($page-1)*$limit + $k+1}}</td>
                                <td class="text-top">
                                    <div class="d-flex align-items-center text-top">
                                        <div class="d-flex justify-content-start flex-column">
                                            <p class="text-dark fw-bold mb-1 fs-6">{{$row->name}}</p>
                                            <p class="text-dark fw-semibold d-block fs-7">Mã: {{$row->crm_id}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-top">
                                    <p class="text-dark fw-bold mb-1 fs-6">Mã: {{$row->contract_code}}</p>
                                    <p class="text-dark fw-semibold d-block fs-7">Loại: {{$row->type_name}}</p>
                                    <p class="text-dark fw-semibold d-block fs-7">Ngày học: {{$row->start_date}}</p>
                                    <p class="text-dark fw-semibold d-block fs-7">{{$row->branch_name}}</p>
                                    <p class="text-dark fw-semibold d-block fs-7">EC: {{$row->ec_name}}</p>
                                    <p class="text-dark fw-semibold d-block fs-7">CS: {{$row->cm_name}}</p>
                                    </p>
                                </td>
                                <td class="text-top">
                                    <p class="text-dark fw-bold mb-1 fs-6">{{$row->tuition_fee_name ? $row->tuition_fee_name :'Gói học thử'}}</p>
                                    <p class="text-dark fw-semibold d-block fs-7">Giá gốc: {{number_format($row->tuition_fee_price,'0',',','.')}}đ</p>
                                    <p class="text-dark fw-semibold d-block fs-7">Phải đóng: {{number_format($row->must_charge,'0',',','.')}}đ</p>
                                    <p class="text-dark fw-semibold d-block fs-7">Công nợ: {{number_format($row->debt_amount,'0',',','.')}}đ</p>
                                </td>
                                <td class="text-top">
                                    <p class="text-dark fw-semibold d-block fs-7">Tổng: <strong>{{$row->total_sessions}}</strong></p>
                                    <p class="text-dark fw-semibold d-block fs-7">Học bổng: {{$row->bonus_sessions}}</p>
                                </td>
                                <td class="text-top">
                                    <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm"><i class="fa-solid fa-print"></i></a>
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