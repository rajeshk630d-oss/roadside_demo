@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{$user->photo}}"
                                         alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{$user->name}}</h3>

                                <p class="text-muted text-center">{{$user->role->name}}</p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Name</b> <a class="float-right">{{$user->name}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>E-mail</b> <a class="float-right">{{$user->email}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Profile Details</h3>
                            </div>
                            <form action="{{route('update_profile')}}" method="post" enctype="multipart/form-data">                                {{csrf_field()}}

                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input name="name" class="form-control" id="name" required placeholder="User Name"
                                                   value="{{$user->name}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="user_email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" readonly id="user_email" name="user_email" placeholder="E-mail"
                                            value="{{$user->email}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="user_password" class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password"
                                            value="" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="user_photo">Photo</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" required
                                                           class="custom-file-input" id="user_photo" name="user_photo">
                                                    <label class="custom-file-label" for="user_photo">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info">Update</button>
                                    <a href="{{route('home')}}" class="btn btn-default float-right">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
