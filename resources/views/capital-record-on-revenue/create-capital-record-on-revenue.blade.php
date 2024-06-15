@extends('layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Capital Record On Revenue</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Capital record on revenue</li>
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
				
				  
                    <div class="col-lg-12 card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="soeBudgteDistributionForm" action="{{ route('soe-budget-distribution.store') }}" method="POST">
                            @csrf
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
                                            <input type="text" class="form-control" id="enterAA/ES" name="enterAA/ES"
                                            placeholder="Enter AA/ES(in Lakhs)">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="uploadInvoice">Upload Invoice / Photo</label>
                                            <input type="file" class="form-control" id="uploadInvoice" name="uploadInvoice"
                                            placeholder="Upload Invoice / Photo">
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
                                            <input type="text" class="form-control" id="budgetUtilizeTillDate/previousYear" name="budgetUtilizeTillDate/previousYear"
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
                                              <option value="">--- Select Type ---</option>
                                              <option value="">RNS</option>
                                              </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                        <label for="SelectWork">Select Work</label>
                                            <select name="SelectWork" id="SelectWork" class="form-control">
                                              <option value="">--- Select Work ---</option>
                                              <option value="">Lumsum</option>
                                              </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                        <label for="selectOriginalScopeOfWork">Select Original Scope of work</label>
                                            <select name="selectOriginalScopeOfWork" id="selectOriginalScopeOfWork" class="form-control">
                                              <option value="">--- Select Original Scope of work ---</option>
                                              <option value="">RD</option>
                                              </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                        <label for="workCategory">Work Category</label>
                                            <select name="workCategory" id="workCategory" class="form-control">
                                              <option value="">--- Select Work Category ---</option>
                                              <option value="">Building</option>
                                              </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                        <label for="dispute">Dispute</label>
                                            <select name="dispute" id="dispute" class="form-control">
                                              <option value="">--- Select Dispute ---</option>
                                              <option value="">Yes</option>
                                              <option value="">No</option>
                                              </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                        <label for="fca">FCA</label>
                                            <select name="fca" id="fca" class="form-control">
                                              <option value="">--- Select FCA ---</option>
                                              <option value="">Land Dispute</option>
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
                                            <select name="pow" id="pow" class="form-control">
                                              <option value="">--- Select Priority of work ---</option>
                                              <option value="">Yes</option>
                                              <option value="">No</option>
                                              </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                        <label for="pow">if Yes, Select</label>
                                            <select name="pow" id="pow" class="form-control">
                                              <option value="">--- Select if yes ---</option>
                                              <option value="">CM</option>
                                              </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                        <label for="pow">Upload Sucess Stories Document / Photo / Video</label>
                                        <input type="file" class="form-control" id="enterDetail" name="enterDetail"
                                            placeholder="Enter Detail">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                        <label for="pow">Freeze / Priority</label>
                                            <select name="pow" id="pow" class="form-control">
                                              <option value="">--- Select Freeze / Priority ---</option>
                                              <option value="">Freeze</option>
                                              <option value="">Priority</option>
                                              </select>
                                        </div>
                                    </div>



                                </div>
                                
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">
        $("#sector_id").change(function(){
            $.ajax({
                url: "{{ route('get_soe_dist_sub_sector') }}?sector_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#subsector_id').html(data.subsectorhtml);
                    $('#department_id').html(data.departmenthtml);
                }
            });
        });
        $("#subsector_id").change(function(){
            $.ajax({
                url: "{{ route('get_soe_dist_department') }}?subsector_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#department_id').html(data.departmenthtml);
                }
            });
        });
    </script>
@endsection