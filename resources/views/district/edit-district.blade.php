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
                    <h1 class="m-0">Edit District</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Edit District</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <section class="content">
                    <div class="row">
                       <div class="col-lg-4">
						   <div class="card">
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ url('district/' . $district->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="card-body">
									<div class="col-md-12">
                                    <div class="form-group">
                                        <label for="district_name">District Name</label>
                                        <input type="text" class="form-control" id="district_name" name="district_name"
                                            value="{{ $district->district_name }}" placeholder="Enter district name">
                                    </div>
									</div>
									<div class="col-md-12">
										 <button type="submit" class="btn btn-success">Update</button>
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