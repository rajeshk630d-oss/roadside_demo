@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Batch</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/batch')}}">Batches</a></li>
                            <li class="breadcrumb-item active">Edit Batch</li>
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
                                                <label for="contractor_id" class="col-sm-6 col-form-label" style="text-align: left">
                                                    {{$contractor->name}} </label>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-2">
                                        <a onclick="save_batch()" class="btn btn-primary">Save Batch</a>
                                    </div>
                                </div>
                            </div>
                            @if(count($jobs) > 0)
                                <form action="{{route('batch.update' , $batch_no)}}" method="post" id="save_batch">
                                    {{csrf_field()}}
                                    <input type="hidden" name="_method" value="PATCH">
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
                                                               name="invoice_no_{{$job->id}}" value="{{isset($data['invoice_no_'.$job->id]) ? $data['invoice_no_'.$job->id] : $job->contractor_invoice}}"> </td>
                                                    <td><input class="form-control" type="date" style="width: 150px"
                                                               name="invoice_date_{{$job->id}}" value="{{isset($data['invoice_date_'.$job->id]) ? $data['invoice_date_'.$job->id] : $job->contractor_invoice_date}}"></td>
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
                "ordering": false,
                "searching": true,
                "bPaginate": false
            });
        });
        function save_batch(){
            $('#save_batch').submit();
        }
    </script>
@endsection

