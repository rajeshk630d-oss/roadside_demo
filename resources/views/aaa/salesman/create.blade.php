@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Salesman</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('aaaSalesman.index')}}">Salesman</a></li>
                            <li class="breadcrumb-item active">Add Salesman</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <form action="{{route('aaaSalesman.store')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Salesman Details</h3>

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
                                               id="name" placeholder="Name" value="{{old('name')}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mobile_no" class="col-sm-2 col-form-label" style="text-align: right">
                                        Mobile No. *
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="mobile_no"
                                               id="mobile_no" placeholder="Mobile Number" value="{{old('mobile_no')}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label" style="text-align: right">
                                        E-mail *
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email"
                                               id="email" placeholder="E-mail" value="{{old('email')}}">
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
                        <a href="{{route('aaaSalesman.index')}}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Create Salesman" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
