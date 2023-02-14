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
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <a href="{{route('admin.loigiai.level',['level_id'=>$cat_info->level])}}" class="text-muted text-hover-primary">Lớp {{$cat_info->level}}</a>
                </li>
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
        <div class="card card-xl-stretch">
            <!--begin::Header-->
            <div class="card-header border-0">
                <h2 class="card-title fw-bold text-dark" style="font-size: 22px;">{{$cat_info->title}}</h2>
            </div>
            <div class="card-body pt-2 row">
                <!--begin:Heading-->
                <?php 
                $title_group ="";
                foreach($list_subject AS $subject):
                    if($subject->group!=$title_group):
                        $title_group = $subject->group;
                ?>
                <h4 class="fs-6 fs-lg-4 text-gray-800 fw-bold mt-3 mb-3 ms-4">{{$title_group}}</h4>
                <?php endif;?>
                <div class="menu-item p-0 m-0 subject_link">
                    <!--begin:Menu link-->
                    <a href="{{route('admin.loigiai.subject',['subject_id'=>$subject->id])}}" class="menu-link">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot bg-gray-300i h-6px w-6px"></span>
                        </span>
                        <span class="menu-title">{{$subject->title}}</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <?php endforeach;?>
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