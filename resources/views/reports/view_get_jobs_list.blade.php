@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Jobs List Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('reports')}}">Reports</a></li>
                        <li class="breadcrumb-item"><a href="{{route('get_jobs_list')}}">Jobs List</a></li>
                        <li class="breadcrumb-item active">Report</li>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="card-title">
                                        Jobs List ({{ $from_date_disp ?? '' }} to {{ $to_date_disp ?? '' }})
                                    </h3>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button onclick="window.print()" class="btn btn-sm btn-primary">
                                        <i class="fas fa-print"></i> Print
                                    </button>
                                    <a href="{{ route('get_jobs_list') }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="jobsTable" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Job No</th>
                                        <th>Start Time</th>
                                        <th>Member Name</th>
                                        <th>Member No</th>
                                        <th>Customer</th>
                                        <th>Veh No</th>
                                        <th>Expiry Date</th>
                                        <th>Model</th>
                                        <th>Chassis No</th>
                                        <th>Service</th>
                                        <th>From Area</th>
                                        <th>To Area</th>
                                        <th>Comp Time</th>
                                        <th>Driver Name</th>
                                        <th>User Name</th>
                                        <th>Job Type</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach($jobs as $job)
                                    @php $total += floatval($job['amount'] ?? 0); @endphp
                                    <tr>
                                        <td>{{ isset($job['date']) ? date('d-m-Y', strtotime($job['date'])) : '' }}</td>
                                        <td>{{ $job['job_no'] ?? '' }}</td>
                                        <td>{{ isset($job['start_time']) ? date('H:i:s', strtotime($job['start_time'])) : '' }}</td>
                                        <td>{{ $job['member_name'] ?? '' }}</td>
                                        <td>{{ $job['member_number'] ?? '' }}</td>
                                        <td>{{ $job['customer_name'] ?? '' }}</td>
                                        <td>{{ $job['vehicle_no'] ?? '' }}</td>
                                        <td>{{ isset($job['expiry_date']) && $job['expiry_date'] ? date('d-m-Y', strtotime($job['expiry_date'])) : '' }}</td>
                                        <td>{{ $job['model'] ?? '' }}</td>
                                        <td>{{ $job['chassis_no'] ?? '' }}</td>
                                        <td>{{ $job['service'] ?? '' }}</td>
                                        <td>{{ $job['from_area'] ?? '' }}</td>
                                        <td>{{ $job['to_area'] ?? '' }}</td>
                                        <td>{{ isset($job['completed_time']) && $job['completed_time'] ? date('H:i:s', strtotime($job['completed_time'])) : '' }}</td>
                                        <td>{{ $job['driver_name'] ?? '' }}</td>
                                        <td>{{ $job['user_name'] ?? '' }}</td>
                                        <td>{{ $job['job_type'] ?? '' }}</td>
                                        <td style="text-align: right">{{ number_format(floatval($job['amount'] ?? 0), 3) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr style="font-weight: bold; background-color: #f0f0f0;">
                                        <td colspan="17" style="text-align: right">Total:</td>
                                        <td style="text-align: right">{{ number_format($total, 3) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
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
<script src="{{asset('public/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script>
    $(function () {
        $("#jobsTable").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "pageLength": 50,
            "buttons": ["copy", "csv", "excel", "pdf", "print"],
            "order": [[0, 'desc']]
        }).buttons().container().appendTo('#jobsTable_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection