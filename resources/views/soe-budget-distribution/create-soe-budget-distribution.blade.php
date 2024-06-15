@extends('layout.master')

@section('content')
<style type="text/css">
    input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Soe budget distribution</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Add Soe budget distribution</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    <section class="content">
        @php
            $user = auth()->user();
        @endphp
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
                        <form id="soeBudgteDistributionForm" action="{{ route('soe-budget-distribution.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    @if (auth()->user())
                                        @if (auth()->user()->role_id == '1')
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="department_id">Department</label>
                                                    <select name="department_id" id="department_id" class="form-control">
                                                        <option value="">---Select Department---</option>
                                                        @if (isset($departmentlist))
                                                            @foreach ($departmentlist as $department)
                                                                <option value={{$department->id}}>{{$department->department_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="department_id">Department</label>
                                                    <select name="department_id" id="department_id" class="form-control" disabled
                                                        value={{ $user->department_id }}>
                                                        <option value={{ $user->department_id }}>
                                                            {{ $user->department->department_name }}</option>
                                                    </select>
                                                    <select name="department_id" id="department_id" class="form-control" hidden
                                                        value={{ $user->department_id }}>
                                                        <option value={{ $user->department_id }}>
                                                            {{ $user->department->department_name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                    @endif

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="majorhead_id">Majorhead</label>
                                            <select name="majorhead_id" id="majorhead_id" class="form-control">
                                                <option value="">---Select majorhead---</option>
                                            </select>
                                        </div>
                                    </div>

                                     <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="scheme_id">Scheme</label>
                                            <select name="scheme_id" id="scheme_id" class="form-control">
                                                <option value="">---Select scheme---</option>
                                            </select>
                                        </div>
                                    </div>
									
									 <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="soe_id">Soe</label>
                                            <select name="soe_id" id="soe_id" class="form-control">
                                                <option value="">---Select soe---</option>
                                            </select>
                                        </div>
                                    </div>
									
									  <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="fin_year_id">Fin year</label>
                                            <select name="fin_year_id" id="fin_year_id" class="form-control" disabled>
                                                <option value="">---Select Fin year---</option>
                                                @if (isset($finyearlist))
                                                    @foreach ($finyearlist as $year)
                                                            <option value={{$year->id}} @if(Session::get('finyear')==$year->id) selected @endif>{{$year->finyear}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                             <input type="hidden" id="fin_year_id" name="fin_year_id" value="{{Session::get('finyear')}}">
                                        </div>
                                    </div>
                                     <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="type">Plan</label>
                                            <select name="plan_id" id="plan_id_disabled" class="form-control" disabled>
                                                <option value="">---Select Plan---</option>
                                                @if (isset($planlist))
                                                    @foreach ($planlist as $plan)
                                                        <option value={{$plan->id}}>{{$plan->plan_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <input type="hidden" id="plan_id" name="plan_id">
                                        </div>
                                    </div>
                                     <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="type">Type</label>
                                            <select name="type" id="type" class="form-control">
                                                    <option value="">---Select Type---</option>
                                                    <option value="1">Automatic</option>
                                                    <option value="2">Manual</option>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="type">Current Quarter of Year </label>
                                            <input type="text" class="form-control" value="{{ $currentquarter }}" disabled>
                                        </div>
                                    </div>
                                     
									
									
                                </div>

                                <div class="row"> 
                             
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <table id="Undistributed_outlay_tbl" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th><h6>Undistributed Outlay (in Lakh.)</h6></th>
                                                        <th>
                                                            <h6 id="undistributed_outlay_label" name="undistributed_outlay_label"></h6>
                                                            <input type="hidden" name="undistributed_outlay_label" id="undistributed_outlay_label_hidden"/>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th><h6>Total Outlay (in Lakh.)</h6></th>
                                                        <th>
                                                            <h6 id="total_outlay_label" name="total_outlay_label"></h6>
                                                            <input type="hidden" name="total_outlay_label" id="total_outlay_label_hidden"/>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                                                    
                                </div>
                                <div class="row"> 
                                    
                                    <div class="col-lg-12">
                                        <div class="form-group table-responsive">
                                            <table class="table table-bordered" name="district_outlay_tbl" id="district_outlay_tbl">
                                                <thead>
                                                    <tr style="text-align: center;">
                                                        <th>District</th>
                                                        <th colspan="3">Financial</th>
                                                        <th colspan="5">Physical Achievement</th>
                                                        <th colspan="3">Beneficiaries</th>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <th>Outlay</th>
                                                        <th>Expenditure</th>
                                                        <th>Percentage (%)</th>
                                                        <th>Item Name</th>
                                                        <th>Unit Of Measure</th>
                                                        <th>Unit</th>
                                                        <th>Achievement</th>
                                                        <th>Percentage (%)</th>
                                                        <th>Total</th>
                                                        <th>Women (Out of Total )</th>
                                                        <th>Disable (Out of total)</th>
                                                    </tr>
                                                </thead>
                                                <tbody name="outlayarr">
                                                    @if (isset($districtlist))
                                                    @php
                                                     
                                                    @endphp
                                                        @foreach ($districtlist as $i=> $district)
                                                        <tr>
                                                            <td>{{$district->district_name}}</td>
                                                            <td>
                                                                <input required type="number" start="1" step="0.01" min="0"class="form-control trigger outlayamt" 
                                                                name="outlay[{{$district->id}}]" 
                                                                id="outlay{{$district->id}}" value="0" placeholder="Enter outlay">
                                                                  <input required type="hidden"
                                                                name="resvised_resvised_outlay[{{$district->id}}]" 
                                                                id="resvised_outlay{{$district->id}}"   value="0">

                                                            </td>
                                                           <td>
                                                                <input type="number" start="1" step="0.01" min="0"class="form-control " 
                                                                name="expenditure[{{$district->id}}]" 
                                                                id="expenditure{{$district->id}}" value="0" placeholder="Enter outlay" readonly>

                                                            </td>
                                                            <td>
                                                                <input type="number" start="1" step="0.01" min="0"class="form-control " 
                                                                name="opercentage[{{$district->id}}]" 
                                                                id="opercentage{{$district->id}}" value="0" placeholder="Enter outlay" readonly>

                                                            </td>
                                                            <td>
                                                                <input type="text" start="1" step="0.01" min="0"class="form-control " 
                                                                name="item_name[{{$district->id}}]" 
                                                                id="item_name{{$district->id}}"  placeholder="Enter Item Name" readonly>

                                                            </td>
                                                            <td>
                                                                <input type="text" start="1" step="0.01" min="0"class="form-control " 
                                                                name="unit_measure[{{$district->id}}]" 
                                                                id="unit_measure{{$district->id}}"  placeholder="Enter Unit Of Measure" readonly>

                                                            </td>
                                                            <td>
                                                                <input type="number" start="1" step="0.01" min="0"class="form-control " 
                                                                name="unit[{{$district->id}}]" 
                                                                id="unit{{$district->id}}" value="0" placeholder="Enter outlay" readonly>

                                                            </td>
                                                            
                                                            <td>
                                                                <input type="number" start="1" step="0.01" min="0"class="form-control " 
                                                                name="achievement[{{$district->id}}]" 
                                                                id="achievement{{$district->id}}" value="0" placeholder="Enter outlay" readonly>

                                                            </td>
                                                            <td>
                                                                <input type="number" start="1" step="0.01" min="0"class="form-control " 
                                                                name="upercentage[{{$district->id}}]" 
                                                                id="upercentage{{$district->id}}" value="0" placeholder="Enter outlay" readonly >

                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control " 
                                                                name="ben_total[{{$district->id}}]" 
                                                                id="ben_total{{$district->id}}" value="0" placeholder="Enter outlay" readonly>

                                                            </td>
                                                            <td>
                                                                <input type="number" start="1" class="form-control " 
                                                                name="women[{{$district->id}}]" 
                                                                id="women{{$district->id}}" value="0" placeholder="Enter outlay" readonly>

                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control " 
                                                                name="disable[{{$district->id}}]" 
                                                                id="disable{{$district->id}}" value="0" placeholder="Enter outlay" readonly>

                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                @endif
                                                </tbody>
                                            </table>
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
    <script type="text/javascript">
        $("document").ready(function(){
            $("#plan_id").val("");
            $("#plan_id_disabled").val("");
            $("#district_outlay_tbl").hide();
            $("#Undistributed_outlay_tbl").hide();
            var department_id = $("#department_id").val();
            if(department_id > 0){
                $.ajax({
                url: "{{ route('get_distribution_majorhead_by_department') }}?department_id=" +department_id,
                method: 'GET',
                success: function(data) {
                    $('#majorhead_id').html(data.majorheadHtml);
                    $('#scheme_id').html(data.schemeHtml);
                    $('#soe_id').html(data.soeHtml);
                }
            });
            }
        });

        $("#department_id").change(function(){
            $("#plan_id").val("");
            $("#plan_id_disabled").val("");
            $("#district_outlay_tbl").hide();
            $("#Undistributed_outlay_tbl").hide();
            $.ajax({
                url: "{{ route('get_distribution_majorhead_by_department') }}?department_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#majorhead_id').html(data.majorheadHtml);
                    $('#scheme_id').html(data.schemeHtml);
                    $('#soe_id').html(data.soeHtml);
                }
            });
        });
        $("#majorhead_id").change(function(){
            $("#plan_id").val("");
            $("#plan_id_disabled").val("");
            $("#district_outlay_tbl").hide();
            $("#Undistributed_outlay_tbl").hide();
            $.ajax({
                url: "{{ route('get_distribution_scheme_by_majorhead') }}?majorhead_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#scheme_id').html(data.schemeHtml);
                    $('#soe_id').html(data.soeHtml);
                }
            });
        });
        $("#scheme_id").change(function(){
            department_id=$("#department_id").val()
            majorhead_id=$("#majorhead_id").val()
            $("#plan_id").val("");
            $("#plan_id_disabled").val("");
            $("#district_outlay_tbl").hide();
            $("#Undistributed_outlay_tbl").hide();
            $.ajax({
                url: "{{ route('get_distribution_soe_by_scheme') }}?scheme_id=" + $(this).val()+'&department_id='+department_id+'&majorhead_id='+majorhead_id,
                method: 'GET',
                success: function(data) {
                    $('#soe_id').html(data.soeHtml);
                }
            });
        });

        $("#soe_id").change(function(){
            var department_id = $("#department_id").val();
            var majorhead_id = $("#majorhead_id").val();
            var scheme_id = $("#scheme_id").val();
            var soe_id = $(this).val();
            var fin_year_id = $("#fin_year_id").val();
            $("#plan_id").val("");
            $("#plan_id_disabled").val("");

            if(department_id > 0 && majorhead_id > 0 && scheme_id > 0 && soe_id > 0 && fin_year_id > 0){
                $.ajax({
                    url: "{{ route('get_soe_undistributed_outlay') }}?department_id="+department_id+"&majorhead_id="+majorhead_id+"&scheme_id="+scheme_id+"&soe_id="+soe_id+"&fin_year_id="+fin_year_id,
                    method: 'GET',
                    success: function(data) {
                        if(data.totaloutlay == 0 && data.undistributed_outlay == 0){
                            $("#Undistributed_outlay_tbl").show();
                            $("#undistributed_outlay").val(data.undistributed_outlay);
                            $("#undistributed_outlay_label").html(data.undistributed_outlay);
                            $("#total_outlay_label").html(data.totaloutlay);
                            $("#undistributed_outlay_label_hidden").val(data.undistributed_outlay);
                            $("#total_outlay_label_hidden").val(data.totaloutlay);
                        }else if(data.distribute_outlay){
                            $('#type').val(2);
                            $("#district_outlay_tbl").show();
                            $("#Undistributed_outlay_tbl").show();
                            $("#undistributed_outlay").val(data.undistributed_outlay);
                            $("#undistributed_outlay_label").html(data.undistributed_outlay/100000);
                            $("#total_outlay_label").html(data.totaloutlay/100000);
                            $("#undistributed_outlay_label_hidden").val(data.undistributed_outlay/100000);
                            $("#total_outlay_label_hidden").val(data.totaloutlay/100000);
                            $("#plan_id").val(data.plan_id);
                            $("#plan_id_disabled").val(data.plan_id);
                            for (var i = 0; i < data.distribute_outlay.length; i++) {
                                $('#'+data.distribute_outlay[i]['district_id']).val(data.distribute_outlay[i]['outlay']/100000);
                                $('#'+data.distribute_outlay[i]['district_id']).prop('disabled', true);
                            }
                        }else{
                            $("#Undistributed_outlay_tbl").show();
                            $("#undistributed_outlay").val(data.undistributed_outlay);
                            $("#undistributed_outlay_label").html(data.undistributed_outlay/100000);
                            $("#total_outlay_label").html(data.totaloutlay/100000);
                            $("#undistributed_outlay_label_hidden").val(data.undistributed_outlay/100000);
                            $("#total_outlay_label_hidden").val(data.totaloutlay/100000);
                            $("#plan_id").val(data.plan_id);
                            $("#plan_id_disabled").val(data.plan_id);
                        }
                    }
                });
            }            
        });

        $("#fin_year_id").change(function(){
            var department_id = $("#department_id").val();
            var majorhead_id = $("#majorhead_id").val();
            var scheme_id = $("#scheme_id").val();
            var soe_id = $("#soe_id").val();
            var fin_year_id = $(this).val();
            $("#plan_id").val("");
            $("#plan_id_disabled").val("");

            if(department_id > 0 && majorhead_id > 0 && scheme_id > 0 && soe_id > 0 && fin_year_id > 0){
                $.ajax({
                    url: "{{ route('get_soe_undistributed_outlay') }}?department_id="+department_id+"&majorhead_id="+majorhead_id+"&scheme_id="+scheme_id+"&soe_id="+soe_id+"&fin_year_id="+fin_year_id,
                    method: 'GET',
                    success: function(data) {
                        if(data.totaloutlay == 0 && data.undistributed_outlay == 0){
                            $("#Undistributed_outlay_tbl").show();
                            $("#undistributed_outlay").val(data.undistributed_outlay);
                            $("#undistributed_outlay_label").html(data.undistributed_outlay);
                            $("#total_outlay_label").html(data.totaloutlay);
                            $("#undistributed_outlay_label_hidden").val(data.undistributed_outlay);
                            $("#total_outlay_label_hidden").val(data.totaloutlay);
                        }else if(data.distribute_outlay){
                            $('#type').val(2);
                            $("#district_outlay_tbl").show();
                            $("#Undistributed_outlay_tbl").show();
                            $("#undistributed_outlay").val(data.undistributed_outlay);
                            $("#undistributed_outlay_label").html(data.undistributed_outlay/100000);
                            $("#total_outlay_label").html(data.totaloutlay/100000);
                            $("#undistributed_outlay_label_hidden").val(data.undistributed_outlay/100000);
                            $("#total_outlay_label_hidden").val(data.totaloutlay/100000);
                            $("#plan_id").val(data.plan_id);
                            $("#plan_id_disabled").val(data.plan_id);
                            for (var i = 0; i < data.distribute_outlay.length; i++) {
                                $('#'+data.distribute_outlay[i]['district_id']).val(data.distribute_outlay[i]['outlay']/100000);
                                $('#'+data.distribute_outlay[i]['district_id']).prop('disabled', true);
                            }
                        }else{
                            $("#Undistributed_outlay_tbl").show();
                            $("#undistributed_outlay").val(data.undistributed_outlay);
                            $("#undistributed_outlay_label").html(data.undistributed_outlay/100000);
                            $("#total_outlay_label").html(data.totaloutlay/100000);
                            $("#undistributed_outlay_label_hidden").val(data.undistributed_outlay/100000);
                            $("#total_outlay_label_hidden").val(data.totaloutlay/100000);
                            $("#plan_id").val(data.plan_id);
                            $("#plan_id_disabled").val(data.plan_id);
                        }
                    }
                });
            }  
        });

        $("#type").change(function(){
            var type = $(this).val()

            if (type == 2) {
                $("input").remove(".hidden");

                $("input[dist_name='district_0']").val(0)
                $("input[dist_name='district_1']").val(0)
                $("input[dist_name='district_2']").val(0)
                $("input[dist_name='district_3']").val(0)
                $("input[dist_name='district_4']").val(0)
                $("input[dist_name='district_5']").val(0)
                $("input[dist_name='district_6']").val(0)
                $("input[dist_name='district_7']").val(0)
                $("input[dist_name='district_8']").val(0)
                $("input[dist_name='district_9']").val(0)
                 $("input[dist_name='district_10']").val(0)
                  $("input[dist_name='district_11']").val(0)
                  $("input[dist_name='district_12']").val(0)

                $("input[dist_name='district_0']").prop('disabled', false);
                $("input[dist_name='district_1']").prop('disabled', false);
                $("input[dist_name='district_2']").prop('disabled', false);
                $("input[dist_name='district_3']").prop('disabled', false);
                $("input[dist_name='district_4']").prop('disabled', false);
                $("input[dist_name='district_5']").prop('disabled', false);
                $("input[dist_name='district_6']").prop('disabled', false);
                $("input[dist_name='district_7']").prop('disabled', false);
                $("input[dist_name='district_8']").prop('disabled', false);
                $("input[dist_name='district_9']").prop('disabled', false);
                $("input[dist_name='district_10']").prop('disabled', false);
                $("input[dist_name='district_11']").prop('disabled', false);
                $("input[dist_name='district_12']").prop('disabled', false);

                $("#district_outlay_tbl").show();
                var department_id = $("#department_id").val();
                var majorhead_id = $("#majorhead_id").val();
                var scheme_id = $("#scheme_id").val();
                var soe_id = $("#soe_id").val();
                var fin_year_id = $("#fin_year_id").val();
                if(department_id > 0 && majorhead_id > 0 && scheme_id > 0 && soe_id > 0 && fin_year_id > 0){
                $.ajax({
                    url: "{{ route('get_soe_undistributed_outlay') }}?department_id="+department_id+"&majorhead_id="+majorhead_id+"&scheme_id="+scheme_id+"&soe_id="+soe_id+"&fin_year_id="+fin_year_id+"&soe_budget_distribution_id=0",
                    method: 'GET',
                    success: function(data) {
                        if(data.distribute_outlay){
                            for (var i = 0; i < data.distribute_outlay.length; i++) {
                                $('#'+data.distribute_outlay[i]['district_id']).val(data.distribute_outlay[i]['outlay']/100000);
                                $('#'+data.distribute_outlay[i]['district_id']).prop('disabled', true);
                            }
                        }else{
                            $("input[dist_name='district_0']").val(0)
                            $("input[dist_name='district_1']").val(0)
                            $("input[dist_name='district_2']").val(0)
                            $("input[dist_name='district_3']").val(0)
                            $("input[dist_name='district_4']").val(0)
                            $("input[dist_name='district_5']").val(0)
                            $("input[dist_name='district_6']").val(0)
                            $("input[dist_name='district_7']").val(0)
                            $("input[dist_name='district_8']").val(0)
                            $("input[dist_name='district_9']").val(0)
                            
                        }
                        distributed_outlay_amount();
                    }
                });
            }
                
            }else if(type==1){
                $("#district_outlay_tbl").show();
                $undist_amount =$("#undistributed_outlay_label_hidden").val();
                $.ajax({
                    url: "{{ route('get_districtPercentage') }}",
                    method: 'GET',
                    success: function(data) {
                        $district_name = "";
                        for (var i = 0; i < data.districtpercentagelist.length; i++) {
                            amount = ($undist_amount * data.districtpercentagelist[i]['percentage']) / 100;
                            amount =amount.toFixed(2)
                            $('#outlay'+data.districtpercentagelist[i]['district_id']).val(amount);
                           // $('#'+data.districtpercentagelist[i]['district_id']).prop('disabled', true);

                            for (var j = 0; j < data.districtlist.length; j++) {
                                if( data.districtlist[j]['id'] ==  data.districtpercentagelist[i]['district_id']){
                                    $district_name = data.districtlist[j]['district_name'];
                                }
                            }
                            $("<input type='hidden' />").attr("class", "hidden").attr("name", $district_name).attr("value", amount).appendTo('#'+data.districtpercentagelist[i]['district_id']);
                        }
                        distributed_outlay_amount();
                    }
                });
            }else{
                $("#district_outlay_tbl").hide();
            }
            distributed_outlay_amount();

        });

        $('input.trigger').focusout(function(e){
            
            var input =$(this);
            if(input.val()==''){

                input.val(0);

            }
            if(parseFloat(input.val())>parseFloat($("#undistributed_outlay_label_hidden").val())){


                alert('Undistributed Outlay Exceeds Total Outlay , Please Enter Correct Outlay');
                input.val(0);
                //return;

            }
            distributed_outlay_amount();
        });

    
        function distributed_outlay_amount(){
            var distributed_outlay = 0;

            $(".outlayamt").each(function(){
            console.log($(this).val())
           distributed_outlay = distributed_outlay+parseInt($(this).val());
        });
            var undistributed_amount = $('#total_outlay_label').html() - distributed_outlay;
            $("#undistributed_outlay_label").html(undistributed_amount);
            $("#undistributed_outlay_label_hidden").val(undistributed_amount);
        }
    </script>
@endsection