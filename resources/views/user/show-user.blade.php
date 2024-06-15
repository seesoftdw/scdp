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
                    <h1 class="m-0">View User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item active">View User</li>
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
                            <form action="{{ route('component.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
										<div class="table-responsive">
                                        <table id="example2" class="table table-bordered table-hover">
                                            <tr>
                                                <td>Username</td>
                                                <td>{{ $user->username }}</td>
                                            </tr>
                                            <tr>
                                                <td>Role</td>
                                                <td>{{ $user->role_id == 1 ? 'Admin' : ($user->role_id == 2 ? 'HOD' : 'User') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Department</td>
                                                <td>
                                                    @if(!empty($user->department->department_name))
                                                    {{$user->department->department_name }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>{{ $user->email }}</td>
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