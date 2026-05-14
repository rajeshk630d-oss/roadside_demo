@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Contractor Inquiry</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Contractor Inquiry</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-10">
                                        <form action="{{route('contractorInquiry')}}" method="post">
                                            {{ csrf_field() }}
                                            <div class="form-group row">
                                                <label for="contractor_id" class="col-sm-2 col-form-label" style="text-align: right">Contractor : </label>
                                                <div class="col-6">
                                                    <select class="select2" name="contractor_id" id="contractor_id"
                                                            data-placeholder="Select Contractor" style="width: 100%;">
                                                        <option value="">Select Contractor</option>
                                                    @foreach($contractors as $contractor)
                                                            <option value="{{$contractor->id}}" <?php if($contractor_id == $contractor->id) {echo "selected";}?>>{{$contractor->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-sm-2">
                                                    <button type="submit" class="btn btn-primary">Search</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if(count($jobs) > 0)
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Job ID</th>
                                            <th>Vehicle No.</th>
                                            <th>Member No.</th>
                                            <th>Customer</th>
                                            <th>From Area</th>
                                            {{--<th>To Area</th>--}}
                                            <th>Contractor</th>
                                            <th>Driver</th>
                                            <th>Driver Number</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Receipt No.</th>
                                            <th>Service</th>
                                            <th>Contractor Amount</th>
                                            <th>Invoice No</th>
                                            <th>Invoice Date</th>
                                            <th>Batch No.</th>
                                            <th>Cheq. No.</th>
                                            <th>Cheq. Date</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($jobs as $job)
                                                <tr>
                                                    <td><a href="{{ route('job.show', $job->id) }}">{{$job->id}}</a></td>
                                                    <td>{{$job->vehicle_no}}</td>
                                                    <td>{{$job->member_number}}</td>
                                                    <td>{{$job->customer_name}}</td>
                                                    <td>{{$job->from_service_area->name}}</td>
                                                    {{--<td>{{$job->to_service_area->name}}</td>--}}
                                                    <td>{{isset($job->contractor) ? $job->contractor->name : ""}}</td>
                                                    <td>{{$job->driver_name}}</td>
                                                    <td>{{$job->driver_no}}</td>
                                                    <td>{{config('view.job_types')[$job->is_credit_cash]}}</td>
                                                    <td>{{$job->amount == 0 ? "" : $job->amount}}</td>
                                                    <td>{{$job->receipt_no}}</td>
                                                    <td>{{$job->service->name}}</td>
                                                    <td>{{$job->contractor_amount}}</td>
                                                    <td>{{$job->contractor_invoice}}</td>
                                                    <td>{{display_date($job->contractor_invoice_date)}}</td>
                                                    <td>{{$job->batch_no}}</td>
                                                    <td>{{$job->cheque_no}}</td>
                                                    <td>{{display_date($job->cheque_date)}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="{{asset('public/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('public/plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('public/plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('public/plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true
            });
        });
        $('.select2').select2()
        function save_batch(){
//            alert("hi");
            $('#save_batch').submit();
        }
    </script>
@endsection

