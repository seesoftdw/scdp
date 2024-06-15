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
                    <h1 class="m-0">Budget Bulk Import</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Budget Bulk Import</li>
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
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="box-uploader">
                                        <form action="{{ route('bulk-soe-budget-import') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="file" id="customFile">
                                            <button class="btn btn-info btn-md">Import</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (session()->has('import_errors'))
                            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                                <div class="card-body table-responsive" style="overflow-x:auto;">
                                    <div class="alert alert-danger">
                                        File format is incorrect.
                                        <!-- <table id="example2" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Column Name</th>
                                                    <th>Message</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach (session()->get('import_errors') as $failure)
                                                    <tr>
                                                        <td>
                                                            {{$failure->attribute()}}
                                                        </td>
                                                        <td>
                                                            @foreach($failure->errors() as $key => $value)
                                                                {{$value}} <br> 
                                                            @endforeach
                                                        </td>
                                                    @endforeach
                                            </tbody>
                                        </table> -->
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
