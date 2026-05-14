@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Service Area Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('reports')}}">Reports</a></li>
                            <li class="breadcrumb-item active">Service Area Report</li>
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
                                <form action="{{route('viewServiceAreaJobReport')}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group row">
                                        <label for="from_area" class="col-sm-2 col-form-label" style="text-align: right">From Area : </label>
                                        <div class="col-5">
                                            <select class="select2" name="from_area" id="from_area" style="width: 100%;"
                                                    data-placeholder="Select Contractor" >
                                                <option value="0" >  -- All Areas --  </option>
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
                                    </div>
                                    <div class="form-group row">
                                        <label for="to_area" class="col-sm-2 col-form-label" style="text-align: right">To Area : </label>
                                        <div class="col-5">
                                            <select class="select2" name="to_area" id="to_area" style="width: 100%;"
                                                    data-placeholder="Select Area" >
                                                <option value="0" >  -- All Areas --  </option>
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
                                        <label for="service_id" class="col-sm-2 col-form-label" style="text-align: right">Service : </label>
                                        <div class="col-5">
                                            <select class="select2" name="service_id" id="service_id" style="width: 100%;"
                                                    data-placeholder="Select Service" >
                                                <option value="0" >  -- All Services --  </option>
                                                @foreach($services as $service)
                                                    <?php
                                                    $select = "";
                                                    if($service->id == old('service_id')){
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
    <script>
        $('.select2').select2()
    </script>
@endsection

