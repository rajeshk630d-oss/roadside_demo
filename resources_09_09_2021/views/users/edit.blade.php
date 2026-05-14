@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('users.index')}}">Users</a></li>
                            <li class="breadcrumb-item active">Update User</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form action="{{route('users.update' , $user->id)}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}

                <input type="hidden" name="_method" value="PATCH">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">User Details</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label" style="text-align: right">
                                        Name *
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="name" id="name"
                                               placeholder="User Name" value="{{$user->name}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label" style="text-align: right">
                                        E-mail *
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="email" id="email"
                                               placeholder="User Email" value="{{$user->email}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="photo" class="col-sm-2 col-form-label" style="text-align: right">
                                        Photo *
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="photo" name="photo">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="role_id" class="col-sm-2 col-form-label" style="text-align: right">
                                        Privilege *
                                    </label>
                                    <div class="col-sm-9">
                                        <select class="select2" name="role_id" id="role_id"
                                                data-placeholder="Select a Privilege " style="width: 100%;">
                                            @foreach($roles as $role)
                                                <?php
                                                $select = "";
                                                if($role->id == $user->role_id){
                                                    $select = "SELECTED";
                                                }
                                                ?>
                                                <option value="{{$role->id}}" {{$select}} >
                                                    {{$role->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label" style="text-align: right">
                                        Password *
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="password" id="password"
                                               placeholder="User Password" value="" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="{{route('users.index')}}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Update User" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            $('.select2').select2()
        })
    </script>
@endsection