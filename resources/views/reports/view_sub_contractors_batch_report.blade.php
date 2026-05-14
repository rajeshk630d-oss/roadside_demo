<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>

    <table >
        <tbody>
        <?php

        $total_contractor=0;

        ?>
        @foreach($jobs as $key => $job)

            <tr>
                <td style="width: 50px">{{$key + 1}}</td>
                <td style="width: 230px">{{$job['contractor_name']}}</td>
                <td style="width: 88px">{{$job['batch_no']}}</td>
                <td style="width: 118px">{{$job['payment_at']}}</td>
                <td style="width: 118px">{{number_format((float)$job['contractor_amount'] , 3)}}</td>
                <?php

                    $total_contractor += $job['contractor_amount'];

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
            <td style="width: 222px"></td>
            <td>Total</td>
            <td>{{number_format((float)$total_contractor , 3)}}</td>

        </tr>
        </tbody>
    </table>
</body>
</html>


