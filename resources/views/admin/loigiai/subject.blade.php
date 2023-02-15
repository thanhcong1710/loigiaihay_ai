@extends('admin.layouts.admin')
@section('head.title', 'Dashboard')
@section('body.content')

<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">Trang chủ</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('admin.loigiai.level',['level_id'=>$subject_info->cat_level])}}" class="text-muted text-hover-primary">Lớp {{$subject_info->cat_level}}</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('admin.loigiai.category',['category_id'=>$subject_info->cat_id,'slug_cat'=>$subject_info->slug_cat])}}" class="text-muted text-hover-primary">{{$subject_info->cat_title}}</a>
                </li>
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->

    </div>
    <!--end::Toolbar container-->
</div>
<div id="kt_app_content" class="app-content flex-column-fluid subject-detail">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card card-xl-stretch">
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">
                    <h3>{{$subject_info->title}}</h3>
                </div>
            </div>
            <div class="card-body pt-4 row">
            {!! $subject_info->noi_dung !!}
            @if(count($questions))
            <hr>
            <h2>Bài Tập Và Hướng Dẫn Giải</h2>
                @foreach($questions AS $ques)
                {!! $ques->noi_dung !!}
                <p><b>Lời giải:</b></p>
                {!! $ques->tra_loi !!}
                @endforeach
            @endif
                <div class="d-flex justify-content-center">
                    <a href="{{route('admin.loigiai.category',['category_id'=>$subject_info->cat_id,'slug_cat'=>$subject_info->slug_cat])}}" class="btn btn-secondary" style="margin-right: 10px; width:30%;max-width:200px;">
                        <i class="fa-solid fa-rotate-left"></i> Quay lại
                    </a>
                    @if(isset($subject_next->id))
                    <a href="{{route('admin.loigiai.subject',['subject_id'=>$subject_next->id,'slug_subject'=>$subject_next->slug])}}" class="btn btn-success" style=" width:30%;max-width:200px;">
                        Chuyên đề tiếp <i class="fa-solid fa-forward"></i>
                    </a>
                    @endif
                </div>
            </div>
            <!--end::Body-->
            
        </div>
    </div>
</div>
<style>
    a.menu-link{
        color:#181c32;
    }
    a.menu-link:hover{
        color:#009ef7;
    }
</style>
@stop