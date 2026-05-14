<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Jobs List Report</title>
    <style>
        body {
            font-family: helvetica, sans-serif;
            font-size: 7px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #ddd;
            font-weight: bold;
            font-size: 7px;
        }
        td {
            font-size: 6px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer-total {
            font-weight: bold;
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

<table>
    <thead>
        <tr>
            <th width="7%">Date</th>
            <th width="5%">Job No</th>
            <th width="7%">Start Time</th>
            <th width="8%">Member Name</th>
            <th width="6%">Member No</th>
            <th width="8%">Customer</th>
            <th width="6%">Veh No</th>
            <th width="7%">Expiry Date</th>
            <th width="4%">Model</th>
            <th width="6%">Chassis No</th>
            <th width="8%">Service</th>
            <th width="7%">From Area</th>
            <th width="7%">To Area</th>
            <th width="7%">Comp Time</th>
            <th width="8%">Driver Name</th>
            <th width="8%">User Name</th>
            <th width="5%">Job Type</th>
            <th width="6%">Amount</th>
        </tr>
    </thead>
    <tbody>
    @php $total_amount = 0; @endphp
    @foreach($jobs as $job)
    @php 
        $total_amount += isset($job['amount']) ? floatval($job['amount']) : 0;
    @endphp
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
        <td class="text-right">{{ number_format(floatval($job['amount'] ?? 0), 3) }}</td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr class="footer-total">
            <td colspan="17" align="right"><strong>Total:</strong></td>
            <td class="text-right"><strong>{{ number_format($total_amount, 3) }}</strong></td>
        </tr>
    </tfoot>
</table>

@if(count($jobs) == 0)
    <p align="center" style="margin-top: 50px;">No records found for the selected period.</p>
@endif

</body>
</html>