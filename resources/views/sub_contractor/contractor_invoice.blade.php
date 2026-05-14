@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Contractor Invoices</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Contractor Invoices</li>
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
                                        <form action="{{route('contractorInvoice')}}" method="post">
                                            {{ csrf_field() }}
                                            <div class="form-group row">
                                                <label for="contractor_id" class="col-sm-2 col-form-label" style="text-align: right">Contractor : </label>
                                                <div class="col-8">
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
                                    <div class="col-2">
                                        <a onclick="save_batch()" class="btn btn-primary">Save Batch</a>
                                    </div>
                                </div>
                            </div>
                            @if(count($jobs) > 0)
                                <form action="{{url('saveContractorInvoice')}}" method="post" id="save_batch">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="contractor_id" id="contractor_id"
                                           value="{{old('contractor_id')?old('contractor_id') : $contractor_id}}">
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Job ID</th>
                                                <th>Vehicle No.</th>
                                                <th>Member No.</th>
                                                <th>From Area</th>
                                                <th>To Area</th>
                                                <th>Contractor Amount</th>
                                                <th>Invoice No.</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($jobs as $job)
                                                    <tr>
                                                        <td>{{$job->id}}</td>
                                                        <td>{{$job->vehicle_no}}</td>
                                                        <td>{{$job->member_number}}</td>
                                                        <td>{{$job->from_service_area->name}}</td>
                                                        <td>{{$job->to_service_area->name}}</td>
                                                        <td>
                                                            <input class="form-control" type="number" style="width: 150px"
                                                                   name="contractor_amount_{{$job->id}}"
                                                                   value="{{isset($data['contractor_amount_'.$job->id]) ? $data['contractor_amount_'.$job->id] : $job->contractor_amount}}">
                                                        </td>
                                                        <td><input class="form-control" type="text" style="width: 150px"
                                                                   name="invoice_no_{{$job->id}}" value="{{isset($data['invoice_no_'.$job->id]) ? $data['invoice_no_'.$job->id] : ""}}"> </td>
                                                        <td><input class="form-control" type="date" style="width: 150px"
                                                                   name="invoice_date_{{$job->id}}" value="{{isset($data['invoice_date_'.$job->id]) ? $data['invoice_date_'.$job->id] : ""}}"></td>
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
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "ordering": true,
                "searching": true,
                "bPaginate": false
            });
//            $('#example2').DataTable({
//                "paging": true,
//                "lengthChange": false,
//                "searching": false,
//                "ordering": false,
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

