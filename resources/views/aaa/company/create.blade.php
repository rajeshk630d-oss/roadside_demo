@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Company</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('aaaCompany.index')}}">Companies</a></li>
                            <li class="breadcrumb-item active">Add Company</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form action="{{route('aaaCompany.store')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Company Details</h3>
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
                                            <label for="email">E-mail *</label>
                                            <input type="text" id="email"  name="email" value="{{old('email')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="telephone">Telephone *</label>
                                            <input type="number" id="telephone"  name="telephone" value="{{old('telephone')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="vat_no">VAT No. *</label>
                                            <input type="text" id="vat_no"  name="vat_no" value="{{old('vat_no')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="cr_no">Cr No *</label>
                                            <input type="text" id="cr_no"  name="cr_no" value="{{old('cr_no')}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
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
                                            <label for="address_line4">Address Line 4 *</label>
                                            <input type="text" id="address_line4"  name="address_line4" value="{{old('address_line4')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="logo">Logo</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="logo" name="logo">
                                                <label class="custom-file-label" for="logo">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="{{route('aaaCompany.index')}}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Create Company" class="btn btn-success float-right">
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