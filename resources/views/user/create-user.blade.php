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
                    <h1 class="m-0">Add User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item active">Add User</li>
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
					<div class="col-lg-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="componentForm" action="{{ route('user.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
								<div class="row">
								<div class="col-lg-3">
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                        placeholder="name@example.com" required="required" autofocus>
                                </div>
								</div>
								<div class="col-lg-3">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" name="username" value="{{ old('username') }}"
                                        placeholder="Username" required="required" autofocus>
                                </div>
								</div>
								<div class="col-lg-3">
                                <div class="form-group">
                                    <label for="department_id">Department</label>
                                    <select name="department_id" id="department_id" class="form-control"
                                        value="{{ old('department_id') }}">
                                        <option value="">--- Select Department ---</option>
                                    </select>
                                </div>
								</div>

                                @if (auth()->user()->role_id == '1')
								<div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="role_id">Role</label>
                                        <select name="role_id" id="role_id" class="form-control"
                                            value="{{ old('role_id') }}">
                                            <option value="">--- Select Role ---</option>
                                            <option value="2">HOD</option>
                                            <option value="3">USER</option>
                                        </select>
                                    </div>
									 </div>
                                @elseif (auth()->user()->role_id === '2')
								<div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="role_id">Role</label>
                                        <select name="role_id" id="role_id" class="form-control"
                                            value="{{ old('role_id') }}">
                                            <option value="">--- Select Role ---</option>
                                            <option value="3">USER</option>
                                        </select>
                                    </div>
									</div>
                                @else
                                @endif
								<div class="col-lg-3">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password"
                                        value="{{ old('password') }}" placeholder="Password" required="required">
                                </div>
								</div>
								<div class="col-lg-3">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        value="{{ old('password_confirmation') }}" placeholder="Confirm Password"
                                        required="required">
                                </div>
								</div>
								<div class="col-lg-12">
									<button type="submit" class="btn btn-success">Add</button>
								 </div>
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
@section('scripts')
    <script type="text/javascript">
        $('document').ready(function() {
            $.ajax({
                url: "{{ route('departmentList') }}",
                method: 'GET',
                success: function(data) {
                    var departmentlist = data.departmentList;
                    var htmlDepartment = "<option value=''>--- Select Department ---</option>";
                    for (var i = 0; i < departmentlist.length; i++) {
                        htmlDepartment += `<option value="` + departmentlist[i]['id'] + `">` +
                            departmentlist[i]['department_name'] + `</option>`;
                    }
                    $('#department_id').html(htmlDepartment);
                }
            });
        });
    </script>
@endsection