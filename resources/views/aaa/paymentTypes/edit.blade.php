@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Payment Type</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('aaaPaymentType.index')}}">Payment Types</a></li>
                            <li class="breadcrumb-item active">Update Payment Type</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <form action="{{route('aaaPaymentType.update' , $payment_type->id)}}" method="post">
                {{csrf_field()}}

                <input type="hidden" name="_method" value="PATCH">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Brand Details</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputName">Name</label>
                                    <input type="text" id="name"  name="name" class="form-control" value="{{$payment_type->name}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputDescription">Remarks</label>
                                    <textarea name="remark" id="remark" class="form-control" rows="4">{{$payment_type->remark}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-6">
                        <a href="{{route('aaaPaymentType.index')}}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Update Payment Type" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
