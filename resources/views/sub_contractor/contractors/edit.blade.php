@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Contractor</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('contractors.index')}}">Contractor</a></li>
                            <li class="breadcrumb-item active">Update Contractor</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form action="{{route('contractors.update' , $contractor->id)}}" method="post">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PATCH">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Contractor Details</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name *</label>
                                            <input type="text" id="name"  name="name" value="{{$contractor->name}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">E-mail *</label>
                                            <input type="text" id="email"  name="email" value="{{$contractor->email}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="telephone">Telephone *</label>
                                            <input type="text" id="telephone"  name="telephone" value="{{$contractor->telephone}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="fax">Fax *</label>
                                            <input type="text" id="fax"  name="fax" value="{{$contractor->fax}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="cr_no">Cr No *</label>
                                            <input type="text" id="cr_no"  name="cr_no" value="{{$contractor->cr_no}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address_line1">Address Line 1 *</label>
                                            <input type="text" id="address_line1"  name="address_line1" value="{{$contractor->address_line1}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="address_line2">Address Line 2 *</label>
                                            <input type="text" id="address_line2"  name="address_line2" value="{{$contractor->address_line2}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="address_line3">Address Line 3 *</label>
                                            <input type="text" id="address_line3"  name="address_line3" value="{{$contractor->address_line3}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Service Country</label>
                                            <select class="select2" name="service_country_master_id" id="service_country_master_id"
                                                    data-placeholder="Select a Service Country" style="width: 100%;">
                                                @foreach($countries as $country)
                                                    <?php
                                                    $select = "";
                                                    if($country->id == $contractor->service_country_master_id){
                                                        $select = "SELECTED";
                                                    }
                                                    ?>
                                                    <option value="{{$country->id}}" {{$select}} >
                                                        {{$country->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Service Area</label>
                                            <select class="select2"name="area_id" id="area_id"
                                                    data-placeholder="Select a Service Area" style="width: 100%;">
                                                @foreach($areas as $area)
                                                    <?php
                                                    $select = "";
                                                    if($country->id == $contractor->area_id){
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="{{route('contractors.index')}}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Update Contractor" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            $('.select2').select2()
        })
    </script>
@endsection