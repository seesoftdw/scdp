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
                    <h1 class="m-0">Edit User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item active">Edit User</li>
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
                        <div class="col-lg-12 card card-primary">
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="userForm" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="card-body">
									<div class="row">
									<div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" name="email" id="email_address" placeholder="name@example.com" required="required" disabled>
                                            @if ($errors->has('email'))
                                                <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                                            @endif
                                    </div>
    								</div>
									<div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" name="username" id="user_name" placeholder="Username" required="required" autofocus>
                                            @if ($errors->has('username'))
                                                <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                                            @endif
                                    </div>
    								</div>
									<div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="department_id">Department</label>
                                        <select name="department_id" id="department_id" class="form-control">
                                        </select>
                                    </div>
									</div>
									<div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="role_id">Role</label>
                                        <select name="role_id" id="role_id" class="form-control">
                                            <option value="">--- Select Role ---</option>
                                            <option value="2">HOD</option>
                                            <option value="3">USER</option>
                                        </select>
                                    </div>
									</div>
									<div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" 
                                            placeholder="Password" onkeyup="EnableDisable(this)">
                                            @if ($errors->has('password'))
                                                <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                                            @endif
                                    </div>
    								</div>
									<div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" 
                                            placeholder="Confirm Password" disabled="disabled" >
                                            @if ($errors->has('password_confirmation'))
                                                <span class="text-danger text-left">{{ $errors->first('password_confirmation') }}</span>
                                            @endif
                                    </div>
									</div>
									<div class="col-lg-12">
										 <button type="submit" id="update" class="btn btn-success">Update</button>
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
    $("#update").click(function() {
            var user_id = window.location.search.substring(1);
            var formAction = '/user/' + user_id;
            $('#userForm').attr('action', formAction);
            $('#userForm').submit();
        });
        $('document').ready(function() {
            var user_id = window.location.search.substring(1);
            var htmlDepartment = "<option value=''>---Select Department---</option>";
            $.ajax({
                url: "{{ url('get_user_data') }}?user_id=" + user_id,
                method: 'GET',
                success: function(data) {
                    var user = data.user;
                    var departmentlist = data.departmentList;
                    console.log(departmentlist);

                    for (var i = 0; i < departmentlist.length; i++) {
                        if (user[0]['department_id'] == departmentlist[i]['id']) {
                            htmlDepartment += `<option value="` + departmentlist[i]['id'] +
                                `" selected>` + departmentlist[i]['department_name'] + `</option>`;
                        } else {
                            htmlDepartment += `<option value="` + departmentlist[i]['id'] + `">` +
                                departmentlist[i]['department_name'] + `</option>`;
                        }
                    }

                    $('#department_id').html(htmlDepartment);
                    $('#email_address').val(user[0]['email']);
                    $('#user_name').val(user[0]['username']);
                    $('#role_id').val(user[0]['role_id']);
                }
            });
        });
    </script>
@endsection