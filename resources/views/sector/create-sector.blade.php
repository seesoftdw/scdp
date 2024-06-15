@extends('layout.master')

@if(auth()->user()->role_id != '1')
    <script type="text/javascript">
        window.location = "/dashboard";
    </script>
@endif
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add Sector</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item active">Add Sector</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content-header -->
<section class="content">
    <div class="container-fluid">
        @if($errors->any())
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                <div class="col-lg-6 alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </div>
            </div>
        @endif
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <!-- /.card-header -->
                    <!-- form start -->
					<div class="card">
                        <form id="sectorForm" action="{{ route('sector.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
    							<div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="service_id">Service*</label>
                                            <select name="service_id" id="service_id" class="form-control">
                                                <option value="">--- Select Service ---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="department_id">Department*</label>
                                            <select name="department_id" id="department_id" class="form-control">
                                                <option value="">--- Select Department ---</option>
                                            </select>
                                        </div>
                                    </div>
        							<div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Sector Name*</label>
                                            <input type="text" class="form-control" id="sector_name" name="sector_name"
                                                placeholder="Enter sector name">
                                        </div>
        							</div>
        							<div class="col-lg-12">
        								<button type="submit" class="btn btn-success">Add</button>
        							</div>
    							</div>
                                <!-- /.card-body -->
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
    $('document').ready(function () {
        
        $.ajax({
            url: "{{ route('get_service_list') }}",
            method: 'GET',
            success: function (data) {
                var serviceList = data.$serviceList;
                var htmlService = "<option value=''>--- Select Service ---</option>";
                for (var i = 0; i < serviceList.length; i++) {
                    htmlService += `<option value="` + serviceList[i]['id'] + `">` +
                        serviceList[i]['service_name'] + `</option>`;
                }
                $('#service_id').html(htmlService);
            }
        });

        $.ajax({
            url: "{{ route('get_department_data') }}",
            method: 'GET',
            data: { sendall: 'all' },
            success: function (data) {
                var department = data.department;
                var htmlService = "<option value=''>--- Select Department ---</option>";
                for (var i = 0; i < department.length; i++) {
                    htmlService += `<option value="` + department[i]['id'] + `">` +
                        department[i]['department_name'] + `</option>`;
                }
                $('#department_id').html(htmlService);
            }
        });

    });
</script>
@endsection