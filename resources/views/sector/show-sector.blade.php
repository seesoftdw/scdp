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
                <h1 class="m-0">View Sector</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item active">View Sector</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content-header -->
<section class="content">
    <div class="container-fluid">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('sector.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                               <div class="table-responsive">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <tr>
                                            <td>Service</td>
                                            <td>{{ $sector->service->service_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Department name</td>
                                            <td>{{ $sector->department->department_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Sector name</td>
                                            <td>{{ $sector->sector_name }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
@endsection