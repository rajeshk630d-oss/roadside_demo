@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Reports</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Reports</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <ol>
                                    @if(is_have_access(67))
                                        <li><a href="{{ route('getDailyReport') }}">Daily Report</a></li>
                                    @endif
                                    @if(is_have_access(68))
                                        <li><a href="{{ route('getBatchReport') }}">Batch Report</a></li>
                                    @endif
                                    @if(is_have_access(100))
                                        <li><a href="{{ route('getCustomerDailyReport') }}">Customer Wise Jobs Report</a></li>
                                    @endif
                                    @if(is_have_access(69))
                                        <li><a href="{{ route('getContractorJobReport') }}">Contractor wise Report</a></li>
                                    @endif
                                    @if(is_have_access(70))
                                        <li><a href="{{ route('getServiceAreaJobReport') }}">Service Area Report</a></li>
                                    @endif
                                    @if(is_have_access(71))
                                        <li><a href="{{ route('getAAAVehicleJobReport') }}">AAA Vehicle Wise Report</a></li>
                                    @endif
                                    @if(is_have_access(72))
                                        <li><a href="{{ route('getServiceAreaSummeryJobReport') }}">Area wise Jobs Summary Report</a></li>
                                    @endif
                                    @if(is_have_access(73))
                                        <li><a href="{{ route('getAAADriverJobReport') }}">AAA Driver Wise Report</a></li>
                                    @endif
                                    @if(is_have_access(96))
                                        <li><a href="{{ route('getMemberVehicleWiseReport') }}">Member Vehicle Services</a></li>
                                    @endif

                                </ol>
                            </div>
                            <div class="col-6">
                                <ol start="10">
                                    @if(is_have_access(74))
                                    <li><a href="{{ route('getCustomerServiceSummeryJobReport') }}">Customer - Service Summery Report</a></li>
                                    @endif
                                    @if(is_have_access(75))
                                        <li><a href="{{ route('getCustomerMemberSummeryJobReport') }}">Customer - Member Summery Report</a></li>
                                    @endif
                                    @if(is_have_access(76))
{{--                                        <li><a href="{{ route('getAreaSummeryChart') }}">Area Summery Chart</a></li>--}}
                                        {{--<li><a href="#">Area Summery Chart</a></li>--}}
                                    @endif
                                    @if(is_have_access(77))
                                        <li><a href="{{ route('getAAAVehicleChart') }}">AAA Vehicle Summery Chart</a></li>
                                        {{--<li><a href="#">AAA Vehicle Summery Chart</a></li>--}}
                                    @endif
                                    @if(is_have_access(78))
                                        <li><a href="{{ route('getMembersReport') }}">Members List</a></li>
                                    @endif
                                    @if(is_have_access(79))
                                        <li><a href="{{ route('getCustomerMemberJobsReport') }}">Customer - Members Wise Report</a></li>
                                    @endif
                                    @if(is_have_access(80))
                                        <li><a href="{{ route('getAAAServiceSummeryChart') }}">AAA - Sevice Summery Chart</a></li>
                                        {{--<li><a href="#">AAA - Sevice Summery Chart</a></li>--}}
                                    @endif
                                    @if(is_have_access(96))
                                        <li><a href="{{ route('getContractorAreaSummeryReport') }}">Contractor - Area Summery Report</a></li>
                                    @endif
                                    @if(is_have_access(98))
                                        <li><a href="{{ route('getDriverWiseJobsReport') }}">Jobs List by Driver</a></li>
                                    @endif
                                    @if(is_have_access(99))
                                        <li><a href="{{ route('getCustomerListReport') }}">Customer List</a></li>
                                    @endif
                                </ol>
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
    <script src="{{asset('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('public/plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('public/plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('public/plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <script>
        $('.select2').select2()
    </script>
@endsection

