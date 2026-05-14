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
                <td colspan="4" style="width: 500px">{{$customer['name']}}</td>
                <td style="width: 80px">{{$customer['total_job_count']}}</td>
            </tr>
            <?php $key = 1;?>
            @foreach($customer['job_counts'] as $job)
                <tr>
                    <td style="width: 150px"></td>
                    <td style="width: 80px">{{$key}}</td>
                    <td style="width: 180px">{{$job['name']}}</td>
                    <td style="width: 80px">{{$job['count']}}</td>
                    <td style="width: 80px"></td>
                </tr>
                <?php $key++; $total +=$job['count']; ?>
            @endforeach
            </tbody>
        </table>
        <hr>

    @endforeach
<br>
<table >
    <tbody>
    <tr>
        <td colspan="2" style="width: 235px"></td>
        <td style="width: 180px">Total Jobs</td>
        <td style="width: 80px">{{$total}}</td>
    </tr>
    </tbody>
</table>
{{--<hr>--}}

</body>
</html>