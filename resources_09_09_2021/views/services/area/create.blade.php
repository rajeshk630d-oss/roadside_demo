@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Service Area</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('serviceArea.index')}}">Service Areas</a></li>
                            <li class="breadcrumb-item active">Add Service Area</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form action="{{route('serviceArea.store')}}" method="post">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Area Details</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputName">Name</label>
                                    <input type="text" id="brand_name"  name="name" value="{{old('name')}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="inputDescription">Remarks</label>
                                    <textarea  id="remark" name="remark" class="form-control" rows="4">{{old('remarks')}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-6">
                        <a href="{{route('serviceArea.index')}}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Create new Area" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
