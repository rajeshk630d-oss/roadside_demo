@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Assign Job # {{$job->id}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('pending_jobs')}}">Jobs</a></li>
                            <li class="breadcrumb-item active">Assign Job</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form action="{{url('assign_job' , $job->id)}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Job Details</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label" style="text-align: right">
                                        Job Type :
                                    </label>
                                    <label for="name" class="col-sm-2 col-form-label" style="text-align: left">
                                        {{config('view.job_types')[$job->is_credit_cash]}}
                                    </label>
                                </div>
                                <div class="form-group row">
                                    <label for="date" class="col-sm-2 col-form-label" style="text-align: right">
                                        Date :
                                    </label>
                                    <label for="date" class="col-sm-4 col-form-label" style="text-align: left">
                                        {{$job->date}}
                                    </label>

                                    <label for="member_id" class="col-sm-2 col-form-label" style="text-align: right">
                                        Member Number :
                                    </label>
                                    <label for="member_id" class="col-sm-4 col-form-label" style="text-align: left">
                                        {{$job->member_number}}
                                    </label>
                                </div>
                                <div class="form-group row">
                                    <label  class="col-sm-2 col-form-label" style="text-align: right">
                                        Member Name :
                                    </label>
                                    <label  class="col-sm-4 col-form-label" style="text-align: left">
                                        {{$job->member_name}}
                                    </label>

                                    <label  class="col-sm-2 col-form-label" style="text-align: right">
                                        Member Contact No. :
                                    </label>
                                    <label class="col-sm-4 col-form-label" style="text-align: left">
                                        {{$job->member_mobile}}
                                    </label>
                                </div>
                                <div class="form-group row">
                                    <label for="customer_name" class="col-sm-2 col-form-label" style="text-align: right">
                                        Customer Name :
                                    </label>
                                    <label for="member_id" class="col-sm-4 col-form-label" style="text-align: left">
                                        {{$job->customer_name}}
                                    </label>
                                    <label for="vehicle_number" class="col-sm-2 col-form-label" style="text-align: right">
                                        Vehicle Number :
                                    </label>
                                    <label for="member_id" class="col-sm-4 col-form-label" style="text-align: left">
                                        {{$job->vehicle_no}}
                                    </label>
                                </div>
                                <div class="form-group row">
                                    <label for="member_expiry_date" class="col-sm-2 col-form-label" style="text-align: right">
                                        Member Expiry Date :
                                    </label>
                                    <label for="member_id" class="col-sm-4 col-form-label" style="text-align: left">
                                        {{$job->member_expiry_date}}
                                    </label>
                                    <label for="chassis_no" class="col-sm-2 col-form-label" style="text-align: right">
                                        Chassis Number :
                                    </label>
                                    <label for="member_id" class="col-sm-4 col-form-label" style="text-align: left">
                                        {{$job->chassis_no}}
                                    </label>
                                </div>
                                <div class="form-group row">
                                    <label for="engine_no" class="col-sm-2 col-form-label" style="text-align: right">
                                        Engine Number :
                                    </label>
                                    <label for="member_id" class="col-sm-4 col-form-label" style="text-align: left">
                                        {{$job->engine_no}}
                                    </label>
                                    <label for="service_master_id" class="col-sm-2 col-form-label" style="text-align: right">
                                        Service Required :
                                    </label>
                                    <label for="member_id" class="col-sm-4 col-form-label" style="text-align: left">
                                        {{\App\Service::find($job->service_master_id)->name}}
                                    </label>
                                </div>
                                <div class="form-group row">
                                    <label for="from_area" class="col-sm-2 col-form-label" style="text-align: right">
                                        From Area :
                                    </label>
                                    <label for="member_id" class="col-sm-4 col-form-label" style="text-align: left">
                                        {{\App\ServiceAreas::find($job->from_area)->name}}
                                    </label>
                                    <label for="to_area" class="col-sm-2 col-form-label" style="text-align: right">
                                        To Area :
                                    </label>
                                    <label for="member_id" class="col-sm-4 col-form-label" style="text-align: left">
                                        {{\App\ServiceAreas::find($job->to_area)->name}}
                                    </label>
                                </div>
                                <div class="form-group row">
                                    <label for="amount" class="col-sm-2 col-form-label" style="text-align: right">
                                        Amount :
                                    </label>
                                    <label for="member_id" class="col-sm-4 col-form-label" style="text-align: left">
                                        {{number_format($job->amount , 2)}}
                                    </label>
                                    <label for="remarks" class="col-sm-2 col-form-label" style="text-align: right">
                                        Remarks *
                                    </label>
                                    <label for="member_id" class="col-sm-4 col-form-label" style="text-align: left">
                                        {{$job->remarks}}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Driver Details</h3>
                            </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label" style="text-align: right">
                                            Assign To *
                                        </label>
                                        <div class="col-sm-3">
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" id="assign_to_aaa" name="assign_to" value="0" onclick="display_form()"
                                                <?php if(old('assign_to') == NULL || old('assign_to') == 0){ echo "checked"; }?>
                                                >
                                                <label for="assign_to_aaa">
                                                    AAA
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" id="assign_to_contractor" name="assign_to" value="1" onclick="display_form()"
                                                <?php if(old('assign_to') == 1){ echo "checked"; }?> >
                                                <label for="assign_to_contractor">
                                                    Contractor
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="aaa_div">
                                        <div class="form-group row">
                                            <label for="vehicle_id" class="col-sm-2 col-form-label">Vehicles</label>
                                            <div class="col-sm-10">
                                                <select class="select2" name="vehicle_id" id="vehicle_id" style="width: 100%;">
                                                    <option value="" >  -- Select Vehicle number --  </option>
                                                    @foreach($vehicles as $vehicle)
                                                        <?php
                                                        $select = "";
                                                        if($vehicle->id == old('vehicle_id')){
                                                            $select = "SELECTED";
                                                        }
                                                        ?>
                                                        <option value="{{$vehicle->id}}" {{$select}} >
                                                            {{$vehicle->vehicle_no}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="driver_id" class="col-sm-2 col-form-label">Driver * </label>
                                            <div class="col-sm-10">
                                                <select class="select2" name="driver_id" id="driver_id" style="width: 100%;" onchange="get_driver()">
                                                    <option value="" >  -- Select Driver --  </option>
                                                    @foreach($drivers as $driver)
                                                        <?php
                                                        $select = "";
                                                        if($driver->id == old('driver_id')){
                                                            $select = "SELECTED";
                                                        }
                                                        ?>
                                                        <option value="{{$driver->id}}" {{$select}} >
                                                            {{$driver->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="contractor_div">
                                        <div class="form-group row">
                                            <label for="contractor_id" class="col-sm-2 col-form-label">Contractors</label>
                                            <div class="col-sm-10">
                                                <select class="select2" name="contractor_id" id="contractor_id" style="width: 100%;">
                                                    <option value="" >  -- Select Contractor --  </option>
                                                    @foreach($contractors as $contractor)
                                                        <?php
                                                        $select = "";
                                                        if($contractor->id == old('contractor_id')){
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
                                            <label for="driver_name" class="col-sm-2 col-form-label">Driver Name *</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="driver_name" id="driver_name"
                                                       placeholder="Enter driver name" value="{{old('driver_name')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="driver_no" class="col-sm-2 col-form-label">Driver Number *</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="driver_no" id="driver_no"
                                                   placeholder="Enter driver phone number" value="{{old('driver_no')}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="amount" class="col-sm-2 col-form-label">Amount </label>
                                        <div class="col-sm-10">
                                            <input type="number" step="0.001" class="form-control" name="amount" id="amount"
                                                   placeholder="Enter Amount" value="{{old('amount') ? old('amount') : $job->amount}}">
                                        </div>
                                    </div>
                                    <div class="form-group row" id = "contractor_amount_div">
                                        <label for="contractor_amount" class="col-sm-2 col-form-label">Contractor Amount </label>
                                        <div class="col-sm-10">
                                            <input type="number" step="0.001" class="form-control" name="contractor_amount" id="contractor_amount"
                                                   placeholder="Enter Contractor Amount" value="{{old('contractor_amount') ? old('contractor_amount') : $job->contractor_amount}}">
                                        </div>
                                    </div>
                                    <div class="form-group row" id = "aaa_charges_div">
                                        <label for="aaa_charges" class="col-sm-2 col-form-label">AAA Charges</label>
                                        <div class="col-sm-10">
                                            <input type="number" step="0.001" class="form-control" name="aaa_charges" id="aaa_charges"
                                                   placeholder="Enter AAA charges" value="{{old('aaa_charges') ? 10 : $job->aaa_charges}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="remarks" class="col-sm-2 col-form-label">Remarks *</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="remarks" id="remarks"
                                                   placeholder="Enter Remarks" value="{{old('remarks') ? old('remarks') : $job->remarks}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info float-right">Assign</button>
                                    <a href="{{route('pending_jobs')}}" class="btn btn-default">Cancel</a>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </form>
        </section>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            $(".select2").select2();
        });
        display_form();
        function display_form(){
           var val = $('[name="assign_to"]:checked').val();
           if(val == 0){
               $('#aaa_div').show();
               $('#contractor_div').hide();
               $('#contractor_amount_div').hide();
               $('#aaa_charges_div').show();
           }else{
               $('#aaa_div').hide();
               $('#contractor_div').show();
               $('#contractor_amount_div').show();
               $('#aaa_charges_div').hide();
           }
        }
        function get_driver(){
            var driver_id = $('#driver_id').val();
            $.ajax({
                url:'{{url('get_driver')}}'+'/'+driver_id,
                dataType: 'json',
                success: function (result) {
                    $('#driver_no').val(result.mobile_no);
                }
            });
        }
    </script>
@endsection