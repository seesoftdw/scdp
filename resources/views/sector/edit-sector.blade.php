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
                <h1 class="m-0">Edit Sector</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item active">Edit Sector</li>
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
                        <form id="sectorForm" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="card-body">
    							<div class="row">
    								<div class="col-md-4">
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
    								<div class="col-md-4">
                                        <div class="form-group">
                                            <label for="sector_name">Sector Name*</label>
                                            <input type="text" class="form-control" id="sector_name" name="sector_name"
                                            placeholder="Enter sector name">
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
        var sector_id = window.location.search.substring(1);
            var formAction = '/sector/' + sector_id;
            $('#sectorForm').attr('action', formAction);
            $('#sectorForm').submit();
        });

        $('document').ready(function(){
            var sector_id = window.location.search.substring(1);
            var htmlService = "<option value=''>--- Select Service ---</option>";
            var departmenthtmlService = "<option value=''>--- Select Department ---</option>";
            $.ajax({
                url: "{{ url('get_sector_data') }}?sector_id=" + sector_id ,
                method: 'GET',
                success: function(data) {
                    var sectorData = data.sectorData;
                    var serviceList = data.$serviceList;
                    var departmentList = data.departmentList;

                    for (var i = 0; i < serviceList.length; i++) {
                        if (sectorData[0]['service_id'] == serviceList[i]['id']) {
                            htmlService += `<option value="` + serviceList[i]['id'] +
                                `" selected>` + serviceList[i]['service_name'] + `</option>`;
                        } else {
                            htmlService += `<option value="` + serviceList[i]['id'] + `">` +
                                serviceList[i]['service_name'] + `</option>`;
                        }
                    } 

                    for (var i = 0; i < departmentList.length; i++) {
                        if (sectorData[0]['department_id'] == departmentList[i]['id']) {
                            departmenthtmlService += `<option value="` + departmentList[i]['id'] +
                                `" selected>` + departmentList[i]['department_name'] + `</option>`;
                        } else {
                            departmenthtmlService += `<option value="` + departmentList[i]['id'] + `">` +
                                departmentList[i]['department_name'] + `</option>`;
                        }
                    } 
                    $('#department_id').html(departmenthtmlService);
                    $('#service_id').html(htmlService);
                    $('#sector_name').val(sectorData[0]['sector_name']);
                }
            });

            // $.ajax({
            //     url: "{{ route('get_department_data') }}",
            //     method: 'GET',
            //     data: { sendall: 'all' },
            //     success: function (data) {
            //         var department = data.department;
            //         var htmlService = "<option value=''>--- Select Department ---</option>";
            //         for (var i = 0; i < department.length; i++) {
            //             htmlService += `<option value="` + department[i]['id'] + `">` +
            //                 department[i]['department_name'] + `</option>`;
            //         }
            //         $('#department_id').html(htmlService);
            //     }
            // });

        });
    </script>
@endsection