@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Role</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('roles.index')}}">Roles</a></li>
                            <li class="breadcrumb-item active">Add Role</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form action="{{route('roles.store')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Role Details</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label" style="text-align: right">
                                        Name * :
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="name" id="name"
                                               placeholder="Role Name" value="{{old('name')}}">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-8">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="is_super_admin" name="is_super_admin" >
                                            <label for="is_super_admin">
                                                Is Super Admin
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <a href="{{route('roles.index')}}" class="btn btn-secondary">Cancel</a>
                                <input type="submit" value="Create Role" class="btn btn-success float-right">
                            </div>
                        </div>
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