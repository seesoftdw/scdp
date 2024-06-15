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
                    <h1 class="m-0">View District Percentage</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">View District Percentage</li>
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
                                        <table id="example2" class="table table-bordered table-hover" >
                                            <tr>
                                                <td>District Name</td>
                                                <td>{{ $districtPercentage->district->district_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Percentage</td>
                                                <td>{{ $districtPercentage->percentage }}%</td>
                                            </tr>
                                        </table>
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