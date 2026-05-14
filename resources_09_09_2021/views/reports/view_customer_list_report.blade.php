<html>

<style>
    body { font-family: DejaVu Sans, sans-serif; }
</style>

<body>
    <table >
        <tbody>
        @foreach($customers as $key => $customer)
            <tr>
                <td style="width: 100px">{{$key+1}}</td>
                <td style="width: 100px">{{$customer['type']}}</td>
                <td style="width: 200px">{{$customer['name']}}</td>
                <td style="width: 100px">{{display_date_time($customer['created_at'])}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</body>
</html>