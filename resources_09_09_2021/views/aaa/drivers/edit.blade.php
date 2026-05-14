@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Driver</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('aaaDriver.index')}}">Drivers</a></li>
                            <li class="breadcrumb-item active">Update Driver</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <form action="{{route('aaaDriver.update' , $driver->id)}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}

                <input type="hidden" name="_method" value="PATCH">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Driver Details</h3>

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
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name"
                                               id="name" placeholder="Name" value="{{$driver->name}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-sm-2 col-form-label" style="text-align: right">
                                        Address *
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="address"
                                               id="address" placeholder="Address" value="{{$driver->address}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="id_no" class="col-sm-2 col-form-label" style="text-align: right">
                                        ID *
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="id_no"
                                               id="id_no" placeholder="ID No." value="{{$driver->id_no}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mobile_no" class="col-sm-2 col-form-label" style="text-align: right">
                                        Mobile No. *
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="mobile_no"
                                               id="mobile_no" placeholder="Mobile Number" value="{{$driver->mobile_no}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="photo" class="col-sm-2 col-form-label" style="text-align: right">
                                        Photo *
                                    </label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="photo" name="photo">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="{{route('aaaDriver.index')}}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Update Driver" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
