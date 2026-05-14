@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>AAA Driver Wise Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('reports')}}">Reports</a></li>
                            <li class="breadcrumb-item active">AAA Driver Wise Report</li>
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
                                <form action="{{route('viewAAADriverJobReport')}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group row">
                                        <label for="driver_id" class="col-sm-2 col-form-label" style="text-align: right">Driver : </label>
                                        <div class="col-5">
                                            <select class="select2" name="driver_id" id="driver_id" style="width: 100%;"
                                                    data-placeholder="Select Vehicle" >
                                                <option value="0" >  -- All Drivers --  </option>
                                                @foreach($drivers as $driver)
                                                    <?php
                                                    $select = "";
                                                    if($driver->id == old('driver_id')){
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
                                    <div class="form-group row">
                                        <label for="from_date" class="col-sm-2 col-form-label" style="text-align: right">From Date : </label>
                                        <div class="col-3">
                                            <input type="datetime-local" id="from_date" name="from_date" class="form-control" required
                                                   value="{{\Carbon\Carbon::now()->format('Y-m-d 00:00:00')}}"
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="to_date" class="col-sm-2 col-form-label" style="text-align: right">To Date : </label>
                                        <div class="col-3">
                                            <input type="datetime-local" id="to_date" name="to_date" class="form-control" required
                                                   value="{{\Carbon\Carbon::now()->format('Y-m-d 23:59:59')}}"
                                            >
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
        $('.select2').select2()
    </script>
@endsection

