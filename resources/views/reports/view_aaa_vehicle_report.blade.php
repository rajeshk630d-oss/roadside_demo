<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>

<body>
    @foreach($vehicles as $vehicle)
        <table>
            <tbody>
                <tr>
                    <td colspan="3" >{{$vehicle['vehicle_no']}}</td>
                    <td colspan="10"></td>
                </tr>
            </tbody>
        </table>
        <table>
            <tbody>
            @foreach($vehicle['jobs'] as $job)
                <tr>
                    <td style="width: 70px"></td>
                    <td style="width: 100px">{{$job['driver_name']}}</td>
                    <td style="width: 60px">{{$job['driver_no']}}</td>
                    <td style="width: 40px">{{$job['id']}}</td>
                    <td style="width: 50px">{{$job['date']}}</td>
                    <td style="width: 70px">{{$job['member_number']}}</td>
                    <td style="width: 60px">{{$job['member_mobile']}}</td>
                    <td style="width: 55px">{{$job['vehicle_no']}}</td>
                    <td style="width: 85px">{{$job['service_name']}}</td>
                    <td style="width: 100px">{{$job['to_area_name']}}</td>
                    <td style="width: 100px">{{$job['created_at']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <hr>
        <table>
            <tbody>
            <tr>
                <td  style="width: 70px" >Total Jobs</td>
                <td  style="width: 70px" >{{$vehicle['job_count']}}</td>
                <td style="width: 710px" ></td>
            </tr>
            </tbody>
        </table>
        <hr>
        <br>
    @endforeach


</body>
</html>