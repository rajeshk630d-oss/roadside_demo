<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>
<table >
    <tbody>
    <?php $total_contractor_amount=0; $x=1;?>
    @foreach($jobs as $job)
        <tr>
            <td style="width: 40px">{{$x++}}</td>
            <td style="width: 50px">{{$job->id}}</td>
            <td style="width: 50px">{{$job->vehicle_no}}</td>
            <td style="width: 50px">{{$job->member_mobile}}</td>
            <td style="width: 60px">{{$job->member_number}}</td>
            <td style="width: 80px">{{ ($job->service != NULL) ? $job->service->name : ""}}</td>
            <td style="width: 95px">{{ ($job->from_service_area != NULL) ? $job->from_service_area->name : ""}}</td>
            <td style="width: 95px">{{ ($job->to_service_area != NULL) ? $job->to_service_area->name : ""}}</td>
            <td style="width: 50px">{{number_format((float)$job->contractor_amount , 3)}}</td>
            <td style="width: 50px">{{$job->contractor_invoice}}</td>
            <td style="width: 50px">{{display_date($job->contractor_invoice_date)}}</td>
            <td style="width: 50px">{{$job->cheque_no}}</td>
            <td style="width: 50px">{{$job->cheque_date != NULL ? display_date($job->cheque_date) : ""}}</td>
            <?php
                $total_contractor_amount += $job->contractor_amount;
            ?>
        </tr>
    @endforeach
    </tbody>
</table>
<hr>
<table cellpadding="5px">
    <tbody>
        <tr>
            <td colspan="8" style="width:515px;text-align: right;padding-right: 10px">Total Contractor Amount</td>
            <td colspan="5">{{number_format((float)$total_contractor_amount , 3)}}</td>
        </tr>
    </tbody>
</table>
</body>
</html>