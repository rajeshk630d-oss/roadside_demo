@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Jobs</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Jobs</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary card-outline card-tabs">
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                @include('jobs.jobs_tabs')
                            </div>
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header">
                                        <form action="{{ route('not_done_jobs') }}" method="POST">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-2">
                                                    <input type="date" class="form-control" name="from_date" value="{{$from_date}}">
                                                </div>
                                                <label class="col-sm-1 col-form-label float-center">To</label>
                                                <div class="col-2">
                                                    <input type="date" class="form-control" name="to_date" value="{{$to_date}}">
                                                </div>
                                                <div class="col-2">
                                                    <input type="submit" class="btn btn-primary" value="Search">
                                                </div>
                                                <div class="col-5">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Call ID</th>

                                                <th>Vehicle No</th>
                                                <th>Member No</th>
                                                <th>Member Name</th>
                                                <th>Member Mobile</th>
                                                <th>Date</th>
                                                <th>From Area</th>
                                                <th>To Area</th>
                                                <th>Customer Name</th>
                                                <th>Created At</th>
                                                <th>Assigned At</th>
                                                <th>Completed At</th>
                                                <th>Options</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($jobs as $key => $job)
                                                <tr>
                                                    <td>{{$job->id }}</td>
                                                    <td>{{$job->vehicle_no }}</td>
                                                    <td>{{$job->member_number }}</td>
                                                    <td>{{$job->member_name }}</td>
                                                    <td>{{$job->member_mobile }}</td>
                                                    <td>{{$job->date }}</td>
                                                    <td>{{$job->from_area_name }}</td>
                                                    <td>{{$job->to_area_name }}</td>
                                                    <td>{{$job->customer_name }}</td>
                                                    <td>{{$job->created_at }}</td>
                                                    <td>{{$job->assigned_date }}</td>
                                                    <td>{{$job->completed_date }}</td>
                                                    <td class="project-actions text-right">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-default">Options</button>
                                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <div class="dropdown-menu" role="menu">
                                                                <a class="dropdown-item" href="{{ route('job.show', $job->id) }}">View</a>
                                                                @if(is_admin(\Illuminate\Support\Facades\Auth::user()->id) && $job->payment_status == 0)
                                                                    <a class="dropdown-item" href="{{ route('job.edit', $job->id) }}">Edit</a>
                                                                @endif
                                                                @if($job->status == 0 )
                                                                    <a class="dropdown-item" href="{{ route('job.assign', $job->id) }}">Assign</a>
                                                                @endif
                                                                @if($job->status == 1 )
                                                                    <a class="dropdown-item" href="{{ route('job.complete', $job->id) }}">Complete</a>
                                                                @endif
                                                                @if($job->status == 0 || $job->status == 1)
                                                                    <button class="dropdown-item" onclick="showNotDoneJobModel({{$job->id}})">Not Done</button>
                                                                    <button class="dropdown-item" onclick="showCancellJobModel({{$job->id}})">Cancel</button>
                                                                @endif
                                                            </div>
                                                        </div>

                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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

                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "order": [[0, 'desc']],

                "buttons": [
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: [1,2,3,4,5,6,7]
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [1,2,3,4,5,6,7]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [1,2,3,4,5,6,7]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [1,2,3,4,5,6,7]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [1,2,3,4,5,6,7]
                        }
                    }
                    , "colvis"]
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
    </script>
@endsection

