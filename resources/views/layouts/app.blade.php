<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{get_company()->name}}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/dist/img/favicon.png')}}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('public/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('public/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('public/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

    <link rel="stylesheet" href="{{asset('public/plugins/daterangepicker/daterangepicker.css')}}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('public/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('public/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('public/plugins/summernote/summernote-bs4.min.css')}}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{asset('storage/app/'.get_company()->logo)}}"
                 alt="{{get_company()->name}}" height="60" width="60"
                style="border-radius: 50%;"
            >
        </div>
        @include('layouts.nav_bar')
        @include('layouts.side_menu')
        @include('layouts.notifications')
        @yield('content')
        @include('layouts.footer')
        @include('layouts.models')
    </div>

    <script src="{{asset('public/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('public/plugins/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('public/plugins/sparklines/sparkline.js')}}"></script>
    <script src="{{asset('public/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{asset('public/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
    <script src="{{asset('public/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('public/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script src="{{asset('public/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <script src="{{asset('public/plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('public/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

    <script src="{{asset('public/dist/js/adminlte.js')}}"></script>
    <script src="{{asset('public/dist/js/pages/dashboard.js')}}"></script>

    @yield('script')
</body>
<script>
    $(function () {
        bsCustomFileInput.init();
    })
</script>
</html>
