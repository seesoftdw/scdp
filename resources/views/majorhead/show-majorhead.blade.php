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
                    <h1 class="m-0">View majorhead</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">View majorhead</li>
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
                            <form>
                                @csrf
                                <div class="card-body">
                                   <div class="table-responsive">
                                        <table id="example2" class="table table-bordered table-hover" >
                                            <tr>
                                                <td>Department</td>
                                                <td>{{ $majorhead->department->department_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>MJR_HEAD</td>
                                                <td>{{ $majorhead->mjr_head }}</td>
                                            </tr>
                                            <tr>
                                                <td>SM_HEAD</td>
                                                <td>{{ $majorhead->sm_head }}</td>
                                            </tr>
                                            <tr>
                                                <td>MIN_HEAD</td>
                                                <td>{{ $majorhead->min_head }}</td>
                                            </tr>
                                            <tr>
                                                <td>SUB_HEAD</td>
                                                <td>{{ $majorhead->sub_head }}</td>
                                            </tr>
                                            <tr>
                                                <td>BDGT_HEAD</td>
                                                <td>{{ $majorhead->bdgt_head }}</td>
                                            </tr>
                                            <tr>
                                                <td>Complete Head</td>
                                                <td>{{ $majorhead->complete_head }}</td>
                                            </tr>
                                        </table>
                                    </div>
									</div>
                                </div>
                            </form>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection