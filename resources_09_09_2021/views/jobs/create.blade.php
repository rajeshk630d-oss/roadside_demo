@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Job</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('job.index')}}">Jobs</a></li>
                            <li class="breadcrumb-item active">Add Job</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form action="{{route('job.store')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}

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
                                            <?php if(old('is_credit_cash') == 0 || old('is_credit_cash') == NULL) {echo "checked";} ?>
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
                                            <?php if(old('is_credit_cash') == "1" ) {echo "checked";} ?>
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
                                            <?php if(old('is_credit_cash') == "2") {echo "checked";} ?>
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
                                        <input type="date" class="form-control" name="date" id="date" placeholder="Job Date" readonly
                                               value="{{old('date') == NULL ? \Carbon\Carbon::now()->format('Y-m-d') : old('date')}}">
                                    </div>
                                    <input type="hidden" name="member_id" id="member_id" value="{{old('member_id')}}">
                                    <input type="hidden" name="customer_id2" id="customer_id2" value="{{old('customer_id2')}}">

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
                                </div>
                                <div class="form-group row">
                                    <label for="member_number" class="col-sm-2 col-form-label" style="text-align: right">
                                        Member Number *
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="member_number" id="member_number"
                                               placeholder="Enter Member Number" value="{{old('member_number')}}">
                                    </div>
                                    <label for="member_name" class="col-sm-2 col-form-label" style="text-align: right">
                                        Member Name *
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="member_name" id="member_name"
                                               placeholder="Enter Member Name" value="{{old('member_name')}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="member_mobile" class="col-sm-2 col-form-label" style="text-align: right">
                                        Mobile Number
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="member_mobile" id="member_mobile"
                                               placeholder="Enter member mobile number" value="{{old('member_mobile')}}">
                                    </div>
                                    <label for="vehicle_number" class="col-sm-2 col-form-label" style="text-align: right">
                                        Vehicle Number
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="vehicle_number" id="vehicle_number"
                                               placeholder="Enter Vehicle Number" value="{{old('vehicle_number')}}">
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="member_expiry_date" class="col-sm-2 col-form-label" style="text-align: right">
                                        Member Expiry Date
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" name="member_expiry_date" id="member_expiry_date"
                                               placeholder="Enter Member Expiry Date" value="{{old('member_expiry_date')}}">
                                    </div>
                                    <label for="chassis_no" class="col-sm-2 col-form-label" style="text-align: right">
                                        Chassis Number
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="chassis_no" id="chassis_no"
                                               placeholder="Enter Chassis Number" value="{{old('chassis_no')}}">
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="engine_no" class="col-sm-2 col-form-label" style="text-align: right">
                                        Engine Number
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="engine_no" id="engine_no"
                                               placeholder="Enter Engine Number" value="{{old('engine_no')}}">
                                    </div>
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
                                    <label for="from_area" class="col-sm-2 col-form-label" style="text-align: right">
                                        From Area *
                                    </label>
                                    <div class="col-sm-4">
                                        <select class="select2" name="from_area" id="from_area" style="width: 100%;">
                                            <option value="" >  -- Enter from Area --  </option>
                                            @foreach($areas as $area)
                                                <?php
                                                $select = "";
                                                if($area->id == old('from_area')){
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
                                                if($area->id == old('to_area')){
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
                                    <label for="amount" class="col-sm-2 col-form-label" style="text-align: right">
                                        Amount
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control" name="amount" id="amount" step="0.001"
                                               placeholder="Enter Amount " value="{{old('amount')}}">
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
                                <div class="form-group row">
                                    <label for="remarks" class="col-sm-2 col-form-label" style="text-align: right">
                                        Remarks
                                    </label>
                                    <div class="col-sm-4">
                                        <textarea id="remarks" name="remarks" class="form-control"
                                                  placeholder="Enter Remarks">{{old('remarks')}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="{{route('job.index')}}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Create Job" class="btn btn-success float-right">
                    </div>
                </div>
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
            var job_type = $("input[name=is_credit_cash]:checked").val();
            if(job_type == 0){
//                $('#customer_id').prop("disabled", true);
//                $('#member_name').attr("readonly", true);
//                $('#member_number').attr("readonly", true);
            }
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

                        $("#chassis_no").val(data.chassis_no);
                        $("#customer_name").val(data.customer_name);
                        $("#engine_no").val(data.engine_no);
                        $("#member_name").val(data.member_name);
                        $("#member_expiry_date").val(data.member_expiry_date);
                        $("#member_number").val(data.member_number);
                        $("#member_mobile").val(data.member_mobile);
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
//                                $("#member_name").attr('readonly', 'readonly');
                                $("#member_number").attr('readonly', 'readonly');
                            } else {
                                $("#member_name").removeAttr('readonly');
                                $("#member_number").removeAttr('readonly');
                            }
                        }
                        display_customer_history();
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
    </script>
@endsection