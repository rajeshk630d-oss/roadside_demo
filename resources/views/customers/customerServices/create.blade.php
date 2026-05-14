@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Customer Service</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('customerServices.index')}}">Customer Services</a></li>
                            <li class="breadcrumb-item active">Add Customer Service</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form action="{{route('customerServices.store')}}" method="post">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Membership Service Details</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="customer_id">Customer *</label>
                                    <select class="select2" name="customer_id" id="customer_id"
                                            data-placeholder="Select a Customer" style="width: 100%;">
                                        @foreach($customers as $customer)
                                            <?php
                                            $select = "";
                                            if($customer->id == old('customer_id')){
                                                $select = "SELECTED";
                                            }
                                            ?>
                                            <option value="{{$customer->id}}" {{$select}} >
                                                {{$customer->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="service_id">Service *</label>
                                    <select class="select2" name="service_id" id="service_id"
                                            data-placeholder="Select a Service" style="width: 100%;">
                                        @foreach($services as $service)
                                            <?php
                                            $select = "";
                                            if($service->id == old('service_id')){
                                                $select = "SELECTED";
                                            }
                                            ?>
                                            <option value="{{$service->id}}" {{$select}} >
                                                {{$service->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="rate">Rate *</label>
                                    <input type="number" step="0.001"  id="rate"  name="rate" value="{{old('rate')}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="max_services">No Services/Contract *</label>
                                    <input type="number" step="1" id="max_services"  name="max_services"
                                           value="{{old('max_services')}}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-6">
                        <a href="{{route('customerServices.index')}}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Create Customer Service" class="btn btn-success float-right">
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