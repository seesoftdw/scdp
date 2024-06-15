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
                    <h1 class="m-0">All in one import</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Master</a></li>
                            <li class="breadcrumb-item active">All in one import List</li>
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
            <pre>
            <?php
            print_r(session()->get('import_errors'));
            ?></pre>
            @if (session()->has('error'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
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
                            {{ $failures->values()['department_name'] }}
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="row">
                <div class="col-12 float-sm-right">
                    <div class="card">
                        <div class="card-header">
                            <form action="{{ route('allinone-import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                                <label for="department_id">Fine Year*</label>
                                                <select name="finyear_id" id="finyear_id" class="form-control">
                                                    <option value="">--- Select Fine Year ---</option>
                                                @foreach ($Finyear as $finyear)
                                        <option value={{ $finyear->id }}>{{ $finyear->finyear }}</option>
                                              @endforeach

                                                </select>
                                            </div>
                                </div>
                                 <div class="col-md-3">

                                     <div class="form-group">
                                                <label for="department_id">Select file*</label>
                                                 <input type="file" name="file" id="customFile" class="form-control">
                               
                                            </div>

                                   
                                </div>
                                 <div class="col-md-3" style="top: 28px;">
                                             <button class="btn btn-info btn-md">Import Department</button>
                                         </div>
                            </div>
                               
                            </form>
                           
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
