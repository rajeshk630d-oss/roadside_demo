@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Job Details # {{$job->id}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('pending_jobs')}}">Jobs</a></li>
                            <li class="breadcrumb-item active">Job Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-text-width"></i>
                                General Information
                            </h3>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-4" style="text-align: right">Job Number : </dt>
                                <dd class="col-sm-8">{{$job->id}}</dd>
                                <dt class="col-sm-4" style="text-align: right">Job Date : </dt>
                                <dd class="col-sm-8">{{display_date($job->date)}}</dd>

                                <dt class="col-sm-4" style="text-align: right">Customer Name: </dt>
                                <dd class="col-sm-8">{{$job->customer_name }}</dd>

                                <dt class="col-sm-4" style="text-align: right">Member No : </dt>
                                <dd class="col-sm-8">{{$job->member_number }}</dd>

                                <dt class="col-sm-4" style="text-align: right">Member Name: </dt>
                                <dd class="col-sm-8">{{$job->member_name }}</dd>

                                <dt class="col-sm-4" style="text-align: right">Member Contact No: </dt>
                                <dd class="col-sm-8">{{$job->member_mobile}} </dd>

                                <dt class="col-sm-4" style="text-align: right">Vehicle Number : </dt>
                                <dd class="col-sm-8">{{$job->vehicle_no != NUll ? $job->vehicle_no : " -- " }}</dd>
                                <dt class="col-sm-4" style="text-align: right">Expiry Date : </dt>
                                <dd class="col-sm-8">{{display_date($job->member_expiry_date)}}</dd>
                                <dt class="col-sm-4" style="text-align: right">Chassis Number : </dt>
                                <dd class="col-sm-8">{{$job->chassis_no != NUll ? $job->chassis_no : " -- " }}</dd>
                                <dt class="col-sm-4" style="text-align: right">Engine Number : </dt>
                                <dd class="col-sm-8">{{$job->engine_no != NUll ? $job->engine_no : " -- " }}</dd>
                                <dt class="col-sm-4" style="text-align: right">Service : </dt>
                                <dd class="col-sm-8">{{$job->service != NUll ? $job->service->name : " -- " }}</dd>
                                <dt class="col-sm-4" style="text-align: right">From Area : </dt>
                                <dd class="col-sm-8">{{$job->from_service_area != NUll ? $job->from_service_area->name : " -- " }}</dd>
                                <dt class="col-sm-4" style="text-align: right">To Area : </dt>
                                <dd class="col-sm-8">{{$job->to_service_area != NUll ? $job->to_service_area->name : " -- " }}</dd>
                                @if($job->attachment != NULL)
                                    <dt class="col-sm-4" style="text-align: right">Attachment : </dt>
                                    <dd class="col-sm-8"><a class="btn btn-info btn-xs" target="_blank"  href="{{url('storage/app/'.$job->attachment)}}" >View Attachment</a></dd>
                                @endif
                                <dt class="col-sm-4" style="text-align: right">Remarks : </dt>
                                <dd class="col-sm-8">{{$job->remarks != NUll ? $job->remarks : " -- " }}</dd>

                                <dt class="col-sm-4" style="text-align: right">Job Status : </dt>
                                <dd class="col-sm-8">{{config('view.job_status')[$job->status]}}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    @if($job->status == 1 || $job->status == 2 )
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-text-width"></i>
                                Driver & Payment Details
                            </h3>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-4" style="text-align: right">Assign to : </dt>
                                <dd class="col-sm-8">{{$job->assign_to == 0 ? "AAA" : "Contractor"}}</dd>
                                @if($job->assign_to != 0)
                                    <dt class="col-sm-4" style="text-align: right">Contractor : </dt>
                                    <dd class="col-sm-8">{{$job->contractor == NULL ? "---" : $job->contractor->name}}</dd>
                                @else
                                    <dt class="col-sm-4" style="text-align: right">Vehicle Number : </dt>
                                    <dd class="col-sm-8">{{$job->vehicle == NULL ? "---" : $job->vehicle->vehicle_no}}</dd>
                                @endif
                                <dt class="col-sm-4" style="text-align: right">Driver : </dt>
                                <dd class="col-sm-8">{{$job->driver_name}}</dd>
                                <dt class="col-sm-4" style="text-align: right">Driver Number : </dt>
                                <dd class="col-sm-8">{{$job->driver_no}}</dd>
                                <dt class="col-sm-4" style="text-align: right">Amount : </dt>
                                <dd class="col-sm-8">{{number_format($job->amount , 3)}}</dd>
                                @if($job->assign_to == 0)
                                    <dt class="col-sm-4" style="text-align: right">AAA Charges : </dt>
                                    <dd class="col-sm-8">{{number_format($job->aaa_charges , 3)}}</dd>
                                @endif
                                @if($job->assign_to != 0)
                                <dt class="col-sm-4" style="text-align: right">Contractor Amount : </dt>
                                <dd class="col-sm-8">{{number_format($job->contractor_amount , 3)}}</dd>

                                @endif
                                @if($job->amount > 0)
                                <dt class="col-sm-4" style="text-align: right">Receipt Number : </dt>
                                <dd class="col-sm-8">  {{$job->receipt_no}}</dd>
                                @endif
                                @if($job->payment_status != 0)
                                <dt class="col-sm-4" style="text-align: right">Batch Number : </dt>
                                <dd class="col-sm-8">{{$job->batch_no}}</dd>
                                <dt class="col-sm-4" style="text-align: right">Invoice Number : </dt>
                                <dd class="col-sm-8">{{$job->contractor_invoice}}</dd>
                                <dt class="col-sm-4" style="text-align: right">Invoice Date : </dt>
                                <dd class="col-sm-8">{{display_date($job->contractor_invoice_date)}}</dd>
                                @endif
                                @if($job->payment_status != 0)
                                    <dt class="col-sm-4" style="text-align: right">Cheque No. : </dt>
                                    <dd class="col-sm-8">{{$job->cheque_no}}</dd>
                                    <dt class="col-sm-4" style="text-align: right">Payment Date : </dt>
                                    <dd class="col-sm-8">{{display_date($job->cheque_date)}}</dd>
                                @endif

                                <dt class="col-sm-4" style="text-align: right">Payment Status : </dt>
                                <dd class="col-sm-8">{{config('view.payment_status')[$job->payment_status]}}</dd>
                            </dl>
                        </div>
                    </div>
                    @endif
                    @if($job->status == 3 || $job->status == 4 )
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-text-width"></i>
                                {{$job->status == 4 ? "Not Done Details" : "Cancell Details"}}
                            </h3>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                @if($job->status == 4)
                                    <dt class="col-sm-4" style="text-align: right">Not Done By : </dt>
                                    <dd class="col-sm-8">{{\App\User::find($job->not_done_by)->name}}</dd>
                                    {{--<dd class="col-sm-8">{{$job->not_done_by}}</dd>--}}
                                    <dt class="col-sm-4" style="text-align: right">Not Done Reason : </dt>
                                    <dd class="col-sm-8">{{$job->not_done_reason}}</dd>
                                @else
                                    <dt class="col-sm-4" style="text-align: right">Cancelled By: </dt>
                                    <dd class="col-sm-8">{{\App\User::find($job->cancelled_by)->name}}</dd>
                                    <dt class="col-sm-4" style="text-align: right">Cancell Reason : </dt>
                                    <dd class="col-sm-8">{{$job->cancelled_reason}}</dd>
                                @endif
                            </dl>
                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </section>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            $(".select2").select2();
            $(".select3").select2({
                ajax: {
                    url: function (params) {
                        return "{{url('get_members')}}/" + params.term;
                    },
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: data.items
                        };
                    }
                }
            });
        })
        get_member_details();
        function get_member_details() {
            var member_id = $('#member_id').val();
            if (member_id != ""){
                $.ajax({
                    type: "GET",
                    url: '{{ url('get_member_details') }}'+ '/' + member_id,
                    success: function (data) {
                        console.log(data);
                        $("#chassis_no").val(data.chassis_no);
                        $("#customer_name").val(data.customer_name);
                        $("#engine_no").val(data.engine_no);
                        $("#member_name").val(data.member_name);
                        $("#member_expiry_date").val(data.member_expiry_date);
                        $("#member_number").val(data.member_number);
                        $("#vehicle_number").val(data.vehicle_number);
//                    $("#zone_div").html('<input type="hidden" name="zone_id" id="zone_id" value="'+data+'">');
                    }
                });
            }
        }
    </script>
@endsection