@extends('layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit SOE</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Edit SOE</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    <section class="content">
        @php
        $user = auth()->user();
        @endphp
        <div class="container-fluid">
            <section class="content">
                    <div class="row">
                       <div class="col-lg-12">
                            <!-- /.card-header -->
                            <!-- form start -->
						    <div class="card">
                            <form id="soeForm" 
                            method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="card-body">
									<div class="row">
									<div class="col-lg-3">
                                    @if (auth()->user())
                                        @if (auth()->user()->role_id == '1')
                                            <div class="form-group">
                                                <label for="department_id">Department*</label>
                                                <select name="department_id" id="department_id" class="form-control">
                                                    <option value="">--- Select Department ---</option>
                                                </select>
                                            </div>
                                        @else
                                            <div class="form-group">
                                                <label for="department_id">Department*</label>
                                                <select name="department_id" id="department_id" class="form-control"
                                                    disabled value={{ $user->department_id }}>
                                                    <option value={{ $user->department_id }}>
                                                        {{ $user->department->department_name }}</option>
                                                </select>
                                                <select name="department_id" id="department_id" class="form-control" hidden
                                                    value={{ $user->department_id }}>
                                                    <option value={{ $user->department_id }}>
                                                        {{ $user->department->department_name }}</option>
                                                </select>
                                            </div>
                                        @endif
                                    @endif
									</div>
									<div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="majorhead_id">Major head*</label>
                                        <select name="majorhead_id" id="majorhead_id" class="form-control">
                                            <option value="">---Select Majorhead---</option>
                                        </select>
                                    </div>
									</div>
									<div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="scheme_id">Scheme master*</label>
                                        <select name="scheme_id" id="scheme_id" class="form-control">
                                            <option value="">---Select Scheme---</option>
                                        </select>
                                    </div>
									</div>
									<div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="soe_name">SOE Name*</label>
                                        <input type="text" class="form-control" id="soe_name" name="soe_name"
                                            placeholder="Enter soe name">
                                    </div>
									</div>
                                </div>
								</div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" id="update" class="btn btn-success">Update</button>
                                </div>
                            </form>
                        </div>
					 </div>
                    </div>
            </section>
        </div>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">
        $("#update").click(function() {
            var soe_id = window.location.search.substring(1);
            var formAction = '/soe-master/' + soe_id;
            $('#soeForm').attr('action', formAction);
            $('#soeForm').submit();
        });
        $('document').ready(function(){
            var soe_id = window.location.search.substring(1);
            var htmlDepartment = "<option value=''>---Select Department---</option>";
            var htmlMajorhead = "<option value=''>---Select Majorhead---</option>";
            var htmlScheme = "<option value=''>---Select Scheme---</option>";
            $.ajax({
                url: "{{ url('get_soe_master_data') }}?soe_id=" + soe_id,
                method: 'GET',
                success: function(data) {
                    var soe = data.soe;
                    var departmentlist = data.departmentList;
                    var majorheadList = data.majorheadList;
                    var schemeMasterList = data.schemeMasterList;

                    for (var i = 0; i < departmentlist.length; i++) {
                        if (soe[0]['department_id'] == departmentlist[i]['id']) {
                            htmlDepartment += `<option value="` + departmentlist[i]['id'] +
                                `" selected>` + departmentlist[i]['department_name'] + `</option>`;
                        } else {
                            htmlDepartment += `<option value="` + departmentlist[i]['id'] + `">` +
                                departmentlist[i]['department_name'] + `</option>`;
                        }
                    }

                    for (var i = 0; i < majorheadList.length; i++) {
                        if (soe[0]['majorhead_id'] == majorheadList[i]['id']) {
                            htmlMajorhead += `<option value="` + majorheadList[i]['id'] +
                                `" selected>` + majorheadList[i]['complete_head'] + `</option>`;
                        } else {
                            htmlMajorhead += `<option value="` + majorheadList[i]['id'] + `">` +
                                majorheadList[i]['complete_head'] + `</option>`;
                        }
                    }


                    for (var i = 0; i < schemeMasterList.length; i++) {
                        if (soe[0]['scheme_id'] == schemeMasterList[i]['id']) {
                            htmlScheme += `<option value="` + schemeMasterList[i]['id'] +
                                `" selected>` + schemeMasterList[i]['scheme_name'] + `</option>`;
                        } else {
                            htmlScheme += `<option value="` + schemeMasterList[i]['id'] + `">` +
                                schemeMasterList[i]['scheme_name'] + `</option>`;
                        }
                    } 

                    $('#department_id').html(htmlDepartment);
                    $('#majorhead_id').html(htmlMajorhead);
                    $('#scheme_id').html(htmlScheme);
                    $('#soe_name').val(soe[0]['soe_name']);
                }
            });
        });

        $("#department_id").change(function(){
            $.ajax({
                url: "{{ route('get_soe_majorhead_by_department') }}?department_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#majorhead_id').html(data.majorheadHtml);
                    $('#scheme_id').html(data.schemeHtml);
                }
            });
        });
        $("#majorhead_id").change(function(){
            $.ajax({
                url: "{{ route('get_soe_scheme_by_majorhead') }}?majorhead_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#scheme_id').html(data.schemeHtml);
                }
            });
        });

    </script>
@endsection