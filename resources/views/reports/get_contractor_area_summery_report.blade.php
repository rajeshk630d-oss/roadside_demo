@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Contrcator Area Summery Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('reports')}}">Reports</a></li>
                            <li class="breadcrumb-item active">Contrcator Area Summery Report</li>
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
                                <form action="{{route('ViewContractorAreaSummeryReport')}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group row">
                                        <label for="contractor_id[]" class="col-sm-2 col-form-label" style="text-align: right">Contractors : </label>
                                        <div class="col-5">
                                            <select class="select2" multiple="multiple" name="contractor_id[]" id="contractor_id[]"
                                                    data-placeholder="Select Contractor" style="width: 100%;">
                                                <option value="0" >  -- All Contractors --  </option>
                                                @foreach($contractors as $contractor)
                                                    <option value="{{$contractor->id}}" >
                                                        {{$contractor->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="service_id" class="col-sm-2 col-form-label" style="text-align: right">Areas : </label>
                                        <div class="col-5">
                                            <select class="select2" multiple="multiple" name="area_id[]" id="area_id[]"
                                                    data-placeholder="Select Area" style="width: 100%;">
                                                <option value="0" >  -- All Areas --  </option>
                                                @foreach($areas as $area)
                                                    <option value="{{$area->id}}" >
                                                        {{$area->name}}
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

