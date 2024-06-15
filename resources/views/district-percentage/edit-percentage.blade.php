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
                    <h1 class="m-0">Edit District Percentage</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">District Percentage</a></li>
                        <li class="breadcrumb-item active">Edit District Percentage</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    @if (session()->has('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        </div>
    @endif
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
        <div class="container-fluid">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 card card-primary">
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="districtPercentageForm" action="{{ url('district-percentage/' . $districtPercentage->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="card-body">
									<div class="row">
									<div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="district_id">District Name</label>
                                        <select name="district_id" class="form-control" value="{{$districtPercentage->district->district_name}}">
                                            <!-- <option value="{{$districtPercentage->district_id}}">{{$districtPercentage->district->district_name}}</option> -->
                                            @if (isset($districtList))
                                                @foreach ($districtList as $district)
                                                        <option value={{$district->id}} @if($district->id == $districtPercentage->district_id) selected @endif> {{$district->district_name}} </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
									</div>
									<div class="col-lg-3">
									<div class="form-group">
                                    <label for="percentage">Percentage</label>
                                    <input type="number" step="0.01" min="0" max="100" class="form-control" id="percentage" name="percentage" value="{{$districtPercentage->percentage}}"
                                        placeholder="Enter percentage">
                                </div>
								</div>
								<div class="col-lg-12">
									<button type="submit" class="btn btn-success">Update</button>
								</div>
								</div>
    							</div>
                                <!-- /.card-body -->
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection