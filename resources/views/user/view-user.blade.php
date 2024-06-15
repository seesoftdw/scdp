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
                    <h1 class="m-0">User List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item active">User List</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 float-sm-right">
                    <div class="card">
                        <div class="card-header">
                            <button type="submit" class="btn btn-dark" style=margin-bottom:10px;margin-left:10px
                                onclick="window.location='{{ url('create-user') }}'">Add User
                            </button>
                        </div>


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

                        @if (session()->has('delete'))
                            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                                <div class="alert alert-danger">
                                    {{ session()->get('delete') }}
                                </div>
                            </div>
                        @endif
                        
                        <div class="card-body">
							<div class="table-responsive">
                            <!-- <table id="example2" class="table table-bordered table-hover"> -->
                            <table id="datatable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>User name</th>
                                        <th>Role</th>
                                        <th>Department</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($users))
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ ($user->role_id == 1) ? 'Admin' : (($user->role_id == 2) ? 'HOD': 'User') }}</td>
                                                @if(!empty($user->department->department_name))
                                                <td>{{ ($user->role_id == 1) ? '-' : $user->department->department_name }}</td>
                                                @else
                                                <td>-</td>
                                                @endif
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @if($user->role_id != '1')
                                                    <a href="{{ url('/user/' . $user->id) }}" title="View user"><button
                                                            class="btn btn-success btn-sm"><i class="fa fa-eye"
                                                                aria-hidden="true"></i></button></a>
                                                    <a href="{{ url('edit-user?' . $user->id) }}"
                                                        title="Edit user">
                                                        <button class="btn btn-primary btn-sm" ><i class="fa fa-pencil-alt" aria-hidden="true"></i>
                                                        </button>
                                                    </a>

                                                    <form method="POST" action="{{ url('/user/' . $user->id) }}"
                                                        accept-charset="UTF-8" style="display:inline">
                                                        {{ method_field('DELETE') }}
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-danger btn-sm show-alert-delete-box"
                                                            title="Delete user"><i class="fa fa-trash-alt" aria-hidden="true"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-danger" style="text-align: center">No record
                                                found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
					  </div>
                        @if (isset($users))
                            <!-- <div class="col-sm-12">
                                <ol class="float-sm-right">
                                     $users->links() 
                                </ol>
                            </div> -->
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">
    $('.show-alert-delete-box').click(function(event){
        var form =  $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
            title: "Are you sure you want to delete this record?",
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            type: "warning",
            buttons: ["Cancel","Yes!"],
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
    });
</script>
@endsection