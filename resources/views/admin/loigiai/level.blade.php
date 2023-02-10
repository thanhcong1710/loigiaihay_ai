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
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                    Kho tài liệu
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
        <div class="row">
            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0">
                    <h3 class="card-title fw-bold text-dark">{{$category_name}}</h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-2 row">
                    @foreach($list_category AS $k=> $row)
                    <!--begin::Item-->
                    <a href="{{route('admin.loigiai.category',['category_id'=>$row->id])}}" class="col-xl-6">
                        <div class="d-flex align-items-center mb-4">
                            <!--begin::Bullet-->
                            <span class="bullet bullet-vertical h-40px bg-secondary"></span>
                            <!--end::Bullet-->
                            <!--begin::Checkbox-->
                            <div class="form-check form-check-custom form-check-solid mx-3">
                            </div>
                            <!--end::Checkbox-->
                            <!--begin::Description-->
                            <div class="flex-grow-1">
                                <span class="text-gray-800 text-hover-primary fw-bold fs-6">{{$row->title}}</span>
                                <span class="text-muted fw-semibold d-block">50 chuyên đề 87 bài tập</span>
                            </div>
                            <!--end::Description-->
                        </div>
                    </a>
                    <!--end:Item-->
                    @endforeach
                </div>
                <!--end::Body-->
            </div>
        </div>
        <!--end::Content container-->
    </div>
</div>
<style>
a:hover .bullet.bg-secondary{
    background-color: #58c04f !important;
}
</style>
@stop