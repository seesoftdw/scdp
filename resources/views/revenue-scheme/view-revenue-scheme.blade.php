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
                    <h1 class="m-0">Revenue Scheme</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Revenue Scheme</li>
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
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10"></div>
                                <div class="col-md-2">
                                    <button  class="btn btn-success" id="btnExport"><i class="fas fa-file-download"></i>&nbsp; Export Revenue Scheme</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="overflow-x:auto;">
                            <table id="datatable" class="table table-bordered table-hover large-table">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Department</th>
                                        <th>Major head</th>
                                        <th>Scheme</th>
                                        <th>Soe</th>
                                        <th>Fin year</th>
                                        <th>Earmarked</th>
                                        <th>Plan</th>
                                        <th>Service</th>
                                        <th>Sector</th>
                                        <th>Sub-sector</th>
                                        <th>HOD outlay</th>
                                        <th>District outlay</th>
                                        <th>Outlay</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($revenueData))
                                        @foreach ($revenueData as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->department->department_name }}</td>
                                                <td>{{ $item->majorhead->complete_head }}</td>
                                                <td>{{ $item->scheme->scheme_name }}</td>
                                                <td>{{ $item->soe->soe_name }}</td>
                                                <td>{{ $item->fin_year->finyear }}</td>
                                                <td>{{ $item->earmarked }}</td>
                                                <td>{{ $item->plan->plan_name }}</td>
                                                <td>{{ $item->service->service_name }}</td>
                                                <td>{{ $item->sector->sector_name }}</td>
                                                <td>{{ $item->subsector->subsectors_name }}</td>
                                                <td>{{ $item->hod_outlay / 100000 }}</td>
                                                <td>{{ $item->district_outlay / 100000 }}</td>
                                                <td>{{ $item->outlay / 100000 }}</td>
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
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('.show-alert-delete-box').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: "Are you sure you want to delete this record?",
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                type: "warning",
                buttons: ["Cancel", "Yes!"],
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });

        $('#btnExport').click(function() {
            $("#revenueTable").table2excel({
                filename: "Revenue-scheme.xls"
            });
        });


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

    <style>
        #doublescroll {
            overflow: auto;
            overflow-y: hidden;
        }

        #doublescroll p {
            margin: 0;
            padding: 1em;
            white-space: nowrap;
        }
    </style>
@endsection
