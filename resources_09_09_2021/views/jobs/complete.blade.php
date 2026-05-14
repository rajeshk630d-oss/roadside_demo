@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Complete Job # {{$job->id}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('assigned_jobs')}}">Jobs</a></li>
                            <li class="breadcrumb-item active">Complete Job</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form action="{{url('complete_job' , $job->id)}}" method="post" enctype="multipart/form-data">
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
                                    <label for="driver_name" class="col-sm-2 col-form-label" style="text-align: right">Assign To :</label>
                                    <label for="vehicle_id" class="col-sm-4 col-form-label">
                                        @if($job->assign_to == 0)
                                            AAA
                                        @else
                                            Contractor
                                        @endif
                                    </label>
                                    @if($job->assign_to == 0)
                                        <label for="vehicle_id" class="col-sm-2 col-form-label"  style="text-align: right">Vehicles :</label>
                                        <label for="vehicle_id" class="col-sm-4 col-form-label">
                                            {{\App\Vehicle::find($job->vehicle_id)->vehicle_no}}
                                        </label>
                                    @else
                                        <label class="col-sm-2 col-form-label"  style="text-align: right">Contractor :</label>
                                        <label class="col-sm-4 col-form-label">
                                            {{\App\Contractor::find($job->contractor_id)->name}}
                                        </label>
                                    @endif
                                </div>
                                <div class="form-group row">

                                    <label for="vehicle_id" class="col-sm-2 col-form-label"  style="text-align: right">Driver Name :</label>
                                    <label for="vehicle_id" class="col-sm-4 col-form-label">
                                        {{$job->driver_name}}
                                    </label>
                                    <label class="col-sm-2 col-form-label"  style="text-align: right">Driver Number :</label>
                                    <label class="col-sm-4 col-form-label">
                                        {{$job->driver_no}}
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Invoice Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="amount" class="col-sm-2 col-form-label">Amount <?php if($job->is_credit_cash == 1) {echo "*";} ?></label>
                                    <div class="col-sm-10">
                                        <input type="number" step="0.001" class="form-control" name="amount" id="amount"
                                               placeholder="Enter Amount" value="{{old('amount') ? old('amount') : $job->amount}}">
                                    </div>
                                </div>
                                @if($job->assign_to == 1)
                                <div class="form-group row">
                                    <label for="contractor_amount" class="col-sm-2 col-form-label">Contractor Amount </label>
                                    <div class="col-sm-10">
                                        <input type="number" step="0.001" class="form-control" name="contractor_amount" id="contractor_amount"
                                               placeholder="Enter Contractor Amount" value="{{old('contractor_amount') ? old('contractor_amount') : $job->contractor_amount}}">
                                    </div>
                                </div>
                                @else
                                    <input type="hidden" name="contractor_amount" id="contractor_amount" value=0>
                                @endif
                                <div class="form-group row">
                                    <label for="receipt_no" class="col-sm-2 col-form-label">Receipt Number <?php if($job->is_credit_cash == 1) {echo "*";} ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="receipt_no" id="receipt_no"
                                               placeholder="Enter Receipt Number" value="{{old('receipt_no')}}">
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
                                <button type="submit" class="btn btn-info float-right">Complete</button>
                                <a href="{{route('assigned_jobs')}}" class="btn btn-default">Cancel</a>
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
           }else{
               $('#aaa_div').hide();
               $('#contractor_div').show();
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