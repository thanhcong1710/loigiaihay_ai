@extends('admin.layouts.admin')
@section('head.title', 'Dashboard')
@section('body.content')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">Trang chủ</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('admin.payment.add')}}" class="text-muted text-hover-primary">Nạp Ruby</a>
                </li>
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->

    </div>
    <!--end::Toolbar container-->
</div>
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card" id="kt_pricing">
            <!--begin::Card body-->
            <div class="card-body p-lg-17">
                <!--begin::Plans-->
                <div class="d-flex flex-column">
                    <!--begin::Heading-->
                    <div class="mb-13 text-center">
                        <h1 class="fs-2hx fw-bold mb-5">Lựa Chọn Gói Nạp</h1>
                        <div class="text-gray-800 fw-semibold fs-5">
                            Chính sách ưu đãi trên đây được áp dụng từ <span class="link-primary fw-bold">01/01/2023</span> đến hết <span class="link-primary fw-bold">01/06/2023</span>
                        </div>
                    </div>
                    <!--begin::Row-->
                    <div class="row g-10">
                        <!--begin::Col-->
                        @foreach($list_payment AS $row)
                        <div class="col-xl-3">
                            <div class="d-flex h-100 align-items-center">
                                <!--begin::Option-->
                                <div class="w-100 d-flex flex-column flex-center rounded-3 bg-light py-15 px-10">
                                    <!--begin::Heading-->
                                    <div class="mb-7 text-center">
                                        <!--begin::Title-->
                                        <h1 class="text-dark mb-5 fw-bolder">{{$row->title}}</h1>
                                        <div class="text-gray-800 fw-semibold mb-5">
                                            Nạp ngay {{$row->coins}} ruby<br> chỉ với 
                                        </div>
                                        <div class="text-center">
                                            <span class="fs-2x fw-bold text-primary" >{{number_format($row->amount,0,",",".")}}</span>
                                            <span class="mb-2 text-primary">VND</span>
                                        </div>
                                        <div class="text-center">
                                            <span style="font-size:20px" >+{{$row->coins}}  <i id="ruby_1" class="fa-solid fa-gem vip"></i></span>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.payment.create',['fee_id'=>$row->id]) }}" class="btn btn-sm btn-success">Nạp Ngay</a>
                                </div>
                                <!--end::Option-->
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Plans-->
            </div>
            <!--end::Card body-->
        </div>
    </div>
    <!--end::Content container-->
</div>
@stop