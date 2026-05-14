@extends('layouts.app')

@section('content')
    <style>
        @media print{
            .no-print, .no-print *
            {
                display: none !important;
            }
            @page {size: landscape}
        }

    </style>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Area wise Summary Chart</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('reports')}}">Reports</a></li>
                            <li class="breadcrumb-item active">Area wise Summary Chart</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header" style="text-align:center;">
                                <h1> <img src="{{url($company_logo)}}" style="width: 100px"> {{$company_name}}</h1>
                                <h2>Areawise Jobs</h2>
                                <h4>From the period of {{$from_date}} To  {{$to_date}}</h4>
                            </div>
                            <div class="card-body" id="to-print">
                                <div class="chart">
                                    <canvas id="barChart" style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;"></canvas>
                                    {{--<canvas id="barChart" ></canvas>--}}

                                </div>
                            </div>
                            <div class="card-footer no-print">
                                <button onclick="printDiv()" class="btn btn-success"> Print</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="{{asset('public/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script>
        $('.select2').select2()
    </script>
    <script>
        var areas = {!! json_encode($areas) !!};
        var colors = {!! json_encode($colors) !!};
        var area_counts = {!! json_encode($area_counts) !!};
        console.log(typeof areas);
        $(function () {
//            var areas = ["Africa", "Asia", "Europe", "Latin America", "North America", "America"];


//            areas = ["Africa", "Asia", "Europe", "Latin America", "North America", "America"];
            console.log(typeof areas);
            new Chart(document.getElementById("barChart"), {
                type: 'bar',
                data: {
                    labels: areas,
                    datasets: [
                        {
                            label: "Jobs",
                            backgroundColor: colors,
                            data: area_counts
                        }
                    ]
                },
                options: {
                    legend: { display: false },
                    title: {
                        display: true
                    }
                }
            });
        })
    </script>
    <script>
        function printDiv() {
            window.addEventListener("load", window.print());
        }
    </script>
@endsection

