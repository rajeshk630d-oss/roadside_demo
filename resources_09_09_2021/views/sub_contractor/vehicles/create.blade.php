@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Contractor Vehicles</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('contractorVehicles.index')}}">Vehicles</a></li>
                            <li class="breadcrumb-item active">Add Contractor Vehicles</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form action="{{route('contractorVehicles.store')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Vehicle Details</h3>
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
                                            <label for="contractor_master_id" class="col-sm-2 " style="text-align: right">
                                                Contractor *
                                            </label>
                                            <div class="col-sm-10">
                                                <select class="select2" name="contractor_master_id" id="contractor_master_id"
                                                    data-placeholder="Select a Contractor" style="width: 100%;">
                                                @foreach($contractors as $contractor)
                                                    <?php
                                                    $select = "";
                                                    if($contractor->id == old('contractor_master_id')){
                                                        $select = "SELECTED";
                                                    }
                                                    ?>
                                                    <option value="{{$contractor->id}}" {{$select}} >
                                                        {{$contractor->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="vehicle_no" class="col-sm-2 col-form-label" style="text-align: right">
                                                Vehicle No *
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="vehicle_no" id="vehicle_no" placeholder="Vehicle No" value="{{old('vehicle_no')}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="vehicle_brand_master_id" class="col-sm-2 " style="text-align: right">
                                                Vehicle Brand *
                                            </label>
                                            <div class="col-sm-10">
                                                <select class="select2" name="vehicle_brand_master_id" id="vehicle_brand_master_id"
                                                        data-placeholder="Select a vehicle brand" style="width: 100%;">
                                                    @foreach($brands as $brand)
                                                        <?php
                                                        $select = "";
                                                        if($brand->id == old('vehicle_brand_master_id')){
                                                            $select = "SELECTED";
                                                        }
                                                        ?>
                                                        <option value="{{$brand->id}}" {{$select}} >
                                                            {{$brand->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="vehicle_type_master_id" class="col-sm-2 " style="text-align: right">
                                                Vehicle Type *
                                            </label>
                                            <div class="col-sm-10">
                                                <select class="select2" name="vehicle_type_master_id" id="vehicle_type_master_id"
                                                        data-placeholder="Select a vehicle type" style="width: 100%;">
                                                    @foreach($vehicle_types as $brand)
                                                        <?php
                                                        $select = "";
                                                        if($brand->id == old('vehicle_type_master_id')){
                                                            $select = "SELECTED";
                                                        }
                                                        ?>
                                                        <option value="{{$brand->id}}" {{$select}} >
                                                            {{$brand->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="vehicle_registration_type_master_id" class="col-sm-2 " style="text-align: right">
                                                Vehicle Registration Type *
                                            </label>
                                            <div class="col-sm-10">
                                                <select class="select2" name="vehicle_registration_type_master_id" id="vehicle_registration_type_master_id"
                                                        data-placeholder="Select a vehicle type" style="width: 100%;">
                                                    @foreach($reg_types as $reg_type)
                                                        <?php
                                                        $select = "";
                                                        if($reg_type->id == old('vehicle_registration_type_master_id')){
                                                            $select = "SELECTED";
                                                        }
                                                        ?>
                                                        <option value="{{$reg_type->id}}" {{$select}} >
                                                            {{$reg_type->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="model_year" class="col-sm-2 col-form-label" style="text-align: right">
                                                Model Year *
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="model_year" id="model_year"
                                                       placeholder="Model Year" value="{{old('model_year')}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="engine_no" class="col-sm-2 col-form-label" style="text-align: right">
                                                Engine No *
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="engine_no" id="engine_no"
                                                       placeholder="Engine No" value="{{old('engine_no')}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="chassis_no" class="col-sm-2 col-form-label" style="text-align: right">
                                                Chassis No *
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="chassis_no"
                                                       id="chassis_no" placeholder="Chassis No" value="{{old('chassis_no')}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="vehicle_no" class="col-sm-2 col-form-label" style="text-align: right">
                                                V No *
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="v_no" id="v_no" placeholder="V No"
                                                       value="{{old('v_no')}}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="registration_expiry_date" class="col-sm-2 col-form-label" style="text-align: right">
                                                Registration Expiry Date *
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" name="registration_expiry_date"
                                                       id="registration_expiry_date" placeholder="Registration expiry date"
                                                       value="{{old('registration_expiry_date')}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="insurance_company" class="col-sm-2 col-form-label" style="text-align: right">
                                                Insurance Company *
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="insurance_company" id="insurance_company"
                                                       placeholder="Insurance company"
                                                       value="{{old('insurance_company')}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="insurance_expiry_date" class="col-sm-2 col-form-label" style="text-align: right">
                                                Insurance Expiry Date *
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" name="insurance_expiry_date"
                                                       id="insurance_expiry_date" placeholder="Insurance expiry date"
                                                       value="{{old('insurance_expiry_date')}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('contractorVehicles.index')}}" class="btn btn-secondary">Cancel</a>
                                <input type="submit" value="Create new Contractor Vehicle" class="btn btn-success float-right">
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