<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>
    @foreach($contractors as $contractor)
        <table>
            <tbody>
                <tr>
                    <td colspan="3" style="font-size: 10px">{{$contractor['name']}}</td>
                </tr>
            </tbody>
        </table>
        <hr style="width: 320px;margin-left:0;">

        <table>
            <tbody>

            @foreach($contractor['jobs'] as $key => $job)
                <tr>
                    <td style="width: 70px"></td>
                    <td style="width: 70px"></td>
                    <td style="width: 185px">{{$job['area_name']}}</td>
                    <td style="width: 80px">{{$job['job_count']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <hr>
        <table>
            <tbody>
            <tr>
                <td style="width: 70px"></td>
                <td style="width: 70px"></td>
                <td style="width: 185px">Total</td>
                <td style="width: 80px">{{$contractor['total_job_count']}}</td>
            </tr>
            </tbody>
        </table>

        <hr>
        <br>
    @endforeach
<table>
    <tbody>
    <tr>
        <td style="width: 70px"></td>
        <td style="width: 70px"></td>
        <td style="width: 185px">Total</td>
        <td style="width: 80px">{{$total_count}}</td>
    </tr>
    </tbody>
</table>

{{--<hr>--}}

</body>
</html>