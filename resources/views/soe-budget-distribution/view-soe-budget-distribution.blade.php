@extends('layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Soe budget distribution List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Soe budget distribution List</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            @if (session()->has('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                </div>
            @endif

            @if (session()->has('update'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                    <div class="alert alert-success">
                        {{ session()->get('update') }}
                    </div>
                </div>
            @endif
            @if (session()->has('error'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                </div>
            @endif
            @if (session()->has('delete'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                    <div class="alert alert-danger">
                        {{ session()->get('delete') }}
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-12 float-sm-right">
                    <div class="card">
                        <div class="card-header">
                            <button type="submit" class="btn btn-dark"
                                onclick="window.location='{{ url('create-soe-budget-distribution') }}'">Add Soe budget
                                distribution
                            </button>
                        </div>

                        <div class="card-body table-responsive">
                            <table id="datatable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Department</th>
                                        <th>Majorhead</th>
                                        <th>Scheme</th>
                                        <th>Soe</th>
                                        <th>Fin year</th>
                                        <th>Plan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($soeBudgetDistribution))
                                        @foreach ($soeBudgetDistribution as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->department->department_name }}</td>
                                                <td>{{ $item->majorhead->complete_head }}</td>
                                                <td>{{ $item->scheme->scheme_name }}</td>
                                                <td>{{ $item->soe->soe_name }}</td>
                                                <td>{{ $item->Fin_year->finyear }}</td>
                                                <td>{{ $item->plan->plan_name }}</td>
                                               

                                                <td>
                                                    <a href="{{ url('edit-soe-budget-distribution?' . $item->id) }}"
                                                        title="Edit">
                                                       <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt" aria-hidden="true"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ url('edit-logs-soe-budget-distribution/' . $item->id) }}"
                                                        title="Edit Logs">
                                                        <button class="btn btn-success btn-sm"><i class="fas fa-clock"></i></i> 
                                                        </button>
                                                    </a>
                                                    @if (auth()->user()->role_id == '1')
                                                     <a href="{{ url('revised-soe-budget-distribution?' . $item->id) }}"
                                                        title="Revised Outlay">
                                                        <button class="btn btn-info btn-sm"><i class="fas fa-sync"></i> 
                                                        </button>
                                                    </a>
                                                    <a href="{{ url('/soe-budget-distribution/' . $item->id) }}"
                                                        title="Revised Outlay Logs"><button class="btn btn-secondary btn-sm"><i class="fas fa-th-large"></i></button>
                                                    </a> 
                                                    @endif


                                                    <form method="POST"
                                                        action="{{ url('/soe-budget-distribution' . '/' . $item->id) }}"
                                                        accept-charset="UTF-8" style="display:inline">
                                                        {{ method_field('DELETE') }}
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-danger btn-sm show-alert-delete-box"
                                                            title="Delete"><i class="fa fa-trash-alt" aria-hidden="true"></i>
                                                        </button>
                                                        </form>
                                                        <!-- <a href="{{ url('/soe-financial-budget-distribution/' . $item->id) }}"
                                                        title="View schememaster"><button class="btn btn-info btn-sm">Financial</button></a>  
                                                                <a href="{{ url('/soe-budget-distribution/' . $item->id) }}"
                                                        title="View schememaster"><button class="btn btn-info btn-sm"> Phusical Achievement</button></a>
                                                                <a href="{{ url('/soe-budget-distribution/' . $item->id) }}"
                                                        title="View schememaster"><button class="btn btn-info btn-sm"> Beneficiaries</button></a> -->
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-danger" style="text-align: center">No record
                                                found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
