@extends('layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Scheme master</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Edit Scheme master</li>
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
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
							<div class="card">
                            <form id="schememasterForm" method="post">
								
                                @csrf
                                @method('PATCH')
                                <div class="card-body">
									<div class="row">
									<div class="col-md-4">
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
									<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="majorhead_id">Major Head*</label>
                                        <select name="majorhead_id" id="majorhead_id" class="form-control">
                                            <option value="">---Select Majorhead---</option>
                                        </select>
                                    </div>
									</div>
									<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="scheme_name">Scheme name*</label>
                                        <input type="text" class="form-control" id="scheme_name" name="scheme_name"
                                            placeholder="Enter Scheme name">
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
                </div>
            </section>
        </div>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('document').ready(function() {
            var scheme_id = window.location.search.substring(1);
            $.ajax({
                url: "{{ route('get_schememaster_data') }}?scheme_id=" +scheme_id,
                method: 'GET',
                success: function(data) {
                    var schememasterdata = data.schememasterdata;
                    var departmentlist = data.departmentlist;
                    var majorheadlist = data.majorheadlist;
                    var htmlDepartment = "<option value=''>---Select Department---</option>";
                    var htmlMajorhead = '<option value="">---Select Majorhead---</option>';

                    for (var i = 0; i < departmentlist.length; i++) {
                        if (schememasterdata[0]['department_id'] == departmentlist[i]['id']) {
                            htmlDepartment += `<option value="` + departmentlist[i]['id'] +
                                `" selected>` + departmentlist[i]['department_name'] + `</option>`;
                        } else {
                            htmlDepartment += `<option value="` + departmentlist[i]['id'] + `">` +
                                departmentlist[i]['department_name'] + `</option>`;
                        }
                    }

                    for (var i = 0; i < majorheadlist.length; i++) {
                        if (schememasterdata[0]['majorhead_id'] == majorheadlist[i]['id']) {
                            htmlMajorhead += `<option value="` + majorheadlist[i]['id'] +
                                `" selected>` + majorheadlist[i]['complete_head'] + `</option>`;
                        } else {
                            htmlMajorhead += `<option value="` + majorheadlist[i]['id'] + `">` +
                                majorheadlist[i]['complete_head'] + `</option>`;
                        }
                    }
                    $('#department_id').html(htmlDepartment);
                    $('#majorhead_id').html(htmlMajorhead);
                    $('#scheme_name').val(schememasterdata[0]['scheme_name']);
                }
            });
        });
        
        $("#department_id").change(function(){
            $.ajax({
                url: "{{ route('get_scheme_majorhead') }}?department_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#majorhead_id').html(data.majorheadHTML);
                }
            });
        });

        $("#update").click(function() {
            var scheme_id = window.location.search.substring(1);
            var formAction = '/scheme-master/' + scheme_id;
            $('#schememasterForm').attr('action', formAction);
            $('#schememasterForm').submit();
        });
    </script>
@endsection
