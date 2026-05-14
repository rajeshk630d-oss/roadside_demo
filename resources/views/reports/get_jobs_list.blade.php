@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Jobs List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('reports')}}">Reports</a></li>
                            <li class="breadcrumb-item active">Jobs list</li>
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
                                <h3 class="card-title">Generate Jobs List Report</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('view_get_jobs_list') }}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-right">Customer :</label>
                                        <div class="col-5">
                                            <select name="customer_id" class="form-control select2">
                                                <option value="">-- All Customers --</option>
                                                @foreach($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-right">From Date :</label>
                                        <div class="col-3">
                                            <input type="date" name="from_date" class="form-control" 
                                                   value="{{ Carbon\Carbon::now()->subDays(7)->format('Y-m-d') }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-right">To Date :</label>
                                        <div class="col-3">
                                            <input type="date" name="to_date" class="form-control" 
                                                   value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-right">File Type :</label>
                                        <div class="col-4">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="fileType" value="1" checked>
                                                <label class="form-check-label">PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="fileType" value="2">
                                                <label class="form-check-label">Excel/CSV</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-file-alt"></i> Generate Jobs List
                                            </button>
                                            <a href="{{ route('reports') }}" class="btn btn-secondary">
                                                <i class="fas fa-times"></i> Cancel
                                            </a>
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
    <script src="{{asset('public/plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
        $(function () {
            $('.select2').select2();
        });
    </script>
@endsection