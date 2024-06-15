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
                    <h1 class="m-0">Component List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Component List</li>
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
            @if (session()->has('import_errors'))
                @foreach (session()->get('import_errors') as $failures)
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 8000)" x-show="show">
                        <div class="alert alert-danger">
                            {{ $failures->errors()[0] }} - At line no:
                            {{ $failures->row() }} - for column
                            {{ $failures->attribute() }} :
                            {{ $failures->values()['component_name'] }}
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="row">
                <div class="col-12 float-sm-right">
                    <div class="card">
                        <div class="card-header">
                            <form action="{{ route('component-import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file" id="customFile">
                                <button class="btn btn-info btn-md">Import component</button>
                            </form>
                            <h4>OR</h4>
                            <button type=submit" class="btn btn-dark" style=margin-bottom:10px;margin-left:10px
                                onclick="window.location='{{ url('create-component') }}'">Add Component
                            </button>
                        </div>

                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Component Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($component))
                                        @foreach ($component as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->component_name }}</td>
                                                <td>
                                                    <a href="{{ url('/component/' . $item->id) }}"
                                                        title="View component"><button class="btn btn-info btn-sm"><i
                                                                class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                                    <a href="{{ url('/component/' . $item->id . '/edit') }}"
                                                        title="Edit component">
                                                        <button class="btn btn-primary btn-sm"><i
                                                                class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                                        </button>
                                                    </a>

                                                    <form method="POST" action="{{ url('/component' . '/' . $item->id) }}"
                                                        accept-charset="UTF-8" style="display:inline">
                                                        {{ method_field('DELETE') }}
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            title="Delete Contact"><i class="fa fa-trash-o"
                                                                aria-hidden="true"></i> Delete
                                                        </button>
                                                    </form>
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
                        @if (isset($component))
                            <div class="col-sm-12">
                                <ol class="float-sm-right">
                                    {{ $component->links() }}
                                </ol>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection