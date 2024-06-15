@extends('layout.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Capital Scheme</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item active">Capital Scheme</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content-header -->
<section class="content">
    <div class="container-fluid">
        @if(session()->has('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            </div>
        @endif
        @if(session()->has('update'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                <div class="alert alert-success">
                    {{ session()->get('update') }}
                </div>
            </div>
        @endif
        @if(session()->has('delete'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                <div class="alert alert-danger">
                    {{ session()->get('delete') }}
                </div>
            </div>
        @endif
        @if(session()->has('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-12 float-sm-right">
                <div class="card">
                    <div class="card-header">
                        <form id="capitalSchemeSearch">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <!-- <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="district_id">District Name</label>
                                            <select name="district_id" id="district_id" class="form-control">
                                                <option value="">--- Select District ---</option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <!-- <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="constituency_id">Constituency</label>
                                            <select name="constituency_id" id="constituency_id" class="form-control">
                                                <option value="">--- Select Constituency ---</option>
                                                </select>
                                            </div>
                                        </div> -->
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="department_id">Department name</label>
                                            <select name="department_id" id="department_id" class="form-control">
                                                <option value="">--- Select Department ---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="fin_year_id">Fin year</label>
                                            <select name="fin_year_id" id="fin_year_id" class="form-control">
                                                <option value="">--- Select Fin year ---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                    </div>
                                    <div class="col-lg-4">
                                        <button type="submit" class="btn btn-dark" class="btn btn-dark"
                                            onclick="window.location='{{ url('create-capital-scheme') }}'"
                                            disabled>Download Excel
                                        </button>
                                        <button type="submit" class="btn btn-dark"
                                            onclick="window.location='{{ url('create-capital-scheme') }}'"
                                            disabled>Download PDF
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <button type="submit" id="search" class="btn btn-dark">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>Major Head/ Scheme name</th>
                        <th>Department</th>
                        <th>Estimated Cost</th>
                        <th>Outlay</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($capitalSchemeList))
                        @foreach($capitalSchemeList as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->scheme->majorhead_name }} -
                                    {{ $item->scheme->scheme_name }}</td>
                                <td>{{ $item->department->department_name }}</td>
                                <td>Estimated Cost</td>
                                <td>{{ $item->total_outlay }}</td>
                                <!-- <td>{{ $item->scheme_name }}</td> -->

                                <!-- <td>
                                                    <a href="{{ url('/scheme-master/' . $item->id) }}"
                                                        title="View schemenamemajorhead"><button class="btn btn-info btn-sm"><i
                                                                class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                                    <a href="{{ url('edit-scheme-master?' . $item->id ) }}"
                                                        title="Edit schemenamemajorhead">
                                                        <button class="btn btn-primary btn-sm"><i
                                                                class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                                        </button>
                                                    </a>

                                                    <form method="POST" action="{{ url('/scheme-master' . '/' . $item->id) }}"
                                                        accept-charset="UTF-8" style="display:inline">
                                                        {{ method_field('DELETE') }}
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            title="Delete Contact"><i class="fa fa-trash-o"
                                                                aria-hidden="true"></i> Delete
                                                        </button>
                                                    </form>
                                                </td> -->
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-danger" style="text-align: center">No record
                                found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <!-- @if (isset($schemenamemajorhead))
                            <div class="col-sm-12">
                                <ol class="float-sm-right">
                                    {{ $schemenamemajorhead->links() }}
                                </ol>
                            </div>
@endif-->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">
    $("#search").click(function() {
            var formAction = '/search-capital-scheme';
            $('#capitalSchemeSearch').attr('action', formAction);
            $('#capitalSchemeSearch').submit();
    });

        $('document').ready(function(){
            $.ajax({
                url: "{{ route('all_capital_list') }}",
                method: 'GET',
                success: function(data) {
                    var departmentlist = data.departmentlist;
                    var finyearlist = data.finyearlist;
                    var htmlDepartment = "<option value=''>---Select Department---</option>";
                    var htmlFinyear = "<option value=''>---Select Fin year---</option>";

                    for (var i = 0; i < departmentlist.length; i++) {
                        htmlDepartment+= `<option value="`+departmentlist[i]['id']+`">`+departmentlist[i]['department_name']+`</option>`;
                    }

                    for (var i = 0; i < finyearlist.length; i++) {
                        htmlFinyear += `<option value="`+finyearlist[i]['id']+`">`+finyearlist[i]['finyear']+`</option>`
                    }
                    $('#department_id').html(htmlDepartment);
                    $('#fin_year_id').html(htmlFinyear);
                }
            });
        });

    </script>
@endsection
