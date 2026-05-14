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
                <td style="width: 40px">{{$job['id']}}</td>
                <td style="width: 45px">{{display_date($job['date'])}}</td>
                <td style="width: 45px">{{$job['vehicle_no']}}</td>
                <td style="width: 50px">{{$job['member_number']}}</td>
                <td style="width: 100px">{{$job['customer_name']}}</td>
                <td style="width: 40px">{{$job['member_mobile']}}</td>
                <td style="width: 60px">{{$job['service_name']}}</td>
                <td style="width: 80px">{{$job['from_area_name']}}</td>
                <td style="width: 80px">{{$job['to_area_name']}}</td>
                <td style="width: 40px">{{$job['amount'] != 0 ? number_format((float)$job['amount'] , 3) : ""}}</td>
                <td style="width: 40px">{{$job['receipt_no'] }}</td>
                <td style="width: 90px">{{$job['driver_name']}}</td>
                <td style="width: 40px">{{$job['driver_no']}}</td>
                <td style="width: 40px">{{config('view.job_status')[$job['status']]}}</td>
                <?php
                if($job['is_credit_cash'] == 0){
                    $member_total += $job['amount'];
                }
                if($job['is_credit_cash'] == 1){
                    $cash_total += $job['amount'];
                }
                if($job['is_credit_cash'] == 2){
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
            <td style="width: 40px">Total Jobs : </td>
            <td style="width: 45px">{{count($jobs)}}</td>

            <td style="width: 45px">Member Jobs Total</td>
            <td style="width: 50px" >{{number_format($member_total , 3)}}</td>

            <td style="width: 100px">Cash Jobs Total</td>
            <td style="width: 40px" >{{number_format($cash_total , 3)}}</td>

            <td style="width: 60px" >Credit Jobs Total</td>
            <td style="width: 80px" >{{number_format($credit_total , 3) }}</td>
            <td style="width: 80px">Total</td>
            <td style="width: 200px" colspan="6">{{number_format($member_total+$credit_total+$cash_total , 3) }}</td>
        </tr>

        </tbody>
    </table>
</body>
</html>