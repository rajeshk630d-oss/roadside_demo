@extends('auth.layouts.app')
@section('content')
<style>
    .body{
        background-image: url({{asset('storage/app/uploads/companies/car_towing.jpeg')}});
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;"
    }
</style>
<div class="login-box" >
    {{--<div class="login-logo">--}}
        {{--<a href="{{url('home')}}"><b>Road</b>Side</a>--}}
    {{--</div>--}}
    </br></br></br>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="{{url('login')}}" method="post">

                {{csrf_field()}}
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" name="email"  id ="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        {{--<div class="icheck-primary">--}}
                            {{--<input type="checkbox" id="remember">--}}
                            {{--<label for="remember">--}}
                                {{--Remember Me--}}
                            {{--</label>--}}
                        {{--</div>--}}
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            {{--<p class="mb-1">--}}
                {{--<a href="{{route('password.request')}}">I forgot my password</a>--}}
            {{--</p>--}}
        </div>
    </div>
</div>
<!-- /.login-box -->
@endsection


