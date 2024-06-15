@extends('layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">View SOE</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">View SOE</li>
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
                                <div class="card-body">
                                    <div class="form-group">
										<div class="table-responsive">
                                        <table id="example2" class="table table-bordered table-hover">
                                            <tr>
                                                <td>Department</td>
                                                <td>{{ $soe->department->department_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Majorhead</td>
                                                <td>{{ $soe->majorhead->complete_head }}</td>
                                            </tr>
                                            <tr>
                                                <td>Scheme</td>
                                                <td>{{ $soe->scheme->scheme_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>SOE Name</td>
                                                <td>{{ $soe->soe_name }}</td>
                                            </tr>
                                        </table>
                                    </div>
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