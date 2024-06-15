<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SCDP')</title>  
    @include('layout.css')
	@yield('page-level-css')    <!-- Page Level CSS -->

</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('dist/img/scdp.png') }}" alt="SCDP" height="60" width="60">
        </div>

        <!-- Navbar -->
        @include('layout.header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layout.sidebar')

        
		<!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
        @include('layout.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>

    @include('layout.script')
    @yield('scripts') <!-- Page Level CSS -->
	@yield('page-level-script') <!-- Page Level CSS -->

    <script type="text/javascript">
        $('#fin_year').on('change', function() {
       id=this.value;

              $.ajax({
                    url: "{{ route('chage_fin_year') }}?fin_year="+id,
                    method: 'GET',
                    success: function(data) {
                       location.reload();
                    }
                });
    });
    </script>
</body>

</html>
