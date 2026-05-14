<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>

<?php  $total = 0;?>

    @foreach($customers as $customer)
        <table >
            <tbody>
            <tr>
                <td style="width: 150px">{{$customer['name']}}</td>
                <td style="width: 30px"></td>
                <td style="width: 120px"></td>
                <td style="width: 30px"></td>
            </tr>
            </tbody>
        </table>
        <hr style="width:150px;margin-left:0;">
        <table >
            <tbody>
            <?php $key = 1;?>
            @foreach($customer['job_counts'] as $key=>$job)
                <tr>
                    <td style="width: 150px"></td>
                    <td style="width: 80px">{{  $job['member_number'] }}</td>
                    <td style="width: 180px">{{  $job['name'] }}</td>
                    <td style="width: 50px">{{  $job['count'] }}</td>
                </tr>
                <?php $key++; $total += $job['count']; ?>
            @endforeach
            </tbody>
        </table>
        <hr>
        <table >
            <tbody>
            <tr>
                <td style="width: 145px"></td>
                <td style="width: 30px"></td>
                <td style="width: 120px"></td>
                <td style="width: 30px">{{$customer['total_job_count']}}</td>
            </tr>
            </tbody>
        </table>
    @endforeach

{{--<hr>--}}

</body>
</html>