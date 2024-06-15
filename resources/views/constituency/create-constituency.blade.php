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
                    <h1 class="m-0">Add Constituency</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Add Constituency</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            @if ($errors->any())
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                    <div class="col-lg-6 alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </div>
                </div>
            @endif
            <section class="content">                
                <div class="row">
                    <div class="col-lg-6 card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="constituencyForm" action="{{ route('constituency.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="district_id">District Name</label>
                                    <select name="district_id" class="form-control">
                                        <option value="">--- Select district ---</option>
                                        @if (isset($districtlist))
                                            @foreach ($districtlist as $district)
                                                    <option value={{$district->id}}>{{$district->district_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <label for="constituencys_name">Constituency Name</label>
                                <input type="text" class="form-control" id="constituencys_name" name="constituencys_name"
                                    placeholder="Enter constituency name">
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection