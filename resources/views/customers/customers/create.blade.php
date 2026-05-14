@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Customer</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('customers.index')}}">Customers</a></li>
                            <li class="breadcrumb-item active">Add Customer</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form action="{{route('customers.store')}}" method="post">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Customer Details</h3>
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
                                            <input type="text" id="name"  name="name" value="{{old('name')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="type">Type *</label>
                                            <input type="text" id="type"  name="type" value="{{old('type')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="address_line1">Address Line 1 *</label>
                                            <input type="text" id="address_line1"  name="address_line1" value="{{old('address_line1')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="address_line2">Address Line 2 *</label>
                                            <input type="text" id="address_line2"  name="address_line2" value="{{old('address_line2')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="address_line3">Address Line 3 *</label>
                                            <input type="text" id="address_line3"  name="address_line3" value="{{old('address_line3')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">E-mail *</label>
                                            <input type="email" id="email"  name="email" value="{{old('email')}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="telephone">Telephone *</label>
                                            <input type="text" id="telephone"  name="telephone" value="{{old('telephone')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="sales_person_id">Sales Person *</label>
                                            <select class="select2" name="sales_person_id" id="sales_person_id"
                                                    data-placeholder="Select a Sales person" style="width: 100%;">
                                                @foreach($sales_persons as $sales_person)
                                                    <?php
                                                    $select = "";
                                                    if($sales_person->id == old('sales_person_id')){
                                                        $select = "SELECTED";
                                                    }
                                                    ?>
                                                    <option value="{{$sales_person->id}}" {{$select}} >
                                                        {{$sales_person->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="fax">Fax *</label>
                                            <input type="text" id="fax"  name="fax" value="{{old('fax')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="cr_no">Contact Person *</label>
                                            <input type="text" id="contact_person"  name="contact_person" value="{{old('contact_person')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="cr_no">Contact Person Mobile *</label>
                                            <input type="text" id="contact_person_mobile"  name="contact_person_mobile"
                                                   value="{{old('contact_person_mobile')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="cr_no">Contact Person Email *</label>
                                            <input type="email" id="contact_person_email"  name="contact_person_email"
                                                   value="{{old('contact_person_email')}}" class="form-control">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="{{route('customers.index')}}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Create new Customer" class="btn btn-success float-right">
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