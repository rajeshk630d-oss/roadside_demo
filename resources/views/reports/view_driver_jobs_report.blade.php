<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif;font-size: 6px; }
    </style>
</head>
<body>
    @foreach($drivers as $driver)
        <table style="padding-top: 5px;padding-bottom: 5px">
            <tbody>
            <tr>
                <td style="width: 200px">{{$driver['name']}}</td>
                <td style="width: 50px"></td>
                <td style="width: 50px"></td>
                <td style="width: 50px"></td>
            </tr>
            </tbody>
        </table>

        <hr style="width:100px;margin-left:0;">

        <table>
            <tbody>
            @foreach($driver['jobs'] as $job)
                <tr>
                    <td style="width: 35px">{{$job['id']}}</td>
                    <td style="width: 40px">{{$job['date']}}</td>
                    <td style="width: 40px">{{$job['vehicle_no']}}</td>
                    <td style="width: 40px">{{$job['member_number']}}</td>
                    <td style="width: 110px">{{$job['member_name']}}</td>
                    <td style="width: 40px">{{$job['member_mobile']}}</td>
                    <td style="width: 55px">{{$job['service_name']}}</td>
                    <td style="width: 70px">{{$job['from_area_name']}}</td>
                    <td style="width: 70px">{{$job['to_area_name']}}</td>
                    <td style="width: 30px">{{$job['amount']}}</td>
                    <td style="width: 40px">{{$job['aaa_vehicle_no']}}</td>
                    <td style="width: 80px">{{$job['driver_name']}}</td>
                    <td style="width: 40px">{{$job['driver_no']}}</td>
                    <td style="width: 70px">{{$job['created_at']}}</td>
                    <td style="width: 50px">{{$job['contractor_amount']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <hr>

        <br>
    @endforeach

</body>
</html>