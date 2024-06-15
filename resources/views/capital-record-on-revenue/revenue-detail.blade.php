@extends('layout.master')

@section('content')
<style>
.verfication-img-box {

    border: solid 1px #ebebeb;

    padding: 15px 10px;

	margin-bottom:15px;

    text-align: center;

    -webkit-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.24);

    -moz-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.24);

    box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.24);

}
img.img-verfication {width: 100%; max-height: 110px; min-height:110px;  margin-bottom:20px; }

.document-view { display:inline-block;}

.document-view a{ display:inline;}

.document-view a .fa { margin-top:0 !important; margin-bottom:0 !important;}
.action-btn {
    text-align: right;
    margin-bottom: 10px;
}
</style>
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
		<div class="action-btn">
				<a class="pull-right btn btn-danger pdf-button" href="{{ route('generatePDF', $revenuerecord->id) }}"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download PDF</a>
		</div>
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
                      	    <div class=" card-body">
                        <div class="row">
						
	
    
		   <div class="col-lg-3">
            <div class="form-group">
              <label>Work Code</label>
			  <div class="form-control control-disabled">{{ $revenuerecord->enterWorkCode ? :  ' '  }}</div>
            </div>
          </div>
		  <div class="col-lg-3">
			   <div class="form-group">
				<label>Work Name</label>
				<div class="form-control control-disabled">{{ $revenuerecord->enterWorkName ? :  ' '  }}</div>
            </div>
		  </div>
		  <div class="col-lg-3">
			   <div class="form-group">
				<label>AA/ES (In Lakhs)</label>
				<div class="form-control control-disabled">{{ $revenuerecord->enterAA_ES ? :  ' '  }}</div>
            </div>
		  </div>
		    <div class="col-lg-3">
			   <div class="form-group">
				<label>Budget Previous Year</label>
				<div class="form-control control-disabled">{{ $revenuerecord->budgetProvidedTillPreviousYear ? :  ' '  }}</div>
            </div>
		  </div>
	  </div>
	  
                                     
                                      
	     <div class="row">
		   <div class="col-lg-3">
            <div class="form-group">
              <label>Budget Utilize Previous Year</label>
			  <div class="form-control control-disabled">{{ $revenuerecord->budgetUtilizeTillDatepreviousYear ? :  ' '  }}</div>
            </div>
          </div>
		  <div class="col-lg-3">
			   <div class="form-group">
				<label>Funds Required</label>
				<div class="form-control control-disabled">{{ $revenuerecord->fundsRequiredForCompletion ? :  ' '  }}</div>
            </div>
		  </div>
		  <div class="col-lg-3">
			   <div class="form-group">
				<label>Type</label>
				<div class="form-control control-disabled">{{ $revenuerecord->SelectType ? :  ' '  }}</div>
            </div>
		  </div>
		    <div class="col-lg-3">
			   <div class="form-group">
				<label>Work</label>
				<div class="form-control control-disabled">{{ $revenuerecord->SelectWork ? :  ' '  }}</div>
            </div>
		  </div>
	  </div>
	
  
	 
	     <div class="row">
		   <div class="col-lg-3">
            <div class="form-group">
              <label>Original Scope Of Work</label>
			  <div class="form-control control-disabled">{{ $revenuerecord->selectOriginalScopeOfWork ? :  ' '  }}</div>
            </div>
          </div>
		  <div class="col-lg-3">
			   <div class="form-group">
				<label>Work Category</label>
				<div class="form-control control-disabled">{{ $revenuerecord->workCategory ? :  ' '  }}</div>
            </div>
		  </div>
		  <div class="col-lg-3">
			   <div class="form-group"> 
				<label>Dispute</label>
				<div class="form-control control-disabled">{{ $revenuerecord->dispute ? :  ' '  }}</div>
            </div>
		  </div>
		    <div class="col-lg-3">
			   <div class="form-group">
				<label>FCA</label>
				<div class="form-control control-disabled">{{ $revenuerecord->fca ? :  ' '  }}</div>
            </div>
		  </div>
	  </div>
	  
	     <div class="row">
		   <div class="col-lg-3">
            <div class="form-group">
              <label>Detail</label>
			  <div class="form-control control-disabled">{{ $revenuerecord->enterDetail ? :  ' '  }}</div>
            </div>
          </div>
		  <div class="col-lg-3">
			   <div class="form-group">
				<label>Priority</label>
				<div class="form-control control-disabled">{{ $revenuerecord->priority ? :  ' '  }}</div>
            </div>
		  </div>
		  <div class="col-lg-3">
			   <div class="form-group">
				<label>pow</label>
				<div class="form-control control-disabled">{{ $revenuerecord->pow ? :  ' '  }}</div>
            </div>
		  </div>
		    <div class="col-lg-3">
			   <div class="form-group">
				<label>Category</label>
				<div class="form-control control-disabled">{{ $revenuerecord->category ? :  ' '  }}</div>
            </div>
		  </div>
	  </div>
                    </div>
                    </div>
				
                </div>
            </section>
			
			  <section class="content">                
                <div class="row">
                    <div class="col-lg-12 card card-primary">
                        <!-- /.card-header -->
						 <div class="card-header card-header-warning card-header-icon">

				
				<h2 class="card-title">Attached Invoices</h2>
				</div>
				<div class=" card-body">
				<?php
				$inovices= App\Models\DocumentsRevenue::where('revenue_id',$revenuerecord->id)->get();
				?>
					<div class="row">  
					
					@if(!empty($inovices))
						@foreach($inovices as $_inovices)
						<div class="col-md-4">
							<div class="verfication-img-box image-lightbox">

							
							<img src="{{ asset($_inovices->uploadInvoice)}}" class="img-verfication" alt="">
							<span class="document-view"><a data-lightbox="roadtrip" class="btn btn-success" href="{{ asset($_inovices->uploadInvoice)}}">
							View</a></span>
							
							</div>
						</div>  
						@endforeach
					@endif						
					</div>        
                          
                    </div>
                    </div>
				
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