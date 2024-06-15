@extends('layout.master')

@if (auth()->user()->role_id != '1')
    <script type="text/javascript">
        window.location = "/dashboard";
    </script>
@endif

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Update Soe budget allocation</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Update Soe budget allocation</li>
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
                        <form id="updatesoeBudgteAllocationForm" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="card-body">
                                <div class="row">
                                    @if (auth()->user())
                                        @if (auth()->user()->role_id == '1')
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="department_id">Department*</label>
                                                    <select name="department_id" id="department_id" class="form-control">
                                                        <option value="">--- Select Department ---</option>
                                                        @if (isset($departmentlist))
                                                            @foreach ($departmentlist as $department)
                                                                <option value={{ $department->id }}>
                                                                    {{ $department->department_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="department_id">Department*</label>
                                                    <select name="department_id" id="department_id" class="form-control"
                                                        disabled value={{ $user->department_id }}>
                                                        <option value={{ $user->department_id }}>
                                                            {{ $user->department->department_name }}</option>
                                                    </select>
                                                    <select name="department_id" id="department_id" class="form-control"
                                                        hidden value={{ $user->department_id }}>
                                                        <option value={{ $user->department_id }}>
                                                            {{ $user->department->department_name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="majorhead_id">Majorhead*</label>
                                            <select name="majorhead_id" id="majorhead_id" class="form-control">
                                                <option value="">---Select Majorhead---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="scheme_id">Scheme name*</label>
                                            <select name="scheme_id" id="scheme_id" class="form-control">
                                                <option value="">---Select Scheme---</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="soe_id">Soe name*</label>
                                            <select name="soe_id" id="soe_id" class="form-control">
                                                <option value="">---Select Soe---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="fin_year_id">Fin year*</label>
                                            <select name="fin_year_id" id="fin_year_id" class="form-control" readonly>
                                                <option value="">---Select Fin year---</option>
                                                @if (isset($finyearlist))
                                                    @foreach ($finyearlist as $year)
                                                        <option value={{ $year->id }}>{{ $year->finyear }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="earmarked">Earmarked*</label>
                                            <select name="earmarked" id="earmarked" class="form-control">
                                                <option value="">---Select Earmarked---</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="plan_id">Plan name*</label>
                                            <select name="plan_id" id="plan_id" class="form-control">
                                                <option value="">---Select Plan---</option>
                                                @if (isset($planlist))
                                                    @foreach ($planlist as $plan)
                                                        <option value={{ $plan->id }}>{{ $plan->plan_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="service_id">Service name*</label>
                                            <select name="service_id" id="service_id" class="form-control">
                                                <option value="">---Select Service---</option>
                                                @if (isset($servicelist))
                                                    @foreach ($servicelist as $service)
                                                        <option value={{ $service->id }}>{{ $service->service_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="sector_id">Sector name*</label>
                                            <select name="sector_id" id="sector_id" class="form-control">
                                                <option value="">---Select Sector---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="subsector_id">Sub sector name*</label>
                                            <select name="subsector_id" id="subsector_id" class="form-control">
                                                <option value="">---Select Sub sector---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="hod_outlay">HOD Outlay (Rs. in Lakh)*</label>
                                            <input type="number" start="1" step="0.01" min="0"
                                                class="form-control" id="hod_outlay" name="hod_outlay"
                                                placeholder="Enter HOD outlay">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="district_outlay">District Outlay (Rs. in Lakh)*</label>
                                            <input type="number" start="1" step="0.01" min="0"
                                                class="form-control" id="district_outlay" name="district_outlay"
                                                placeholder="Enter District outlay">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="outlay">Outlay (Rs. in Lakh)*</label>
                                            <input type="number" start="1" step="0.01" min="0"
                                                class="form-control" id="outlayHidden" name="outlayHidden" disabled>
                                            <input type="hidden" id="outlay" name="outlay">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
								</div>
                                <div class="card-footer">
                                    <button type="submit" id="update" class="btn btn-success">Update</button>
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
        $("#update").click(function() {
            var soe_budget_allocation_id = window.location.search.substring(1);
            var formAction = '/soe-budget-allocation/' + soe_budget_allocation_id;
            $('#updatesoeBudgteAllocationForm').attr('action', formAction);
            $('#updatesoeBudgteAllocationForm').submit();
        });

        $('document').ready(function() {
            var soe_budget_allocation_id = window.location.search.substring(1);
            $.ajax({
                url: "{{ route('get_soe_budget_allocation_data') }}?soe_budget_allocation_id=" +
                    soe_budget_allocation_id,
                method: 'GET',
                success: function(data) {
                    var soebudgetallocation = data.soebudgetallocation;
                    var departmentlist = data.departmentlist;
                    var majorheadlist = data.majorheadlist;
                    var schemelist = data.schemelist;
                    var soelist = data.soelist;
                    var finyearlist = data.finyearlist;
                    var planlist = data.planlist;
                    var servicelist = data.servicelist;
                    var sectorlist = data.sectorlist;
                    var subsectorlist = data.subsectorlist;

                    var htmlDepartment = "<option value=''>---Select Department---</option>";
                    var htmlMajorhead = "<option value=''>---Select Department---</option>";
                    var htmlScheme = "<option value=''>---Select Scheme---</option>";
                    var htmlSoe = "<option value=''>---Select Soe---</option>";
                    var htmlFinyear = "";//"<option value=''>---Select Fin year---</option>";
                    var htmlPlan = "<option value=''>---Select Plan---</option>";
                    var htmlService = "<option value=''>---Select Service---</option>";
                    var htmlSector = "<option value=''>---Select Sector---</option>";
                    var htmlSubSector = "<option value=''>---Select Sub sector---</option>";

                    for (var i = 0; i < departmentlist.length; i++) {
                        if (soebudgetallocation[0]['department_id'] == departmentlist[i]['id']) {
                            htmlDepartment += `<option value="` + departmentlist[i]['id'] +
                                `" selected>` + departmentlist[i]['department_name'] + `</option>`;
                        } else {
                            htmlDepartment += `<option value="` + departmentlist[i]['id'] + `">` +
                                departmentlist[i]['department_name'] + `</option>`;
                        }
                    }

                    for (var i = 0; i < majorheadlist.length; i++) {
                        if (soebudgetallocation[0]['majorhead_id'] == majorheadlist[i]['id']) {
                            htmlMajorhead += `<option value="` + majorheadlist[i]['id'] +
                                `" selected>` + majorheadlist[i]['complete_head'] + `</option>`;
                        } else {
                            htmlMajorhead += `<option value="` + majorheadlist[i]['id'] + `">` +
                                majorheadlist[i]['complete_head'] + `</option>`;
                        }
                    }

                    for (var i = 0; i < schemelist.length; i++) {
                        if (soebudgetallocation[0]['scheme_id'] == schemelist[i]['id']) {
                            htmlScheme += `<option value="` + schemelist[i]['id'] + `" selected>` +
                                schemelist[i]['scheme_name'] + `</option>`;
                        } else {
                            htmlScheme += `<option value="` + schemelist[i]['id'] + `">` + schemelist[i]
                                ['scheme_name'] + `</option>`;
                        }
                    }

                    for (var i = 0; i < soelist.length; i++) {
                        if (soebudgetallocation[0]['soe_id'] == soelist[i]['id']) {
                            htmlSoe += `<option value="` + soelist[i]['id'] + `" selected>` + soelist[i]
                                ['soe_name'] + `</option>`;
                        } else {
                            htmlSoe += `<option value="` + soelist[i]['id'] + `">` + soelist[i][
                                'soe_name'
                            ] + `</option>`;
                        }
                    }

                    for (var i = 0; i < finyearlist.length; i++) {
                        if (soebudgetallocation[0]['fin_year_id'] == finyearlist[i]['id']) {
                            htmlFinyear += `<option value="` + finyearlist[i]['id'] + `" selected>` +
                                finyearlist[i]['finyear'] + `</option>`;
                        } else {
                            // htmlFinyear += `<option value="` + finyearlist[i]['id'] + `">` +
                            //     finyearlist[i]['finyear'] + `</option>`;
                        }
                    }

                    for (var i = 0; i < planlist.length; i++) {
                        if (soebudgetallocation[0]['plan_id'] == planlist[i]['id']) {
                            htmlPlan += `<option value="` + planlist[i]['id'] + `" selected>` +
                                planlist[i]['plan_name'] + `</option>`;
                        } else {
                            htmlPlan += `<option value="` + planlist[i]['id'] + `">` + planlist[i][
                                'plan_name'
                            ] + `</option>`;
                        }
                    }

                    for (var i = 0; i < servicelist.length; i++) {
                        if (soebudgetallocation[0]['service_id'] == servicelist[i]['id']) {
                            htmlService += `<option value="` + servicelist[i]['id'] + `" selected>` +
                                servicelist[i]['service_name'] + `</option>`;
                        } else {
                            htmlService += `<option value="` + servicelist[i]['id'] + `">` +
                                servicelist[i]['service_name'] + `</option>`;
                        }
                    }

                    for (var i = 0; i < sectorlist.length; i++) {
                        if (soebudgetallocation[0]['sector_id'] == sectorlist[i]['id']) {
                            htmlSector += `<option value="` + sectorlist[i]['id'] + `" selected>` +
                                sectorlist[i]['sector_name'] + `</option>`;
                        } else {
                            htmlSector += `<option value="` + sectorlist[i]['id'] + `">` + sectorlist[i]
                                ['sector_name'] + `</option>`;
                        }
                    }

                    for (var i = 0; i < subsectorlist.length; i++) {
                        if (soebudgetallocation[0]['subsector_id'] == subsectorlist[i]['id']) {
                            htmlSubSector += `<option value="` + subsectorlist[i]['id'] +
                                `" selected>` + subsectorlist[i]['subsectors_name'] + `</option>`;
                        } else {
                            htmlSubSector += `<option value="` + subsectorlist[i]['id'] + `">` +
                                subsectorlist[i]['subsectors_name'] + `</option>`;
                        }
                    }

                    $('#department_id').html(htmlDepartment);
                    $('#majorhead_id').html(htmlMajorhead);
                    $('#scheme_id').html(htmlScheme);
                    $('#soe_id').html(htmlSoe);
                    $('#fin_year_id').html(htmlFinyear);
                    $('#plan_id').html(htmlPlan);
                    $('#service_id').html(htmlService);
                    $('#sector_id').html(htmlSector);
                    $('#subsector_id').html(htmlSubSector);

                    $('#hod_outlay').val((soebudgetallocation[0]['hod_outlay'] / 100000));
                    $('#district_outlay').val((soebudgetallocation[0]['district_outlay'] / 100000));
                    $('#outlay').val((soebudgetallocation[0]['outlay'] / 100000));
                    $('#outlayHidden').val((soebudgetallocation[0]['outlay'] / 100000));
                    $('#earmarked').val(soebudgetallocation[0]['earmarked']);

                }
            });
        });

        $("#department_id").change(function() {
            $.ajax({
                url: "{{ route('get_allocation_majorhead_by_department') }}?department_id=" + $(this)
                .val(),
                method: 'GET',
                success: function(data) {
                    $('#majorhead_id').html(data.majorheadHtml);
                    $('#scheme_id').html(data.schemeHtml);
                    $('#soe_id').html(data.soeHtml);
                }
            });
        });
        $("#majorhead_id").change(function() {
            $.ajax({
                url: "{{ route('get_allocation_scheme_by_majorhead') }}?majorhead_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#scheme_id').html(data.schemeHtml);
                    $('#soe_id').html(data.soeHtml);
                }
            });
        });
        $("#scheme_id").change(function() {
            $.ajax({
                url: "{{ route('get_allocation_soe_by_scheme') }}?scheme_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#soe_id').html(data.soeHtml);
                }
            });
        });
        $("#service_id").change(function() {
            $.ajax({
                url: "{{ route('get_allocation_sector_by_service') }}?service_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#sector_id').html(data.sectorhtml);
                    $('#subsector_id').html(data.subsectorhtml);
                }
            });
        })
        $("#sector_id").change(function() {
            $.ajax({
                url: "{{ route('get_allocation_subsector_by_sector') }}?sector_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#subsector_id').html(data.subsectorhtml);
                }
            });
        });

        $('#hod_outlay').on('keyup', function(e) {
            let hodOutlay = e.target.value > 0 ? parseInt(e.target.value) : parseInt($('#district_outlay').val());
            var districtOutlay = $('#district_outlay').val() > 0 ? parseInt($('#district_outlay').val()) : 0;
            hodOutlay = $('#hod_outlay').val() > 0 ? parseInt($('#hod_outlay').val()) : 0;
            let totalOutlay = parseInt(districtOutlay) + parseInt(hodOutlay)
            $('#outlay').val(totalOutlay);
            $('#outlayHidden').val(totalOutlay);
        });
        $('#district_outlay').on('keyup', function(e) {
            let districtOutlay = e.target.value > 0 ? parseInt(e.target.value) : parseInt($('#hod_outlay').val());;
            var hodOutlay = $('#hod_outlay').val() > 0 ? parseInt($('#hod_outlay').val()) : 0;
            districtOutlay = $('#district_outlay').val() > 0 ? parseInt($('#district_outlay').val()) : 0;
            let totalOutlay = parseInt(districtOutlay) + parseInt(hodOutlay)
            $('#outlay').val(totalOutlay);
            $('#outlayHidden').val(totalOutlay);
        });
    </script>
@endsection
