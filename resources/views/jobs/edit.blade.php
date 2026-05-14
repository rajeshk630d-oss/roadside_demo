@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Job # {{$job->id}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('job.index')}}">Jobs</a></li>
                            <li class="breadcrumb-item active">Update Job</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form action="{{route('job.update' , $job->id)}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PATCH">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
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
                                        Job Type *
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="job_type_member" name="is_credit_cash" value="0"
                                                   onchange="change_job_type(0)"
                                            <?php
                                                if($job->is_credit_cash == 0 ) {
                                                    echo "checked";
                                                }
                                                ?>
                                            >
                                            <label for="job_type_member">
                                                Member
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="job_type_cash" name="is_credit_cash" value="1"
                                                   onchange="change_job_type(1)"
                                            <?php if($job->is_credit_cash == "1" ) {echo "checked";} ?>
                                            >
                                            <label for="job_type_cash">
                                                Cash
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="job_type_credit" name="is_credit_cash" value="2"
                                                   onchange="change_job_type(2)"
                                            <?php if($job->is_credit_cash == "2") {echo "checked";} ?>
                                            >
                                            <label for="job_type_credit">
                                                Credit
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="search_member_customer" class="col-sm-2 col-form-label" style="text-align: right">Search Member/customer</label>
                                    <div class="col-sm-10">
                                        <select class="select3" name="search_member_customer" id="search_member_customer" onchange="get_member_details()"
                                                data-placeholder="Search member or customer by member no or member name or customer name or vehicle no"
                                                style="width: 100%;">
                                            <option value="" >-- Enter Membership Number --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="date" class="col-sm-2 col-form-label" style="text-align: right">
                                        Date *
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" name="date" id="date" placeholder="Job Date"
                                               value="{{$job->date}}">
                                    </div>
                                    <input type="hidden" name="member_id" id="member_id" value="{{$job->member_id}}">
                                    <input type="hidden" name="customer_id2" id="customer_id2" value="{{$job->customer_id}}">

                                    <label for="customer_id" class="col-sm-2 col-form-label" style="text-align: right">
                                        Customer *{{old('customer_id')}}
                                    </label>
                                    <div class="col-sm-4">
                                        <select class="select2" name="customer_id" id="customer_id" style="width: 100%;"
                                                data-placeholder="Select Customer" onchange="change_customer_id()">
                                            <option value="" >  -- Enter Service Required --  </option>
                                            @foreach($customers as $customer)
                                                <?php
                                                $select = "";
                                                if($customer->id == $job->customer_id){
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
                                    <label for="member_number" class="col-sm-2 col-form-label" style="text-align: right">
                                        Member Number *
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="member_number" id="member_number"
                                               placeholder="Enter Member Number" value="{{$job->member_number}}">
                                    </div>
                                    <label for="member_name" class="col-sm-2 col-form-label" style="text-align: right">
                                        Member Name *
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="member_name" id="member_name"
                                               placeholder="Enter Member Name" value="{{$job->member_name}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="vehicle_number" class="col-sm-2 col-form-label" style="text-align: right">
                                        Vehicle Number
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="vehicle_number" id="vehicle_number"
                                               placeholder="Enter Vehicle Number" value="{{$job->vehicle_no}}">
                                    </div>
                                    <label for="member_expiry_date" class="col-sm-2 col-form-label" style="text-align: right">
                                        Member Expiry Date *
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" name="member_expiry_date" id="member_expiry_date"
                                               placeholder="Enter Member Expiry Date" value="{{$job->member_expiry_date}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="chassis_no" class="col-sm-2 col-form-label" style="text-align: right">
                                        Chassis Number
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="chassis_no" id="chassis_no"
                                               placeholder="Enter Chassis Number" value="{{$job->chassis_no}}">
                                    </div>
                                    <label for="engine_no" class="col-sm-2 col-form-label" style="text-align: right">
                                        Engine Number
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="engine_no" id="engine_no"
                                               placeholder="Enter Engine Number" value="{{$job->engine_no}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="service_master_id" class="col-sm-2 col-form-label" style="text-align: right">
                                        Service Required *
                                    </label>
                                    <div class="col-sm-4">
                                        <select class="select2" name="service_master_id" id="service_master_id" style="width: 100%;"
                                                onchange="display_customer_history()">
                                            <option value="" >  -- Enter Service Required --  </option>
                                            @foreach($services as $service)
                                                <?php
                                                $select = "";
                                                if($service->id == $job->service_master_id){
                                                    $select = "SELECTED";
                                                }
                                                ?>
                                                <option value="{{$service->id}}" {{$select}} >
                                                    {{$service->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="amount" class="col-sm-2 col-form-label" style="text-align: right">
                                        Amount
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control" name="amount" id="amount" step="0.001"
                                               placeholder="Enter Amount " value="{{$job->amount}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="from_area" class="col-sm-2 col-form-label" style="text-align: right">
                                        From Area *
                                    </label>
                                    <div class="col-sm-4">
                                        <select class="select2" name="from_area" id="from_area" style="width: 100%;">
                                            <option value="" >  -- Enter from Area --  </option>
                                            @foreach($areas as $area)
                                                <?php
                                                $select = "";
                                                if($area->id == $job->from_area){
                                                    $select = "SELECTED";
                                                }
                                                ?>
                                                <option value="{{$area->id}}" {{$select}} >
                                                    {{$area->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="to_area" class="col-sm-2 col-form-label" style="text-align: right">
                                        To Area *
                                    </label>
                                    <div class="col-sm-4">
                                        <select class="select2" name="to_area" id="to_area" style="width: 100%;">
                                            <option value="" >  -- Enter To Area --  </option>
                                            @foreach($areas as $area)
                                                <?php
                                                $select = "";
                                                if($area->id == $job->to_area){
                                                    $select = "SELECTED";
                                                }
                                                ?>
                                                <option value="{{$area->id}}" {{$select}} >
                                                    {{$area->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="remarks" class="col-sm-2 col-form-label" style="text-align: right">
                                        Remarks
                                    </label>
                                    <div class="col-sm-4">
                                        <textarea id="remarks" name="remarks" class="form-control"
                                                  placeholder="Enter Remarks">{{$job->remarks}}</textarea>
                                    </div>
                                    <label for="attachment" class="col-sm-2 col-form-label" style="text-align: right">
                                        Attachment
                                    </label>
                                    <div class="col-sm-4">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="attachment" name="attachment">
                                            <label class="custom-file-label" for="attachment">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Driver & Invoice Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label" style="text-align: right">
                                        Assign To *
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="assign_to_aaa" name="assign_to" value="0" onclick="display_form()"
                                            <?php if($job->assign_to == NULL || $job->assign_to == 0){ echo "checked"; }?>
                                            >
                                            <label for="assign_to_aaa">
                                                AAA
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="assign_to_contractor" name="assign_to" value="1" onclick="display_form()"
                                            <?php if($job->assign_to == 1){ echo "checked"; }?> >
                                            <label for="assign_to_contractor" >
                                                Contractor
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div id="aaa_div">
                                    <div class="form-group row">
                                        <label for="vehicle_id" class="col-sm-2 col-form-label" style="text-align: right">Vehicles</label>
                                        <div class="col-sm-10">
                                            <select class="select2" name="vehicle_id" id="vehicle_id" style="width: 100%;">
                                                <option value="" >  -- Select Vehicle number --  </option>
                                                @foreach($vehicles as $vehicle)
                                                    <?php
                                                    $select = "";
                                                    if($vehicle->id == $job->vehicle_id){
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
                                        <label for="driver_id" class="col-sm-2 col-form-label" style="text-align: right">Driver * </label>
                                        <div class="col-sm-10">
                                            <select class="select2" name="driver_id" id="driver_id" style="width: 100%;" onchange="get_driver()">
                                                <option value="" >  -- Select Driver --  </option>
                                                @foreach($drivers as $driver)
                                                    <?php
                                                    $select = "";
                                                    if($driver->id == $job->driver_id){
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
                                        <label for="contractor_id" class="col-sm-2 col-form-label" style="text-align: right">Contractors</label>
                                        <div class="col-sm-10">
                                            <select class="select2" name="contractor_id" id="contractor_id" style="width: 100%;">
                                                <option value="" >  -- Select Contractor --  </option>
                                                @foreach($contractors as $contractor)
                                                    <?php
                                                    $select = "";
                                                    if($contractor->id == $job->contractor_id){
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
                                        <label for="driver_name" class="col-sm-2 col-form-label" style="text-align: right">Driver Name *</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="driver_name" id="driver_name"
                                                   placeholder="Enter driver name" value="{{$job->driver_name}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="driver_no" class="col-sm-2 col-form-label" style="text-align: right">Driver Number *</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="driver_no" id="driver_no"
                                               placeholder="Enter driver phone number" value="{{$job->driver_no}}">
                                    </div>
                                </div>
                                <div class="form-group row" id = "contractor_amount_div">
                                    <label for="contractor_amount" class="col-sm-2 col-form-label" style="text-align: right">Contractor Amount </label>
                                    <div class="col-sm-10">
                                        <input type="number" step="0.001" class="form-control" name="contractor_amount" id="contractor_amount"
                                               placeholder="Enter Contractor Amount" value="{{$job->contractor_amount}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="receipt_no" class="col-sm-2 col-form-label" style="text-align: right">Receipt Number <?php if($job->is_credit_cash == 1) {echo "*";} ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="receipt_no" id="receipt_no"
                                               placeholder="Enter Receipt Number" value="{{$job->receipt_no}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="status" class="col-sm-2 col-form-label" style="text-align: right">Status</label>
                                    <div class="col-sm-10">
                                        <select class="select2" name="status" id="status" style="width: 100%;" onchange="display_reasons()">
                                            @foreach(config('view.job_status') as $key => $value)
                                                <?php
                                                $select = "";
                                                if($key == $job->status)
                                                    $select = "SELECTED";
                                                ?>
                                                <option value="{{$key}}" {{$select}}>{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row" id="cancel_reason_div">
                                    <label for="cancelled_reason" class="col-sm-2 col-form-label" style="text-align: right">Cancel Reason </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="cancelled_reason" id="cancelled_reason"
                                               placeholder="Enter Cancell reason" value="{{$job->cancelled_reason}}">
                                    </div>
                                </div>
                                <div class="form-group row" id="not_done_reason_div">
                                    <label for="not_done_reason" class="col-sm-2 col-form-label" style="text-align: right">Not Done Reason </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="not_done_reason" id="not_done_reason"
                                               placeholder="Enter Not Done reason" value="{{$job->not_done_reason}}">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="{{route('job.index')}}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Update Job" class="btn btn-success float-right">
                    </div>
                </div>
                <br>
            </form>
        </section>

        <div class="modal fade" id="modal-customer_history">
            <div class="modal-dialog modal-xl" id="div_customer_history">

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            $(".select2").select2();
            $(".select3").select2({
                ajax: {
                    url: '{{ url('get_members') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search : params.term, // search term
                            is_cash_credit : $("input[name=is_credit_cash]:checked").val(), // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Search for a customer or member',
                minimumInputLength: 3,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });
        });
        function formatRepo (repo) {
            if (repo.loading) {
                return repo.text;
            }

            var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'><i class='fa fa-user'></i> </div>" +
                "<div class='select2-result-repository__description'><i class='fa fa-user'></i> </div>" +
                "<div class='select2-result-repository__statistics'>" +
                "<div class='select2-result-repository__forks'><i class='fa fa-car'></i> </div>" +
                "<div class='select2-result-repository__stargazers'><i class='fa fa-user'></i> </div>" +
                "</div>" +
                "</div>" +
                "</div>"
            );

            var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'><i class='fa fa-user'></i> </div>" +
                "</div>" +
                "</div>"
            );

            $container.find(".select2-result-repository__title").append("Member : " + repo.member_name + ' ( '+repo.member_no + ' ) '+ ' | ' + "Vehicle No : " + repo.vehicle_no + ' | ' + "Customer : " + repo.customer_name);
//            $container.find(".select2-result-repository__description").append("Member :" + repo.member_name);
//            $container.find(".select2-result-repository__forks").append("Vehicle No : " + repo.vehicle_no);
//            $container.find(".select2-result-repository__stargazers").append("Customer : " + repo.customer_name);
            return $container;
        }
        function formatRepoSelection (repo) {
            return repo.full_name || repo.text;
        }
        function get_member_details() {
            var search_member_customer = $('#search_member_customer').val();
            if (search_member_customer != ""){
                $.ajax({
                    type: "GET",
                    url: '{{ url('get_member_details') }}'+ '/' + search_member_customer,
                    success: function (data) {
//                        console.log(data);

                        $("#chassis_no").val(data.chassis_no);
                        $("#customer_name").val(data.customer_name);
                        $("#engine_no").val(data.engine_no);
                        $("#member_name").val(data.member_name);
                        $("#member_expiry_date").val(data.member_expiry_date);
                        $("#member_number").val(data.member_number);
                        $("#vehicle_number").val(data.vehicle_number);
                        $("#customer_id").val(data.customer_id).change();
                        $("#member_id").val(data.member_id);
                        $("#customer_id2").val(data.customer_id);
                        var job_type = $("input[name=is_credit_cash]:checked").val();
                        if(job_type == 0) {
                            if (data.customer_id != "") {
                                $('#customer_id').prop("disabled", true);
                            }
                            if (data.member_id != "") {
                                $("#member_name").attr('readonly', 'readonly');
                                $("#member_number").attr('readonly', 'readonly');
                            } else {
                                $("#member_name").removeAttr('readonly');
                                $("#member_number").removeAttr('readonly');
                            }
                        }
                    }
                });
            }
        }
        function display_customer_history(){
            var customer_id = $("#customer_id").val();
            var member_no = $("#member_number").val();
            var service_id = $("#service_master_id").val();

            $.ajax({
                type: "POST",
                url: '{{ url('get_customer_history_popup') }}',
                data:{_token:'{{ csrf_token() }}', customer_id:customer_id, member_no:member_no, service_id:service_id},
                success: function (data) {
                    console.log(data);
                    $('#div_customer_history').html(data)
                    $('#modal-customer_history').modal('show');
                }
            });
        }
        function change_customer_id(){
            var customer_id = $("#customer_id").val();
            $("#customer_id2").val(customer_id);
        }
        function change_job_type(){
            return "";
            var job_type = $("input[name=is_credit_cash]:checked").val();
            $("#chassis_no").val("");
            $("#customer_name").val("");
            $("#engine_no").val("");
            $("#member_name").val("");
            $("#member_expiry_date").val("");
            $("#member_number").val("");
            $("#vehicle_number").val("");
            $("#customer_id").val("").change();
            $("#search_member_customer").val("").change();
            $("#member_id").val("");

            if(job_type == 0){
//                $('#customer_id').prop("disabled", true);
//                $('#member_name').attr("readonly", true);
//                $('#member_number').attr("readonly", true);
            }else{
                $('#customer_id').prop("disabled", false);
                $('#member_name').attr("readonly", false);
                $('#member_number').attr("readonly", false);
            }
        }
        display_form();
        function display_form(){
            var val = $('[name="assign_to"]:checked').val();
            if(val == 0){
                $('#aaa_div').show();
                $('#contractor_div').hide();
                $('#contractor_amount_div').hide();
            }else{
                $('#aaa_div').hide();
                $('#contractor_div').show();
                $('#contractor_amount_div').show();
            }
        }
        display_reasons();
        function display_reasons(){
            var val = $('#status').val();
            if(val == 3 || val == 4){
                if(val == 3){
                    $('#cancel_reason_div').show();
                    $('#not_done_reason_div').hide();
                }else{
                    $('#cancel_reason_div').hide();
                    $('#not_done_reason_div').show();
                }
            }else{
                $('#cancel_reason_div').hide();
                $('#not_done_reason_div').hide();
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