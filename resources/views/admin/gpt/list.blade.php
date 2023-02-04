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
                <form method="get" action="{{ route('admin.gpt.list') }}">
                    <div class="col-md-4 d-flex flex-column mb-7 fv-row">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                            <span>Nhập từ khóa tìm kiếm</span>
                        </label>
                        <!--end::Label-->
                        <input type="text" class="form-control " placeholder="" name="keyword" value="{{$keyword}}">
                    </div>
                    <div class="text-center">
                        <a href="{{ route('admin.gpt.list') }}">
                            <button type="button" id="kt_modal_new_card_cancel" class="btn btn-sm btn-light me-3"><i class="fa-solid fa-ban"></i> Hủy</button>
                        </a>
                        <button type="submit" id="kt_modal_new_card_submit" class="btn btn-sm btn-primary">
                            <i class="fa-solid fa-magnifying-glass"></i>Tìm kiếm
                        </button>
                        <a href="{{ route('admin.gpt.add') }}">
                            <button type="button" class="btn btn-sm btn-success"></i><i class="fa-solid fa-question"></i> Thêm mới</button>
                        </a>
                    </div>
                </form>
            </div>
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Lịch sử</span>
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
                                <th class="text-center ps-4 min-w-60px rounded-start">STT</th>
                                <th class="text-center min-w-250px">Nội dung</th>
                                <th class="text-center">Ruby</th>
                                <th class="text-center">Thời gian</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list AS $k=>$row)
                            <tr>
                                <td class="text-center">{{($page-1)*$limit + $k+1}}</td>
                                <td>{{strlen($row->question) > 100 ? substr($row->question,0, 100)."..." : $row->question }}</td>
                                <td class="text-center">{{$row->coins}}</td>
                                <td class="text-center">{{$row->created_at}}</td>
                                <td class="text-center">
                                    @if($row->status==1)
                                    <i class="fa-solid fa-check" style="font-size: 24px; color: #10d114;"></i>
                                    @else
                                    <i class="fa-solid fa-x" style="font-size: 20px; color: #b20c0c;"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.gpt.detail',['chat_id'=>$row->id]) }}" class="btn btn-icon btn-light btn-hover-primary btn-sm"><i class="fa-solid fa-eye"></i></a>
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