@extends('admin.layouts.admin')
@section('head.title', 'Dashboard')
@section('body.content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="row g-5 g-xl-8">
            <!--begin::Col-->
            <div class="col-xl-5" style="margin:auto;">

                <!--begin::Mixed Widget 1-->
                <div class="card card-xl-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body p-0">
                        <!--begin::Header-->
                        <div class="px-9 pt-7 card-rounded h-275px w-100 bg-primary">
                            <!--begin::Heading-->
                            <div class="d-flex flex-stack">
                                <h3 class="m-0 text-white fw-bold fs-3" style="width: 100%; text-align:center">Thông Tin Chuyển Khoản</h3>
                            </div>
                            <!--end::Heading-->

                            <!--begin::Balance-->
                            <div class="d-flex text-center flex-column text-white pt-2">
                                <span class="fw-bold fs-2x pt-1">{{number_format($payment_info->amount,0,",",".")}} VND</span>
                            </div>
                            <!--end::Balance-->
                        </div>
                        <!--end::Header-->

                        <!--begin::Items-->
                        <div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1" style="margin-top: -146px">
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-6">
                                <div class="d-flex align-items-center flex-wrap w-100">
                                    <!--begin::Title-->
                                    <div class="mb-1 pe-3 flex-grow-1">
                                        <span class="fs-5 text-gray-800 text-hover-primary">Ngân hàng</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="fw-bold fs-5 text-gray-800 pe-1">
                                            <img alt="Pic" src="/images/logo_vpb.svg" style="width: 86px;margin-top: -10px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-6">
                                <div class="d-flex align-items-center flex-wrap w-100">
                                    <!--begin::Title-->
                                    <div class="mb-1 pe-3 flex-grow-1">
                                        <span class="fs-5 text-gray-800 text-hover-primary">Số tài khoản</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="fw-bold fs-5 text-gray-800 pe-1">
                                            64308987
                                        </div>
                                        <i class="fa-solid fa-copy" style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="Copy: 64308987" id="copy_taikhoan" onclick="copyText('64308987','taikhoan')"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-6">
                                <div class="d-flex align-items-center flex-wrap w-100">
                                    <!--begin::Title-->
                                    <div class="mb-1 pe-3 flex-grow-1">
                                        <span class="fs-5 text-gray-800 text-hover-primary">Chủ tài khoản</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="fw-bold fs-5 text-gray-800 pe-1">
                                            LUONG THANH CONG
                                        </div>
                                        <i class="fa-solid fa-copy" style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="Copy: LUONG THANH CONG" id="copy_chutaikhoan" onclick="copyText('LUONG THANH CONG','chutaikhoan')"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-6">
                                <div class="d-flex align-items-center flex-wrap w-100">
                                    <!--begin::Title-->
                                    <div class="mb-1 pe-3 flex-grow-1">
                                        <span class="fs-5 text-gray-800 text-hover-primary">Số tiền chuyển</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="fw-bold fs-5 text-gray-800 pe-1">
                                            {{number_format($payment_info->amount,0,",",".")}} VND
                                        </div>
                                        <i class="fa-solid fa-copy" style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="Copy: {{$payment_info->amount}}" id="copy_sotien" onclick="copyText('{{$payment_info->amount}}','sotien')"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-6">
                                <div class="d-flex align-items-center flex-wrap w-100">
                                    <!--begin::Title-->
                                    <div class="mb-1 pe-3 flex-grow-1">
                                        <span class="fs-5 text-gray-800 text-hover-primary">Nội dung chuyển</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="fw-bold fs-5 text-gray-800 pe-1">
                                            {{$payment_info->code}}
                                        </div>
                                        <i class="fa-solid fa-copy" style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="Copy: {{$payment_info->code}}" id="copy_noidung" onclick="copyText('{{$payment_info->code}}','noidung')"></i>
                                    </div>
                                </div>
                            </div>
                            @if($payment_info->status===0)
                            <a style="width:100%" href="{{ route('admin.payment.transfer',['payment_id'=>$payment_info->id]) }}" class="btn btn-sm btn-success">Đã chuyển khoản</a>
                            @else
                            <hr>
                            <div class="d-flex align-items-center mb-6">
                                <div class="d-flex align-items-center flex-wrap w-100">
                                    <!--begin::Title-->
                                    <div class="mb-1 pe-3 flex-grow-1">
                                        <span class="fs-5 text-gray-800 text-hover-primary">Trạng thái</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="fw-bold fs-5 text-gray-800 pe-1" style="{{$payment_info->status==1 ? 'color:red !important':'color:green !important'}}">
                                            {{$payment_info->status==1 ? "Chờ xác nhận" : "Thành công"}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <!--end::Items-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 1-->
            </div>
            <div class="col-xl-8" style="margin:auto; margin-top:15px;">
                <ul>
                <li><i>Vui lòng chuyển khoản 24/7 và đảm bảo đúng nội dung chuyển khoản để giao dịch được xử lý nhanh nhất.</i></li>
                <li><i>Khi chuyển khoản, vui lòng chọn hình thức Người chuyển trả phí để chúng tôi nhận được chính xác số tiền đã chuyển.</i></li>
                <li><i>Sau khi chuyển khoản, vui lòng chọn xác nhận đã chuyển khoản.</i></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    function copyText(text,id) {
        // Copy the text inside the text field
        navigator.clipboard.writeText(text);
        $('#copy_'+id).tooltip('show')
    }
</script>
@stop