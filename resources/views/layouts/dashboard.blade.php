<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @stack('prepend-style')
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href={{ asset('dashboard/css/adminlte.min.css') }}>
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href={{ asset('dashboard/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}>
    <!-- DataTables -->
    <link rel="stylesheet" href={{ asset('dashboard/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}>
    <link rel="stylesheet"
        href={{ asset('dashboard/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}>
    <link rel="stylesheet" href={{ asset('dashboard/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}>
    @stack('addon-style')
    <title>@yield('title')</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('components.dashboard.preloader')

        @include('components.dashboard.navbar')

        @include('components.dashboard.sidebar')

        <div class="content-wrapper">
            @include('components.dashboard.breadcrumb')
            <section class="content">
                @yield('content')
            </section>
        </div>

        @include('components.dashboard.footer')

    </div>

    @stack('prepend-script')
    <script src={{ asset('dashboard/plugins/jquery/jquery.min.js') }}></script>
    <!-- Bootstrap 4 -->
    <script src={{ asset('dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js') }}></script>
    <!-- overlayScrollbars -->
    <script src={{ asset('dashboard/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}></script>
    <!-- AdminLTE App -->
    <script src={{ asset('dashboard/js/adminlte.min.js') }}></script>
    <!--- DataTables -->
    <script src={{ asset('dashboard/plugins/datatables/jquery.dataTables.min.js') }}></script>
    <script src={{ asset('dashboard/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}></script>
    <script src={{ asset('dashboard/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}></script>
    <script src={{ asset('dashboard/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}></script>
    <script src={{ asset('dashboard/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}></script>
    <script src={{ asset('dashboard/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}></script>
    <script src={{ asset('dashboard/plugins/jszip/jszip.min.js') }}></script>
    <script src={{ asset('dashboard/plugins/pdfmake/pdfmake.min.js') }}></script>
    <script src={{ asset('dashboard/plugins/pdfmake/vfs_fonts.js') }}></script>
    <script src={{ asset('dashboard/plugins/datatables-buttons/js/buttons.html5.min.js') }}></script>
    <script src={{ asset('dashboard/plugins/datatables-buttons/js/buttons.print.min.js') }}></script>
    <script src={{ asset('dashboard/plugins/datatables-buttons/js/buttons.colVis.min.js') }}></script>
    {{-- <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script> --}}
    @stack('addon-script')
    @yield('js')
</body>

</html>
