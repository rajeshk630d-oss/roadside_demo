@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Contractor Payments</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Contractor Payments</li>
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
                                <form action="{{route('contractorPayment')}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group row">

                                        <label for="batch_no" class="col-sm-2 col-form-label" style="text-align: right">Batch : </label>
                                        <div class="col-4">
                                            <select class="select2" name="batch_no" id="batch_no" style="width: 100%;"
                                                    data-placeholder="Select Batch" >
                                                <option value="" >  -- Enter Service Required --  </option>
                                                @foreach($batches as $batch)
                                                    <?php
                                                    $batch_no = old('batch_no') ? old('batch_no') : $batch_no;
                                                    $select = "";
                                                    if($batch->batch_no == $batch_no){
                                                        $select = "SELECTED";
                                                    }
                                                    ?>
                                                    <option value="{{$batch->batch_no}}" {{$select}} >
                                                        {{$batch->batch_no." ( ".$batch->name." ) "}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @if(count($jobs) > 0)
                                <form action="{{url('saveContractorPayment')}}" method="post" id="save_batch">
                                    {{ csrf_field() }}

                                    <input type="hidden" name="batch_no" id="batch_no"
                                           value="{{old('batch_no') ? old('batch_no') : $batch_no}}">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="cheque_no" class="col-sm-2 col-form-label" style="text-align: right">Cheque No. </label>
                                            <div class="col-3">
                                                <input class="form-control" type="text" required
                                                       name="cheque_no" id="cheque_no"
                                                       value="{{isset($data['cheque_no']) ? $data['cheque_no'] : ""}}">
                                            </div>
                                            <label for="cheque_date" class="col-sm-2 col-form-label" style="text-align: right">Cheque Date : </label>
                                            <div class="col-3">
                                                <input class="form-control" type="date"  required
                                                       name="cheque_date"
                                                       value="{{isset($data['cheque_date']) ? $data['cheque_date'] : ""}}">
                                            </div>
                                            <div class="col-sm-2">
                                                <button  type="submit" class="btn btn-primary">Make Payment</button>
                                            </div>
                                        </div>
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Job ID</th>
                                                {{--<th>Customer</th>--}}
                                                <th>Vehicle No.</th>
                                                <th>Member No.</th>
                                                <th>From Area</th>
                                                <th>To Area</th>
                                                <th>Contractor Amount</th>
                                                <th>Invoice No.</th>
                                                <th>Batch No.</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($jobs as $job)
                                                    <tr>
                                                        <td>{{$job->id}}</td>
{{--                                                        <td>{{$job->customer_name}}</td>--}}

                                                        <td>{{$job->vehicle_no}}</td>
                                                        <td>{{$job->member_number}}</td>
                                                        <td>{{$job->from_service_area->name}}</td>
                                                        <td>{{$job->to_service_area->name}}</td>
                                                        <td>{{$job->contractor_amount}}</td>
                                                        <td>{{$job->contractor_invoice}}</td>
                                                        <td>{{$job->batch_no}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
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
//            $("#example1").DataTable({
//                "responsive": true, "lengthChange": false, "autoWidth": false,
//                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
//            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
//            $('#example2').DataTable({
//                "paging": true,
//                "lengthChange": false,
//                "searching": false,
//                "ordering": true,
//                "info": true,
//                "autoWidth": false,
//                "responsive": true
//            });
        });
        $('.select2').select2()
        function save_batch(){
//            alert("hi");
            $('#save_batch').submit();
        }
    </script>
@endsection

