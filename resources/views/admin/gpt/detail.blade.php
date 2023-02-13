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
                    <a href="{{route('admin.gpt.add')}}" class="text-muted text-hover-primary">Hỏi đáp GPT</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Trả lời</li>
                <!--end::Item-->
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
                    <h2>Trả Lời</h2>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="fv-row fv-plugins-icon-container">
                        <label class="fs-6 fw-semibold form-label mt-3">
                            <span>Nội dung câu hỏi</span>
                        </label>
                        <div class="alert alert-primary" role="alert">
                            {{$chat_info->question}}
                        </div>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-sm-3 rol-cols-md-1 row-cols-lg-3">
                    <div class="col">
                        <div class="fv-row fv-plugins-icon-container">
                            <div class="form-control" style="border:none">
                                <input type="text" id="result_token" tabindex="-1" data-min="10" data-max="1024" data-from="{{$chat_info->max_token}}" name="result_token" value="" onchange="caculatorRuby()" />
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <input type="hidden" id="coins_tmp" name="coins_tmp" value="5">
                        <div class="fv-row fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span style="margin-right: 10px">Ruby</span>
                                @for($i=1;$i<=$chat_info->coins;$i++)
                                <i id="ruby_1" class="fa-solid fa-gem active"></i>
                                @endfor
                            </label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex flex-column align-items-start">
                    <!--begin::User-->
                    <div class="d-flex align-items-center mb-2">
                        <!--begin::Avatar-->
                        <div class="symbol  symbol-35px symbol-circle "><img alt="Pic" src="/images/openai-svgrepo-com.svg"></div><!--end::Avatar-->
                        <!--begin::Details-->
                        <div class="ms-3">
                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">GPT</a>
                        </div>
                    </div>
                    <div class="p-5 rounded bg-light-info text-dark fw-semibold text-start" style="width: 100%;">
                        {{$chat_info->answer}} 
                    </div>
                </div>
                <div class="d-flex justify-content-end" style="margin-top: 10px;">
                    <a href="{{ route('admin.gpt.list') }}" class="btn btn-secondary" style="margin-right: 10px;">
                        <i class="fa-solid fa-list"></i> <span class="indicator-label">Lịch sử</span>
                    </a>
                    <a href="{{ route('admin.gpt.add') }}" class="btn btn-success">
                        <i class="fa-solid fa-question"></i> <span class="indicator-label">Đặt câu hỏi</span>
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</div>
<script>
    $("#result_token").ionRangeSlider();
</script>
@stop