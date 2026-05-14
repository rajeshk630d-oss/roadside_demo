@extends('layouts.app')

@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Email Settings</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Email Settings</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">E-mail Settings</h3>
                </div>
                <form method="POST" action="{{ url('emailSettings') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="MAIL_USERNAME">Username</label>
                            <input class="form-control" id="MAIL_USERNAME" name="MAIL_USERNAME" placeholder="Enter username"
                                   value="{{get_setting('MAIL_USERNAME')}}" required>
                        </div>
                        <div class="form-group">
                            <label for="MAIL_PASSWORD">Password</label>
                            <input class="form-control" id="MAIL_PASSWORD" name="MAIL_PASSWORD" placeholder="Enter password"
                                value="{{get_setting('MAIL_PASSWORD')}}" required>
                        </div>

                        <div class="form-group">
                            <label for="MAIL_FROM_ADDRESS">From Address</label>
                            <input class="form-control" id="MAIL_FROM_ADDRESS" name="MAIL_FROM_ADDRESS" required
                                   value="{{get_setting('MAIL_FROM_ADDRESS')}}" placeholder="Enter From Address">
                        </div>
                        <div class="form-group">
                            <label for="MAIL_FROM_NAME">From Name</label>
                            <input class="form-control" id="MAIL_FROM_NAME" name="MAIL_FROM_NAME" placeholder="Enter From Name"
                                   value="{{get_setting('MAIL_FROM_NAME')}}" required>
                        </div>


                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

        </section>
    </div>

@endsection
