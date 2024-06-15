@extends('layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Logs of Soe budget distribution List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Edit Logs of Soe budget distribution List</li>
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
                        <!-- <div class="card-header">
                            <button type="submit" class="btn btn-dark"
                                onclick="window.location='{{ url('create-soe-budget-distribution') }}'">Add Soe budget
                                distribution
                            </button>
                        </div> -->

                        <div class="card-body table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Updated Date</th>
                                        <th>User</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($log))
                                        @foreach ($log as $key => $value)
                                            <tr>
                                                <td>{{ $key + 1}}</td>
                                                <td>{{ date('d-m-Y', strtotime($value->created_at)); }}</td>
                                                <td>{{ $value->user()->first()->name }}</td>
                                                <td>
                                                    <a href="{{ url('show-edit-logs-soe-budget-distribution') }}/{{$value->id}}" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View Logs</a>
                                                    <!-- <button class="btn btn-info btn-sm logbtn" data-id="{{$value->id}}">
                                                        <i class="fa fa-eye" aria-hidden="true"></i> View Logs
                                                    </button> -->
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
                        @if (isset($log))
                            <div class="col-sm-12">
                                <ol class="float-sm-right">
                                    {{ $log->links() }}
                                </ol>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Logs</h4>
                    <span id="date"></span>
                    <span id="user"></span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="mainlog">
                    
                </div>
            </div>
        <!-- /.modal-content -->
        </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

@endsection

@section('scripts')
<script type="text/javascript">
    $(".logbtn").click(function() {
        var id = $(this).attr('data-id');
        var url = "{{ route('show.edit.logs', ':id') }}";
        url = url.replace(':id', id);
        // alert(id);
        $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    $("#mainlog").html(data.table);
                    $("#date").html(data.date);
                    $("#user").html(data.user);
                    $('#modal-default').modal('show');
                }
            });
    });
</script>
@endsection
