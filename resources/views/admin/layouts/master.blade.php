<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="{{ url ('../assets/admin/dist/plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="{{ url('../assets/admin/dist/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ url('../assets/admin/dist/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ url('../assets/admin/dist/plugins/jqvmap/jqvmap.min.css') }}">
        <link rel="stylesheet" href="{{ url('../assets/admin/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ url('../assets/admin/dist/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <link rel="stylesheet" href="{{ url('../assets/admin/dist/plugins/daterangepicker/daterangepicker.css') }}">
        <link rel="stylesheet" href="{{ url('../assets/admin/dist/plugins/summernote/summernote-bs4.min.css') }}">
        <style>
            button.submit {
                padding: 4px 30px;
                border: unset;
                background-color: darkgreen;
                color: aliceblue;
                text-align: center;
            }
            .notification-container {
                max-height: 300px; /* Adjust the height as needed */
                overflow-y: auto;
            }

          
        </style>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
        <!-- Preloader -->       
        @include('admin.layouts.navigation')

        <!-- Main Sidebar Container -->
        @include('admin.layouts.sidebar')
        <!-- /.sidebar -->

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                   
                </div>
            </div>
            <!-- /.content-header -->

            @yield('content')


        </div>

        <script src="{{url('../assets/admin/dist/plugins/jquery/jquery.min.js')}}"></script>
        <script src="{{url('../assets/admin/dist/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
        <script src="{{url('../assets/admin/dist/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{url('../assets/admin/dist/plugins/chart.js/Chart.min.js')}}"></script>
        <script src="{{url('../assets/admin/dist/plugins/sparklines/sparkline.js')}}"></script>
        <script src="{{url('../assets/admin/dist/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
        <script src="{{url('../assets/admin/dist/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
        <script src="{{url('../assets/admin/dist/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
        <script src="{{url('../assets/admin/dist/plugins/moment/moment.min.js')}}"></script>
        <script src="{{url('../assets/admin/dist/plugins/daterangepicker/daterangepicker.js')}}"></script>
        <script src="{{url('../assets/admin/dist/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
        <script src="{{url('../assets/admin/dist/plugins/summernote/summernote-bs4.min.js')}}"></script>
        <script src="{{url('../assets/admin/dist/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
        <script src="{{url('../assets/admin/dist/js/adminlte.js')}}"></script>
        <script src="{{url('../assets/admin/dist/js/pages/dashboard.js')}}"></script>

    </body>
</html>



