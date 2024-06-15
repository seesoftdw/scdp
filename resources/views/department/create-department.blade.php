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
                    <h1 class="m-0">Add Department</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Add Department</li>
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
                <div class="row">
                    <div class="col-lg-12">
						<div class="card">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="departmentForm" action="{{ route('department.store') }}" method="GET">
                            @csrf
                            <div class="card-body">
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<label for="hod_code">HOD code*</label>
											<input type="number" min="0" class="form-control" id="hod_code" name="hod_code"
												placeholder="Enter hod code">
										</div>
									</div>
									<div class="col-lg-3">
											<div class="form-group">
										<label for="hod_code">HOD name*</label>
										<input type="text" class="form-control" id="hod_name" name="hod_name"
											placeholder="Enter hod name">
									</div>
									</div>
									<div class="col-lg-3">
										 <div class="form-group">
                                    <label for="department_name">Department name*</label>
                                    <input type="text" class="form-control" id="department_name" name="department_name"
                                        placeholder="Enter department name">
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
@endsection
{{-- @section('scripts')
    <script type="text/javascript">
        $("#sector_id").change(function(){
            $.ajax({
                url: "{{ route('get_sub_sector') }}?sector_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#subsector_id').html(data.html);
                }
            });
        });
    </script>
@endsection --}}