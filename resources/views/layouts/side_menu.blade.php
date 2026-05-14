<?php
$nav_role = \App\Role::findOrFail(\Illuminate\Support\Facades\Auth::user()->role_id);
$nav_features = user_features();
$nav_is_admin = $nav_role->is_superadmin;
//dd(Auth::user());
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{url('home')}}" class="brand-link">
        <img src="{{asset('storage/app/'.get_company()->logo)}}"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{get_company()->name}}</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('storage/app/'.Auth::user()->photo)}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->name}}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Navigation</li>
                <li class="nav-item">
                    <a href="{{url('home')}}" class="nav-link {{areActiveRoutes(['home'])}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @if($nav_is_admin == 1 || in_array(2 , $nav_features))
                <li class="nav-item">
                    <a href="{{url('job')}}" class="nav-link {{areActiveRoutes(['job.index' , 'job.create','job.edit',
                    'assigned_jobs','not_done_jobs',
                    'completed_jobs','cancelled_jobs','all_jobs'])}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Jobs</p>
                    </a>
                </li>
                @endif

                <li class="nav-item {{areActiveMenu(['vehicleBrand.index' , 'vehicleBrand.create', 'vehicleBrand.edit',
                                                    'vehicleType.index', 'vehicleType.create','vehicleType.edit',
                                                    'registrationType.index', 'registrationType.create','registrationType.edit'])}}">
                    <a href="#"
                       class="nav-link {{areActiveRoutes(['vehicleBrand.index', 'vehicleBrand.create','vehicleBrand.edit',
                                                    'vehicleType.index', 'vehicleType.create','vehicleType.edit',
                                                    'registrationType.index', 'registrationType.create','registrationType.edit'])}}">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            Vehicles
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if($nav_is_admin == 1 || in_array(13 , $nav_features))
                        <li class="nav-item">
                            <a href="{{ route('vehicleBrand.index') }}"
                               class="nav-link {{areActiveRoutes(['vehicleBrand.index', 'vehicleBrand.create','vehicleBrand.edit'])}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Brand Master</p>
                            </a>
                        </li>
                        @endif
                        @if($nav_is_admin == 1 || in_array(17 , $nav_features))
                        <li class="nav-item">
                            <a href="{{ route('vehicleType.index') }}"
                               class="nav-link {{areActiveRoutes(['vehicleType.index', 'vehicleType.create','vehicleType.edit'])}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Type Master</p>
                            </a>
                        </li>
                        @endif
                        @if($nav_is_admin == 1 || in_array(21 , $nav_features))
                        <li class="nav-item">
                            <a href="{{ route('registrationType.index') }}"
                               class="nav-link {{areActiveRoutes(['registrationType.index', 'registrationType.create','registrationType.edit'])}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Registration Type Master</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                <li
                        class="nav-item {{areActiveMenu(['serviceCountry.index' , 'serviceCountry.create', 'serviceCountry.edit',
                                                    'serviceArea.index', 'serviceArea.create','serviceArea.edit',
                                                    'service.index', 'service.create','service.edit'])}}">
                    <a href="#" class="nav-link {{areActiveRoutes(['serviceCountry.index', 'serviceCountry.create','serviceCountry.edit',
                                                    'serviceArea.index', 'serviceArea.create','serviceArea.edit',
                                                    'service.index', 'service.create','service.edit'])}}">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            Services
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('serviceCountry.index') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['serviceCountry.index', 'serviceCountry.create','serviceCountry.edit'])}}">--}}

                            {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Service Country Master</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}

                        @if($nav_is_admin == 1 || in_array(25 , $nav_features))
                        <li class="nav-item">
                            <a href="{{ route('serviceArea.index') }}"
                               class="nav-link {{areActiveRoutes(['serviceArea.index', 'serviceArea.create','serviceArea.edit'])}}">
                            <i class="far fa-circle nav-icon"></i>
                                <p>Service Area Master</p>
                            </a>
                        </li>
                        @endif
                        @if($nav_is_admin == 1 || in_array(29 , $nav_features))
                        <li class="nav-item">
                            <a href="{{ route('service.index') }}"
                               class="nav-link {{areActiveRoutes(['service.index', 'service.create','service.edit'])}}">

                            <i class="far fa-circle nav-icon"></i>
                                <p>Service Master</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                <li class="nav-item {{areActiveMenu(['contractors.index' , 'contractors.create', 'contractors.edit',
                                                    'batch.index' , 'batch.create', 'batch.edit',
                                                    'contractorInvoice' , 'contractorPayment','contractorInquiry'])}}">
                    <a href="#" class="nav-link {{areActiveRoutes(['contractors.index', 'contractors.create','contractors.edit',
                                                'contractorInvoice' , 'contractorPayment','contractorInquiry','batch.index'])}}">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            Contractor
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        @if($nav_is_admin == 1 || in_array(33 , $nav_features))
                        <li class="nav-item">
                            <a href="{{ route('contractors.index') }}"
                               class="nav-link {{areActiveRoutes(['contractors.index', 'contractors.create','contractors.edit'])}}">

                            <i class="far fa-circle nav-icon"></i>
                                <p>Contractors</p>
                            </a>
                        </li>
                        @endif
                        @if($nav_is_admin == 1 || in_array(37 , $nav_features))
                        <li class="nav-item">
                            <a href="{{ route('contractorInvoice') }}"
                               class="nav-link {{areActiveRoutes(['contractorInvoice'])}}">

                            <i class="far fa-circle nav-icon"></i>
                                <p>Contractor Invoice</p>
                            </a>
                        </li>
                        @endif
                        @if($nav_is_admin == 1 || in_array(38 , $nav_features))
                        <li class="nav-item">
                            <a href="{{ route('contractorPayment') }}"
                               class="nav-link {{areActiveRoutes(['contractorPayment'])}}">

                            <i class="far fa-circle nav-icon"></i>
                                <p>Contractor Payments</p>
                            </a>
                        </li>
                        @endif
                        @if($nav_is_admin == 1 || in_array(39 , $nav_features))
                        <li class="nav-item">
                            <a href="{{ route('contractorInquiry') }}"
                               class="nav-link {{areActiveRoutes(['contractorInquiry'])}}">

                            <i class="far fa-circle nav-icon"></i>
                                <p>Contractor Inquiry</p>
                            </a>
                        </li>
                        @endif
                        @if($nav_is_admin == 1 || in_array(93 , $nav_features))
                        <li class="nav-item">
                            <a href="{{ route('batch.index') }}"
                               class="nav-link {{areActiveRoutes(['batch.index', 'batch.create','batch.edit'])}}">

                                <i class="far fa-circle nav-icon"></i>
                                <p>Batches</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>

                @if($nav_is_admin == 1 || in_array(40 , $nav_features))
                <li class="nav-item">
                    <a href="{{route('customers.index')}}"
                       class="nav-link {{areActiveRoutes(['customers.index' , 'customers.create', 'customers.edit'])}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Customers</p>
                    </a>
                </li>
                @endif
                {{--<li--}}
                    {{--class="nav-item {{areActiveMenu(['customers.index' , 'customers.create', 'customers.edit',--}}
                                                    {{--'customerContracts.index', 'customerContracts.create','customerContracts.edit'])}}">--}}
                    {{--<a href="#" class="nav-link {{areActiveRoutes(['customers.index' , 'customers.create', 'customers.edit',--}}
                                                    {{--'customerContracts.index', 'customerContracts.create','customerContracts.edit'])}}">--}}
                        {{--<i class="nav-icon fas fa-circle"></i>--}}
                        {{--<p>--}}
                            {{--Customers--}}
                            {{--<i class="right fas fa-angle-left"></i>--}}
                        {{--</p>--}}
                    {{--</a>--}}
                    {{--<ul class="nav nav-treeview">--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('customers.index') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['customers.index', 'customers.create','customers.edit'])}}">--}}

                            {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Customers</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('customerContracts.index') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['customerContracts.index', 'customerContracts.create','customerContracts.edit'])}}">--}}

                            {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Customer Contracts</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                @if($nav_is_admin == 1 || in_array(44 , $nav_features))
                <li class="nav-item">
                    <a href="{{route('customerServices.index')}}"
                       class="nav-link {{areActiveRoutes(['customerServices.index' , 'customerServices.create', 'customerServices.edit'])}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Customer Services</p>
                    </a>
                </li>
                @endif
                @if($nav_is_admin == 1 || in_array(48 , $nav_features))
                <li class="nav-item">
                    <a href="{{route('membershipTypes.index')}}"
                       class="nav-link {{areActiveRoutes(['membershipTypes.index' , 'membershipTypes.create', 'membershipTypes.edit'])}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Membership Types</p>
                    </a>
                </li>
                @endif
                {{--<li--}}
                    {{--class="nav-item {{areActiveMenu(['membershipTypes.index' , 'membershipTypes.create', 'membershipTypes.edit',--}}
                                                    {{--'membershipServices.index', 'membershipServices.create','membershipServices.edit'])}}">--}}
                    {{--<a href="#" class="nav-link {{areActiveRoutes(['membershipTypes.index' , 'membershipTypes.create', 'membershipTypes.edit',--}}
                                                    {{--'membershipServices.index', 'membershipServices.create','membershipServices.edit'])}}">--}}
                        {{--<i class="nav-icon fas fa-circle"></i>--}}
                        {{--<p>--}}
                            {{--AAA Membership--}}
                            {{--<i class="right fas fa-angle-left"></i>--}}
                        {{--</p>--}}
                    {{--</a>--}}
                    {{--<ul class="nav nav-treeview">--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('membershipTypes.index') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['membershipTypes.index', 'membershipTypes.create','membershipTypes.edit'])}}">--}}

                            {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Membership Type</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('membershipServices.index') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['membershipServices.index', 'membershipServices.create','membershipServices.edit'])}}">--}}

                            {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Membership Services</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}

                @if($nav_is_admin == 1 || in_array(52 , $nav_features))
                <li class="nav-item">
                    <a href="{{route('members.index')}}"
                       class="nav-link {{areActiveRoutes(['members.index' , 'members.create', 'members.edit'])}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Members</p>
                    </a>
                </li>
                @endif
                <li
                        class="nav-item {{areActiveMenu(['aaaCompany.index' , 'aaaCompany.create', 'aaaCompany.edit',
                                                    'aaaPaymentType.index', 'aaaPaymentType.create','aaaPaymentType.edit',
                                                    'aaaDriver.index', 'aaaDriver.create','aaaDriver.edit',
                                                    'aaaVehicle.index', 'aaaVehicle.create','aaaVehicle.edit',
                                                    'aaaSalesman.index', 'aaaSalesman.create','aaaSalesman.edit'])}}">
                    <a href="#" class="nav-link {{areActiveRoutes(['aaaCompany.index' , 'aaaCompany.create', 'aaaCompany.edit',
                                                    'aaaPaymentType.index', 'aaaPaymentType.create','aaaPaymentType.edit',
                                                    'aaaDriver.index', 'aaaDriver.create','aaaDriver.edit',
                                                    'aaaVehicle.index', 'aaaVehicle.create','aaaVehicle.edit',
                                                    'aaaSalesman.index', 'aaaSalesman.create','aaaSalesman.edit'])}}">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            AAA Master
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if($nav_is_admin == 1 || in_array(56 , $nav_features))
                        <li class="nav-item">
                            <a href="{{ route('aaaCompany.index') }}"
                               class="nav-link {{areActiveRoutes(['aaaCompany.index', 'aaaCompany.create','aaaCompany.edit'])}}">
                            <i class="far fa-circle nav-icon"></i>
                                <p>Company Master</p>
                            </a>
                        </li>
                        @endif
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('aaaPaymentType.index') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['aaaPaymentType.index', 'aaaPaymentType.create','aaaPaymentType.edit'])}}">--}}

                            {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Payment Type Master</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('aaaSalesman.index') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['aaaSalesman.index', 'aaaSalesman.create','aaaSalesman.edit'])}}">--}}

                            {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Salesman Master</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        @if($nav_is_admin == 1 || in_array(58 , $nav_features))
                        <li class="nav-item">
                            <a href="{{ route('aaaDriver.index') }}"
                               class="nav-link {{areActiveRoutes(['aaaDriver.index', 'aaaDriver.create','aaaDriver.edit'])}}">

                            <i class="far fa-circle nav-icon"></i>
                                <p>Driver Master</p>
                            </a>
                        </li>
                        @endif
                        @if($nav_is_admin == 1 || in_array(62 , $nav_features))
                        <li class="nav-item">
                            <a href="{{ route('aaaVehicle.index') }}"
                               class="nav-link {{areActiveRoutes(['aaaVehicle.index', 'aaaVehicle.create','aaaVehicle.edit'])}}">

                            <i class="far fa-circle nav-icon"></i>
                                <p>Vehicle Master</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @if($nav_is_admin == 1 || in_array(66 , $nav_features))
                <li class="nav-item">
                    <a href="{{route('reports')}}"
                       class="nav-link {{areActiveRoutes(['reports' , 'getDailyReport' , 'getBatchReport',
                            'getContractorJobReport', 'getServiceAreaJobReport' , 'getAAAVehicleJobReport',
                            'getServiceAreaSummeryJobReport','getAAADriverJobReport', 'getCustomerServiceSummeryJobReport' ,
                            'getCustomerMemberSummeryJobReport' , 'getAreaSummeryChart','getAAAVehicleChart',
                            'getMembersReport','getCustomerMemberJobsReport' , 'getAAAServiceSummeryChart'])}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Reports</p>
                    </a>
                </li>
                @endif

                {{--<li class="nav-item {{areActiveMenu(['getDailyReport' , 'getBatchReport', 'getContractorJobReport',--}}
                {{--'getServiceAreaJobReport' , 'getAAAVehicleJobReport','getServiceAreaSummeryJobReport','getAAADriverJobReport',--}}
                {{--'getCustomerServiceSummeryJobReport' , 'getCustomerMemberSummeryJobReport' , 'getAreaSummeryChart','getAAAVehicleChart',--}}
                {{--'getMembersReport','getCustomerMemberJobsReport' , 'getAAAServiceSummeryChart'])}}">--}}
                    {{--<a href="#" class="nav-link {{areActiveRoutes(['getDailyReport' , 'getBatchReport', 'getContractorJobReport',--}}
                            {{--'getServiceAreaJobReport' , 'getAAAVehicleJobReport','getServiceAreaSummeryJobReport','getAAADriverJobReport',--}}
                            {{--'getCustomerServiceSummeryJobReport' , 'getCustomerMemberSummeryJobReport' , 'getAreaSummeryChart','getAAAVehicleChart',--}}
                            {{--'getMembersReport','getCustomerMemberJobsReport' , 'getAAAServiceSummeryChart'])}}">--}}
                        {{--<i class="nav-icon fas fa-circle"></i>--}}
                        {{--<p>--}}
                            {{--Reports--}}
                            {{--<i class="right fas fa-angle-left"></i>--}}
                        {{--</p>--}}
                    {{--</a>--}}
                    {{--<ul class="nav nav-treeview">--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('getDailyReport') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['getDailyReport'])}}">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Daily Report</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('getBatchReport') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['getBatchReport'])}}">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Batch Report</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('getContractorJobReport') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['getContractorJobReport'])}}">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Contractor wise Report</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('getServiceAreaJobReport') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['getServiceAreaJobReport'])}}">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Service Area Report</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('getAAAVehicleJobReport') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['getAAAVehicleJobReport'])}}">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>AAA Vehicle Wise Report</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('getServiceAreaSummeryJobReport') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['getServiceAreaSummeryJobReport'])}}">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Area wise Jobs Summary Report</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('getAAADriverJobReport') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['getAAADriverJobReport'])}}">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>AAA Driver Wise Report</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('getCustomerServiceSummeryJobReport') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['getCustomerServiceSummeryJobReport'])}}">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Customer - Service Summery Report</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('getCustomerMemberSummeryJobReport') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['getCustomerMemberSummeryJobReport'])}}">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Customer - Member Summery Report</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('getAreaSummeryChart') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['getAreaSummeryChart'])}}">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Area Summery Chart</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('getAAAVehicleChart') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['getAAAVehicleChart'])}}">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>AAA Vehicle Summery Chart</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('getMembersReport') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['getMembersReport'])}}">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Members List</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('getCustomerMemberJobsReport') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['getCustomerMemberJobsReport'])}}">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Customer - Members Wise Report</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('getAAAServiceSummeryChart') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['getAAAServiceSummeryChart'])}}">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>AAA - Sevice Summery Chart</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}

                    {{--</ul>--}}
                {{--</li>--}}


                <li class="nav-header">Super Admin</li>
                @if($nav_is_admin == 1 || in_array(81 , $nav_features))
                <li class="nav-item">
                    <a href="{{route('roles.index')}}"
                       class="nav-link {{areActiveRoutes(['roles.index' , 'roles.create', 'roles.edit'])}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Privileges Roles</p>
                    </a>
                </li>
                @endif
                {{--<li class="nav-item {{areActiveMenu(['roles.index' , 'roles.create', 'roles.edit'])}}">--}}
                    {{--<a href="#" class="nav-link {{areActiveRoutes(['roles.index' , 'roles.create', 'roles.edit'])}}">--}}
                        {{--<i class="nav-icon fas fa-circle"></i>--}}
                        {{--<p>--}}
                            {{--Privileges Roles--}}
                            {{--<i class="right fas fa-angle-left"></i>--}}
                        {{--</p>--}}
                    {{--</a>--}}
                    {{--<ul class="nav nav-treeview">--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('roles.create') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['roles.create'])}}">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Add New Privilege</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('roles.index') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['roles.index'])}}">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>List Privilege</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                @if($nav_is_admin == 1 || in_array(85 , $nav_features))
                <li class="nav-item">
                    <a href="{{route('users.index')}}"
                       class="nav-link {{areActiveRoutes(['users.index' , 'users.create', 'users.edit'])}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Users</p>
                    </a>
                </li>
                @endif
                {{--<li class="nav-item {{areActiveMenu(['users.index' , 'users.create', 'users.edit'])}}">--}}
                    {{--<a href="#" class="nav-link {{areActiveRoutes(['users.index' , 'users.create', 'users.edit'])}}">--}}
                        {{--<i class="nav-icon fas fa-circle"></i>--}}
                        {{--<p>--}}
                            {{--User Management--}}
                            {{--<i class="right fas fa-angle-left"></i>--}}
                        {{--</p>--}}
                    {{--</a>--}}
                    {{--<ul class="nav nav-treeview">--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('users.create') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['users.create'])}}">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Add User</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{ route('users.index') }}"--}}
                               {{--class="nav-link {{areActiveRoutes(['users.index'])}}">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>List Users</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                @if($nav_is_admin == 1 || in_array(89 , $nav_features))
                <li class="nav-item {{areActiveMenu(['app_settings' , 'email_settings'])}}">
                    <a href="#" class="nav-link {{areActiveRoutes(['app_settings' , 'email_settings'])}}">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if($nav_is_admin == 1 || in_array(90 , $nav_features))
                        <li class="nav-item">
                            <a href="{{ route('app_settings') }}"
                               class="nav-link {{areActiveRoutes(['app_settings'])}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Application Settings</p>
                            </a>
                        </li>
                        @endif
                        @if($nav_is_admin == 1 || in_array(91 , $nav_features))
                        <li class="nav-item">
                            <a href="{{ route('email_settings') }}"
                               class="nav-link {{areActiveRoutes(['email_settings'])}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>E-mail Settings</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if($nav_is_admin == 1 || in_array(92 , $nav_features))
                <li class="nav-item">
                    <a href="{{route('userLogs')}}"
                       class="nav-link {{areActiveRoutes(['userLogs'])}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>User Log</p>
                    </a>
                </li>
                @endif
                @if($nav_is_admin == 1 || in_array(102 , $nav_features))
                <li class="nav-item">
                    <a href="{{route('backup')}}"
                       class="nav-link {{areActiveRoutes(['backup'])}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Database Backup</p>
                    </a>
                </li>
                @endif

            </ul>
        </nav>
    </div>
</aside>
