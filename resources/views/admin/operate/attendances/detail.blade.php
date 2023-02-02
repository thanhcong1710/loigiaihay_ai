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
                <form method="get" action="{{ route('admin.operate.contracts.list') }}">
                <div class="row row-cols-1 row-cols-sm-3 rol-cols-md-1 row-cols-lg-3">
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Trung tâm</span>
                                </label>
                                <select class="form-select" name="branch_id" id="branch_id" data-control="select2" data-placeholder="Chọn trung tâm" data-allow-clear="true" required>
                                    <option></option>
                                    @foreach($branches As $branch)
                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Kỳ học</span>
                                </label>
                                <select class="form-select" name="semester_id" id="semester_id" onchange="loadProgram()" required>
                                    <option></option>
                                    @foreach($semesters As $semester)
                                    <option value="{{$semester->product_id}}">{{$semester->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Chương trình</span>
                                </label>
                                <select class="form-select" name="program_id" id="program_id"  onchange="loadClass()" data-control="select2" data-placeholder="Chọn chương trình học" data-allow-clear="true" required>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Lớp học</span>
                                </label>
                                <select class="form-select" name="class_id" id="class_id" onchange="loadStudent()" data-control="select2" data-placeholder="Chọn lớp học" data-allow-clear="true" required>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Tháng học</span>
                                </label>
                                <select class="form-select" name="month_id" id="month_id" required>
                                    <option value="2022-10">2022-10</option>
                                    <option value="2022-11" selected>2022-11</option>
                                    <option value="2022-12">2022-12</option>
                                    <option value="2022-13">2023-01</option>
                                    <option value="2022-14">2023-02</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Danh sách học sinh</span>
                </h3>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 list-student">
                        <thead>
                            <tr class="fw-bold text-muted bg-light" style="border-bottom: none;">
                                <th class="ps-4 min-w-60px rounded-start">STT</th>
                                <th class="min-w-200px">Học sinh</th>
                                <th class="min-w-200px">Mã CRM</th>
                                <th class="min-w-100px">Buổi 1</th>
                                <th class="min-w-100px">Buổi 2</th>
                                <th class="min-w-100px">Buổi 3</th>
                                <th class="min-w-100px">Buổi 4</th>
                            </tr>
                        </thead>
                        <tbody id="table_content">
                            
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function loadProgram(){
        $('#class_id').val('')
        $.ajax({
            type: "POST",
            url: "{{route('admin.operate.attendance.get_list_program')}}",
            dataType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                branch_id: $('#branch_id').val(),
                product_id: $('#semester_id').val(),
            },
            error: function(err) {},
            success: function(data) {
                var sel = $("#program_id");
                sel.empty();
                sel.append('<option></option>');
                for (var i = 0; i < data.length; i++) {
                    sel.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                }
            }
        });
    }
    function loadClass(){
        $.ajax({
            type: "POST",
            url: "{{route('admin.operate.attendance.get_list_class')}}",
            dataType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                branch_id: $('#branch_id').val(),
                product_id: $('#semester_id').val(),
                program_id: $('#program_id').val(),
            },
            error: function(err) {},
            success: function(data) {
                var sel = $("#class_id");
                sel.empty();
                sel.append('<option></option>');
                for (var i = 0; i < data.length; i++) {
                    sel.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                }
            }
        });
    }
    function loadStudents(){
        $.ajax({
            type: "POST",
            url: "{{route('admin.operate.attendance.get_list_class')}}",
            dataType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                branch_id: $('#branch_id').val(),
                product_id: $('#semester_id').val(),
                program_id: $('#program_id').val(),
            },
            error: function(err) {},
            success: function(data) {
                var sel = $("#class_id");
                sel.empty();
                sel.append('<option></option>');
                for (var i = 0; i < data.length; i++) {
                    sel.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                }
            }
        });
    }
    function loadStudent() {
        loading();
        $.ajax({
            type: "POST",
            url: "{{route('admin.operate.attendance.get_student')}}",
            dataType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                class_id: $('#class_id').val(),
            },
            error: function(err) {},
            success: function(data) {
                var sel ='';
                for (var i = 0; i < data.length; i++) {
                    sel = sel+'<tr>'+
                            '<td class="text-center">'+(i+1)+'</td>'+
                            '<td>' + data[i].name + '</td>'+
                            '<td>'+ data[i].crm_id +'</td>'+
                            '<td>'+
                                '<span class="switch switch-outline switch-icon switch-success">'+
                                    '<label>'+
                                    '<input type="checkbox" name="select"/>'+
                                    '<span></span>'+
                                    '</label>'+
                                '</span>'+
                            '</td>'+
                            '<td>'+
                                '<span class="switch switch-outline switch-icon switch-success">'+
                                    '<label>'+
                                    '<input type="checkbox"  name="select"/>'+
                                    '<span></span>'+
                                    '</label>'+
                                '</span>'+
                            '</td>'+
                            '<td>'+
                                '<span class="switch switch-outline switch-icon switch-success">'+
                                    '<label>'+
                                    '<input type="checkbox" name="select"/>'+
                                    '<span></span>'+
                                    '</label>'+
                                '</span>'+
                            '</td>'+
                            '<td>'+
                                '<span class="switch switch-outline switch-icon switch-success">'+
                                    '<label>'+
                                    '<input type="checkbox"  name="select"/>'+
                                    '<span></span>'+
                                    '</label>'+
                                '</span>'+
                            '</td>'+
                        '</tr>';
                }
                $('#table_content').html(sel);
                unloading();
            }
        });
    }
</script>
@stop