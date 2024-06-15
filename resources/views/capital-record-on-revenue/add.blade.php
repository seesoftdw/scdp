@extends('layout.master')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Add Capital Record On Revenue</h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Master</a></li>
          <li class="breadcrumb-item active">Capital record on revenue</li>
        </ol>
      </div>
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
  </div>
  <!-- /.container-fluid --> 
</section>
<!-- /.content-header -->
<section class="content">
  <div class="container-fluid">
  @if ($errors->any())
  <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
    <div class="col-lg-6 alert alert-danger"> @foreach ($errors->all() as $error)
      <li class="text-danger">{{ $error }}</li>
      @endforeach </div>
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
	<div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 card card-primary"> 
        <!-- /.card-header --> 
        <!-- form start -->
        <form id="soeBudgteDistributionForm" action="{{route('storerevenue')}}" method="POST"    enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="schemeId" value="{{ $schemeId }}">
          <div class="card-body">
          <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="enterWorkCode">Enter Work Code</label>
              <input type="text" class="form-control" id="enterWorkCode" name="enterWorkCode"
                                            placeholder="Enter Work Code">
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="enterWorkName">Enter Work Name</label>
              <input type="text" class="form-control" id="enterWorkName" name="enterWorkName"
                                            placeholder="Enter Work Name">
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="enterEstimateCode">Enter Estimate Cost</label>
              <input type="text" class="form-control" id="enterEstimateCode" name="enterEstimateCode"
                                            placeholder="Enter Estimate Cost">
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="enterAA/ES">Enter AA/ES(in Lakhs)</label>
              <input type="text" class="form-control" id="enterAA/ES" name="enterAA_ES"
                                            placeholder="Enter AA/ES(in Lakhs)">
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="uploadInvoice">Upload Invoice / Photo</label>
              <input type="file" class="form-control" id="uploadInvoice" name="uploadInvoice[]"
                                            placeholder="Upload Invoice / Photo" multiple>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="budgetProvidedTillPreviousYear">Budget provided till previous year</label>
              <input type="text" class="form-control" id="budgetProvidedTillPreviousYear" name="budgetProvidedTillPreviousYear"
                                            placeholder="Budget provided till previous year">
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="budgetUtilizeTillDate/previousYear">Budget utilize till date/previous year</label>
              <input type="text" class="form-control" id="budgetUtilizeTillDate/previousYear" name="budgetUtilizeTillDatepreviousYear"
                                            placeholder="Budget utilize till date/previous year">
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="fundsRequiredForCompletion">Funds required for completion</label>
              <input type="text" class="form-control" id="fundsRequiredForCompletion" name="fundsRequiredForCompletion"
                                            placeholder="Funds required for completion">
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="SelectType">Select Type</label>
              <select name="SelectType" id="SelectType" class="form-control">
                <option value="" readonly>--- Select Type ---</option>
                <option value="RNS">RNS</option>
                <option value="TNS">TNS</option>
              </select>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="SelectWork">Select Work</label>
              <select name="SelectWork" id="SelectWork" class="form-control">
                <option value="" readonly>--- Select Work ---</option>
                <option value="Lumsum">Lumsum</option>
              </select>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="selectOriginalScopeOfWork">Select Original Scope of work</label>
              <select name="selectOriginalScopeOfWork" id="selectOriginalScopeOfWork" class="form-control">
                <option value="" readonly>--- Select Original Scope of work ---</option>
                <option value="RD">RD</option>
                <option value="CD">CD</option>
                <option value="MT">MT</option>
              </select>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="workCategory">Work Category</label>
              <select name="workCategory" id="workCategory" class="form-control">
                <option value="" readonly>--- Select Work Category ---</option>
                <option value="Building">Building</option>
                <option value="Road">Road</option>
              </select>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="dispute">Dispute</label>
              <select name="dispute" id="dispute" class="form-control">
                <option value="" readonly>--- Select Dispute ---</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="fca">FCA</label>
              <select name="fca" id="fca" class="form-control">
                <option value="" readonly>--- Select FCA ---</option>
                <option value="Land Dispute">Land Dispute</option>
                <option value="Court Case">Court Case</option>
                <option value="Any other">Any other</option>
              </select>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="enterDetail">Enter Detail</label>
              <input type="text" class="form-control" id="enterDetail" name="enterDetail"
                                            placeholder="Enter Detail">
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="pow">Priority of work</label>
              <select name="priority" id="pow" class="form-control">
                <option value="" readonly>--- Select Priority of work ---</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="pow">if Yes, Select</label>
              <select name="pow" id="pow" class="form-control">
                <option value="" readonly>--- Select if yes ---</option>
                <option value="CM">CM</option>
                <option value="PM">PM</option>
                <option value="MLA">MLA</option>
              </select>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label for="pow">Upload Sucess Stories Document / Photo </label>
              <input type="file" class="form-control" id="enterDetail" name="SucessStories"
                                            placeholder="Enter Detail">
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="pow">Freeze / Priority</label>
              <select name="category" id="pow" class="form-control">
                <option value="" readonly>--- Select Freeze / Priority ---</option>
                <option value="Freeze">Freeze</option>
                <option value="Priority">Priority</option>
              </select>
            </div>
          </div>
		  <div class="col-lg-12">
			   <button type="submit" class="btn btn-success">Save</button>
		  </div>
        </form>
      </div>
    </div>
    <!-- /.card-body -->
    
    </div>
	 </div>
    </div>
  </section>
  </div>
</section>
@endsection
@section('scripts')
   
@endsection