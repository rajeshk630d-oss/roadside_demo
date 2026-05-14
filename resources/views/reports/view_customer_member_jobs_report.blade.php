<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>

    @foreach($customers as $customer)
        <table>
            <tbody>
            <tr>
                <td style="width: 200px">{{$customer['customer_name']}}</td>
                <td style="width: 50px"></td>
                <td style="width: 100px"></td>
                <td style="width: 50px"></td>
                <td style="width: 70px"></td>
                <td style="width: 70px"></td>
                <td style="width: 70px"></td>
                <td style="width: 100px"></td>
                <td style="width: 70px"></td>
                <td style="width: 70px"></td>
                <td style="width: 70px"></td>
            </tr>
            </tbody>
        </table>

        <hr style="width:120px;margin-left:0;">
        <?php $x=0; ?>
        @foreach($customer['members'] as $key => $member)
            <?php $x++; ?>
            <table>
                <tbody>
                <tr>
                    <td style="width: 120px"></td>
                    <td style="width: 50px">{{$member['member_no']}}</td>
                    <td style="width: 200px">{{$member['member_name']}}</td>
                    <td style="width: 50px"></td>
                    <td style="width: 70px"></td>
                    <td style="width: 70px"></td>
                    <td style="width: 70px"></td>
                    <td style="width: 100px"></td>
                    <td style="width: 70px"></td>
                    <td style="width: 70px"></td>
                    <td style="width: 70px"></td>
                </tr>
                </tbody>
            </table>
            {{--<hr style="width:170px;margin-left:140px;">--}}
            <table>
                <tbody>
                    @foreach($member['jobs'] as $job)
                    <tr>
                        <td style="width: 120px"></td>
                        <td style="width: 50px"></td>
                        <td style="width: 70px"></td>
                        <td style="width: 50px">{{$job['id']}}</td>
                        <td style="width: 60px">{{$job['date']}}</td>
                        <td style="width: 60px">{{$job['vehicle_no']}}</td>
                        <td style="width: 60px">{{$job['member_mobile']}}</td>
                        <td style="width: 80px">{{$job['service_name']}}</td>
                        <td style="width: 80px">{{$job['from_area_name']}}</td>
                        <td style="width: 60px">{{$job['driver_no']}}</td>
                        <td style="width: 100px">{{$job['driver_name']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <hr style="margin-left:310px;">
            <table>
                <tbody>
                <tr>
                    <td style="width: 120px"></td>
                    <td style="width: 50px"></td>
                    <td style="width: 70px"></td>
                    <td style="width: 50px">{{$member['member_jobs_total']}}</td>
                    <td style="width: 70px"></td>
                    <td style="width: 70px"></td>
                    <td style="width: 70px"></td>
                    <td style="width: 100px"></td>
                    <td style="width: 70px"></td>
                    <td style="width: 70px"></td>
                    <td style="width: 70px"></td>
                </tr>
                </tbody>
            </table>
            @if(count($customer['members']) != $x)
            <hr style="margin-left:370px;">
            @endif


        @endforeach
        <hr style="">
        <table>
            <tbody>
            <tr>
                <td style="width: 120px"></td>
                <td style="width: 50px"></td>
                <td style="width: 100px"></td>
                <td style="width: 50px">{{$customer['customer_jobs_total']}}</td>
                <td style="width: 70px"></td>
                <td style="width: 70px"></td>
                <td style="width: 70px"></td>
                <td style="width: 100px"></td>
                <td style="width: 70px"></td>
                <td style="width: 70px"></td>
                <td style="width: 70px"></td>
            </tr>
            </tbody>
        </table>
        <hr style="">

    @endforeach
    <table>
        <tbody>
        <tr>
            <td style="width: 120px"></td>
            <td style="width: 50px"></td>
            <td style="width: 100px"></td>
            <td style="width: 50px">{{$total_count}}</td>
            <td style="width: 70px"></td>
            <td style="width: 70px"></td>
            <td style="width: 70px"></td>
            <td style="width: 100px"></td>
            <td style="width: 70px"></td>
            <td style="width: 70px"></td>
            <td style="width: 70px"></td>
        </tr>
        </tbody>
    </table>
    <hr style="">

</body>
</html>