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
                    <h1 class="m-0">View District</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">View District</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <section class="content">
                    <div class="row">
                        <div class="col-lg-4">
							<div class="card">
                            <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-group">
                                        <table class="table table-bordered table-hover">
                                            <label>District Name</label>
                                            <tr>
                                                <td>{{ $district->district_name }}</td>
                                            </tr>
                                        </table>
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