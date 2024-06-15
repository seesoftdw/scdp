@extends('layout.master')

@if (auth()->user()->role_id != '1')
    <script type="text/javascript">
        window.location = "/dashboard";
    </script>
@endif
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Department</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Edit Department</li>
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
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 card card-primary">
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="updateDepartment" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="card-body">
									<div class="row">
									<div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="hod_code">HOD code*</label>
                                        <input type="number" min="0" class="form-control" id="hod_code" name="hod_code">
                                    </div>
									</div>
									<div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="hod_code">HOD name*</label>
                                        <input type="text" class="form-control" id="hod_name" name="hod_name">
                                    </div>
									</div>
									<div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="department_name">Department Name*</label>
                                        <input type="text" class="form-control" id="department_name"
                                            name="department_name">
                                    </div>
									</div>
									<div class="col-lg-12">
										<button type="submit" id="update" class="btn btn-success">Update</button>
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
@endsection
@section('scripts')
    <script type="text/javascript">
    
    $("#update").click(function() {
        var department_id = window.location.search.substring(1);
        var formAction = '/department/' + department_id;
        $('#updateDepartment').attr('action', formAction);
        $('#updateDepartment').submit();
    });

    $('document').ready(function(){
        var department_id = window.location.search.substring(1);
        $.ajax({
            url: "{{ route('get_department_data') }}?department_id=" + department_id,
            method: 'GET',
            success: function(data) {
                var department = data.department;
                $('#hod_code').val(department[0]['hod_code']);
                $('#hod_name').val(department[0]['hod_name']);
                $('#department_name').val(department[0]['department_name']);
            }
        });
    });

    </script>
@endsection