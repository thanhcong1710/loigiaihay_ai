@extends('admin.layouts.admin')
@section('head.title', 'Dashboard')
@section('body.content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        <!--begin::Row-->
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Lịch sử giao dịch</span>
                </h3>
                <a href="{{ route('admin.payment.add') }}" style="float:right;"  class="btn btn-success">
                    <i class="fa-solid fa-dollar-sign"></i> Nạp Ngay
                </a>
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
                                <th class="text-center ps-4 min-w-60px rounded-start">STT</th>
                                <th class="text-center">Gói phí</th>
                                <th class="text-center">Số tiền</th>
                                <th class="text-center">Ruby</th>
                                <th class="text-center">Thời gian tạo</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list AS $k=>$row)
                            <tr>
                                <td class="text-center">{{($page-1)*$limit + $k+1}}</td>
                                <td class="text-center">{{$row->fee_name}}</td>
                                <td class="text-right">{{number_format($row->amount,0,",",".")}} VND</td>
                                <td class="text-center">{{$row->coins}} <i class="fa-solid fa-gem vip"></i></td>
                                <td class="text-center">{{$row->created_at}}</td>
                                <td class="text-center">{{$row->status==1 ? "Chờ xác nhận" : ($row->status==2 ? "Thành công" : "Chưa chuyển khoản")}}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.payment.detail',['payment_id'=>$row->id]) }}" class="btn btn-icon btn-light btn-hover-primary btn-sm"><i class="fa-solid fa-eye"></i></a>
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