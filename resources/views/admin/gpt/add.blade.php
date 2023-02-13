@extends('admin.layouts.admin')
@section('head.title', 'Dashboard')
@section('body.content')
<!--begin::Toolbar-->
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
                <li class="breadcrumb-item text-muted">Hỏi đáp GPT</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->

    </div>
    <!--end::Toolbar container-->
</div>
<!--end::Toolbar-->
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
                    <h2>Đặt Câu Hỏi</h2>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <form method="post" action="{{ route('admin.gpt.store') }}" id="form-question" class="form fv-plugins-bootstrap5 fv-plugins-framework">
                    @csrf
                    <div class="row">
                        <div class="fv-row fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Nội dung câu hỏi</span>
                            </label>
                            <textarea class="form-control" id="question" name="question" rows="3" required onchange="caculatorRuby()"></textarea>
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-sm-3 rol-cols-md-1 row-cols-lg-3">
                        <div class="col">
                            <div class="fv-row fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>Ký tự trả về</span>
                                </label>
                                <div class="form-control" style="border:none">
                                    <input type="text" id="result_token" tabindex="-1" data-min="10" data-max="1024" data-from="256" name="result_token" value="" onchange="caculatorRuby()" />
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <input type="hidden" id="coins_tmp" name="coins_tmp" value="5">
                            <div class="fv-row fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span style="margin-right: 10px">Ước tính</span>
                                    <i id="ruby_1" class="fa-solid fa-gem"></i>
                                    <i id="ruby_2" class="fa-solid fa-gem"></i>
                                    <i id="ruby_3" class="fa-solid fa-gem"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="total_ruby" value="5">
                    <div id="message-error" style="color:red; margin: 10px 0px"></div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.gpt.list') }}" class="btn btn-secondary" style="margin-right: 10px;">
                            <i class="fa-solid fa-list"></i> <span class="indicator-label">Lịch sử</span>
                        </a>
                        <button onclick="submitQuestion()" type="button" id="kt_modal_new_card_submit" class="btn btn-success">
                            <i class="fa-solid fa-paper-plane"></i> <span class="indicator-label">Gửi</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="rubyModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tài khoản của bạn không đủ <i class="fa-solid fa-gem"></i></h5>
            </div>
            <div class="modal-body">
                Tài khoản của bạn không đủ <i style="font-size:14px" class="fa-solid fa-gem"></i>. Vui lòng nạp thêm <i style="font-size:14px" class="fa-solid fa-gem"></i> hoặc đợi để được tặng thêm <i style="font-size:14px" class="fa-solid fa-gem"></i> (Free 5 <i style="font-size:14px" class="fa-solid fa-gem"></i>/ngày sử dụng tới 24h hàng ngày)
            </div>
            <div class="modal-footer">
                <a href="{{route('admin.payment.add')}}" class="btn btn-primary font-weight-bold">Nạp <i class="fa-solid fa-gem"></i> ngay</button></a>
            </div>
        </div>
    </div>
</div>
<script>
    var ruby = 0
    $("#result_token").ionRangeSlider();

    function caculatorRuby() {
        var question = $("#question").val()
        var result_token = $("#result_token").val()
        ruby = 0
        if ($("#question").val()) {
            ruby = 1
            if ((parseInt(question.length) + parseInt(result_token)) > 512) {
                ruby = 2
            }
            if ((parseInt(question.length) + parseInt(result_token)) > 1024) {
                ruby = 3
            }
        }
        $(".fa-gem").removeClass("active");
        for (var i = 1; i <= ruby; i++) {
            $("#ruby_" + i).addClass("active")
        }
        $("#coins_tmp").val(ruby);
    }

    function submitQuestion() {
        caculatorRuby()
        $('#message-error').html('');
        if (ruby > $("#total_ruby").val()) {
            $("#rubyModal").modal("show");
        } else {
            if (!$("#question").val()) {
                $('#message-error').html('Nội dung câu hỏi không để trống.');
            } else {
                loading();
                $("#form-question").submit();
            }
        }
    }
</script>
@stop