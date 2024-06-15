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
                    <h1 class="m-0">Update Soe budget distribution</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Update Soe budget distribution</li>
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
                        <form id="updatesoeBudgteDistributionForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="card-body">
                                <div class="row">
                                    @if (auth()->user())
                                        @if (auth()->user()->role_id == '1')
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="department_id">Department</label>
                                                    <select name="department_id" id="department_id_disabled" class="form-control" disabled>
                                                        <option value="">---Select Department---</option>
                                                        @if (isset($departmentlist))
                                                            @foreach ($departmentlist as $department)
                                                                <option value={{$department->id}}>{{$department->department_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <input type="hidden" name="department_id" id="department_id">
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

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="majorhead_id">Majorhead</label>
                                            <select name="majorhead_id" id="majorhead_id_disabled" class="form-control" disabled>
                                                <option value="">---Select Majorhead---</option>
                                            </select>
                                            <input type="hidden" name="majorhead_id" id="majorhead_id">
                                        </div>
                                    </div>

                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <label for="scheme_id">Scheme</label>
                                            <select name="scheme_id" id="scheme_id_disabled" class="form-control" disabled>
                                                <option value="">---Select Scheme---</option>
                                            </select>
                                            <input type="hidden" name="scheme_id" id="scheme_id">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="soe_id">Soe</label>
                                            <select name="soe_id" id="soe_id_disabled" class="form-control" disabled>
                                                <option value="">---Select Soe---</option>
                                            </select>
                                            <input type="hidden" name="soe_id" id="soe_id">
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="fin_year_id">Fin year</label>
                                            <select name="fin_year_id" id="fin_year_id_disabled" class="form-control" disabled>
                                                <option value="">---Select Fin year---</option>
                                                @if (isset($finyearlist))
                                                    @foreach ($finyearlist as $year)
                                                            <option value={{$year->id}}>{{$year->finyear}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <input type="hidden" name="fin_year_id" id="fin_year_id">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="type">Plan</label>
                                            <select name="plan_id" id="plan_id_disabled" class="form-control" disabled>
                                            </select>
                                            <input type="hidden" id="plan_id" name="plan_id">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="type">Type</label>
                                            <select name="type" id="type" class="form-control">
                                                    <option value="">---Select Type---</option>
                                                    <option value="1">Automatic</option>
                                                    <option value="2">Manual</option>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-lg-2">
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
                                                    
                                                    <tr>
                                                        <th>District</th>
                                                        <th>Outlay</th>
                                                        <th>Latest Revised Outlay</th>
                                                    </tr>
                                                </thead>
                                                <tbody name="outlayarr">
                                                    @if (isset($districtlist))
                                                    @php
                                                    $i = 0;
                                                        $outlay=0;
                                                        $expenditure=0;
                                                        $opercentage=0;
                                                        $unit=0;
                                                       
                                                        $achievement=0;
                                                        $upercentage=0;
                                                        $ben_total=0;
                                                        $women=0;
                                                        $disable=0;
                                                        $resvised_outlay=0;
                                                    @endphp
                                                        @foreach ($districtlist as $i => $district)
                                                            <?php 

                                                            $i=$district->id;

                                                            if(sizeof($districtdata['outlay'])==$i) {
                                                                continue;
                                                            }
                                                            
                                                            if(!empty($districtdata['outlay'][$i])) {
                                                                $outlay=$outlay+$districtdata['outlay'][$i];
                                                            }
                                                            if(!empty($districtdata['resvised_outlay'][$i])) {
                                                                $resvised_outlay=$resvised_outlay+$districtdata['resvised_outlay'][$i];
                                                            }
                                                            // $expenditure=$expenditure+$districtdata['expenditure'][$i];
                                                            // $opercentage=$opercentage+$districtdata['opercentage'][$i];
                                                            // $unit=$unit+$districtdata['unit'][$i];
                                                            
                                                            // $achievement=$achievement+$districtdata['achievement'][$i];
                                                            // $upercentage=$upercentage+$districtdata['upercentage'][$i];
                                                            // $ben_total=$ben_total+$districtdata['ben_total'][$i];
                                                            // $women=$women+$districtdata['women'][$i];
                                                            // $disable=$disable+$districtdata['disable'][$i];
                                                            ?>
                                                            @if(!empty($districtdata['outlay'][$i]))
                                                                <tr>
                                                                    <td>{{$district->district_name}}</td>
                                                                    <td>
                                                                        <input required type="number" start="1" step="0.01" min="0"class="form-control trigger outlayamt" 
                                                                        name="outlay[{{$district->id}}]" 
                                                                        id="outlay{{$district->id}}" value="{{$districtdata['outlay'][$i]}}" placeholder="Enter outlay" data-id="{{$district->id}}" <?php if($districtdata['outlay'][$i]!=0 && auth()->user()->role_id != '1'){echo "readonly";}?> readonly>

                                                                    </td>
                                                                    <td>
                                                                        <input required type="number" start="1" step="0.01" min="0"class="form-control  resvised_outlayamt" 
                                                                        name="resvised_outlay[{{$district->id}}]" 
                                                                        id="resvised_outlay{{$district->id}}"  placeholder="Enter resvised_outlay" data-id="{{$district->id}}" value="{{$districtdata['resvised_outlay'][$i]}}" >

                                                                    </td>
                                                                    
                                                                </tr>
                                                            @endif
                                                        @endforeach
  
                                                        <tr>
                                                            <th>Total</th>
                                                            <th>{{$outlay}}</th>
                                                            <th>{{ $resvised_outlay }}</th>
                                                             
                                                        </tr>
                                                @endif
                                                       
                                             
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                   
                                </div>   

                            </div>
                            <!-- /.card-body -->


                            <div class="modal fade" id="modal-default">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Notifications</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                     <div class="form-group">
                                                        <label>Comments</label>
                                                        <textarea class="form-control" rows="5" cols="65" name="comments" id="comments"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                     <div class="form-group position-relative">
                                                        <input type="file" class="custom-file-input form-control" id="exampleInputFile" name="file" id="noti_file" accept="application/pdf">
                                                        <label class="custom-file-label" for="exampleInputFile">File Upload</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <input type="hidden" name="setval" value="set_resvised_outlay">
                                            <button type="submit" id="update" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                <!-- /.modal-content -->
                                </div>
                            <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->


                            <div class="card-footer">
                                <!-- <button type="submit" id="update" class="btn btn-success">Update</button> -->
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default"> Update </button>

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
        $("#update").click(function() {
        var soe_budget_distribution_id = window.location.search.substring(1);
            var formAction = '{{URL::to('/')}}/soe-budget-distribution/' + soe_budget_distribution_id;
            $('#updatesoeBudgteDistributionForm').attr('action', formAction);
            $('#updatesoeBudgteDistributionForm').submit();
        });

        $('document').ready(function(){
            var soe_budget_distribution_id = window.location.search.substring(1);
            //$("#district_outlay_tbl").hide();
           /// $("#Undistributed_outlay_tbl").hide();
            $.ajax({
                url: "{{ route('get_soe_budget_distribution_data') }}?soe_budget_distribution_id=" + soe_budget_distribution_id,
                method: 'GET',
                success: function(data) {
                    var soebudgetdistribution = data.soebudgetdistribution;
                    var departmentlist = data.departmentlist;
                    var majorheadlist = data.majorheadlist;
                    var schemelist = data.schemelist;
                    var soelist = data.soelist;
                    var districtlist = data.districtlist;
                    var finyearlist = data.finyearlist;
                    var planlist = data.planlist;
                    var htmlDepartment = "<option value=''>---Select Department---</option>";
                    var htmlMajorhead = "<option value=''>---Select Majorhead---</option>";
                    var htmlScheme = "<option value=''>---Select Scheme---</option>";
                    var htmlSoe = "<option value=''>---Select Soe---</option>";
                    var htmlDistrict = "<option value=''>---Select District---</option>";
                    var htmlFinyear = "<option value=''>---Select Fin year---</option>";
                    var htmlPlan = "<option value=''>---Select Plan---</option>";
                    $('#outlay').val(soebudgetdistribution[0]['outlay']/100000);
                    $('#type').val(2);

                    $('#plan_id_disabled').val(soebudgetdistribution[0]['plan_id']);
                    $('#plan_id').val(soebudgetdistribution[0]['plan_id']);

                    $('#type').prop('disabled', true);

                    for (var i = 0; i < departmentlist.length; i++) {
                        if(soebudgetdistribution[0]['department_id'] == departmentlist[i]['id']){
                            htmlDepartment += `<option value="`+departmentlist[i]['id']+`" selected>`+departmentlist[i]['department_name']+`</option>`;
                            $('#department_id').val(departmentlist[i]['id']);
                        }else{
                            htmlDepartment += `<option value="`+departmentlist[i]['id']+`">`+departmentlist[i]['department_name']+`</option>`;
                        }
                    }

                    for (var i = 0; i < majorheadlist.length; i++) {
                        if(soebudgetdistribution[0]['majorhead_id'] == majorheadlist[i]['id']){
                            htmlMajorhead += `<option value="`+majorheadlist[i]['id']+`" selected>`+majorheadlist[i]['complete_head']+`</option>`;
                            $('#majorhead_id').val(majorheadlist[i]['id']);
                        }else{
                            htmlMajorhead += `<option value="`+majorheadlist[i]['id']+`">`+majorheadlist[i]['complete_head']+`</option>`;
                        }
                    }


                    for (var i = 0; i < schemelist.length; i++) {
                        if(soebudgetdistribution[0]['scheme_id'] == schemelist[i]['id']){
                            htmlScheme += `<option value="`+schemelist[i]['id']+`" selected>`+schemelist[i]['scheme_name']+`</option>`;
                            $('#scheme_id').val(schemelist[i]['id']);
                        }else{
                            htmlScheme += `<option value="`+schemelist[i]['id']+`">`+schemelist[i]['scheme_name']+`</option>`;
                        }
                    }

                    for (var i = 0; i < soelist.length; i++) {
                        if(soebudgetdistribution[0]['soe_id'] == soelist[i]['id']){
                            htmlSoe += `<option value="`+soelist[i]['id']+`" selected>`+soelist[i]['soe_name']+`</option>`;
                            $('#soe_id').val(soelist[i]['id']);
                        }else{
                            htmlSoe += `<option value="`+soelist[i]['id']+`">`+soelist[i]['soe_name']+`</option>`;
                        }
                    }

                    for (var i = 0; i < districtlist.length; i++) {
                        if(soebudgetdistribution[0]['district_id'] == districtlist[i]['id']){
                            htmlDistrict += `<option value="`+districtlist[i]['id']+`" selected>`+districtlist[i]['district_name']+`</option>`;
                        }else{
                            htmlDistrict += `<option value="`+districtlist[i]['id']+`">`+districtlist[i]['district_name']+`</option>`;
                        }
                    }

                    for (var i = 0; i < finyearlist.length; i++) {
                        if(soebudgetdistribution[0]['fin_year_id'] == finyearlist[i]['id']){
                            htmlFinyear += `<option value="`+finyearlist[i]['id']+`" selected>`+finyearlist[i]['finyear']+`</option>`;
                            $('#fin_year_id').val(finyearlist[i]['id']);
                        }else{
                            htmlFinyear += `<option value="`+finyearlist[i]['id']+`">`+finyearlist[i]['finyear']+`</option>`;
                        }
                    }

                    for (var i = 0; i < planlist.length; i++) {
                        if(soebudgetdistribution[0]['plan_id'] == planlist[i]['id']){
                            htmlPlan += `<option value="`+planlist[i]['id']+`" selected>`+planlist[i]['plan_name']+`</option>`;
                            $('#plan_id').val(planlist[i]['id']);
                            
                        }else{
                            htmlPlan += `<option value="`+planlist[i]['id']+`">`+planlist[i]['plan_name']+`</option>`;
                        }
                    }

                    $('#department_id_disabled').html(htmlDepartment);
                    $('#majorhead_id_disabled').html(htmlMajorhead);
                    $('#scheme_id_disabled').html(htmlScheme);
                    $('#soe_id_disabled').html(htmlSoe);                    
                    $('#fin_year_id_disabled').html(htmlFinyear);                    
                    $('#district_id').html(htmlDistrict);
                    $('#plan_id_disabled').html(htmlPlan);
                    get_table();
                }
            });

            
        });

        function get_table(){
            var department_id = $("#department_id").val();
            var majorhead_id = $("#majorhead_id").val();
            var scheme_id = $("#scheme_id").val();
            var soe_id = $("#soe_id").val();
            var fin_year_id = $("#fin_year_id").val();
            var soe_budget_distribution_id = window.location.search.substring(1);
            if(department_id > 0 && majorhead_id > 0 && scheme_id > 0 && soe_id > 0 && fin_year_id > 0){
                $.ajax({
                    url: "{{ route('get_soe_undistributed_outlay') }}?department_id="+department_id+"&majorhead_id="+majorhead_id+"&scheme_id="+scheme_id+"&soe_id="+soe_id+"&fin_year_id="+fin_year_id+"&soe_budget_distribution_id="+soe_budget_distribution_id,
                    method: 'GET',
                    success: function(data) {
                        //console.log(data)
                       // if(data.distribute_outlay){
                            //alert()
                            $('#type').val(2);
                            $("#district_outlay_tbl").show();
                            $("#Undistributed_outlay_tbl").show();
                            $("#undistributed_outlay").val(data.undistributed_outlay);
                            $("#undistributed_outlay_label").html(data.undistributed_outlay/100000);
                            $("#total_outlay_label").html(data.totaloutlay/100000);
                            $("#undistributed_outlay_label_hidden").val(data.undistributed_outlay/100000);
                            $("#total_outlay_label_hidden").val(data.totaloutlay/100000);
                            for (var i = 0; i < data.distribute_outlay.length; i++) {
                                $('#'+data.distribute_outlay[i]['district_id']).val(data.distribute_outlay[i]['outlay']/100000);
                                $('#'+data.distribute_outlay[i]['district_id']).prop('disabled', false);
                            }
                      //  }
                    }
                });
            } 
        }
        $('.expenditure').focusout(function(e){
                id=$(this).data('id');
                input=parseFloat($(this).val());
                total=parseFloat($('#resvised_outlay'+id).val())
                //alert(total)
               // alert($(this).val())
            if(total==0){

                alert("Outlay budget is 0");
                  $('#expenditure'+id).val(0);
            }else if(total<input){

                alert("Expenditure  is less than or equal to outlay");
                $('#expenditure'+id).val(0);
            }else{

                per=(input*100)/total;
                 per =per.toFixed(2)
                total=$('#opercentage'+id).val(per)
                
            }
        });
        $('.resvised_outlayamt').focusin(function(e){
             id=$(this).data('id');
             oldvalue=parseFloat($(this).val())
          $('.resvised_outlayamt').focusout(function(e){
               
                input=parseFloat($(this).val());
                expenditure=parseFloat($('#expenditure'+id).val())
                //alert(total)
               // alert($(this).val())
            if(input<expenditure){

                alert("Revised Outlay can not be less than expenditure amount");
                  $('#resvised_outlay'+id).val(oldvalue);
            }if(input==''){
                  $('#resvised_outlay'+id).val(oldvalue);
            }else{

                per=(expenditure*100)/input;
                 per =per.toFixed(2)
                total=$('#opercentage'+id).val(per)
                
            }
        })
      });
        $('.achievement').focusout(function(e){


                if($(this).val()==''){

                    $(this).val(0);

                }
                id=$(this).data('id');
                input=parseFloat($(this).val());
                total=parseFloat($('#unit'+id).val())
                //alert(total)
            if(total==0){

                alert("unit is 0");
                  $('#achievement'+id).val(0);
            }else if(total<input){

                alert("Achievement  should be less than or equal to Unit");
                $('#achievement'+id).val(0);
            }else{

                per=(input*100)/total;
                 per =per.toFixed(2)
                total=$('#upercentage'+id).val(per)
                
            }
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
           distributed_outlay = distributed_outlay+parseFloat($(this).val());
        });
            var undistributed_amount = $('#total_outlay_label').html() - distributed_outlay;
            $("#undistributed_outlay_label").html(undistributed_amount);
            $("#undistributed_outlay_label_hidden").val(undistributed_amount);
        }


        $('input.ben_total').focusout(function(e){
            
            var input =$(this);
             if(input.val()==''){

                input.val(0);

            }
            
        });
         $('input.women').focusout(function(e){


            
            var input =$(this);
             if(input.val()==''){

                input.val(0);

            }
            var id=input.data('id');
            var total= parseFloat(input.val())+parseFloat($('#disable'+id).val())
            if(total>parseFloat($('#ben_total'+id).val())){
                alert('Total of women and disable beneficiaries should be less than total beneficiaries');
                input.val(0);
            }
            
        });
          $('input.disable').focusout(function(e){
            
            var input =$(this);
             if(input.val()==''){

                input.val(0);

            }
            var id=input.data('id');
            var total= parseFloat(input.val())+parseFloat($('#women'+id).val())
            if(total>parseFloat($('#ben_total'+id).val())){
                //alert('Disable beneficiaries less than total');
                alert('Total of women and disable beneficiaries less than total beneficiaries');
                input.val(0);
            }
            
        });
           $('input.unit,.expenditure').focusout(function(e){
            
            var input =$(this);
             if(input.val()==''){

                input.val(0);

            }
            
            
        });

        


    </script>
@endsection