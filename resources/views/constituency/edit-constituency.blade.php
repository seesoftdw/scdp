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
                    <h1 class="m-0">Edit Constituency</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Constituency</a></li>
                        <li class="breadcrumb-item active">Edit Constituency</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 card card-primary">
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="constituencyForm" action="{{ url('constituency/' . $constituency->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="district_id">District Name</label>
                                        <select name="district_id" class="form-control" value="{{$constituency->district->district_name}}">
                                            <option value="{{$constituency->district_id}}">{{$constituency->district->district_name}}</option>
                                            @if (isset($districtlist))
                                                @foreach ($districtlist as $district)
                                                        <option value={{$district->id}}>{{$district->district_name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <label for="constituencys_name">Constituency Name</label>
                                    <input type="text" class="form-control" id="constituency_name" name="constituencys_name" value="{{$constituency->constituencys_name}}"
                                        placeholder="Enter constituency name">
                                </div>
    
                                <!-- /.card-body -->
    
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection