@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Invoice</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Invoice</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="callout callout-info">
                            <h5><i class="fas fa-info"></i> Note:</h5>
                            This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
                        </div>


                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <?php $company = get_company(); ?>
                                            <img src="{{asset('storage/app/'.get_company()->logo)}}"
                                                 class="brand-image img-circle elevation-3"
                                                 style="opacity: .8;height: 40px;width: 40px"> {{ $company->name }}
                                        <small class="float-right">
                                            Date: {{ \Carbon\Carbon::parse($job->date)->format('d-m-Y') }}
                                        </small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-3 invoice-col">
                                    From
                                    <address>
                                        <strong>{{$company->name }}</strong><br>
                                        795 Folsom Ave, Suite 600<br>
                                        San Francisco, CA 94107<br>
                                        Phone: (804) 123-5432<br>
                                        Email: info@almasaeedstudio.com
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 invoice-col">
                                    To
                                    <address>
                                        <strong>{{ $job->customer_name }}</strong><br>
                                        795 Folsom Ave, Suite 600<br>
                                        San Francisco, CA 94107<br>
                                        Phone: (555) 539-1037<br>
                                        Email: john.doe@example.com
                                    </address>
                                </div>
                                <div class="col-6">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th style="width:50%">Vehicle :</th>
                                                <td>{{ $job->vehicle_no ?? "---" }}</td>
                                            </tr>
                                            <tr>
                                                <th style="width:50%">Amount :</th>
                                                <td>{{ number_format($job->amount , 3) }}</td>
                                            </tr>
                                            @if($job->assign_to == 1)
                                            <tr>
                                                <th>Contractor Amount</th>
                                                <td>{{ number_format($job->contractor_amount , 3) }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <th>Shipping:</th>
                                                <td>$5.80</td>
                                            </tr>
                                            <tr>
                                                <th>Total:</th>
                                                <td>$265.24</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row no-print">
                                <div class="col-12">
                                    <a href="{{route('print_job_invoice' , $job->id)}}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                                </div>
                            </div>
                        </div>
                    </div>
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