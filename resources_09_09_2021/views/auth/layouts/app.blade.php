<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{get_company()->name}}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/dist/img/favicon.png')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{asset('public/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/dist/css/adminlte.min.css')}}">
</head>
<style>
    .body{
        background-image: url({{asset('storage/app/uploads/companies/car_towing.jpeg')}});
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
    }
</style>
<body class="hold-transition login-page"
      style="background-image: url({{asset('storage/app/uploads/companies/car_towing.jpeg')}});
              background-position: center;
              background-repeat: no-repeat;
              background-size: cover;
              position: relative;">
    @include('layouts.notifications')
    @yield('content')
</body>
<script src="{{asset('public/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('public/dist/js/adminlte.min.js')}}"></script>

</html>