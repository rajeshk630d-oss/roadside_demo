<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>
    <table >
        <tbody>
        <?php $cash_total = 0;$credit_total=0;$member_total = 0; ?>
        @foreach($jobs as $job)
            <tr>
                <td style="width: 32px">{{$job['id']}}</td>
                <td style="width: 40px">{{display_date($job['date'])}}</td>
                <td style="width: 40px">{{$job['vehicle_no']}}</td>
                <td style="width: 45px">{{$job['member_number']}}</td>
                <td style="width: 90px">{{$job['customer_name']}}</td>
                <td style="width: 40px">{{$job['member_mobile']}}</td>
                <td style="width: 60px">{{$services[$job['service_master_id']]}}</td>
                <td style="width: 70px">{{$areas[$job['from_area']]}}</td>
                <td style="width: 70px">{{$areas[$job['to_area']]}}</td>
                <td style="width: 40px">{{$job['amount'] != 0 ? number_format((float)$job['amount'] , 3) : ""}}</td>
                <td style="width: 40px">{{$job['receipt_no'] }}</td>
                <td style="width: 80px">{{$job['driver_name']}}</td>
                <td style="width: 40px">{{$job['driver_no']}}</td>
                <td style="width: 40px">{{config('view.job_status')[$job['status']]}}</td>
                <td style="width: 60px">{{$users[$job['user_id']]}}</td>
                <?php
                if($job['is_credit_cash'] == 0){
                    if($job['amount'] != NULL)
                        $member_total += $job['amount'];
                }
                if($job['is_credit_cash'] == 1){
                    if($job['amount'] != NULL)
                        $cash_total += $job['amount'];
                }
                if($job['is_credit_cash'] == 2){
                    if($job['amount'] != NULL)
                        $credit_total += $job['amount'];
                }
                ?>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br>
    <hr style="padding-top: 10px;padding-bottom: 10px;">
    </br>
    <table >
        <tbody>
        <tr >
            <td style="width: 37px">Total Jobs : </td>
            <td style="width: 40px">{{count($jobs)}}</td>

            <td style="width: 40px">Member Jobs Total</td>
            <td style="width: 45px" colspan="1">{{number_format($member_total , 3)}}</td>

            <td style="width: 90px">Cash Jobs Total</td>
            <td style="width: 40px" colspan="1">{{number_format($cash_total , 3)}}</td>

            <td style="width: 60px" colspan="1">Credit Jobs Total</td>
            <td style="width: 70px" colspan="1">{{number_format($credit_total , 3) }}</td>
            <td style="width: 70px">Total</td>
            <td style="width: 200px" colspan="6">{{number_format($member_total+$credit_total+$cash_total , 3) }}</td>
        </tr>

        </tbody>
    </table>
</body>
</html>