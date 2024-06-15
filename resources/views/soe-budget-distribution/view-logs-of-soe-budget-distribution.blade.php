@extends('layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Logs of Soe budget distribution List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Edit Logs of Soe budget distribution List</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
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
            @if (session()->has('error'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
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
            <div class="row">
                <div class="col-12 float-sm-right">
                    <div class="card">
                        <!-- <div class="card-header">
                            <button type="submit" class="btn btn-dark"
                                onclick="window.location='{{ url('create-soe-budget-distribution') }}'">Add Soe budget
                                distribution
                            </button>
                        </div> -->

                        <div class="card-body table-responsive">
                            username = {{$user}}<br>
                            updated date = {{$date}}
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr style='text-align: center;'>
                                        <th>District</th>
                                        <th colspan='4'>Financial</th>
                                        <th colspan='5'>Physical Achievement</th>
                                        <th colspan='3'>Beneficiaries</th>
                                        
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th>Outlay</th>
                                        <th>Revised Outlay</th>
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
                                <tbody>
                                        <?php
                                        $decodelog = json_decode($log->data);
                                        $decodelog=end($decodelog);
                                        $data=[];
                                        foreach($decodelog as $key=>$value){
                                            $data[$key]=(array)$value;
                                        }
                                        // $districtdata=$data;
                                        
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

                                        foreach ($district as $key => $value) {
                                            $i = $value->id;

                                            // if(!empty($districtdata['outlay'][$i])) {
                                                $outlay=$outlay+$data['outlay'][$i];
                                            // } else {
                                            //     $outlay="";
                                            // }
                                            // if(!empty($districtdata['resvised_outlay'][$i])) {
                                                $resvised_outlay=$resvised_outlay+$data['resvised_outlay'][$i];
                                            // } else {
                                            //     $resvised_outlay="";
                                            // }
                                            // if(!empty($districtdata['expenditure'][$i])) {
                                                $expenditure=$expenditure+$data['expenditure'][$i];
                                            // } else {
                                            //     $expenditure="";
                                            // }
                                            // if(!empty($districtdata['opercentage'][$i])) {
                                                $opercentage=$opercentage+$data['opercentage'][$i];
                                            // } else {
                                            //     $opercentage="";
                                            // }
                                            // if(!empty($districtdata['unit'][$i])) {
                                                $unit=$unit+$data['unit'][$i];
                                            // } else {
                                            //     $unit="";
                                            // }
                                            // if(!empty($districtdata['achievement'][$i])) {
                                                $achievement=$achievement+$data['achievement'][$i];
                                            // } else {
                                            //     $achievement="";
                                            // }
                                            // if(!empty($districtdata['upercentage'][$i])) {
                                                $upercentage=$upercentage+$data['upercentage'][$i];
                                            // } else {
                                            //     $upercentage="";
                                            // }
                                            // if(!empty($districtdata['ben_total'][$i])) {
                                                $ben_total=$ben_total+$data['ben_total'][$i];
                                            // } else {
                                            //     $ben_total="";
                                            // }
                                            // if(!empty($districtdata['women'][$i])) {
                                                $women=$women+$data['women'][$i];
                                            // } else {
                                            //     $women="";
                                            // }
                                            // if(!empty($districtdata['disable'][$i])) {
                                                $disable=$disable+$data['disable'][$i];
                                            // } else {
                                            //     $disable="";
                                            // }
                                            ?>
                                            <tr>
                                                <td>{{$value->district_name}}</td>
                                                <td>{{$data['outlay'][$i]}}</td>
                                                <td>{{$data['resvised_outlay'][$i]}}</td>
                                                <td>{{$data['expenditure'][$i]}}</td>
                                                <td>{{$data['opercentage'][$i]}}</td>
                                                <td>{{$data['item_name'][$i]}}</td>
                                                <td>{{$data['unit_measure'][$i]}}</td>
                                                <td>{{$data['unit'][$i]}}</td>
                                                <td>{{$data['achievement'][$i]}}</td>
                                                <td>{{$data['upercentage'][$i]}}</td>
                                                <td>{{$data['ben_total'][$i]}}</td>
                                                <td>{{$data['women'][$i]}}</td>
                                                <td>{{$data['disable'][$i]}}</td>
                                            </tr>
                                        <?php
                                        }
                                        ?>

                                        <tr>
                                            <th>Total</th>
                                            <th>{{$outlay}}</th>
                                            <th>{{$resvised_outlay}}</th>
                                            <th>{{$expenditure}}</th>
                                            <th>
                                                <?php
                                                if($expenditure){
                                                    $count1 = $expenditure / $resvised_outlay;
                                                    $count2 = $count1 * 100;
                                                } else {
                                                    $count2 = 0;
                                                } 
                                                ?>
                                                {{number_format($count2, 2)}}</th>
                                            <th></th> 
                                            <th></th>
                                            <th>{{$unit}}</th>
                                            <th>{{$achievement}}</th>
                                            <th>
                                                <?php
                                                if($achievement){
                                                    if($achievement != 0)
                                                    {
                                                        $count3 = $achievement / $unit;
                                                        $count4 = $count3 * 100;
                                                    } else {
                                                        $count4 = 0;
                                                    }
                                                } else {
                                                    $count4 = 0;
                                                }
                                                ?>
                                                {{number_format($count4, 2)}}
                                            </th>
                                            <th>{{$ben_total}}</th>
                                            <th>{{$women}}</th>
                                            <th>{{$disable}}</th>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

