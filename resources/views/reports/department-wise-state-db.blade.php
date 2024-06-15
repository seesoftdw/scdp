@extends('layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Department wise SDB(State Development Budget)</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Department wise SDB(State Development Budget)</li>
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
                    @if (session()->has('alert'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 8000)" x-show="show">
                        <div class="alert alert-warning">
                            {{ session()->get('alert') }}
                        </div>
                    </div>
                @endif
                    <div class="card">
                        <div class="card-header">
                            <form action="{{ route('export-department-wise-state-db') }}" method="post">
                                @csrf
                                <div class="row">
                                    <!-- <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="quarter">Quarter</label>
                                            <select name="quarter" id="quarter" class="form-control">
                                                <option value="">---Select Quarter---</option>
                                                <option value="1">First Quarter</option>
                                                <option value="2">Second Quarter</option>
                                                <option value="3">Third Quarter</option>
                                                <option value="4">Fourth Quarter</option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="department">Department</label>
                                            <select name="department" id="department" class="form-control change">
                                                <option value="">---Select Department---</option>
                                                @if (isset($department))
                                                    @foreach($department as $key => $value)
                                                        <option value="{{$value->id}}">{{$value->department_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="sector_id">Sector</label>
                                            <select name="sector" id="sector" class="form-control">
                                                <option value="">---Select Sector---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="sector_id">District</label>
                                            <select name="district_id" id="district_id" class="form-control">
                                                <option value="">--- Select District ---</option>
                                                    @if (isset($districtList))
                                                        @foreach ($districtList as $district)
                                                                <option value={{$district->id}}>{{$district->district_name}}</option>
                                                        @endforeach
                                                    @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="quarter" style="color: transparent;">Filter</label>
                                            <a href="#" id="filter" class="form-control btn btn-success btn-right"> Filter </a>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input type="hidden" name="plan_id" value="{{$plan_id}}">
                                            <label for="quarter" style="color: transparent;">Export</label>
                                            <button type="submit" id="export" class="form-control btn btn-success btn-right">
                                                <i class="fas fa-file-download"></i>&nbsp; Export </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
							<div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="6" style="text-align: center">
                                            Department wise State Development Budget & Expenditure under Scheduled Caste Development Programme of the year 2022-23 (Rs. In Lakhs)
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th>Name of Department</th>
                                        <th>Outlay for 2022-23</th>
                                        <th>Revised Outlay</th>
                                        <th>Exp. 31-03-2023</th>
                                        <th>% age from ReviseBudget</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    @php
                                        $grand = [];
                                        $outley_grand = [];
                                        $exp_grand = [];
                                    @endphp
                                    @foreach($department as $key => $value)
                                        @php
                                            $sector = App\Models\Sector::where('department_id',$value->id)->get();
                                            $total_of_sector = [];
                                            $exp_total_of_sector = [];
                                            $total_outley_dep = [];
                                            if(count($sector) == 0)
                                            {
                                                $total_outley_dep = App\Models\Soe_budget_allocation::where('plan_id',$plan_id)->where('department_id',$value->id)->pluck('outlay')->toArray();
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <th>{{ $value->department_name }}</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @foreach($sector as $sector_key => $sector_value)
                                        <tr>
                                            <td></td>
                                            <td>{{ $sector_value->sector_name }}</td>
                                            <td>
                                                @php
                                                    $sector_outlay_total = App\Models\Soe_budget_allocation::where('plan_id',$plan_id)->where('sector_id',$sector_value->id)->pluck('outlay')->toArray();
                                                    echo number_format(array_sum($sector_outlay_total)); 
                                                    array_push($total_outley_dep, array_sum($sector_outlay_total)); 
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $soe_id = App\Models\Soe_budget_allocation::where('plan_id',$plan_id)->where('sector_id',$sector_value->id)->pluck('soe_id')->toArray();
                                                    $sector_revise_outlay_total = App\Models\Soe_budget_distribution::whereIn('soe_id',$soe_id)->get();
                                                    $arr_add = [];
                                                    $exp_arr_add = [];
                                                    foreach($sector_revise_outlay_total as $diskey => $disvalue)
                                                    {
                                                        $arr = [];
                                                        $exp_arr = [];
                                                        if($disvalue->q_1_data)
                                                        {
                                                            $decode1 = json_decode($disvalue->q_1_data);
                                                            $count1 = count($decode1) - 1;
                                                            if($decode1[$count1]->resvised_outlay)
                                                            {
                                                                array_push($arr, array_sum(get_object_vars(($decode1[$count1]->resvised_outlay))));
                                                            }
                                                            if($decode1[$count1]->expenditure)
                                                            {
                                                                array_push($exp_arr, array_sum(get_object_vars(($decode1[$count1]->expenditure))));
                                                            }
                                                        }
                                                        if($disvalue->q_2_data)
                                                        {
                                                            $decode2 = json_decode($disvalue->q_2_data);
                                                            $count2 = count($decode2) - 1;
                                                            if($decode2[$count2]->resvised_outlay)
                                                            {
                                                                array_push($arr, array_sum(get_object_vars(($decode2[$count2]->resvised_outlay))));
                                                            }
                                                            if($decode2[$count2]->expenditure)
                                                            {
                                                                array_push($exp_arr, array_sum(get_object_vars(($decode2[$count2]->expenditure))));
                                                            }
                                                        }
                                                        if($disvalue->q_3_data)
                                                        {
                                                            $decode3 = json_decode($disvalue->q_3_data);
                                                            $count3 = count($decode3) - 1;
                                                            if($decode3[$count3]->resvised_outlay)
                                                            {
                                                                array_push($arr, array_sum(get_object_vars(($decode3[$count3]->resvised_outlay))));
                                                            }
                                                            if($decode3[$count3]->expenditure)
                                                            {
                                                                array_push($exp_arr, array_sum(get_object_vars(($decode3[$count3]->expenditure))));
                                                            }
                                                        }
                                                        if($disvalue->q_4_data)
                                                        {
                                                            $decode4 = json_decode($disvalue->q_4_data);
                                                            $count4 = count($decode4) - 1;
                                                            if($decode4[$count4]->resvised_outlay)
                                                            {
                                                                array_push($arr, array_sum(get_object_vars(($decode4[$count4]->resvised_outlay))));
                                                            }
                                                            if($decode4[$count4]->expenditure)
                                                            {
                                                                array_push($exp_arr, array_sum(get_object_vars(($decode4[$count4]->expenditure))));
                                                            }
                                                        }

                                                        array_push($arr_add, array_sum($arr));
                                                        array_push($exp_arr_add, array_sum($exp_arr));
                                                    }
                                                    echo array_sum($arr_add);
                                                    array_push($total_of_sector, array_sum($arr_add));
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    echo array_sum($exp_arr_add);
                                                    array_push($exp_total_of_sector, array_sum($exp_arr_add));
                                                @endphp
                                            </td>
                                            <td>@if(array_sum($arr_add) > 0) {{ number_format(array_sum($exp_arr_add) / array_sum($arr_add) * 100 , 2, '.', '') }} @endif</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <th></th>
                                            <th>Total : {{$value->department_name}}</th>
                                            <th>
                                                @php 
                                                    echo number_format(array_sum($total_outley_dep)); 
                                                    array_push($outley_grand, array_sum($total_outley_dep));
                                                @endphp
                                            </th>
                                            <th>
                                                @php
                                                    echo number_format(array_sum($total_of_sector), 2, '.', '');
                                                    array_push($grand, array_sum($total_of_sector));
                                                @endphp
                                            </th>
                                            <th>
                                                @php
                                                    echo number_format(array_sum($exp_total_of_sector), 2, '.', '');
                                                    array_push($exp_grand, array_sum($exp_total_of_sector));
                                                @endphp
                                            </th>
                                            <th>@if(array_sum($total_of_sector) > 0) {{ number_format(array_sum($exp_total_of_sector) / array_sum($total_of_sector) * 100 , 2, '.', '') }} @endif</th>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th></th>
                                        <th>GRAND TOTAL</th>
                                        <th> {{ number_format(array_sum($outley_grand)) }} </th>
                                        <th> {{ number_format(array_sum($grand), 2, '.', '') }} </th>
                                        <th> {{ number_format(array_sum($exp_grand), 2, '.', '') }} </th>
                                        <th> @if(array_sum($grand) > 0) {{ number_format(array_sum($exp_grand) / array_sum($grand) * 100 , 2, '.', '') }} @endif</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script type="text/javascript">

        $("#filter").click(function(){
            var dep_id = $("#department").val();
            var sector_id = $("#sector").val();
            var district_id = $("#district_id").val();
            var plan_id = <?php echo $plan_id; ?>;
            var url = "{{ route('get.department.wise.state.db.data') }}";
            url = url.replace(':id', dep_id);
            $.ajax({
                url: url,
                data: {dep_id: dep_id, plan_id: plan_id, sector_id: sector_id, district_id: district_id},
                method: 'GET',
                success: function(data) {
                    $('#tbody').html(data);
                }
            });
        });

        $("#department").change(function() {
            $.ajax({
                url: "{{ route('get_allocation_sector_by_department') }}",
                method: 'GET',
                data: { 
                    id: $(this).val()
                },
                success: function(data) {
                    $('#sector').html(data.sector);
                    // $('#subsector_id').html(data.subsectorhtml);
                }
            });
        })

    </script>
@endsection