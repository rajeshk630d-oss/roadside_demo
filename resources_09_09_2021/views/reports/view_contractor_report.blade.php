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
                    <td colspan="3" >{{$contractor['name']}}</td>
                    <td colspan="10"></td>
                </tr>
            </tbody>
        </table>
        <hr style="width:200px;margin-left:0;">
        <table>
            <tbody>
            @foreach($contractor['jobs'] as $job)
                <tr>
                    <td style="width: 80px"></td>
                    <td style="width: 90px">{{$job['driver_name']}}</td>
                    <td style="width: 50px">{{$job['driver_no']}}</td>
                    <td style="width: 40px">{{$job['id']}}</td>
                    <td style="width: 45px">{{$job['date']}}</td>
                    <td style="width: 70px">{{$job['member_number']}}</td>
                    <td style="width: 50px">{{$job['member_mobile']}}</td>
                    <td style="width: 50px">{{$job['vehicle_no']}}</td>
                    <td style="width: 80px">{{$job['service_name']}}</td>
                    <td style="width: 100px">{{$job['to_area_name']}}</td>
                    <td style="width: 40px">{{$job['contractor_amount']}}</td>
                    <td style="width: 50px">{{$job['contractor_invoice']}}</td>
                    <td style="width: 60px">{{$job['cheque_no']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <hr>
        <table cellpadding="5px">
            <tbody>
            <tr>
                <td  style="width: 80px" >Total Jobs</td>
                <td  style="width: 90px" >{{$contractor['job_count']}}</td>
                <td style="width: 480px;text-align: right;padding-right: 20px;" >Total Contractor amount</td>
                <td colspan="2" >{{$contractor['jobs_total']}}</td>
            </tr>
            </tbody>
        </table>
        <hr>
        <br>
    @endforeach
    <table cellpadding="5px">
        <tbody>
        <tr>
            <td  style="width: 80px" ></td>
            <td  style="width: 90px" ></td>
            <td style="width: 480px;text-align: right;padding-right: 20px;" >Total  Amount</td>
            <td colspan="2" >{{number_format($total_contractor_amount , 3)}}</td>
        </tr>
        </tbody>
    </table>
    <hr>

</body>
</html>