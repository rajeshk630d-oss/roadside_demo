@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Contractor wise Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('reports')}}">Reports</a></li>
                            <li class="breadcrumb-item active">Contractor wise Report</li>
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
                                <form action="{{route('viewContractorJobReport')}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group row">
                                        <label for="contractor_id" class="col-sm-2 col-form-label" style="text-align: right">Contractor : </label>
                                        <div class="col-5">
                                            <select class="select2" name="contractor_id" id="contractor_id" style="width: 100%;"
                                                    data-placeholder="Select Contractor" >
                                                <option value="0" >  -- All Contractors --  </option>
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
                                        <label for="from_date" class="col-sm-2 col-form-label" style="text-align: right">From Date : </label>
                                        <div class="col-3">
                                            <input type="date" id="from_date" name="from_date" class="form-control" required
                                                   value="{{\Carbon\Carbon::now()->format('Y-m-d')}}"
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="to_date" class="col-sm-2 col-form-label" style="text-align: right">To Date : </label>
                                        <div class="col-3">
                                            <input type="date" id="to_date" name="to_date" class="form-control" required
                                                   value="{{\Carbon\Carbon::now()->format('Y-m-d')}}"
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="type_id" class="col-sm-2 col-form-label" style="text-align: right">Type : </label>
                                        <div class="col-3">
                                            <select class="select2" name="type_id" id="type_id" style="width: 100%;" >
                                                <option value="1" <?php if(old('type_id') == 1 ){echo "SELECTED";} ?>>All Jobs</option>
                                                <option value="2" <?php if(old('type_id') == 2 ){echo "SELECTED";} ?>>With Out Invoice</option>
                                                <option value="3" <?php if(old('type_id') == 3 ){echo "SELECTED";} ?>>With Invoice but no Cheque</option>
                                                <option value="4" <?php if(old('type_id') == 4 ){echo "SELECTED";} ?>>With Cheque</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-2"></div>
                                        <div class="col-1">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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

