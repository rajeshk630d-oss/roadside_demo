<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
    body { font-family: DejaVu Sans, sans-serif; }
</style>

<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        /** Define the margins of your page **/
        @page {
            margin: 100px 25px;
            size: landscape;
            font-size: 5px;
            font-family: 'dejavu sans', sans-serif;

        }

        .pagenum:before {
            content: counter(page);
        }
    </style>
</head>
<body>

    <?php $service_count = 0; ?>
    @foreach($services as $service)
        <table>
            <tbody>
                <tr>
                    <td style="width: 100px">{{$service['service_name']}}</td>
                    <td style="width: 100px"></td>
                    <td style="width: 50px"></td>
                    <td style="width: 50px"></td>
                    <td style="width: 50px"></td>
                    <td style="width: 70px"></td>
                    <td style="width: 120px"></td>
                    <td style="width: 70px"></td>
                    <td style="width: 120px"></td>
                    <td style="width: 70px"></td>
                </tr>
            </tbody>
        </table>
        <hr style="width: 100px;">
        <?php $service_count++;$service_area_count = 0;$service_job_count = 0; ?>
        @foreach($service['from_areas'] as $area)
            <?php $service_area_count++; ?>
            <table>
                <tbody>
                <tr>
                    <td style="width: 100px"></td>
                    <td style="width: 100px">{{$area['from_area_name']}}</td>
                    <td style="width: 50px"></td>
                    <td style="width: 50px"></td>
                    <td style="width: 50px"></td>
                    <td style="width: 70px"></td>
                    <td style="width: 120px"></td>
                    <td style="width: 70px"></td>
                    <td style="width: 120px"></td>
                    <td style="width: 70px"></td>
                </tr>
                </tbody>
            </table>
            <hr style="width: 200px">
            <table>
                <tbody>
                @foreach($area['jobs'] as $job)
                    <?php $service_job_count++; ?>
                    <tr>
                        <td style="width: 100px"></td>
                        <td style="width: 100px"></td>
                        <td style="width: 50px">{{$job['id']}}</td>
                        <td style="width: 60px">{{display_date($job['date'])}}</td>
                        <td style="width: 50px">{{$job['vehicle_no']}}</td>
                        <td style="width: 50px">{{$job['member_number']}}</td>
                        <td style="width: 120px">{{$job['customer_name']}}</td>
                        <td style="width: 70px">{{$job['member_mobile']}}</td>
                        <td style="width: 120px">{{$job['driver_name']}}</td>
                        <td style="width: 70px">{{$job['driver_no']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <hr style="margin-left: 270px">
            <table>
                <tbody>
                <tr>
                    <td style="width: 100px"></td>
                    <td style="width: 100px"></td>
                    <td style="width: 50px">{{count($area['jobs'])}}</td>
                    <td style="width: 60px"></td>
                    <td style="width: 50px"></td>
                    <td style="width: 50px"></td>
                    <td style="width: 120px"></td>
                    <td style="width: 70px"></td>
                    <td style="width: 120px"></td>
                    <td style="width: 70px"></td>

                </tr>
                </tbody>
            </table>
            @if($service_area_count != count($service['from_areas']))
            <hr style="margin-left: 270px">
            @endif
        @endforeach

        @if($service_area_count != count($service['from_areas']))
            <hr style="margin-left: 300px">
        @else
            <hr style="margin-left: 130px">
            <table>
                <tbody>
                <tr>
                    <td style="width: 100px"></td>
                    <td style="width: 100px"></td>
                    <td style="width: 50px">{{$service_job_count}}</td>
                    <td style="width: 60px"></td>
                    <td style="width: 50px"></td>
                    <td style="width: 50px"></td>
                    <td style="width: 120px"></td>
                    <td style="width: 70px"></td>
                    <td style="width: 120px"></td>
                    <td style="width: 70px"></td>

                </tr>
                </tbody>
            </table>
            @if(count($services) != $service_count)
            <hr style="margin-left: 130px">
            @endif
        @endif
    @endforeach
    <hr>
    <table>
        <tbody>
        <tr>
            <td style="width: 100px"></td>
            <td style="width: 100px"></td>
            <td style="width: 50px">{{$total_jobs_count}}</td>
            <td style="width: 50px"></td>
            <td style="width: 50px"></td>
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