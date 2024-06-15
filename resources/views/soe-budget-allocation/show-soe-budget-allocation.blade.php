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
                    <h1 class="m-0">View Soe budget allocation</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">View Soe budget allocation</li>
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
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example2" class="table table-bordered table-hover" >
                                            <tr>
                                                <td>Department name</td>
                                                <td>{{ $soebudgetallocation->department->department_name }}</td>
                                            </tr>
                                            
                                            <tr>
                                                <td>Major head name</td>
                                                <td>{{ $soebudgetallocation->majorhead->complete_head }}</td>
                                            </tr>
                                            <tr>
                                                <td>Scheme name</td>
                                                <td>{{ $soebudgetallocation->scheme->scheme_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Soe name</td>
                                                <td>{{ $soebudgetallocation->soe->soe_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Fin - year</td>
                                                <td>{{ $soebudgetallocation->fin_year->finyear }}</td>
                                            </tr>
                                            <tr>
                                                <td>Outlay</td>
                                                <td>{{ $soebudgetallocation->outlay }}</td>
                                            </tr>
                                            <tr>
                                                <td>Earmarked</td>
                                                <td>{{ $soebudgetallocation->is_earnmarked == 1 ? 'Yes' :'No' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Plan name</td>
                                                <td>{{ $soebudgetallocation->plan->plan_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Service name</td>
                                                <td>{{ $soebudgetallocation->service->service_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Sector name</td>
                                                <td>{{ $soebudgetallocation->sector->sector_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>sub-sector name</td>
                                                <td>{{ $soebudgetallocation->subsector->subsectors_name }}</td>
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