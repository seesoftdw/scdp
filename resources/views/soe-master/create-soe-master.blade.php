@extends('layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add SOE</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Add SOE</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            @if ($errors->any())
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                    <div class="col-lg-6 alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </div>
                </div>
            @endif
            <section class="content">
                @php
                    $user = auth()->user();
                @endphp
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- /.card-header -->
                            <!-- form start -->
							<div class="card">
                            <form id="soeForm" action="{{ route('soe-master.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
									<div class="row">
									<div class="col-lg-3">
                                    @if (auth()->user())
                                        {{-- @if (auth()->user()->role_id == '1')
                                            <div class="form-group">
                                                <label for="department_id">Department*</label>
                                                <select name="department_id" id="department_id" class="form-control">
                                                    <option value="">---Select Department---</option>
                                                </select>
                                            </div>
                                        @else
                                            <div class="form-group">
                                                <label for="department_id">Department*</label>
                                                <select name="department_id" id="department_id" class="form-control" hidden
                                                    value={{ $user->department_id }}>
                                                    <option value={{ $user->department_id }}>
                                                        {{ $user->department->department_name }}</option>
                                                </select>
                                                <select name="department_id" id="department_id" class="form-control" disabled
                                                    value={{ $user->department_id }}>
                                                    <option value={{ $user->department_id }}>
                                                        {{ $user->department->department_name }}</option>
                                                </select>
                                            </div>
                                        @endif --}}
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
                                                <select name="department_id" id="department_id" class="form-control" hidden
                                                    value={{ $user->department_id }}>
                                                    <option value={{ $user->department_id }}>
                                                        {{ $user->department->department_name }}</option>
                                                </select>
                                                <select name="department_id" id="department_id" class="form-control" disabled
                                                    value={{ $user->department_id }}>
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
                                    <button type="submit" class="btn btn-success">Add</button>
                                </div>
                            </form>
                        </div>
						</div>
                    </div>
            </section>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('document').ready(function() {    
            $.ajax({
                url: "{{ route('soe_department_list') }}",
                method: 'GET',
                success: function(data) {
                    var departmentlist = data.departmentList;
                    var htmlDepartment = "<option value=''>---Select Department---</option>";
                    for (var i = 0; i < departmentlist.length; i++) {
                        htmlDepartment += `<option value="` + departmentlist[i]['id'] + `">` +
                            departmentlist[i]['department_name'] + `</option>`;
                    }
                    $('#department_id').html(htmlDepartment);
                }
            });
            var $department_id = $('#department_id').val();
            if($department_id > 0){
                $.ajax({
                url: "{{ route('get_scheme_majorhead') }}?department_id=" + $department_id,
                method: 'GET',
                success: function(data) {
                    $('#majorhead_id').html(data.majorheadHTML);
                }
                });
            }
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
