@extends('layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Scheme Name + Major Head</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Add Scheme Name + Major Head</li>
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
                            <form id="schemename-majorheadForm" action="{{ route('scheme-master.store') }}" method="POST">
                                @csrf
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
                                        <label for="majorhead_id">Major Head*</label>
                                        <select name="majorhead_id" id="majorhead_id" class="form-control">
                                            <option value="">---Select Majorhead---</option>
                                        </select>
                                    </div>
									</div>
									<div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="scheme_name">Scheme name*</label>
                                        <input type="text" class="form-control" id="scheme_name" name="scheme_name"
                                            placeholder="Enter Scheme name">
                                    </div>
									 </div>
									<div class="col-lg-12">
										<button type="submit" class="btn btn-success">Add</button>
									</div>
									</div>
                                </div>
                                <!-- /.card-body -->
                            </form>
                        </div>
						</div>
                    </div>
            </section>
        </div>
    </section>
    </div>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('document').ready(function() {
            $.ajax({
                url: "{{ route('departmentList') }}",
                method: 'GET',
                success: function(data) {
                    var departmentlist = data.departmentList;
                    var htmlDepartment = "<option value=''>---Select Department---</option>";
                    for (var i = 0; i < departmentlist.length; i++) {
                        htmlDepartment += `<option value="` + departmentlist[i]['id'] + `">` +
                            departmentlist[i]['department_name'] + `</option>`;
                        }
                        if(!($('#department_id').val() > 0)){
                            $('#department_id').html(htmlDepartment);
                        }
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
                url: "{{ route('get_scheme_majorhead') }}?department_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#majorhead_id').html(data.majorheadHTML);
                }
            });
        });
    </script>
@endsection
