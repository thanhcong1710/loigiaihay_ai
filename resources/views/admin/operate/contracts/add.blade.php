@extends('admin.layouts.admin')
@section('head.title', 'Dashboard')
@section('body.content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="row g-7">
            <div class="col-xl-6">
                <!--begin::Contacts-->
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
                            <h2>Thông tin học sinh</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-5">
                        <!--begin::Form-->
                        <div class="form fv-plugins-bootstrap5 fv-plugins-framework">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Trung tâm</span>
                                </label>
                                <select class="form-select" name="branch_id" id="branch_id" data-control="select2" data-placeholder="Chọn trung tâm" data-allow-clear="true" onchange="selectBranch()" required>
                                    <option></option>
                                    @foreach($branches As $branch)
                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Tìm kiếm học sinh theo mã CMS hoặc Tên:</span>
                                </label>
                                <input id="search_student" class="form-control" disabled>
                            </div>
                            <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>Họ tên</span>
                                        </label>
                                        <input type="text" class="form-control " name="name" id="name" value="" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>Mã CRM</span>
                                        </label>
                                        <input type="text" class="form-control " name="crm_id" id="crm_id"  value="" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>Mã hợp đồng</span>
                                        </label>
                                        <input type="text" class="form-control " name="contract_code" value="" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>Phụ huynh</span>
                                        </label>
                                        <input type="text" class="form-control " name="gud_name1" id="gud_name1" value="" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>Số điện thoại</span>
                                        </label>
                                        <input type="text" class="form-control " name="gud_mobile1" id="gud_mobile1" value="" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>Email</span>
                                        </label>
                                        <input type="text" class="form-control " name="gud_email1" id="dug_email1" value="" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>Địa chỉ</span>
                                        </label>
                                        <input type="text" class="form-control " name="address" id="address" value="" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>Trường học</span>
                                        </label>
                                        <input type="text" class="form-control " name="shool" id="school" value="" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>Trung tâm</span>
                                        </label>
                                        <input type="text" class="form-control " name="branch_name" id="branch_name" value="" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>EC</span>
                                        </label>
                                        <input type="text" class="form-control " name="ec_name" id="ec_name" value="" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>EC leader</span>
                                        </label>
                                        <input type="text" class="form-control " name="ecl_name" id="ecl_name" value="" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>Giám đốc trung tâm</span>
                                        </label>
                                        <input type="text" class="form-control " name="gdtt" id="gdtt" value="" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card card-flush h-lg-100" id="kt_contacts_main">
                    <div class="card-header pt-7" id="kt_chat_contacts_header">
                        <div class="card-title">
                            <span class="svg-icon svg-icon-1 me-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="currentColor"></path>
                                    <path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="currentColor"></path>
                                </svg>
                            </span>
                            <h2>Thông tin nhập học</h2>
                        </div>
                    </div>
                    <div class="card-body pt-5">
                        <form id="kt_ecommerce_settings_general_form" method="POST" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{route('admin.operate.contracts.store')}}">
                        @csrf
                            <input id="student_id" name="student_id" type="hidden">
                            <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span class="required">Loại khách hàng</span>
                                        </label>
                                        <select class="form-select" name="contract_type" required>
                                            <option>Chọn loại khách hàng</option>
                                            <option value="0">Học thử</option>
                                            <option value="1">Chính thức</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span class="required">Chương trình học</span>
                                        </label>
                                        <select class="form-select" name="product_id" id="product_id" required onchange="loadTuitionFee()">
                                            <option>Chọn chương trình học</option>
                                            @foreach($products As $product)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span class="required">Ca học</span>
                                        </label>
                                        <select class="form-select" name="shift" data-control="select2" data-placeholder="Chọn ca học" data-allow-clear="true" required>
                                            <option>Chọn ca học</option>
                                            @foreach($shifts As $shift)
                                            <option value="{{$shift->id}}">{{$shift->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>Gói phí</span>
                                </label>
                                <select class="form-select" name="tuition_fee_id" id="tuition_fee_id" onchange="selectTuitionFee()" data-control="select2" data-placeholder="Chọn gói phí" data-allow-clear="true" required>
                                    <option></option>
                                </select>
                            </div>
                            <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>Giá gốc</span>
                                        </label>
                                        <input type="text" class="form-control " name="price" id="price" value="" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>Số tiền phải đóng</span>
                                        </label>
                                        <input type="text" class="form-control " name="must_charge" id="must_charge" value="" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>Số buổi học</span>
                                        </label>
                                        <input type="text" class="form-control " name="session" id="session" value="" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>Số buổi học bổng</span>
                                        </label>
                                        <input type="text" class="form-control " name="bonus_sessions" id="bonus_sessions" value="" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>Ngày dự kiến học</span>
                                        </label>
                                        <input class="form-control" placeholder="Chọn ngày sinh" id="kt_daterangepicker_1" name="start_date" required />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>Ngày dự kiến kết thúc</span>
                                        </label>
                                        <input type="text" class="form-control " name="end_date" value="" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>Lớp học mong muốn</span>
                                </label>
                                <input type="text" class="form-control " name="name" value="">
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.operate.contracts.list') }}">
                                    <button type="button" id="kt_modal_new_card_cancel" class="btn btn-light me-3"><i class="fa-solid fa-ban"></i>Hủy</button>
                                </a>
                                <button type="submit" id="kt_modal_new_card_submit" class="btn btn-success">
                                    <span class="indicator-label"><i class="fa-solid fa-floppy-disk"></i>Lưu</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  
<script>
    $("#kt_daterangepicker_1").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format("YYYY"), 12),
        locale: {
            format: "DD/MM/YYYY"
        }
    }, function(start, end, label) {
        var years = moment().diff(start, "years");
    });
    function selectBranch() {
        document.getElementById('search_student').disabled = false;
    }
    function selectStudent(){
        $.ajax({
            url: "{{ route('admin.operate.contracts.get_student_info') }}",
            data: {
                student_id: $('#student_id').val()
            },
            success: function(data) {
                data = jQuery.parseJSON(data);
                $('#name').val(data.name);
                $('#crm_id').val(data.crm_id);
                $('#gud_name1').val(data.gud_name1);
                $('#gud_mobile1').val(data.gud_mobile1);
                $('#gud_email1').val(data.gud_email1);
                $('#address').val(data.address);
                $('#school').val(data.school);
                $('#branch_name').val(data.branch_name);
                $('#ec_name').val(data.ec_name);
                $('#ecl_name').val(data.ecl_name);
            }
        });
    }
    $(function() {
        $("#search_student").autocomplete({
            source: function(request, response) {
                var data_list = [];
                loading();
                $.ajax({
                    url: "{{ route('admin.operate.contracts.search_student') }}",
                    data: {
                        q: request.term,
                        branch_id:$('#branch_id').val()
                    },
                    success: function(data) {
                        data_list = jQuery.parseJSON(data);
                        response(data_list);
                        unloading();
                    }
                });
            },
            minLength: 3,
            select: function(event, ui) {
                $('#student_id').val(ui.item.student_id);
                selectStudent();
            },
        });
    });
    function loadTuitionFee() {
        $("#tuition_fee_id").val("")
        $.ajax({
            type: "POST",
            url: "{{route('admin.operate.contracts.get_list_tuititon_fee')}}",
            dataType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                product_id: $('#product_id').val(),
                branch_id: $('#branch_id').val()
            },
            error: function(err) {},
            success: function(data) {
                var sel = $("#tuition_fee_id");
                sel.empty();
                sel.append('<option></option>');
                for (var i = 0; i < data.length; i++) {
                    sel.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                }
            }
        });
    };
    function selectTuitionFee() {
        $.ajax({
            type: "POST",
            url: "{{route('admin.operate.contracts.get_tuititon_fee_info')}}",
            dataType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                tuition_fee_id: $('#tuition_fee_id').val(),
            },
            error: function(err) {},
            success: function(data) {
                $('#price').val(data.price);
                $('#must_charge').val(data.receivable);
                $('#session').val(data.session);
            }
        });
    };
</script>
@stop