@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Customer Contract</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('customerContracts.index')}}">Contracts</a></li>
                            <li class="breadcrumb-item active">Add Contract</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form action="{{route('customerContracts.store')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Contract Details</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="customers_id" class="col-sm-2 " style="text-align: right">
                                                Customer *
                                            </label>
                                            <div class="col-sm-10">
                                                <select class="select2" name="customers_id" id="customers_id"
                                                    data-placeholder="Select a Contractor" style="width: 100%;">
                                                @foreach($customers as $customer)
                                                    <?php
                                                    $select = "";
                                                    if($customer->id == old('customers_id')){
                                                        $select = "SELECTED";
                                                    }
                                                    ?>
                                                    <option value="{{$customer->id}}" {{$select}} >
                                                        {{$customer->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="service_master_id" class="col-sm-2 " style="text-align: right">
                                                Service *
                                            </label>
                                            <div class="col-sm-10">
                                            <select class="select2" name="service_master_id" id="service_master_id"
                                                    data-placeholder="Select a Service" style="width: 100%;">
                                                @foreach($services as $service)
                                                    <?php
                                                    $select = "";
                                                    if($service->id == old('service_master_id')){
                                                        $select = "SELECTED";
                                                    }
                                                    ?>
                                                    <option value="{{$service->id}}" {{$select}} >
                                                        {{$service->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="charges" class="col-sm-2 col-form-label" style="text-align: right">
                                                Charges *
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="number" step="0.001" class="form-control" name="charges"
                                                       id="charges" placeholder="Charges" value="{{old('charges')}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="free_services_contract" class="col-sm-2 col-form-label" style="text-align: right">
                                                Free Services/Contract *
                                            </label>
                                            <div class="col-sm-10">
                                                <input  class="form-control" name="free_services_contract"
                                                        id="free_services_contract" placeholder="Free Services or contract" value="{{old('free_services_contract')}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="minimum_km" class="col-sm-2 col-form-label" style="text-align: right">
                                                Minimum Km *
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="number" step="0.001" class="form-control" name="minimum_km" id="minimum_km" value="{{old('minimum_km')}}" placeholder="Minimum KM">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="extracharges_km" class="col-sm-2 col-form-label" style="text-align: right">
                                                Extra Charges/Km *
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="number" step="0.001" class="form-control" name="extracharges_km" id="extracharges_km" value="{{old('extracharges_km')}}" placeholder="Extra changes per KM">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="payment_terms" class="col-sm-2 col-form-label" style="text-align: right">
                                                Payment Terms *
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="payment_terms" value="{{old('payment_terms')}}" id="payment_terms" placeholder="Payment Terms">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="contract_pdf" class="col-sm-2 col-form-label" style="text-align: right">
                                                Contract Pdf *
                                            </label>
                                            <div class="col-sm-10">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="contract_pdf" name="contract_pdf">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('customerContracts.index')}}" class="btn btn-secondary">Cancel</a>
                                <input type="submit" value="Create new Contract" class="btn btn-success float-right">
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