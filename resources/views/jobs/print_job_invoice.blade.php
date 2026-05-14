<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice-{{$job->invoice_no}}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('storage/app/'.get_company()->logo)}}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('public/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="{{asset('public/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <?php $company = get_company(); ?>
                                        <img src="{{asset('storage/app/'.get_company()->logo)}}"
                                             class="brand-image img-circle elevation-3"
                                             style="opacity: .8;height: 40px;width: 40px"> {{ $company->name }}
                                        <small class="float-right">
                                            Date: {{ \Carbon\Carbon::parse($job->date)->format('d-m-Y') }}
                                        </small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-3 invoice-col">
                                    From
                                    <address>
                                        <strong>{{$company->name }}</strong><br>
                                        795 Folsom Ave, Suite 600<br>
                                        San Francisco, CA 94107<br>
                                        Phone: (804) 123-5432<br>
                                        Email: info@almasaeedstudio.com
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 invoice-col">
                                    To
                                    <address>
                                        <strong>{{ $job->customer_name }}</strong><br>
                                        795 Folsom Ave, Suite 600<br>
                                        San Francisco, CA 94107<br>
                                        Phone: (555) 539-1037<br>
                                        Email: john.doe@example.com
                                    </address>
                                </div>
                                <div class="col-6">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th style="width:50%">Vehicle :</th>
                                                <td>{{ $job->vehicle_no ?? "---" }}</td>
                                            </tr>
                                            <tr>
                                                <th style="width:50%">Amount :</th>
                                                <td>{{ number_format($job->amount , 3) }}</td>
                                            </tr>
                                            @if($job->assign_to == 1)
                                                <tr>
                                                    <th>Contractor Amount</th>
                                                    <td>{{ number_format($job->contractor_amount , 3) }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th>Shipping:</th>
                                                <td>$5.80</td>
                                            </tr>
                                            <tr>
                                                <th>Total:</th>
                                                <td>$265.24</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="{{asset('public/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('public/dist/js/adminlte.js')}}"></script>
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>
</html>

