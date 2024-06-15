@extends('layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Capital Record List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Capital Record List</li>
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
			   <div class="form-in-box">
	  <div class="row">
		   <div class="col-lg-3">
            <div class="form-group">
              <label>Department</label>
			  <div class="form-control control-disabled">{{ $capitalData->department->department_name }}</div>
            </div>
          </div>
		  <div class="col-lg-3">
			   <div class="form-group">
				<label>Major head</label>
				<div class="form-control control-disabled">{{ $capitalData->majorhead->complete_head }}</div>
            </div>
		  </div>
		  <div class="col-lg-3">
			   <div class="form-group">
				<label>Scheme</label>
				<div class="form-control control-disabled">{{ $capitalData->scheme->scheme_name }}</div>
            </div>
		  </div>
	  </div>
  </div>
			
            <section class="content">                
                <div class="row">
                    <div class="col-lg-12 card card-primary">
                        <!-- /.card-header -->
                         <div id="doublescroll" class="card-body" style="overflow-x:auto;">
                         <div  class="table-responsive" >
                            <table id="capitalTable" class=" table table-bordered table-hover  " id="">
                                <thead>
								
								
                                    <tr>
                                       <th>Sr No.</th>
                                        <th>Work Code</th>
                                        <th>Work Name</th>
                                        <th>EstimateCost</th>
                                        <th>AA/ES (In Lakhs)</th>
                                        <th>Budget Previous Year</th>
                                        <th>Budget Utilize Previous Year</th>
                                        <th>Funds Required</th>
                                        <th>Type</th>
                                        <th>Work</th>
                                        <th>Original Scope Of Work</th>
                                        <th>Work Category</th>
                                        <th>Dispute</th>
                                        <th>FCA</th>
                                        <th>Detail</th>
                                        <th>Priority</th>
                                        <th>pow</th>
                                        <th>Category</th>	  
                                        <th>Action</th>	  
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($revenuerecord))
                                        @foreach ($revenuerecord as $item)
                                            <tr>
											
											
										
											
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->enterWorkCode }}</td>
                                                <td>{{ $item->enterWorkName }}</td>
                                                <td>{{ $item->enterEstimateCost }}</td>
                                                <td>{{ $item->enterAA_ES }}</td>
                                                <td>{{ $item->budgetProvidedTillPreviousYear }}</td>
                                                <td>{{ $item->budgetUtilizeTillDatepreviousYear }}</td>
                                                <td>{{ $item->fundsRequiredForCompletion }}</td>
                                                <td>{{ $item->SelectType }}</td>
                                                <td>{{ $item->SelectWork }}</td>
                                                <td>{{ $item->selectOriginalScopeOfWork }}</td>
                                                <td>{{ $item->workCategory }}</td>
                                                <td>{{ $item->dispute }}</td>
                                                <td>{{ $item->fca }}</td>
                                                <td>{{ $item->enterDetail }}</td>
                                                <td>{{ $item->Priority }}</td>
                                                <td>{{ $item->pow }}</td>
                                                <td>{{ $item->category }}</td>
                                                
                                                
                                                <td>
												
												
													<a title="View Revenue List" href="{{ route('revenuedetail',$item->id)}}" class="btn btn-success btn-sm"><i class="fa-eye fas"></i></a>
												</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="13" class="text-danger" style="text-align: center">No record
                                                found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        </div>
                       
                        
                    </div>
					 @if (isset($revenuerecord))
                            <div class="col-sm-12">
                                <ol class="float-sm-right">
                                    {{ $revenuerecord->links() }}
                                </ol>
                            </div>
                        @endif
                </div>
            </section>
        </div>
    </section>
@endsection
@section('scripts')
   <script>
  function DoubleScroll(element) {
            var scrollbar = document.createElement('div');
            scrollbar.appendChild(document.createElement('div'));
            scrollbar.style.overflow = 'auto';
            scrollbar.style.overflowY = 'hidden';
            scrollbar.firstChild.style.width = element.scrollWidth + 'px';
            scrollbar.firstChild.style.paddingTop = '1px';
            scrollbar.firstChild.appendChild(document.createTextNode('\xA0'));
            scrollbar.onscroll = function() {
                element.scrollLeft = scrollbar.scrollLeft;
            };
            element.onscroll = function() {
                scrollbar.scrollLeft = element.scrollLeft;
            };
            element.parentNode.insertBefore(scrollbar, element);
        }

        DoubleScroll(document.getElementById('doublescroll'));
</script>
@endsection