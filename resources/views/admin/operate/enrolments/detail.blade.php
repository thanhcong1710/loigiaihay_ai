@extends('admin.layouts.admin')
@section('head.title', 'Dashboard')
@section('body.content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="row g-7">
            <div class="col-xl-4">
                <!--begin::Contacts-->
                <div class="card card-flush h-lg-100" id="kt_contacts_main">
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
                                    <span class="required">Kỳ học</span>
                                </label>
                                <select class="form-select" name="semester_id" id="semester_id" onchange="loadClass()" disabled>
                                    <option></option>
                                    @foreach($semesters As $semester)
                                    <option value="{{$semester->id}}">{{$semester->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="kt_docs_jstree_contextual"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card card-flush h-lg-100" id="kt_contacts_main">
                    <div class="card-header pt-7" id="kt_chat_contacts_header">
                        <div class="card-title">
                            <span class="svg-icon svg-icon-1 me-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="currentColor"></path>
                                    <path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="currentColor"></path>
                                </svg>
                            </span>
                            <h2>Thông tin lớp học</h2>
                        </div>
                    </div>
                    <div class="card-body pt-5" style="padding-top:0px!important">
                        <div class="d-flex align-items-center border border-dashed border-gray-300 rounded px-7 py-1 mb-1">
                            <div class="fs-5 text-dark text-hover-primary fw-semibold  w-200px">Tên lớp học</div>
                            <div class="min-w-175px pe-2">
                                <span class="badge badge-light text-dark" style="font-size: 13px;" id="class_name"></span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center border border-dashed border-gray-300 rounded px-7 py-1 mb-1">
                            <div class="fs-5 text-dark text-hover-primary fw-semibold  w-200px">Thời gian</div>
                            <div class="min-w-175px pe-2">
                                <span class="badge badge-light text-dark" style="font-size: 13px;" id="class_time"></span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center border border-dashed border-gray-300 rounded px-7 py-1 mb-1">
                            <div class="fs-5 text-dark text-hover-primary fw-semibold  w-200px">Giáo viên </div>
                            <div class="min-w-175px pe-2">
                                <span class="badge badge-light text-dark" style="font-size: 13px;" id="class_teacher"></span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center border border-dashed border-gray-300 rounded px-7 py-1 mb-1">
                            <div class="fs-5 text-dark text-hover-primary fw-semibold  w-200px">Tổng số học sinh</div>
                            <div class="min-w-175px pe-2">
                                <span class="badge badge-light text-dark" style="font-size: 13px;" id="class_max_students"></span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center border border-dashed border-gray-300 rounded px-7 py-1 mb-1">
                            <div class="fs-5 text-dark text-hover-primary fw-semibold  w-200px">Phòng học</div>
                            <div class="min-w-175px pe-2">
                                <span class="badge badge-light text-dark" style="font-size: 13px;" id="time_place"></span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center border border-dashed border-gray-300 rounded px-7 py-1 mb-1">
                            <div class="fs-5 text-dark text-hover-primary fw-semibold w-200px">CS - giáo viên chủ nhiệm</div>
                            <div class="min-w-175px pe-2">
                                <span class="badge badge-light text-dark" style="font-size: 13px;" id="class_cm_name"></span>
                            </div>
                        </div>
                        <div style="margin: 10px 0px 20px 0px;">
                            <a href="{{ route('admin.students.add') }}">
                                <button type="button" class="btn btn-sm btn-success"></i><i class="fa-solid fa-plus"></i>Xếp lớp thêm học sinh</button>
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 list-student">
                                <thead>
                                    <tr class="fw-bold text-muted bg-light" style="border-bottom: none;">
                                        <th class="ps-4 min-w-60px rounded-start">STT</th>
                                        <th class="min-w-250px">Thông tin học sinh</th>
                                        <th class="min-w-250px">Thông tin xếp lớp</th>
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
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<script>
    function selectBranch() {
        $("#semester_id").val("")
        document.getElementById('semester_id').disabled = false;
    }

    function loadClass() {
        loading();
        $.ajax({
            type: "POST",
            url: "{{route('admin.operate.enrolment.get_list_class')}}",
            dataType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                branch_id: $('#branch_id').val(),
                semester_id: $('#semester_id').val(),
            },
            error: function(err) {},
            success: function(data) {
                loadTree(data)
                unloading();
            }
        });
    };
    var treeJSON = [];
    $("#kt_docs_jstree_contextual").jstree({
        "core": {
            "themes": {
                "responsive": false
            },
            // so that create works
            "check_callback": true,
            'data': function(node, cb) {
                if (node.id === '#') { //Load root, will fire on first load as well as on refresh
                    cb.call(this, treeJSON);
                }
            }
        },
        "types": {
            "default": {
                "icon": "fa fa-folder text-primary"
            },
            "file": {
                "icon": "fa fa-file  text-primary"
            }
        },
        "state": {
            "key": "demo2"
        },
        "plugins": ["contextmenu", "state", "types"]
    });
    $('#kt_docs_jstree_contextual').on('changed.jstree', function(e, data) {
        // var i, j, r = [];
        // for (i = 0, j = data.selected.length; i < j; i++) {
        //     r.push(data.instance.get_node(data.selected[i]).text);
        // }
        if (typeof data.instance.get_node(data.selected[0]).id != 'undefined') {
            loadInfoClass(data.instance.get_node(data.selected[0]).id);
        }
    }).jstree();

    function loadTree(data) {
        treeJSON = data
        var tree = $('#kt_docs_jstree_contextual').jstree(true);
        tree.refresh();

    }

    function loadInfoClass(class_id) {
        loading();
        $.ajax({
            type: "POST",
            url: "{{route('admin.operate.enrolment.get_info_class')}}",
            dataType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                class_id: class_id
            },
            error: function(err) {},
            success: function(data) {
                $('#class_name').html(data.class_info.class_name);
                $('#class_time').html(data.class_info.class_time);
                $('#class_teacher').html(data.class_info.teachers_name);
                $('#class_max_students').html(data.class_info.class_max_students);
                $('#time_place').html(data.class_info.time_place);
                $('#class_cm_name').html(data.class_info.cm_name);
                var sel ='';
                for (var i = 0; i < data.students_list.length; i++) {
                    sel = sel+'<tr>'+
                            '<td class="text-center">'+(i+1)+'</td>'+
                            '<td>'+
                                '<p>' + data.students_list[i].student_name + '</p>'+
                                '<p>Mã: ' + data.students_list[i].crm_id + '</p>'+
                                '<p>Gói phí: ' + data.students_list[i].tuition_fee_name + '</p>'+
                            '</td>'+
                            '<td>'+
                                '<p>Ngày bắt đầu: ' + data.students_list[i].start_date + '</p>'+
                                '<p>Ngày kết thúc: ' + data.students_list[i].last_date + '</p>'+
                                '<p>Số buổi: ' + data.students_list[i].available_sessions + '</p>'+
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