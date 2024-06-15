@extends('layout.master')

@section('content')
<style type="text/css">
  .searchBoxElement{
    background-color: white;
    border: 1px solid #aaa;
    position: absolute;
    max-height: 114px;
    overflow-x: hidden;
    overflow-y: auto;
    margin: 0;
    padding: 0;
    line-height: 23px;
    list-style: none;
    z-index: 1;
    -ms-overflow-style: none;
    scrollbar-width: none;
  }

  .searchBoxElement span{
    padding: 0 5px;
  }

  .searchBoxElement::-webkit-scrollbar {
    display:none;
  }

  .searchBoxElement li{
    background-color: white;
    color: black;
  }

  .searchBoxElement li:hover{
    background-color: #50a0ff;
    color: white;
  }

  .searchBoxElement li.selected{
    background-color: #50a0ff;
    color: white;
  }

  .refineText{
    padding: 8px 0 8px 0 !important;
  }
  #overlay{   
    position: fixed;
    top: 0;
    z-index: 100;
    width: 100%;
    height:100%;
    display: none;
    background: rgba(0,0,0,0.6);
  }
  .cv-spinner {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;  
  }
  .spinner {
    width: 40px;
    height: 40px;
    border: 4px #ddd solid;
    border-top: 4px #2e93e6 solid;
    border-radius: 50%;
    animation: sp-anime 0.8s infinite linear;
  }
  @keyframes sp-anime {
    100% { 
      transform: rotate(360deg); 
    }
  }
  .is-hide{
    display:none;
  }
</style>
<div id="overlay">
  <div class="cv-spinner"> <span class="spinner"></span> </div>
</div>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
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
  <div class="container-fluid home-dashboard-stats">
    @if (auth()->user()->role_id == '1')
      <div class="row"> 

        <!-- <div class="col-lg-4 col-md-6 col-xl-3">

          <div class="small-box info-box">
            <div class="inner info-box-content">
              <h3 id="usersCount"></h3>
              <p>User</p>
            </div>
            <div class="icon info-box-icon bg-gradient-blue">
              <i class="ion ion-person-stalker"></i>
            </div>

          </div>
        </div> -->
        <div class="col-lg-4 col-md-6 col-xl-3"> 
          <!-- small box -->
          <div class="small-box info-box">
            <div class="inner info-box-content">
              <h3 id="serviceCount"></h3>
              <p>Service</p>
            </div>
            <div class="icon info-box-icon bg-gradient-cyan"> <i class="ion ion-ios-keypad-outline"></i> </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --> 
          </div>
        </div>
        <!-- <div class="col-lg-4 col-md-6 col-xl-3">
          <div class="small-box info-box">
            <div class="inner info-box-content">
              <h3 id="finYearCount"></h3>
              <p>Fin-Year</p>
            </div>
            <div class="icon info-box-icon bg-gradient-danger">
              <i class="ion ion-calendar"></i>
            </div>
          </div>
        </div> -->
        <div class="col-lg-4 col-md-6 col-xl-3"> 
          <!-- small box -->
          <div class="small-box info-box">
            <div class="inner info-box-content">
              <h3 id="districtCount"></h3>
              <p>District</p>
            </div>
            <div class="icon info-box-icon bg-gradient-green"> <i class="ion ion-map"></i> </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --> 
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xl-3"> 
          <!-- small box -->
          <div class="small-box info-box">
            <div class="inner info-box-content">
              <h3 id="sectorCount"></h3>
              <p>Sector</p>
            </div>
            <div class="icon info-box-icon bg-gradient-indigo"> <i class="ion ion-android-map"></i> </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --> 
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xl-3"> 
          <!-- small box -->
          <div class="small-box info-box">
            <div class="inner info-box-content">
              <h3 id="subSectorCount"></h3>
              <p>Sub-Sector</p>
            </div>
            <div class="icon info-box-icon bg-gradient-olive"> <i class="ion ion-ios-shuffle-strong"></i> </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --> 
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xl-3"> 
          <!-- small box -->
          <div class="small-box info-box">
            <div class="inner info-box-content">
              <h3 id="departmentCount"></h3>
              <p>Department</p>
            </div>
            <div class="icon info-box-icon bg-gradient-orange"> <i class="fa-university fas"></i> </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --> 
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xl-3"> 
          <!-- small box -->
          <div class="small-box info-box">
            <div class="inner info-box-content">
              <h3 id="schemeCount"></h3>
              <p>Scheme</p>
            </div>
            <div class="icon info-box-icon bg-gradient-purple"> <i class="ion ion-document-text"></i> </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --> 
          </div>
        </div>
        <!-- <div class="col-lg-4 col-md-6 col-xl-3">

          <div class="small-box info-box">
            <div class="inner info-box-content">
              <h3 id="planCount"></h3>
              <p>Plans</p>
            </div>
            <div class="icon info-box-icon bg-gradient-pink">
              <i class="ion ion-ios-list-outline"></i>
            </div>

          </div>
        </div> -->
        <div class="col-lg-4 col-md-6 col-xl-3"> 
          <!-- small box -->
          <div class="small-box info-box">
            <div class="inner info-box-content">
              <h3 id="soeCount"></h3>
              <p>SOE</p>
            </div>
            <div class="icon info-box-icon bg-gradient-lightblue"> <i class="ion ion-gear-b"></i> </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --> 
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xl-3"> 
          <!-- small box -->
          <div class="small-box info-box">
            <div class="inner info-box-content">
              <h3 id="majorHeadCount"></h3>
              <p>Major Head</p>
            </div>
            <div class="icon info-box-icon bg-gradient-navy"> <i class="ion ion-person"></i> </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --> 
          </div>
        </div>
      </div>
    @else
      <div class="row">
        <div class="col-lg-4 col-md-6 col-xl-3"> 
          <!-- small box -->
          <div class="small-box info-box">
            <div class="inner info-box-content">
              <h3 id="districtCount"></h3>
              <p>District</p>
            </div>
            <div class="icon info-box-icon bg-gradient-green"> <i class="ion ion-map"></i> </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --> 
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xl-3"> 
          <!-- small box -->
          <div class="small-box info-box">
            <div class="inner info-box-content">
              <h3 id="majorHeadCount"></h3>
              <p>Major Head</p>
            </div>
            <div class="icon info-box-icon bg-gradient-navy"> <i class="ion ion-person"></i> </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --> 
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-md-6 col-xl-3"> 
          <!-- small box -->
          <div class="small-box info-box">
            <div class="inner info-box-content">
              <h3 id="schemeCount"></h3>
              <input type="hidden" id="department_id" value={{ auth()->
              user()->department_id }} />
              <p>Scheme</p>
            </div>
            <div class="icon info-box-icon bg-info"> <i class="ion ion-stats-bars"></i> </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --> 
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xl-3"> 
          <!-- small box -->
          <div class="small-box info-box">
            <div class="inner info-box-content">
              <h3 id="soeCount"></h3>
              <p>SOE</p>
            </div>
            <div class="icon info-box-icon bg-info"> <i class="ion ion-stats-bars"></i> </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --> 
          </div>
        </div>
        <!-- ./col --> 
      </div>
    @endif 
  <!-- /.container-fluid --> 

  <!-- Main content -->
  <section class="content home-dashboard">
    <div class="row">
      <div class="col-md-6"> 
        <!-- STACKED BAR CHART -->
        <div class="card">
          <div class="card-header">
            <div class="card-icon card-header-rose"> <i class="fas fa-rupee-sign"></i> </div>
            <h3 class="card-title">Earned And Non Earned Wise Outlay Budget</h3>

            <!-- <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>  -->
          </div>
          <div class="card-body">
            <div class="chart">
              <canvas id="stackedBarChart"
              style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
          </div>
          <!-- /.card-body --> 
        </div>
        <!-- /.card --> 
      </div>
      <div class="col-md-6"> 
        <!-- PIE CHART -->
        <div class="card">
          <div class="card-header">
            <div class="card-icon card-header-warning"> <i class="fas fa-rupee-sign"></i> </div>
            <h3 class="card-title">HOD and District Wise Outlay Budget</h3>

            <!-- <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>  -->
          </div>
          <div class="card-body">
            <canvas id="pieChart"
            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
          <!-- /.card-body --> 
        </div>
        <!-- /.card --> 

      </div>
      <!-- /.col (LEFT) --> 
      <!-- /.col (RIGHT) --> 
    </div>
    <div class="row"> 
      <!-- /.col (LEFT) -->
      <div class="col-md-6"> 

        <!-- BAR CHART -->
        <div class="card">
          <div class="card-header">
            <div class="card-icon card-header-success"> <i class="fa-university fas"></i> </div>
            <h3 class="card-title">Service Wise Budget</h3>

            <!-- <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>  -->
          </div>
          <div class="card-body">
            <div class="chart">
              <canvas id="sector"
              style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
          </div>
          <!-- /.card-body --> 
        </div>
        <!-- /.card --> 

      </div>
      <div class="col-md-6"> 

        <!-- BAR CHART -->
        <div class="card">
          <div class="card-header">
            <div class="card-icon card-header-primary"> <i class="fa-calculator fas"></i> </div>
            <h3 class="card-title">Plan Wise Budget</h3>

            <!-- <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div> --> 
          </div>
          <div class="card-body">
            <div class="chart">
              <canvas id="grandTotal"
              style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
          </div>
          <!-- /.card-body --> 
        </div>
        <!-- /.card --> 

      </div>
      <!-- /.col (RIGHT) --> 
    </div>
    <!-- /.row --> 
  </section>
  <!-- /.content -->
  <section class="content home-dashboard">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="card-icon card-header-info"> <i class="fa-map-marked-alt fas"></i> </div>
            <h3 class="card-title">District wise distribution</h3>
          </div>
          <div class="card-body">
            <div class="forms-fillter">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <div class="dasboard-utilized">
                      <label >Select Department:</label>
                      <select class="form-control" name="scheme" id="department">
                        <option value="">Select Department</option>
                        @foreach($Department as $scheme)
                        <option value="{{$scheme->id}}">{{$scheme->department_name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <div class="dasboard-utilized">
                      <label>Select Majorhead:</label>
                      <select class="form-control" name="" id="majorhead">
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <div class="dasboard-utilized">
                      <label>Select Scheme:</label>
                      <select class="form-control" name="scheme" id="scheme_change">
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <div class="card-icon bg-gradient-red"> <i class="fas fa-money-bill-alt"></i> </div>
                    <h3 class="card-title">Financial</h3>
                  </div>
                  <div class="card-body"><div id="districtBarChart"></div></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <div class="card-icon bg-gradient-orange"> <i class="fas fa-trophy"></i> </div>
                    <h3 class="card-title">Physical Achievement</h3>
                  </div>
                  <div class="card-body"><div id="physical_achievement"></div></div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-icon card-header-success"><i class="fas fa-users-cog"></i></div>
                    <h3 class="card-title">Beneficiaries</h3>
                  </div>
                  <div class="card-body"><div id="beneficiaries"></div></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</section>
@endsection
@section('scripts') 
<script src="https://code.highcharts.com/highcharts.js"></script> 
<script type="text/javascript">

 $( document ).ready(function() {
  $('#department').val($("#department option:last").val()).change();
});
 $('body').on('change', '#majorhead', function ()
 {
   $('#scheme_change').html('')
   $("#overlay").fadeIn(300);　
   id=$(this).val();

   var str='<option value="0">Select Scheme</option>';
   $.ajax({
    url: "{{ route('get_scheme_data') }}?majorhead_id="+id,
    method: 'GET',
    dataType:'json',
    success: function(data) {


                                     // console.log(data)
                                     $.each(data.schememaster, function (key, val) {
                                      str +='<option value="'+val.id+'">'+val.scheme_name+'</option>';
                                    });
                                     console.log(str);
                             //$('#majorhead').append(str)



                             dist=[];
                             outlay=[];
                             unit=[];
                             achievement=[];
                             expenditure=[];
                             ben_total=[];
                             disable=[];
                             women=[];
                             if(data.status==1){

                              $.each(data.data.district, function (key, val) {
                               dist.push(val)  ;
                               outlay.push(parseFloat(data.data.outlay[key]))
                               expenditure.push(parseFloat(data.data.expenditure[key]))
                               unit.push(parseFloat(data.data.unit[key]))
                               achievement.push(parseFloat(data.data.achievement[key]))
                               ben_total.push(parseFloat(data.data.ben_total[key]))
                               disable.push(parseFloat(data.data.disable[key]))
                               women.push(parseFloat(data.data.women[key]))
                             });
                            }else
                            {
                              alert('No record found');
                            }
                           // if(data.status==1){
                             $("#overlay").fadeOut(300);

                             Highcharts.chart('districtBarChart', {

                              chart: {
                                type: 'column'
                              },
                              title: {
                                text: 'Financial'
                              },
                              subtitle: {
                                text: ''
                              },
                              xAxis: {
                                categories: dist,
                                crosshair: true
                              },
                              yAxis: {
                                min: 0,
                                title: {
                                  text: 'value in crore'
                                }
                              },
                              tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                '<td style="padding:0"><b>{point.y:.1f} crore</b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                              },
                              plotOptions: {
                                column: {
                                  pointPadding: 0,
                                  borderWidth: 0
                                }
                              },
                              series: [{
                                name: 'Outlay',
                                data: outlay

                              },{
                                name: 'Expenditure',
                                data: expenditure

                              } ]
                            });

                             Highcharts.chart('physical_achievement', {
                              chart: {
                                type: 'column'
                              },
                              title: {
                                text: ''
                              },
                              subtitle: {
                                text: ''
                              },
                              xAxis: {
                                categories: dist,
                                crosshair: true
                              },
                              yAxis: {
                                min: 0,
                                title: {
                                  text: 'Value in crore'
                                }
                              },
                              tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                '<td style="padding:0"><b>{point.y:.1f} crore</b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                              },
                              plotOptions: {
                                column: {
                                  pointPadding: 0,
                                  borderWidth: 0
                                }
                              },
                              series: [{
                                name: 'Unit',
                                data: unit

                              },{
                                name: 'Achievement',
                                data: achievement

                              } ]
                            });
                             Highcharts.chart('beneficiaries', {
                              chart: {
                                type: 'column'
                              },
                              title: {
                                text: ''
                              },
                              subtitle: {
                                text: ''
                              },
                              xAxis: {
                                categories: dist,
                                crosshair: true
                              },
                              yAxis: {
                                min: 0,
                                title: {
                                  text: 'Number of Beneficiaries'
                                }
                              },
                              tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                              },
                              plotOptions: {
                                column: {
                                  pointPadding: 0,
                                  borderWidth: 0
                                }
                              },


                              series: [{
                                name: 'Total Beneficiaries',
                                data: ben_total

                              },{
                                name: 'Disable (Out of total)',
                                data: disable

                              },{
                                name: ' Women (Out of Total )',
                                data: women

                              } ]
                            });

                             $('#scheme_change').append(str)
                           }
                         }).done(function() {
                          setTimeout(function(){
                            $("#overlay").fadeOut(300);
                          },500);
                        });;
                       });

$('#department').on('change', function() {
 $('#majorhead').html('')
 $('#scheme_change').html('')

 $("#overlay").fadeIn(300);　
 id=this.value;
 var str='<option value="0">Select Majorhead</option>';
 $.ajax({
  url: "{{ route('get_majorheads_data') }}?department_id="+id,
  method: 'GET',
  dataType:'json',
  success: function(data) {
                           // console.log(data)
                           $.each(data.schememaster, function (key, val) {
                            str +='<option value="'+val.id+'">'+val.complete_head+'</option>';
                          });
                           console.log(str);
                           $('#majorhead').append(str)



                           dist=[];
                           outlay=[];
                           unit=[];
                           achievement=[];
                           expenditure=[];
                           ben_total=[];
                           disable=[];
                           women=[];
                           if(data.status==1){

                            $.each(data.data.district, function (key, val) {
                             dist.push(val)  ;
                             outlay.push(parseFloat(data.data.outlay[key]))
                             expenditure.push(parseFloat(data.data.expenditure[key]))
                             unit.push(parseFloat(data.data.unit[key]))
                             achievement.push(parseFloat(data.data.achievement[key]))
                             ben_total.push(parseFloat(data.data.ben_total[key]))
                             disable.push(parseFloat(data.data.disable[key]))
                             women.push(parseFloat(data.data.women[key]))
                           });
                          }else
                          {
                           // alert('No record found');
                         }
                           // if(data.status==1){
                             $("#overlay").fadeOut(300);

                             Highcharts.chart('districtBarChart', {

                              chart: {
                                type: 'column'
                              },
                              title: {
                                text: ''
                              },
                              subtitle: {
                                text: ''
                              },
                              xAxis: {
                                categories: dist,
                                crosshair: true
                              },
                              yAxis: {
                                min: 0,
                                title: {
                                  text: 'value in crore'
                                }
                              },
                              tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                '<td style="padding:0"><b>{point.y:.1f} crore</b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                              },
                              plotOptions: {
                                column: {
                                  pointPadding: 0,
                                  borderWidth: 0
                                }
                              },
                              series: [{
                                name: 'Outlay',
                                data: outlay

                              },{
                                name: 'Expenditure',
                                data: expenditure

                              } ]
                            });

                             Highcharts.chart('physical_achievement', {
                              chart: {
                                type: 'column'
                              },
                              title: {
                                text: ''
                              },
                              subtitle: {
                                text: ''
                              },
                              xAxis: {
                                categories: dist,
                                crosshair: true
                              },
                              yAxis: {
                                min: 0,
                                title: {
                                  text: 'Value in crore'
                                }
                              },
                              tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                '<td style="padding:0"><b>{point.y:.1f} crore</b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                              },
                              plotOptions: {
                                column: {
                                  pointPadding: 0,
                                  borderWidth: 0
                                }
                              },
                              series: [{
                                name: 'Unit',
                                data: unit

                              },{
                                name: 'Achievement',
                                data: achievement

                              } ]
                            });
                             Highcharts.chart('beneficiaries', {
                              chart: {
                                type: 'column'
                              },
                              title: {
                                text: ''
                              },
                              subtitle: {
                                text: ''
                              },
                              xAxis: {
                                categories: dist,
                                crosshair: true
                              },
                              yAxis: {
                                min: 0,
                                title: {
                                  text: 'Number of Beneficiaries'
                                }
                              },
                              tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                              },
                              plotOptions: {
                                column: {
                                  pointPadding: 0,
                                  borderWidth: 0
                                }
                              },


                              series: [{
                                name: 'Total Beneficiaries',
                                data: ben_total

                              },{
                                name: 'Disable (Out of total)',
                                data: disable

                              },{
                                name: ' Women (Out of Total )',
                                data: women

                              } ]
                            });


                         // }else{

                          // alert("No data found");
                          //}

                        }
                      }).done(function() {
                        setTimeout(function(){
                          $("#overlay").fadeOut(300);
                        },500);
                      });;
                    });
$('body').on('change', '#scheme_change', function ()
{
            // $('#scheme_change').html('')
            $("#overlay").fadeIn(300);　
            id=$(this).val();
            
            var str='<option value="">Select Scheme</option>';
            $.ajax({
              url: "{{ route('get_chart_data') }}?scheme_id="+id,
              method: 'GET',
              dataType:'json',
              success: function(data) {
                            //console.log(data);
                            
                            dist=[];
                            outlay=[];
                            unit=[];
                            achievement=[];
                            expenditure=[];
                            ben_total=[];
                            disable=[];
                            women=[];
                            if(data.status==1){
                              $.each(data.data.district, function (key, val) {
                               dist.push(val)  ;
                               outlay.push(parseFloat(data.data.outlay[key]))
                               expenditure.push(parseFloat(data.data.expenditure[key]))
                               unit.push(parseFloat(data.data.unit[key]))
                               achievement.push(parseFloat(data.data.achievement[key]))
                               ben_total.push(parseFloat(data.data.ben_total[key]))
                               disable.push(parseFloat(data.data.disable[key]))
                               women.push(parseFloat(data.data.women[key]))
                             });
                            }else
                            {
                           // alert('No record found');
                         }
                           // if(data.status==1){
                             $("#overlay").fadeOut(300);

                             Highcharts.chart('districtBarChart', {
                              chart: {
                                type: 'column'
                              },
                              title: {
                                text: 'Financial'
                              },
                              subtitle: {
                                text: ''
                              },
                              xAxis: {
                                categories: dist,
                                crosshair: true
                              },
                              yAxis: {
                                min: 0,
                                title: {
                                  text: 'value in crore'
                                }
                              },
                              tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                '<td style="padding:0"><b>{point.y:.1f} crore</b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                              },
                              plotOptions: {
                                column: {
                                  pointPadding: 0,
                                  borderWidth: 0
                                }
                              },
                              series: [{
                                name: 'Outlay',
                                data: outlay

                              },{
                                name: 'Expenditure',
                                data: expenditure

                              } ]
                            });

                             Highcharts.chart('physical_achievement', {
                              chart: {
                                type: 'column'
                              },
                              title: {
                                text: ''
                              },
                              subtitle: {
                                text: ''
                              },
                              xAxis: {
                                categories: dist,
                                crosshair: true
                              },
                              yAxis: {
                                min: 0,
                                title: {
                                  text: 'Value in crore'
                                }
                              },
                              tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                '<td style="padding:0"><b>{point.y:.1f} crore</b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                              },
                              plotOptions: {
                                column: {
                                  pointPadding: 0,
                                  borderWidth: 0
                                }
                              },
                              series: [{
                                name: 'Unit',
                                data: unit

                              },{
                                name: 'Achievement',
                                data: achievement

                              } ]
                            });
                             Highcharts.chart('beneficiaries', {
                              chart: {
                                type: 'column'
                              },
                              title: {
                                text: ''
                              },
                              subtitle: {
                                text: ''
                              },
                              xAxis: {
                                categories: dist,
                                crosshair: true
                              },
                              yAxis: {
                                min: 0,
                                title: {
                                  text: 'Number of Beneficiaries'
                                }
                              },
                              tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                              },
                              plotOptions: {
                                column: {
                                  pointPadding: 0,
                                  borderWidth: 0
                                }
                              },


                              series: [{
                                name: 'Total Beneficiaries',
                                data: ben_total

                              },{
                                name: 'Disable (Out of total)',
                                data: disable

                              },{
                                name: ' Women (Out of Total )',
                                data: women

                              } ]
                            });





                           }
                         }).done(function() {
                          setTimeout(function(){
                            $("#overlay").fadeOut(300);
                          },500);
                        });;
                       });


(function($) {
        /*
        * æ¤œç´¢æ©Ÿèƒ½ä»˜ã ã‚»ãƒ¬ã‚¯ãƒˆãƒœãƒƒã‚¯ã‚¹
        *
        * Copyright (c) 2020 iseyoshitaka
        */
        $.fn.searchBox = function(opts) {

        // å¼•æ•°ã«å€¤ãŒå­˜åœ¨ã™ã‚‹å ´åˆã€ãƒ‡ãƒ•ã‚©ãƒ«ãƒˆå€¤ã‚’ä¸Šæ›¸ãã™ã‚‹
        var settings = $.extend({}, $.fn.searchBox.defaults, opts);
        
        var init = function (obj) {

          var self = $(obj),
          parent = self.closest('div,tr'),
                searchWord = ''; // çµžã‚Šè¾¼ã¿æ–‡å­—åˆ—

            // çµžã‚Šè¾¼ã¿æ¤œç´¢ç”¨ã®ãƒ†ã‚­ã‚¹ãƒˆå…¥åŠ›æ¬„ã®è¿½åŠ 
            self.before('<input type="text" class="refineText formTextbox" />');
            var refineText = parent.find('.refineText');
            if (settings.mode === MODE.NORMAL) {
              refineText.attr('readonly', 'readonly');
            }
            
            // åˆæœŸè¡¨ç¤ºã§é¸æŠžæ¸ˆã¿ã®å ´åˆã€çµžã‚Šè¾¼ã¿æ–‡è¨€å…¥åŠ›æ¬„ã«é¸æŠžæ¸ˆã¿ã®æ–‡è¨€ã‚’è¡¨ç¤º
            var selectedOption = self.find('option:selected');
            if(selectedOption){
              refineText.val(selectedOption.text());
              if (selectedOption.val() === '') {
                if (settings.mode === MODE.TAG) {
                  refineText.val("");
                }
              }
            }

            // ã‚»ãƒ¬ã‚¯ãƒˆãƒœãƒƒã‚¯ã‚¹ã®ä»£ã‚ã‚Šã«è¡¨ç¤ºã™ã‚‹ãƒ€ãƒŸãƒ¼ãƒªã‚¹ãƒˆã‚’ä½œæˆ
            var visibleTarget =self.find('option').map(function(i, e) {
              return '<li data-selected="off" data-searchval="' + $(e).val() + '"><span>' + $(e).text() + '</span></li>';
            }).get();
            self.after($('<ul class="searchBoxElement"></ul>').hide());

            // ãƒ€ãƒŸãƒ¼ãƒªã‚¹ãƒˆã®è¡¨ç¤ºå¹…ã‚’ã‚»ãƒ¬ã‚¯ãƒˆãƒœãƒƒã‚¯ã‚¹ã«ã‚ã‚ã›ã‚‹
            var refineTextWidth = (settings.elementWidth) ? settings.elementWidth : self.width();
            refineText.css('width', refineTextWidth);
            parent.find('.searchBoxElement').css('width', refineTextWidth);

            // å…ƒã®ã‚»ãƒ¬ã‚¯ãƒˆãƒœãƒƒã‚¯ã‚¹ã¯éžè¡¨ç¤ºã«ã™ã‚‹
            self.hide();

            // ãƒ€ãƒŸãƒ¼ãƒªã‚¹ãƒˆã‚’æ¤œç´¢æ¡ä»¶ã§çµžã‚Šè¾¼ã¿ã¾ã™ã€‚
            var changeSearchBoxElement = function() {
              if (searchWord !== '') {
                var matcher = new RegExp(searchWord.replace(/\\/g, '\\\\'), "i");
                    var filterTarget = $(visibleTarget.join()); // é…åˆ—ã®ã‚³ãƒ”ãƒ¼
                    filterTarget = filterTarget.filter(function(){
                      return $(this).text().match(matcher);
                    });
                    parent.find('.searchBoxElement').empty();
                    parent.find('.searchBoxElement').html(filterTarget);
                    parent.find('.searchBoxElement').show();
                  } else {
                    parent.find('.searchBoxElement').empty();
                    parent.find('.searchBoxElement').html(visibleTarget.slice(0, settings.optionMaxSize).join(''));
                    parent.find('.searchBoxElement').show();
                  }

                // é¸æŠžä¸­ã®LIã‚¿ã‚°ã®èƒŒæ™¯è‰²ã‚’å¤‰æ›´ã—ã¾ã™ã€‚
                var selectedOption = self.find('option:selected');
                if(selectedOption){
                  parent.find('.searchBoxElement').find('li').removeClass('selected');
                  parent.find('.searchBoxElement').find('li[data-searchval="' + selectedOption.val() + '"]').addClass('selected');
                }
                
                // ãƒ€ãƒŸãƒ¼ãƒªã‚¹ãƒˆé¸æŠžæ™‚
                parent.find('.searchBoxElement').find('li').click(function(e){
                  e.preventDefault();
                    // e.stopPropagation();
                    var li = $(this),
                    searchval = li.data('searchval');
                    self.val(searchval).change();
                    parent.find('li').attr('data-selected', 'off');
                    li.attr('data-selected', 'on');
                  });

              };

            // keyupæ™‚ã®ãƒ•ã‚¡ãƒ³ã‚¯ã‚·ãƒ§ãƒ³
            refineText.keyup(function(e){
              searchWord = $(this).val();
                // ãƒ€ãƒŸãƒ¼ãƒªã‚¹ãƒˆã‚’ãƒªãƒ•ãƒ¬ãƒƒã‚·ãƒ¥
                changeSearchBoxElement();
              });

            // ã‚»ãƒ¬ã‚¯ãƒˆãƒœãƒƒã‚¯ã‚¹å¤‰æ›´æ™‚
            self.change(function(){
                // ç›´è¿‘ã®çµžã‚Šè¾¼ã¿æ–‡è¨€ã‚¨ãƒªã‚¢ã¸é¸æŠžã‚ªãƒ—ã‚·ãƒ§ãƒ³ã®ãƒ†ã‚­ã‚¹ãƒˆã‚’åæ˜ 
                var selectedOption = $(this).find('option:selected');
                searchWord = selectedOption.text();
                refineText.val(selectedOption.text());

                if (settings.selectCallback) {
                  settings.selectCallback({
                    selectVal: selectedOption.attr('value'),
                    selectLabel: selectedOption.text()
                  });
                }
              });

            // ãƒ†ã‚­ã‚¹ãƒˆãƒœãƒƒã‚¯ã‚¹ã‚’ã‚¯ãƒªãƒƒã‚¯ã—ãŸå ´åˆã¯ãƒ€ãƒŸãƒ¼ãƒªã‚¹ãƒˆã‚’è¡¨ç¤ºã™ã‚‹
            refineText.click(function(e) {
              e.preventDefault();

                // ãƒ¢ãƒ¼ãƒ‰ã«åˆã‚ã›ã¦è¨­å®š
                if (settings.mode === MODE.NORMAL) {
                  searchWord = '';
                } else if (settings.mode === MODE.INPUT) {
                  refineText.val('');
                  searchWord = '';
                } else if (settings.mode === MODE.TAG) {
                  var selectedOption = self.find('option:selected');
                  if (selectedOption.val() === '') {
                    refineText.val('');
                    searchWord = '';
                  }
                }

                // ãƒ€ãƒŸãƒ¼ãƒªã‚¹ãƒˆã‚’ãƒªãƒ•ãƒ¬ãƒƒã‚·ãƒ¥
                parent.find('.searchBoxElement').hide();
                changeSearchBoxElement();
                
              });
            
            // ã‚»ãƒ¬ã‚¯ãƒˆãƒœãƒƒã‚¯ã‚¹ã®å¤–ã‚’ã‚¯ãƒªãƒƒã‚¯ã—ãŸå ´åˆã¯ãƒ€ãƒŸãƒ¼ãƒªã‚¹ãƒˆã‚’éžè¡¨ç¤ºã«ã™ã‚‹ã€‚
            $(document).click(function(e){
              if($(e.target).hasClass('refineText')){
                return;
              }
              parent.find('.searchBoxElement').hide();
              if (settings.mode !== MODE.TAG) {
                var selectedOption = self.find('option:selected');
                searchWord = selectedOption.text();
                refineText.val(selectedOption.text());
              }
            });

          }

          $(this).each(function (){
            init(this);
          });

          return this;
        }

        var MODE = {
        NORMAL: 0, // é€šå¸¸ã®ã‚»ãƒ¬ã‚¯ãƒˆãƒœãƒƒã‚¯ã‚¹
        INPUT: 1, // å…¥åŠ›å¼ã‚»ãƒ¬ã‚¯ãƒˆãƒœãƒƒã‚¯ã‚¹
        TAG: 2 // ã‚¿ã‚°è¿½åŠ å¼ã‚»ãƒ¬ã‚¯ãƒˆãƒœãƒƒã‚¯ã‚¹
      };

      $.fn.searchBox.defaults = {
        selectCallback: null, // é¸æŠžå¾Œã«å‘¼ã°ã‚Œã‚‹ã‚³ãƒ¼ãƒ«ãƒãƒƒã‚¯
        elementWidth: null, // ã‚»ãƒ¬ã‚¯ãƒˆãƒœãƒƒã‚¯ã‚¹ã®è¡¨ç¤ºå¹…
        optionMaxSize: 100, // ã‚»ãƒ¬ã‚¯ãƒˆãƒœãƒƒã‚¯ã‚¹å†…ã«è¡¨ç¤ºã™ã‚‹æœ€å¤§æ•°
        mode: MODE.INPUT // è¡¨ç¤ºãƒ¢ãƒ¼ãƒ‰
      };

    })(jQuery);       
    // $('#department').searchBox();
//$('#scheme_change').searchBox();





$('document').ready(function() {
  if ($(".inner").length < 5) {
    var departmentId = $('#department_id').val();
    $.ajax({
      url: "{{ route('get_user_data_count') }}?departmentId=" + departmentId,
      method: 'GET',
      success: function(data) {
        $('#schemeCount').html(data.scheme);
        $('#soeCount').html(data.soe);
      }
    })

    $.ajax({
      url: "{{ route('get_data_count') }}",
      method: 'GET',
      success: function(data) {
        $('#usersCount').html(data.users);
        $('#componentCount').html(data.components);
        $('#serviceCount').html(data.services);
        $('#finYearCount').html(data.finyears);
        $('#districtCount').html(data.districts);
        $('#sectorCount').html(data.sectors);
        $('#subSectorCount').html(data.subsectors);
        $('#departmentCount').html(data.departments);
        $('#schemeCount').html(data.scheme);
        $('#consitituencyCount').html(data.consitituency);
        $('#planCount').html(data.plans);
        $('#soeCount').html(data.soe);
        $('#majorHeadCount').html(data.majorhead);
      }
    });
  } else {
    $.ajax({
      url: "{{ route('get_data_count') }}",
      method: 'GET',
      success: function(data) {
        $('#usersCount').html(data.users);
        $('#componentCount').html(data.components);
        $('#serviceCount').html(data.services);
        $('#finYearCount').html(data.finyears);
        $('#districtCount').html(data.districts);
        $('#sectorCount').html(data.sectors);
        $('#subSectorCount').html(data.subsectors);
        $('#departmentCount').html(data.departments);
        $('#schemeCount').html(data.scheme);
        $('#consitituencyCount').html(data.consitituency);
        $('#planCount').html(data.plans);
        $('#soeCount').html(data.soe);
        $('#majorHeadCount').html(data.majorhead);
      }
    });
  }

  $.ajax({
    url: "{{ route('get_earmarked_outlays') }}",
    method: 'GET',
    success: function(data) {
      let earmarkedTotal = data.earmarkedTotal;
      let earmarkedHodTotal = data.earmarkedHodTotal;
      let earmarkedDistrictTotal = data.earmarkedDistrictTotal;
      let nonEarmarkedTotal = data.nonEarmarkedTotal;
      let nonEarmarkedHodTotal = data.nonEarmarkedHodTotal;
      let nonEarmarkedDistrictTotal = data.nonEarmarkedDistrictTotal;
                    //---------------------
                    //- STACKED BAR CHART -
                    //---------------------
                    var outlayChartData = {
                      labels: ['Total Outlay', 'District Outlay', 'HOD Outlay', ],
                      datasets: [{
                        label: 'Non Earmarked',
                        backgroundColor: 'rgba(74, 78, 105, 1)',
                        borderColor: 'rgba(74, 78, 105, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(74, 78, 105, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: [nonEarmarkedTotal, nonEarmarkedDistrictTotal,
                        nonEarmarkedHodTotal
                        ]
                      }, {
                        label: 'Earmarked',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [earmarkedTotal, earmarkedDistrictTotal,
                        earmarkedHodTotal]
                      },

                      ]
                    }

                    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
                    var outlayBarChartData = $.extend(true, {}, outlayChartData)
                    var temp0 = outlayChartData.datasets[0]
                    var temp1 = outlayChartData.datasets[1]
                    outlayBarChartData.datasets[0] = temp1
                    outlayBarChartData.datasets[1] = temp0
                    var stackedBarChartData = $.extend(true, {}, outlayBarChartData)

                    var stackedBarChartOptions = {
                      responsive: true,
                      maintainAspectRatio: false,
                      scales: {
                        horizontal: true,
                        xAxes: [{
                          ticks: {
                            min: 0
                          }
                        }]
                      }
                    }

                    new Chart(stackedBarChartCanvas, {
                      type: 'horizontalBar',
                      data: outlayBarChartData,
                      options: stackedBarChartOptions,
                    })

                  }
                });

  $.ajax({
    url: "{{ route('get_outlays') }}",
    method: 'GET',
    success: function(data) {
      console.log('test')
      console.log(data);
      var hod = district = outlay = 0;

      if (data && data.outlays && data.outlays.length > 0) {

        for (let i = 0; i < data.outlays.length; i++) {
          if(data.outlays[i].hod_outlay!=null){
            hod += parseFloat(data.outlays[i].hod_outlay) / 100000;
          }
          if(data.outlays[i].district_outlay!=null){
            district += parseFloat(data.outlays[i].district_outlay) / 100000;
          }


          outlay += parseFloat(data.outlays[i].outlay) / 100000;
        }
      }
      console.log(hod)
      console.log(district)
                    //-------------
                    //- PIE CHART -
                    //-------------
                    // Get context with jQuery - using jQuery's .get() method.
                    var pieData = {
                      labels: [
                      'Total Outlay',
                      'HOD Outlay',
                      'District Outlay',
                      ],
                      datasets: [{
                        data: [outlay, hod, district],
                        backgroundColor: [
                        '#00a65a',
                        '#f39c12',
                        '#f56954'
                        ],
                      }]
                    }
                    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
                    var pieData = pieData;
                    var pieOptions = {
                      maintainAspectRatio: false,
                      responsive: true,
                    }
                    new Chart(pieChartCanvas, {
                      type: 'pie',
                      data: pieData,
                      options: pieOptions
                    })

                  }
                })

  $.ajax({
    url: "{{ route('get_district') }}",
    method: 'GET',
    success: function(data) {
      let districts = [];
      for (let i = 0; i < data.districts.length; i++) {
        districts.push(data.districts[i].district_name)
      }

      $.ajax({
        url: "{{ route('get_district_budget_distributed') }}",
        method: 'GET',
        success: function(data) {
          let bilaspurTotal = data.bilaspurTotal;
          let chambaTotal = data.chambaTotal;
          let hamirpurTotal = data.hamirpurTotal;
          let kangaraTotal = data.kangaraTotal;
          let kulluTotal = data.kulluTotal;
          let mandiTotal = data.mandiTotal;
          let shimlaTotal = data.shimlaTotal;
          let sirmaurTotal = data.sirmaurTotal;
          let solanTotal = data.solanTotal;
          let unaTotal = data.unaTotal;

          let bilaspurSDBTotal = data.bilaspurSDBTotal;
          let chambaSDBTotal = data.chambaSDBTotal;
          let hamirpurSDBTotal = data.hamirpurSDBTotal;
          let kangaraSDBTotal = data.kangaraSDBTotal;
          let kulluSDBTotal = data.kulluSDBTotal;
          let mandiSDBTotal = data.mandiSDBTotal;
          let shimlaSDBTotal = data.shimlaSDBTotal;
          let sirmaurSDBTotal = data.sirmaurSDBTotal;
          let solanSDBTotal = data.solanSDBTotal;
          let unaSDBTotal = data.unaSDBTotal;

          let bilaspurCDBTotal = data.bilaspurCDBTotal;
          let chambaCDBTotal = data.chambaCDBTotal;
          let hamirpurCDBTotal = data.hamirpurCDBTotal;
          let kangaraCDBTotal = data.kangaraCDBTotal;
          let kulluCDBTotal = data.kulluCDBTotal;
          let mandiCDBTotal = data.mandiCDBTotal;
          let shimlaCDBTotal = data.shimlaCDBTotal;
          let sirmaurCDBTotal = data.sirmaurCDBTotal;
          let solanCDBTotal = data.solanCDBTotal;
          let unaCDBTotal = data.unaCDBTotal;

                            //-------------
                            //- BAR CHART -
                            //-------------

                            var areaChartData = {
                              labels: districts,
                              datasets: [{
                                label: 'Total',
                                backgroundColor: 'rgba(79, 173, 19,0.9)',
                                borderColor: 'rgba(79, 173, 19,0.8)',
                                pointRadius: false,
                                pointColor: '#3b8bba',
                                pointStrokeColor: 'rgba(79, 173, 19,1)',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(79, 173, 19,1)',
                                data: [bilaspurTotal, 
                                chambaTotal,
                                hamirpurTotal,
                                kangaraTotal, 
                                kulluTotal, 
                                mandiTotal, 
                                shimlaTotal, 
                                sirmaurTotal, 
                                solanTotal, 
                                unaTotal
                                ]
                              },
                              {
                                label: 'Central Development budget',
                                backgroundColor: 'rgba(148, 79, 94, 1)',
                                borderColor: 'rgba(148, 79, 94, 1)',
                                pointRadius: false,
                                pointColor: 'rgba(2148, 79, 94, 1)',
                                pointStrokeColor: '#c1c7d1',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(220,220,220,1)',
                                data: [bilaspurCDBTotal, 
                                chambaCDBTotal,
                                hamirpurCDBTotal,
                                kangaraCDBTotal, 
                                kulluCDBTotal, 
                                mandiCDBTotal, 
                                shimlaCDBTotal, 
                                sirmaurCDBTotal, 
                                solanCDBTotal,
                                unaCDBTotal
                                ]
                              },
                              {
                                label: 'State Development budget',
                                backgroundColor: 'rgba(234, 175, 29, 1)',
                                borderColor: 'rgba(234, 175, 29, 1)',
                                pointRadius: false,
                                pointColor: 'rgba(234, 175, 29, 1)',
                                pointStrokeColor: '#c1c7d1',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(220,220,220,1)',
                                data: [bilaspurSDBTotal, 
                                chambaSDBTotal, 
                                hamirpurSDBTotal, 
                                kangaraSDBTotal, 
                                kulluSDBTotal, 
                                mandiSDBTotal, 
                                shimlaSDBTotal, 
                                sirmaurSDBTotal, 
                                solanSDBTotal,
                                unaSDBTotal
                                ]
                              },
                              ]
                            }



                          }
                        })

}
})

$.ajax({
  url: "{{ route('get_plan_outlay_total') }}",
  method: 'GET',
  success: function(data) {
    var sdbEconomicsTotal = data.sdbEconomicsTotal;
    var sdbSocialTotal = data.sdbSocialTotal;
    var sdbGeneralTotal = data.sdbGeneralTotal;
    var cdbEconomicsTotal = data.cdbEconomicsTotal;
    var cdbSocialTotal = data.cdbSocialTotal;
    var cdbGeneralTotal = data.cdbGeneralTotal;
    var totalEconomicsService = data.totalEconomicsService;
    var totalSocialService = data.totalSocialService;
    var totalGeneralService = data.totalGeneralService
                    //-------------
                    //- Sector BAR CHART -
                    //-------------

                    var sectorChartData = {
                      labels: ['State Development budget', 'Central Development budget',
                      'National Development budget'
                      ],
                      datasets: [{
                        label: 'Economic Service',
                        backgroundColor: 'rgba(40, 120, 254,0.9)',
                        borderColor: 'rgba40, 120, 254,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(40, 120, 254,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(40, 120, 254,1)',
                        data: [sdbEconomicsTotal, cdbEconomicsTotal,
                        totalEconomicsService
                        ]
                      },
                      {
                        label: 'Social Service',
                        backgroundColor: 'rgba(228, 88, 188, 1)',
                        borderColor: 'rgba(228, 88, 188, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(2228, 88, 188, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: [sdbSocialTotal, cdbSocialTotal, totalSocialService]
                      },
                      {
                        label: 'General Service',
                        backgroundColor: 'rgba(113, 188, 254, 1)',
                        borderColor: 'rgba(113, 188, 254, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(113, 188, 254, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: [sdbGeneralTotal, cdbGeneralTotal, totalGeneralService]
                      },
                      ]
                    }

                    var sectorBarChartCanvas = $('#sector').get(0).getContext('2d')
                    var sectorBarChartData = $.extend(true, {}, sectorChartData)
                    var temp0 = sectorChartData.datasets[0]
                    var temp1 = sectorChartData.datasets[1]
                    var temp2 = sectorChartData.datasets[2]
                    sectorBarChartData.datasets[0] = temp0
                    sectorBarChartData.datasets[1] = temp1
                    sectorBarChartData.datasets[2] = temp2

                    var barChartOptions = {
                      responsive: true,
                      maintainAspectRatio: false,
                      scales: {
                        yAxes: [{
                          ticks: {
                            min: 0
                          }
                        }]
                      }
                    }

                    new Chart(sectorBarChartCanvas, {
                      type: 'bar',
                      data: sectorBarChartData,
                      options: barChartOptions
                    })
                  }
                })

$.ajax({
  url: "{{ route('get_outlay_total') }}",
  method: 'GET',
  success: function(data) {
                    //-------------
                    //- Grand BAR CHART -
                    //-------------

                    var grandTotalChartData = {
                      labels: ['', 'State Development budget', '', 'Central Development budget',
                      '',
                      'National Development budget', ''
                      ],
                      datasets: [{
                        label: 'Grand Total (In crore)',
                        backgroundColor: 'rgba(249, 0, 64,0.9)',
                        borderColor: 'rgba(249, 0, 64,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(249, 0, 64,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(249, 0, 64,1)',
                        data: [0, data.cdbOutlay, 0, data.sdbOutlay, 0, data
                        .totalScheduledCastes, 0
                        ]
                      }]
                    }

                    var grandTotalBarChartCanvas = $('#grandTotal').get(0).getContext('2d')
                    var grandTotalBarChartData = $.extend(true, {}, grandTotalChartData)
                    var temp0 = grandTotalChartData.datasets[0]
                    grandTotalBarChartData.datasets[0] = temp0

                    var barChartOptions = {
                      responsive: true,
                      maintainAspectRatio: false,
                      scales: {
                        yAxes: [{
                          ticks: {
                            min: 0
                          }
                        }]
                      }
                    }

                    new Chart(grandTotalBarChartCanvas, {
                      type: 'bar',
                      data: grandTotalBarChartData,
                      options: barChartOptions
                    })

                  }
                })

});
</script> 
@endsection 