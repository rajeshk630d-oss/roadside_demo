@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Member</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('members.index')}}">Members</a></li>
                            <li class="breadcrumb-item active">Add Member</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form action="{{route('members.store')}}" method="post">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Member Details</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="membership_no">Membership No *</label>
                                            <input type="text" id="membership_no"  name="membership_no" value="{{old('membership_no')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Membership Type *</label>
                                            <select class="select2" name="membership_type_id" id="membership_type_id"
                                                    data-placeholder="Select a membership type" style="width: 100%;">
                                                @foreach($membership_types as $type)
                                                    <?php
                                                    $select = "";
                                                    if($type->id == old('membership_type_id')){
                                                        $select = "SELECTED";
                                                    }
                                                    ?>
                                                    <option value="{{$type->id}}" {{$select}} >
                                                        {{$type->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Customer *</label>
                                            <select class="select2"name="customer_id" id="customer_id"
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
                                            <label for="mobile">Mobile Number </label>
                                            <input type="text" id="mobile"  name="mobile" value="{{old('mobile')}}"
                                                   placeholder="Enter Mobile Number" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="vehicle_no">Vehicle No </label>
                                            <input type="text" id="vehicle_no"  name="vehicle_no" value="{{old('vehicle_no')}}"
                                                   placeholder="Enter Vehicle Number" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="chassis_no">Chassis No </label>
                                            <input type="text" id="chassis_no"  name="chassis_no" value="{{old('chassis_no')}}"
                                                   placeholder="Enter Chassis Number" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="engine_no">Engine No </label>
                                            <input type="text" id="engine_no"  name="engine_no" value="{{old('engine_no')}}"
                                                   placeholder="Enter Engine Number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="member_name">Member Name *</label>
                                            <input type="text" id="member_name"  name="member_name" value="{{old('member_name')}}"
                                                   placeholder="Enter Member Name" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="vehicle_brand_id">Vehicle Brand </label>
                                            <select class="select2" name="vehicle_brand_id" id="vehicle_brand_id"
                                                    data-placeholder="Select a Vehicle Brand" style="width: 100%;">
                                                <option value=""> Select Vehicle Brand </option>
                                                @foreach($brands as $brand)
                                                    <?php
                                                    $select = "";
                                                    if($brand->id == old('vehicle_brand_id')){
                                                        $select = "SELECTED";
                                                    }
                                                    ?>
                                                    <option value="{{$brand->id}}" {{$select}} >
                                                        {{$brand->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="vehicle_type_id">Vehicle Type </label>
                                            <select class="select2" name="vehicle_type_id" id="vehicle_type_id"
                                                    data-placeholder="Select a Vehicle Type" style="width: 100%;">
                                                <option value=""> Select Vehicle Type </option>
                                                @foreach($vehicle_types as $vehicle_type)
                                                    <?php
                                                    $select = "";
                                                    if($vehicle_type->id == old('vehicle_type_id')){
                                                        $select = "SELECTED";
                                                    }
                                                    ?>
                                                    <option value="{{$vehicle_type->id}}" {{$select}} >
                                                        {{$vehicle_type->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="vehicle_reg_type_id">Vehicle Registration Type </label>
                                            <select class="select2" name="vehicle_reg_type_id" id="vehicle_reg_type_id"
                                                    data-placeholder="Select a Vehicle Registration Type" style="width: 100%;">
                                                <option value=""> Select Vehicle Type </option>
                                                @foreach($vehicle_reg_types as $type)
                                                    <?php
                                                    $select = "";
                                                    if($type->id == old('vehicle_reg_type_id')){
                                                        $select = "SELECTED";
                                                    }
                                                    ?>
                                                    <option value="{{$type->id}}" {{$select}} >
                                                        {{$type->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="mfg_year">Manufactured Year </label>
                                            <input type="number" id="mfg_year"  name="mfg_year" value="{{old('mfg_year')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="expiry_date">Expiry Date *{{old('expiry_date')}}</label>
                                            <input type="date" id="expiry_date"  name="expiry_date"
                                                   min="{{\Carbon\Carbon::now()->format('Y-m-d')}}"
                                                   value="{{old('expiry_date')}}" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="ref_no">Reference No</label>
                                            <input type="text" id="ref_no"  name="ref_no" value="{{old('ref_no')}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="{{route('service.index')}}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Create new Member" class="btn btn-success float-right">
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