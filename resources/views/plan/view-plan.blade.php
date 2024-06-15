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
                    <h1 class="m-0">Plan List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Plan List</li>
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
            @if (session()->has('alert'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 8000)" x-show="show">
                <div class="alert alert-warning">
                    {{ session()->get('alert') }}
                </div>
            </div>
            @endif
            @if (session()->has('import_errors'))
                @foreach (session()->get('import_errors') as $failures)
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 8000)" x-show="show">
                        <div class="alert alert-danger">
                            {{ $failures->errors()[0] }} - At line no:
                            {{ $failures->row() }} - for column
                            {{ $failures->attribute() }} :
                            {{ $failures->values()['plan_name'] }}
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="row">
                <div class="col-12 float-sm-right">
                    <div class="card">
                        <div class="card-header">
                            <button type="submit" class="btn btn-dark" style=margin-bottom:10px;margin-left:10px
                                onclick="window.location='{{ url('create-plan') }}'">Add Plan
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Plan Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($plan))
                                        @foreach ($plan as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->plan_name }}</td>
                                                <td>
                                                    <a href="{{ url('/plan/' . $item->id) }}"
                                                        title="View plan"><button class="btn btn-success btn-sm"><i
                                                                class="fa fa-eye" aria-hidden="true"></i></button></a>
                                                    @if($item->id > 3)
                                                        <a href="{{ url('/plan/' . $item->id . '/edit') }}"
                                                            title="Edit plan">
                                                            <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt" aria-hidden="true"></i>
                                                            </button>
                                                        </a>

                                                        <form method="POST" action="{{ url('/plan' . '/' . $item->id) }}"
                                                            accept-charset="UTF-8" style="display:inline">
                                                            {{ method_field('DELETE') }}
                                                            {{ csrf_field() }}
                                                            <button type="submit" class="btn btn-danger btn-sm show-alert-delete-box"
                                                                title="Delete Contact"><i class="fa fa-trash-alt" aria-hidden="true"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-danger" style="text-align: center">No record
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
@section('scripts')
    <script type="text/javascript">
    $('.show-alert-delete-box').click(function(event){
        var form =  $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
            title: "Are you sure you want to delete this record?",
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            type: "warning",
            buttons: ["Cancel","Yes!"],
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
    });
</script>
@endsection