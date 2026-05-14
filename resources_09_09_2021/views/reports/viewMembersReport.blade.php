<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>
    <table >
        <tbody>
        @foreach($members as $member)
            <tr>
                <td style="width: 95px">{{$member['membership_no']}}</td>
                <td style="width: 95px">{{$member['vehicle_no']}}</td>
                <td style="width: 85px">{{$member['engine_no']}}</td>
                <td style="width: 90px">{{$member['chassis_no']}}</td>
                <td style="width: 120px">{{$member['member_name']}}</td>
                <td style="width: 60px">{{display_date($member['expiry_date'])}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</body>
</html>