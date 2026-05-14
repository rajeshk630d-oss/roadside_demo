<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>

    @foreach($services as $service)
        <table>
            <tbody>
                <tr>
                    <td colspan="3" style="font-size: 8px">{{$service['name']}}</td>
                </tr>
            </tbody>
        </table>
        <hr width="120px">
        <table>
            <tbody>
            <?php $x = 1;?>
            @foreach($service['jobs_count'] as $key => $job)
                <tr>
                    <td style="width: 130px"></td>
                    <td style="width: 70px">{{$x++}}</td>
                    <td style="width: 185px">{{$job['to_area_name']}}</td>
                    <td style="width: 80px">{{$job['count']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <hr>
        <table>
            <tbody>
            <tr>
                <td style="width: 130px"></td>
                <td style="width: 70px"></td>
                <td style="width: 185px">Total Jobs</td>
                <td style="width: 80px">{{$service['total_job_count']}}</td>
            </tr>

            </tbody>
        </table>

        <hr>
        <br>
    @endforeach


</body>
</html>