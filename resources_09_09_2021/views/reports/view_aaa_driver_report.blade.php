<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>
    @foreach($drivers as $driver)
        <table>
            <tbody>
                <tr>
                    <td colspan="3" >{{$driver['name']}}</td>
                    <td colspan="10"></td>
                </tr>
            </tbody>
        </table>
        <table>
            <tbody>
            @foreach($driver['jobs'] as $job)
                <tr>
                    <td style="width: 100px"></td>
                    <td style="width: 60px">{{$job['aaa_vehicle_no']}}</td>
                    <td style="width: 50px">{{$job['id']}}</td>
                    <td style="width: 100px">{{$job['created_at']}}</td>
                    <td style="width: 60px">{{$job['member_number']}}</td>
                    <td style="width: 120px">{{$job['customer_name']}}</td>
                    <td style="width: 60px">{{$job['member_mobile']}}</td>
                    <td style="width: 60px">{{$job['vehicle_no']}}</td>
                    <td style="width: 80px">{{$job['service_name']}}</td>
                    <td style="width: 100px">{{$job['to_area_name']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <hr>
        <table>
            <tbody>
            <tr>
                <td  style="width: 100px" >Total Jobs</td>
                <td  style="width: 60px" >{{$driver['job_count']}}</td>
                <td style="width: 710px" ></td>
            </tr>
            </tbody>
        </table>
        <hr>
        <br>
    @endforeach


</body>
</html>