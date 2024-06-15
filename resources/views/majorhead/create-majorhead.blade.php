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
                    <h1 class="m-0">Add majorhead</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Add majorhead</li>
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
                        <!-- /.card-header -->
                        <!-- form start -->
						<div class="card">
                        <form id="majorheadForm" action="{{ route('majorhead.store') }}" method="POST">
                            @csrf
                            <div class="card-body" id="innneraddinput">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="department_id">Department Name*</label>
                                            <select name="department_id" id="department_id" class="form-control">
                                                <option value="">--- Select department ---</option>
                                                @if (isset($departmentlist))
                                                    @foreach ($departmentlist as $department)
                                                        <option value={{ $department->id }}>
                                                            {{ $department->department_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="mjr_head">Mjr head*</label>
                                            <input type="number" min="0" class="form-control" id="mjr_head"
                                                name="mjr_head" placeholder="Mjr head">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sm_head">Sm head*</label>
                                            <input type="number" min="0" class="form-control" id="sm_head"
                                                name="sm_head" placeholder="Sm head">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="min_head">Min head*</label>
                                            <input type="number" min="0" class="form-control" id="min_head"
                                                name="min_head" placeholder="Min head">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sub_head">Sub head*</label>
                                            <input type="number" min="0" class="form-control" id="sub_head"
                                                name="sub_head" placeholder="Sub head">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bdgt_head">Bdgt head*</label>
                                            <input type="text" class="form-control" id="bdgt_head" name="bdgt_head"
                                                placeholder="Bdgt head">
                                        </div>
                                    </div>
									 <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="complete_head">Complete head*</label>
                                            <input type="text" class="form-control" id="complete_head_hidden"
                                                name="complete_head_hidden" placeholder="complete head" disabled>
                                            <input type="hidden" id="complete_head" name="complete_head">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Add</button>
                            </div>
                        </form>
                    </div>
					</div>
                </div>
            </section>
        </div>
    </section>
@endsection
@section('scripts')
    <style type="text/css">
        .error{
            color: red;
        }
    </style>
    
    <script type="text/javascript" src="{{asset('assets/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">
        $("#majorheadForm").validate({
            rules: {
                department_id: {
                    required: true
                },
                mjr_head: {
                    required: true,
                    minlength: 4,
                    maxlength: 4
                },
                sm_head: {
                    required: true,
                    minlength: 2,
                    maxlength: 2
                },
                min_head: {
                    required: true,
                    minlength: 3,
                    maxlength: 3
                },
                sub_head: {
                    required: true,
                    minlength: 2,
                    maxlength: 2
                },
                bdgt_head: {
                    required: true,
                    minlength: 4,
                    maxlength: 4
                }
            },
            messages: {
                mjr_head: "Only 4 Digits Allowed",
                sm_head: "Only 2 Digits Allowed",
                min_head: "Only 3 Digits Alloweds",
                sub_head: "Only 2 Digits Allowed",
                bdgt_head: "Only 4 Digits Allowed"
            }
        });
    </script>

    <script type="text/javascript">
        var complete_head = "";
        var mjr_head = sm_head = min_head = sub_head = bdgt_head = "";


        $('#mjr_head').on('keyup', function(e) {
            mjr_head = e.target.value
            $('#complete_head').val(mjr_head + "-" + sm_head + "-" + min_head + "-" + sub_head + "-" + bdgt_head);
            $('#complete_head_hidden').val(mjr_head + "-" + sm_head + "-" + min_head + "-" + sub_head + "-" + bdgt_head);
        });

        $('#sm_head').on('keyup', function(e) {
            sm_head = e.target.value
            $('#complete_head').val(mjr_head + "-" + sm_head + "-" + min_head + "-" + sub_head + "-" + bdgt_head);
            $('#complete_head_hidden').val(mjr_head + "-" + sm_head + "-" + min_head + "-" + sub_head + "-" + bdgt_head);
        });

        $('#min_head').on('keyup', function(e) {
            min_head = e.target.value
            $('#complete_head').val(mjr_head + "-" + sm_head + "-" + min_head + "-" + sub_head + "-" + bdgt_head);
            $('#complete_head_hidden').val(mjr_head + "-" + sm_head + "-" + min_head + "-" + sub_head + "-" + bdgt_head);
        });

        $('#sub_head').on('keyup', function(e) {
            sub_head = e.target.value
            $('#complete_head').val(mjr_head + "-" + sm_head + "-" + min_head + "-" + sub_head + "-" + bdgt_head);
            $('#complete_head_hidden').val(mjr_head + "-" + sm_head + "-" + min_head + "-" + sub_head + "-" + bdgt_head);
        });

        $('#bdgt_head').on('keyup', function(e) {
            bdgt_head = e.target.value
            $('#complete_head').val(mjr_head + "-" + sm_head + "-" + min_head + "-" + sub_head + "-" + bdgt_head);
            $('#complete_head_hidden').val(mjr_head + "-" + sm_head + "-" + min_head + "-" + sub_head + "-" + bdgt_head);
        });
    </script>
@endsection
