<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>

    <?php $member_count = 0; ?>
    @foreach($members as $member)
        <?php $member_count++; ?>
        <table>
            <tbody>
            <tr>
                <td style="width: 50px">{{$member['member_no']}}</td>
                <td style="width: 100px">{{$member['member_name']}}</td>
                <td style="width: 50px"></td>
                <td style="width: 70px"></td>
                <td style="width: 50px"></td>
                <td style="width: 70px"></td>
                <td style="width: 70px"></td>
                <td style="width: 100px"></td>
                <td style="width: 70px"></td>
                <td style="width: 120px"></td>
                <td style="width: 70px"></td>
            </tr>
            </tbody>
        </table>
        <hr style="width: 200px;margin-left: 0px">
        @foreach($member['vehicles'] as $vehicle)
            <table>
                <tbody>
                <tr>
                    <td style="width: 50px"></td>
                    <td style="width: 100px"></td>
                    <td style="width: 50px">{{$vehicle['vehicle_no']}}</td>
                    <td style="width: 70px"></td>
                    <td style="width: 30px">{{$vehicle['member_vehicle_jobs_count']}}</td>
                    <td style="width: 70px"></td>
                    <td style="width: 70px"></td>
                    <td style="width: 100px"></td>
                    <td style="width: 70px"></td>
                    <td style="width: 120px"></td>
                    <td style="width: 70px"></td>
                </tr>
                </tbody>
            </table>
            <hr style="width: 200px;margin-left: 220px">
            <table>
                <tbody>
                @foreach($vehicle['jobs'] as $job)
                    <tr>
                        <td style="width: 50px"></td>
                        <td style="width: 100px"></td>
                        <td style="width: 50px"></td>
                        <td style="width: 70px">{{$job['member_mobile']}}</td>
                        <td style="width: 30px"></td>
                        <td style="width: 50px">{{$job['id']}}</td>
                        <td style="width: 50px">{{$job['date']}}</td>
                        <td style="width: 90px">{{$job['service_name']}}</td>
                        <td style="width: 100px">{{$job['from_area_name']}}</td>
                        <td style="width: 100px">{{$job['driver_name']}}</td>
                        <td style="width: 50px">{{$job['driver_no']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        @endforeach
        <hr>
        <table>
            <tbody>
            <tr>
                <td style="width: 50px"></td>
                <td style="width: 100px"></td>
                <td style="width: 50px"></td>
                <td style="width: 70px"></td>
                <td style="width: 30px">{{$member['member_jobs_count']}}</td>
                <td style="width: 70px"></td>
                <td style="width: 70px"></td>
                <td style="width: 100px"></td>
                <td style="width: 70px"></td>
                <td style="width: 120px"></td>
                <td style="width: 70px"></td>
            </tr>
            </tbody>
        </table>
        @if($member_count != count($members))
        <hr>
        @endif
    @endforeach
    <hr>
<table>
    <tbody>
    <tr>
        <td style="width: 70px"></td>
        <td style="width: 120px"></td>
        <td style="width: 50px"></td>
        <td style="width: 70px"></td>
        <td style="width: 50px">{{$total_jobs_count}}</td>
        <td style="width: 70px"></td>
        <td style="width: 70px"></td>
        <td style="width: 100px"></td>
        <td style="width: 70px"></td>
        <td style="width: 120px"></td>
        <td style="width: 70px"></td>
    </tr>
    </tbody>
</table>
    <hr>
</body>
</html>