<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>
    <table >
        <tbody>
        <?php $total = 0;$total_contractor=0;$total_aaa = 0;?>
        @foreach($jobs as $key => $job)
            <tr>
                <td style="width: 40px">{{$key + 1}}</td>
                <td style="width: 50px">{{display_date($job['date'])}}</td>
                <td style="width: 50px">{{$job['id']}}</td>
                <td style="width: 50px">{{$job['member_number']}}</td>
                <td style="width: 110px">{{$job['from_area_name']}}</td>
                <td style="width: 110px">{{$job['to_area_name']}}</td>
                @if($job['assign_to'] == 1)
                <td style="width: 150px">{{$job['contractor_name']}}</td>
                @else
                <td style="width: 150px">AAA</td>
                @endif
                <td style="width: 90px">{{number_format((float)$job['contractor_amount'] , 3)}}</td>
                <td style="width: 70px">{{number_format((float)$job['aaa_charges'] , 3)}}</td>
                <td style="width: 60px">{{number_format((float)($job['aaa_charges']+$job['contractor_amount']) , 3)}}</td>
                <?php
                    $total += ($job['contractor_amount'] + $job['aaa_charges']);
                    $total_contractor += $job['contractor_amount'];
                    $total_aaa += $job['aaa_charges'];
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
            <td style="width: 40px"></td>
            <td style="width: 50px"></td>
            <td style="width: 50px"></td>
            <td style="width: 50px"></td>
            <td style="width: 110px"></td>
            <td style="width: 105px"></td>
            <td style="width: 150px">Total</td>
            <td style="width: 90px">{{number_format((float)$total_contractor , 3)}}</td>
            <td style="width: 70px">{{number_format((float)$total_aaa , 3)}}</td>
            <td style="width: 60px">{{number_format((float)$total , 3)}}</td>
        </tr>
        </tbody>
    </table>
</body>
</html>


