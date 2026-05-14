@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Service</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('service.index')}}">Services</a></li>
                            <li class="breadcrumb-item active">Add Service</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form action="{{route('service.store')}}" method="post">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Service Details</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="name"  name="name" value="{{old('name')}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="charges">Charges</label>
                                    <input type="number" step="0.001" id="charges"  name="charges" value="{{old('charges')}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="minimum_km">Minimum Km</label>
                                    <input type="number" step="0.001" id="minimum_km"  name="minimum_km" value="{{old('minimum_km')}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="extracharges_km">Extra Charges Per Km</label>
                                    <input type="number" step="0.001" id="extracharges_km"  name="extracharges_km" value="{{old('extracharges_km')}}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-6">
                        <a href="{{route('service.index')}}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Create new Service" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
