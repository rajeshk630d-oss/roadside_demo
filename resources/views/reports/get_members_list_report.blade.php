@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Customer - Member List Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('reports')}}">Reports</a></li>
                            <li class="breadcrumb-item active">Customer - Members List Report</li>
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
                                <form action="{{route('viewMembersReport')}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group row">
                                        <label for="customer_id" class="col-sm-2 col-form-label" style="text-align: right">Customer : </label>
                                        <div class="col-5">
                                            <select class="select2" name="customer_id" id="customer_id" style="width: 100%;"
                                                    data-placeholder="Select Service" >
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
    <script src="{{asset('public/plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('public/plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <script>
        $('.select2').select2()
    </script>
@endsection

