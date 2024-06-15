@extends('layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Scheme master List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Scheme master List</li>
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
            @if (session()->has('delete'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                    <div class="alert alert-danger">
                        {{ session()->get('delete') }}
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
                            {{ $failures->values()['soe_name'] }}
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="row">
                <div class="col-12 float-sm-right">
                    <div class="card">
						<div class="card-header">
							<div class="row">
							<div class="col-md-6">
							<div class="box-uploader">
                            @if (auth()->user()->role_id == '1')
                                <form action="{{ route('scheme-master-import') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="file" id="customFile">
                                    <button class="btn btn-info btn-md">Import Scheme</button>
                                </form>
                            @endif
							</div>
							</div>
							<div class="col-md-6">
                             <button type="submit" class="btn btn-dark btn-right"
                                onclick="window.location='{{ url('create-scheme-master') }}'">Add Scheme
                            </button>
                        </div>
						</div>
						</div>
						
                        <div class="card-body">
							<div class="table-responsive">
                            <table id="datatable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Department</th>
                                        <th>Majorhead</th>
                                        <th>Scheme name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($schememaster))
                                        @foreach ($schememaster as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->department->department_name }}</td>
                                                <td>{{ $item->majorhead->complete_head }}</td>
                                                <td>{{ $item->scheme_name }}</td>

                                                <td>
                                                    <a href="{{ url('/scheme-master/' . $item->id) }}"
                                                        title="View schememaster"><button class="btn btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                                    <a href="{{ url('edit-scheme-master?' . $item->id) }}"
                                                        title="Edit schememaster">
                                                        <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt" aria-hidden="true"></i>
                                                        </button>
                                                    </a>

                                                    <form method="POST"
                                                        action="{{ url('/scheme-master' . '/' . $item->id) }}"
                                                        accept-charset="UTF-8" style="display:inline">
                                                        {{ method_field('DELETE') }}
                                                        {{ csrf_field() }}
                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm show-alert-delete-box"
                                                            title="Delete Contact"><i class="fa fa-trash-alt" aria-hidden="true"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-danger" style="text-align: center">No record
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
        </div>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('.show-alert-delete-box').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: "Are you sure you want to delete this record?",
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                type: "warning",
                buttons: ["Cancel", "Yes!"],
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
