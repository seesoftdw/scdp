@extends('layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">View Soe budget distribution</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">View Soe budget distribution</li>
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
                    	@if(count($first) > 0)
                        <div class="col-lg-12 card card-primary">
                            <!-- /.card-header -->
                            <!-- form start -->
                                <div class="card-body">
									<div class="table-responsive">
										<table class="table table-bordered">
										  <thead>
											<tr>
											  <th colspan="6"><h4 align="center">Quarter 1 (April to June)</h4></th>
											</tr>
											<tr>
											  <th>Sr. No. </th>
											  <th>Date</th>
											  <th>Revision</th>
											  <th>Comment</th>
											  <th>Updated by</th>
											  <th>Action</th>
											</tr>
										  </thead>
										  <tbody>
										  	@foreach($first as $key => $value)
											<tr>
											  <td>{{$key + 1}}</td>
											  <td>{{date('d-m-Y', strtotime($value->created_at));}}</td>
											  <td>Revision {{$key + 1}}</td>
											  <td>{{$value->comments}}</td>
											  <td>
											  	<?php
											  	$name = App\Models\user::where('id',$value->created_by)->first();
											  	if(!empty($name->name))
											  	{
											  		echo $name->name;
											  	}
											  	?>
											  </td>
											  <td>
											  	@if($value->notification_doc)
											  	<a class="btn btn-success btn-sm" href="{{asset('notification_docs')}}/{{$value->notification_doc}}" target="_blank"><i class="fas fa-eye"></i> View Notification Docs</a>
											  	@endif
											  	<button class="btn btn-success btn-sm logbtn" data-id="{{$value->id}}"><i class="fas fa-eye"></i> Logs</button>
											  </td>
											</tr>
											@endforeach
										  </tbody>
										</table>
									</div>
                                </div>
                            <!-- /.card-body -->
                        </div>
                        @endif
                    	@if(count($second) > 0)
                        <div class="col-lg-12 card card-primary">
                            <!-- /.card-header -->
                            <!-- form start -->
                                <div class="card-body">
									<div class="table-responsive">
										<table class="table table-bordered">
										  <thead>
											<tr>
											  <th colspan="6"><h4 align="center">Quarter 2 (July to September)</h4></th>
											</tr>
											<tr>
											  <th>Sr. No.</th>
											  <th>Date</th>
											  <th>Revision</th>
											  <th>Comment</th>
											  <th>Updated by</th>
											  <th>Action</th>
											</tr>
										  </thead>
										  <tbody>
										  	@foreach($second as $key => $value)
											<tr>
											  <td>{{$key + 1}}</td>
											  <td>{{date('d-m-Y', strtotime($value->created_at));}}</td>
											  <td>Revision {{$key + 1}}</td>
											  <td>{{$value->comments}}</td>
											  <td>
											  	<?php
											  	$name = App\Models\user::where('id',$value->created_by)->first();
											  	if(!empty($name->name))
											  	{
											  		echo $name->name;
											  	}
											  	?>
											  </td>
											  <td>
											  	@if($value->notification_doc)
											  		<a class="btn btn-success btn-sm" href="{{asset('notification_docs')}}/{{$value->notification_doc}}" target="_blank"><i class="fas fa-eye"></i> View Notification Docs</a>
											  	@endif
											  	<button class="btn btn-success btn-sm logbtn" data-id="{{$value->id}}"><i class="fas fa-eye"></i> Logs</button>
											  </td>
											</tr>
											@endforeach
										  </tbody>
										</table>
									</div>
                                </div>
                            <!-- /.card-body -->
                        </div>
                        @endif
                    	@if(count($third) > 0)
                        <div class="col-lg-12 card card-primary">
                            <!-- /.card-header -->
                            <!-- form start -->
                                <div class="card-body">
									<div class="table-responsive">
										<table class="table table-bordered">
										  <thead>
											<tr>
											  <th colspan="6"><h4 align="center">Quarter 3 (October to December)</h4></th>
											</tr>
											<tr>
											  <th>Sr. No.</th>
											  <th>Date</th>
											  <th>Revision</th>
											  <th>Comment</th>
											  <th>Updated by</th>
											  <th>Action</th>
											</tr>
										  </thead>
										  <tbody>
										  	@foreach($third as $key => $value)
											<tr>
											  <td>{{$key + 1}}</td>
											  <td>{{date('d-m-Y', strtotime($value->created_at));}}</td>
											  <td>Revision {{$key + 1}}</td>
											  <td>{{$value->comments}}</td>
											  <td>
											  	<?php
											  	$name = App\Models\user::where('id',$value->created_by)->first();
											  	if(!empty($name->name))
											  	{
											  		echo $name->name;
											  	}
											  	?>
											  </td>
											  <td>
											  	@if($value->notification_doc)
											  		<a class="btn btn-success btn-sm" href="{{asset('notification_docs')}}/{{$value->notification_doc}}" target="_blank"><i class="fas fa-eye"></i> View Notification Docs</a>
											  	@endif
											  	<button class="btn btn-success btn-sm logbtn" data-id="{{$value->id}}"><i class="fas fa-eye"></i> Logs</button>
											  </td>
											</tr>
											@endforeach
										  </tbody>
										</table>
									</div>
                                </div>
                            <!-- /.card-body -->
                        </div>
                        @endif
                    	@if(count($fourth) > 0)
                        <div class="col-lg-12 card card-primary">
                            <!-- /.card-header -->
                            <!-- form start -->
                                <div class="card-body">
									<div class="table-responsive">
										<table class="table table-bordered">
										  <thead>
											<tr>
											  <th colspan="6"><h4 align="center">Quarter 4 (January to March)</h4></th>
											</tr>
											<tr>
											  <th>Sr. No.</th>
											  <th>Date</th>
											  <th>Revision</th>
											  <th>Comment</th>
											  <th>Updated by</th>
											  <th>Action</th>
											</tr>
										  </thead>
										  <tbody>
										  	@foreach($fourth as $key => $value)
											<tr>
											  <td>{{$key + 1}}</td>
											  <td>{{date('d-m-Y', strtotime($value->created_at));}}</td>
											  <td>Revision {{$key + 1}}</td>
											  <td>{{$value->comments}}</td>
											  <td>
											  	<?php
											  	$name = App\Models\user::where('id',$value->created_by)->first();
											  	if(!empty($name->name))
											  	{
											  		echo $name->name;
											  	}
											  	?>
											  </td>
											  <td>
											  	@if($value->notification_doc)
											  		<a class="btn btn-success btn-sm" href="{{asset('notification_docs')}}/{{$value->notification_doc}}" target="_blank"><i class="fas fa-eye"></i> View Notification Docs</a>
											  	@endif
											  	<button class="btn btn-success btn-sm logbtn" data-id="{{$value->id}}"><i class="fas fa-eye"></i> Logs</button>
											  </td>
											</tr>
											@endforeach
										  </tbody>
										</table>
									</div>
                                </div>
                            <!-- /.card-body -->
                        </div>
                    	@endif
                    </div>
                </div>
            </section>
        </div>
    </section>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Logs</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="mainlog">
                    
                </div>
            </div>
        <!-- /.modal-content -->
        </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@section('scripts')
<script type="text/javascript">
	$(".logbtn").click(function() {
		var id = $(this).attr('data-id');
		var url = "{{ route('get_log_of_revised_outlay', ':id') }}";
		url = url.replace(':id', id);
		// alert(id);
		$.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                	$("#mainlog").html(data);
					$('#modal-default').modal('show');
                }
            });
	});
</script>
@endsection