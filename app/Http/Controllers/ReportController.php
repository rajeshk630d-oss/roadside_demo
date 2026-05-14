<?php

namespace App\Http\Controllers;

use App\Contractor;
use App\Customer;
use App\Driver;
use App\Job;
use App\JobData;
use App\Member;
use App\Service;
use App\ServiceAreas;
use App\User;
use App\UserLog;
use App\Vehicle;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
//use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;

class ReportController extends Controller
{
    public function __construct()
    {
        ini_set('max_execution_time', '0');
        ini_set("memory_limit", "-1");
    }
    public function index(){
        return view('reports.index');
    }

    //--------------------not completed------------------------

    public function getAAAVehicleChart (){
        return view('reports.get_aaa_vehicle_chart');
    }
    public function viewAAAVehicleChart (Request $request){
        $from_date = str_replace('T', ' ' , $request->from_date );
        $to_date = str_replace('T', ' ' , $request->to_date );
        $from_date = Carbon::parse($from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($to_date)->format('Y-m-d H:i:s');
        $counts = JobData::select('id','vehicle_id' ,'aaa_vehicle_no', DB::raw('count(*) as job_count'))
            ->where('assign_to' , 0)
            ->whereNotIn('status' , [3 , 4])
            ->where('created_at' , '>=' , $from_date)
            ->where('created_at' , '<=' , $to_date)
            ->groupBy('vehicle_id')
            ->orderBy('aaa_vehicle_no' , 'ASC')
            ->get()->toArray();
        $vehicle_ids = [];
        $vehicle_nos = [];
        $colors=[];
        $area_counts=[];
        $output = [];
        foreach($counts as $count){
            $vehicle_ids[] =  $count['vehicle_id'];
            $vehicle_nos[] =  $count['aaa_vehicle_no'];
            $area_counts[] = $count['job_count'];
            $colors[] =  rand_color();
            $array = array(
                'vehicle_id' => $count['vehicle_id'],
                'vehicle_no' => $count['aaa_vehicle_no'],
                'count' => $count['job_count']
            );
            if($count['job_count'] > 0) {
                $output[] = $array;
            }
        }
        if(count($output) == 0){
            return back()->with('flash_error' , 'No jobs found.');
        }
        $from_date = Carbon::parse($from_date)->format('d-m-Y h:i:s A');
        $to_date = Carbon::parse($to_date)->format('d-m-Y h:i:s A');
        $company_name = get_company()->name;
        $company_logo = 'storage/app/'.get_company()->logo;
        $print_time = Carbon::now()->format('h:i:s A');
        $print_date = Carbon::now()->format('d/m/Y');

        return view('reports.view_aaa_vehicle_jobs_chart' , compact('from_date' , 'to_date',
            'company_name','company_logo','print_time' , 'print_date' , 'vehicle_ids' ,'vehicle_nos' , 'area_counts' , 'colors'));

    }

    public function getAAAServiceSummeryChart (){
        $services = Service::where('is_active' , 1)->get();
        return view('reports.get_service_area_summery_report',compact('services'));
    }
    public function viewAAAServiceSummeryChart (Request $request){
        $from_date = str_replace('T', ' ' , $request->from_date );
        $to_date = str_replace('T', ' ' , $request->to_date );
        $from_date = Carbon::parse($from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($to_date)->format('Y-m-d H:i:s');
        if($request->service_id == 0 || $request->service_id == "" ){
            $service_name = "ALL";
            $services = Service::select('id' , 'name')->where('is_active' , 1)->get()->toArray();
        }
        else{
            $service = Service::find($request->service_id);
            $service_name = $service->name;
            $services = Service::select('id' , 'name')->where('id' , $request->service_id)->get()->toArray();
        }
        $counts = JobData::select('service_master_id' , 'to_area', 'to_area_name', 'service_name' ,
            DB::raw('count(*) as job_count'))
            ->where('created_at' , '>=' , $from_date)
            ->where('created_at' , '<=' , $to_date)
            ->groupBy('service_master_id' , 'to_area')
            ->orderBy('service_master_id' , 'ASC')
            ->orderBy('to_area' , 'ASC')
            ->get()->toArray();
        $services = array();
        foreach($counts as $count){
            $array = array(
                'to_area_name' => $count['to_area_name'],
                'count' => $count['job_count']
            );
            $services[$count['service_master_id']]['name'] = $count['service_name'];
            if(isset($services[$count['service_master_id']]['total_job_count'])){
                $services[$count['service_master_id']]['total_job_count'] += $count['job_count'];
            }else{
                $services[$count['service_master_id']]['total_job_count'] = $count['job_count'];
            }
            $services[$count['service_master_id']]['jobs_count'][$count['to_area']] = $array;
        }
//        dd($services);
        $from_date = Carbon::parse($from_date)->format('d-m-Y h:i:s A');
        $to_date = Carbon::parse($to_date)->format('d-m-Y h:i:s A');
//        dd($from_date);
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['services'] = $services;
        $data['company_name'] = get_company()->name;
        $data['company_logo'] = 'storage/app/'.get_company()->logo;
        $data['print_time'] = Carbon::now()->format('h:i:s A');
        $data['print_date'] = Carbon::now()->format('d/m/Y');
        $pdf = PDF::loadView('reports.view_service_area_summery_report', $data)->setPaper('a4', 'landscape');
        return $pdf->download('ServiceAreaSummery.pdf');
        return $pdf->stream();
    }

    //------------------------------------------------- completed ------------------------------------

    public function getCustomerListReport(){
        $customers = Customer::where('is_active' , 1)->get();
//        $data['customers'] = $customers;
//        $data['company_name'] = get_company()->name;
//        $data['company_logo'] = 'storage/app/'.get_company()->logo;
//        $data['print_time'] = Carbon::now()->format('h:i:s A');
//        $data['print_date'] = Carbon::now()->format('d/m/Y');
//        $pdf = PDF::loadView('reports.view_customer_list_report', $data);
        $company_name = get_company()->name;
        $company_logo = 'storage/app/'.get_company()->logo;
        $print_time = Carbon::now()->format('h:i:s A');
        $print_date = Carbon::now()->format('d/m/Y');

        $view = view('reports.view_customer_list_report' , compact('company_name','company_logo','print_time',
            'print_date','customers'));

        $html = $view->render();
        $pdf = new TCPDF();

        $pdf::setHeaderCallback(function($pdf) use ($company_name ,$company_logo,$print_time,
            $print_date) {
            $pdf->Ln(10);
            $tbl = '<table style="font-size: 10px">
                        <tr>
                            <td align="left"><b>'.$company_name.'</b></td>
                            <td align="center"><img height="30px" width="100px" src="'.asset($company_logo).'" ></td>
                            <td align="right">Print Date : '.$print_date.'<br />Print Time : '.$print_time.'</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left"><b>Customer List</b></td>
                            <td align="right" >Page no '.$pdf->getPage().'</td>
                        </tr>
                    </table>
                    ';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
            $tbl = '<table style="font-size: 9px">
                        <tr>
                            <td style="width: 105px">S.No #</td>
                            <td style="width: 100px">Type</td>
                            <td style="width: 200px">Name</td>
                            <td style="width: 100px">Created Date</td>
                        </tr>
                    </table>';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
        });
        $pdf::AddPage();
        $pdf::SetFontSize(8);
        $pdf::setTopMargin(38);

        $pdf::writeHTML($html, true, false, true, false, '');
        $filename = 'CustomerList.pdf';
        $pdf::output($filename , 'D');
//
//
//        return $pdf->download('CustomerListReport.pdf');
//        return $pdf->stream();
    }

    public function getServiceAreaJobReport (){
        $areas = ServiceAreas::where('is_active' , 1)->get();
        $services = Service::where('is_active' , 1)->get();
        return view('reports.get_service_area_report',compact('areas'  ,'services'));
    }
    public function ViewServiceAreaJobReport(Request $request){

        $from_date = Carbon::parse($request->from_date)->format('Y-m-d');
        $to_date = Carbon::parse($request->to_date)->format('Y-m-d');
        if($request->from_area == 0 || $request->from_area == "" ){
            $from_area_name = "ALL";
        }else{
            $from_area = ServiceAreas::find($request->from_area);
            $from_area_name = $from_area->name;
        }
        if($request->to_area == 0 || $request->to_area == "" ){
            $to_area_name = "ALL";
        }else{
            $to_area = ServiceAreas::find($request->to_area);
            $to_area_name = $to_area->name;
        }
        $jobs = JobData::select('id','service_master_id','service_name','from_area','from_area_name',
            'to_area','to_area_name','vehicle_no','date',
            'member_number','customer_name','member_mobile','driver_name','driver_no');
        if($request->has('service_id') && $request->service_id != 0 && $request->service_id != ""){
            $jobs = $jobs->where('service_master_id',$request->service_id);
        }
        if($request->has('from_area') && $request->from_area != 0 && $request->from_area != ""){
            $jobs = $jobs->where('from_area',$request->from_area);
        }
        if($request->has('to_area') && $request->to_area != 0 && $request->to_area != ""){
            $jobs = $jobs->where('to_area',$request->to_area);
        }

        $jobs = $jobs->where('created_at' , '>=' , $from_date)
            ->where('created_at' , '<=' , $to_date)
            ->orderBy('service_name' , 'ASC')
            ->orderBy('from_area_name' , 'ASC')
            ->get()->toArray();
        $total_jobs_count = count($jobs);
        $services = array();
        foreach($jobs as $job){
            $services[$job['service_master_id']]['service_name'] = $job['service_name'];
            $services[$job['service_master_id']]['from_areas'][$job['from_area']]['from_area_name'] = $job['from_area_name'];
            $services[$job['service_master_id']]['from_areas'][$job['from_area']]['jobs'][] = $job;
        }
        $from_date = Carbon::parse($from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($to_date)->format('Y-m-d H:i:s');
        $company_name = get_company()->name;
        $company_logo = 'storage/app/'.get_company()->logo;
        $print_time = Carbon::now()->format('h:i:s A');
        $print_date = Carbon::now()->format('d/m/Y');
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['services'] = $services;
        $data['total_jobs_count'] = $total_jobs_count;

        $data['company_name'] = get_company()->name;
        $data['company_logo'] = 'storage/app/'.get_company()->logo;
        $data['print_time'] = Carbon::now()->format('h:i:s A');
        $data['print_date'] = Carbon::now()->format('d/m/Y');
        $filename = 'ServiceAreadetailedReport.pdf';
        $view = view('reports.view_service_area_jobs_report' , compact('company_name','company_logo','print_time',
            'print_date','from_date','to_date' , 'services' , 'total_jobs_count'));

        $html = $view->render();
        $pdf = new TCPDF('L');
        $pdf::setHeaderCallback(function($pdf) use ($company_name ,$company_logo,$print_time,
            $print_date,$from_date,$to_date) {
            $pdf->Ln(10);
            $tbl = '<table style="font-size: 10px">
                        <tr>
                            <td align="left"><b>'.$company_name.'</b></td>
                            <td align="center"><img height="30px" width="100px" src="'.asset($company_logo).'" ></td>
                            <td align="right">Print Date : '.$print_date.'<br />Print Time : '.$print_time.'</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">Service-Area jobs Detailed Report for the period of <b>'.display_date_time($from_date).' - '.display_date_time($to_date).'</b></td>
                            <td align="right" >Page no '.$pdf->getPage().'</td>
                        </tr>                 
                    </table>
                    ';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
            $tbl = '<table style="font-size: 9px">
                        <tr>
                            <td style="width: 105px">Service</td>
                            <td style="width: 100px">From Area</td>
                            <td style="width: 55px">Job No</td>
                            <td style="width: 55px">Job Date</td>
                            <td style="width: 50px">Vehicle No</td>
                            <td style="width: 50px">Member No</td>
                            <td style="width: 120px">Customer</td>
                            <td style="width: 70px">Mobile No.</td>
                            <td style="width: 120px">Driver Name</td>
                            <td style="width: 70px">Driver No</td>
                        </tr>
                    </table>';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
        });
        $pdf::AddPage('L', 'A4');
        $pdf::SetFontSize(8);
        $pdf::setTopMargin(38);

        $pdf::writeHTML($html, true, false, true, false, '');

        $pdf::output($filename , 'D');

//        return view('reports.view_service_area_jobs_report' , compact('company_name','company_logo','print_time',
//            'print_date','from_date','to_date' , 'services' , 'total_jobs_count'));
//        return $pdf->stream();
    }

    public function getDriverWiseJobsReport(){
        $drivers = Driver::select('id' , 'name')->where('is_active' , 1)->get();
        return view('reports.get_driver_report',compact('drivers'));
    }
    public function ViewDriverWiseJobsReport(Request $request){
        $from_date = str_replace('T', ' ' , $request->from_date );
        $to_date = str_replace('T', ' ' , $request->to_date );
        $from_date = Carbon::parse($from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($to_date)->format('Y-m-d H:i:s');
        if($request->driver_id == NULL || $request->driver_id == 0){
            $driver_name = "All";
            $drivers = Driver::select('id','name')->where('is_active' , 1)->orderBy('name' , 'ASC')->get()->toArray();
        }else{
            $driver = Driver::find($request->driver_id);
            $driver_name = $driver->name;
            $drivers = Driver::select('id','name')->where('id' , $request->driver_id)
                ->orderBy('name' , 'ASC')->get()->toArray();
        }
        foreach($drivers as $key => $driver){
            $jobs = JobData::select('id','date','vehicle_no','member_number','member_name','member_mobile',
                'service_name','from_area_name','to_area_name','amount','aaa_vehicle_no', 'driver_name' , 'driver_no','created_at',
                'contractor_amount')
                ->where('assign_to' , 0)
                ->where('driver_id' , $driver['id'])
                ->where('date' ,'>=' , $from_date)
                ->where('date' ,'<=' , $to_date)->get()->toArray();
            foreach($jobs as $key2 => $job){
                $jobs[$key2]['amount'] = number_format($job['amount'] , 3);
                $jobs[$key2]['contractor_amount'] = number_format($job['contractor_amount'] , 3);
                $jobs[$key2]['date'] = display_date($job['date']);
                $jobs[$key2]['created_at'] = display_date_time($job['created_at']);
            }
            $drivers[$key]['jobs'] = $jobs;
            if(count($jobs) == 0){
                unset($drivers[$key]);
            }
        }

//        $data['from_date'] = $request->from_date;
//        $data['to_date'] = $request->to_date;

        $data['driver_name'] = $driver_name;
        $company_name = get_company()->name;
        $company_logo = 'storage/app/'.get_company()->logo;
        $print_time = Carbon::now()->format('h:i:s A');
        $print_date = Carbon::now()->format('d/m/Y');


        $filename = 'DriverJobsReport.pdf';
        $view = view('reports.view_driver_jobs_report' , compact('company_name','company_logo','print_time',
            'print_date','from_date','to_date' , 'drivers' ,'driver_name'));

        $html = $view->render();
        $pdf = new TCPDF('L');
        $pdf::setHeaderCallback(function($pdf) use ($company_name ,$company_logo,$print_time,
            $print_date,$from_date,$to_date) {
            $pdf->Ln(10);
            $tbl = '<table style="font-size: 10px">
                        <tr>
                            <td align="left"><b>'.$company_name.'</b></td>
                            <td align="center"><img height="30px" width="100px" src="'.asset($company_logo).'" ></td>
                            <td align="right">Print Date : '.$print_date.'<br />Print Time : '.$print_time.'</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">Jobs done by Drivers for the period of <b>'.display_date_time($from_date).' - '.display_date_time($to_date).'</b></td>
                            <td align="right" >Page no '.$pdf->getPage().'</td>
                        </tr>                 
                    </table>
                    ';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
            $tbl = '<table style="font-size: 7px">
                        <tr>
                            <td style="width: 38px">Job No</td>
                            <td style="width: 40px">Date</td>
                            <td style="width: 40px">Veh No</td>
                            <td style="width: 40px">Mem No</td>
                            <td style="width: 110px">Customer Name</td>
                            <td style="width: 40px">Mem Mobile</td>
                            <td style="width: 55px">Service</td>
                            <td style="width: 70px">From Area</td>
                            <td style="width: 70px">To Area</td>
                            <td style="width: 30px">Job Amt</td>
                            <td style="width: 40px">AAA Vehicle</td>
                            <td style="width: 80px">Driver Name</td>
                            <td style="width: 40px">Driver No</td>
                            <td style="width: 70px">Created At</td>
                            <td style="width: 50px">Cont Amt</td>
                        </tr>
                    </table>';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
        });
        $pdf::AddPage('L', 'A4');
        $pdf::SetFontSize(8);
        $pdf::setTopMargin(38);
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::output($filename , 'D');
    }

    public function getContractorAreaSummeryReport (){
        $areas = ServiceAreas::where('is_active' , 1)->get();
        $contractors = Contractor::where('is_active' , 1)->get();
        return view('reports.get_contractor_area_summery_report',compact('areas' , 'contractors'));
    }
    public function ViewContractorAreaSummeryReport (Request $request){
        $from_date = str_replace('T', ' ' , $request->from_date );
        $to_date = str_replace('T', ' ' , $request->to_date );
        $from_date = Carbon::parse($from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($to_date)->format('Y-m-d H:i:s');
        $counts = JobData::select('contractor_id' , 'contractor_name', 'from_area', 'from_area_name' ,
            DB::raw('count(*) as job_count'));
        if($request->has('contractor_id') && count($request->contractor_id) > 0){
            $counts = $counts->whereIn('contractor_id' ,  $request->contractor_id);
        }
        $counts = $counts->where('assign_to' ,  1)
            ->where('created_at' , '>=' , $from_date)
            ->where('created_at' , '<=' , $to_date)
            ->groupBy('contractor_id' , 'from_area')
            ->orderBy('contractor_name' , 'ASC')
            ->orderBy('from_area_name' , 'ASC')
            ->get()->toArray();
        $contractors = array();

        $total_count = 0;
        foreach($counts as $count){
            $contractors[$count['contractor_id']]['name'] = $count['contractor_name'];
            $contractors[$count['contractor_id']]['jobs'][$count['from_area']]['area_name'] = $count['from_area_name'];
            $contractors[$count['contractor_id']]['jobs'][$count['from_area']]['job_count'] = $count['job_count'];
            if(isset($contractors[$count['contractor_id']]['total_job_count'])){
                $contractors[$count['contractor_id']]['total_job_count'] += $count['job_count'];
            }else{
                $contractors[$count['contractor_id']]['total_job_count']  = $count['job_count'];
            }
            $total_count += $count['job_count'];
        }
        $from_date = Carbon::parse($from_date)->format('d-m-Y h:i:s A');
        $to_date = Carbon::parse($to_date)->format('d-m-Y h:i:s A');
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['contrcators'] = $contractors;
        $data['total_count'] = $total_count;
        $company_name = get_company()->name;
        $company_logo = 'storage/app/'.get_company()->logo;
        $print_time = Carbon::now()->format('h:i:s A');
        $print_date = Carbon::now()->format('d/m/Y');
        $view = view('reports.view_contractor_area_summery_report' , compact('company_name','company_logo','print_time',
            'print_date','contractors','total_count'));

        $html = $view->render();
        $pdf = new TCPDF();

        $pdf::setHeaderCallback(function($pdf) use ($company_name ,$company_logo,$print_time,$from_date,$to_date,
            $print_date) {
            $pdf->Ln(10);
            $tbl = '<table style="font-size: 10px">
                        <tr>
                            <td align="left"><b>'.$company_name.'</b></td>
                            <td align="center"><img height="30px" width="100px" src="'.asset($company_logo).'" ></td>
                            <td align="right">Print Date : '.$print_date.'<br />Print Time : '.$print_time.'</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left"><b><strong>Contractor - Areawise Jobs Summary Report <br>For the period of '.$from_date.'  to '.$to_date.'</strong></b></td>
                            <td align="right" >Page no '.$pdf->getPage().'</td>
                        </tr>
                    </table>
                    ';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
            $tbl = '<table style="font-size: 9px">
                        <tr>
                            <td style="width: 70px"></td>
                            <td style="width: 70px"></td>
                            <td style="width: 185px">Area Name</td>
                            <td style="width: 80px">No of Jobs</td>
                        </tr>
                    </table>';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
        });
        $pdf::AddPage();
        $pdf::SetFontSize(8);
        $pdf::setTopMargin(42);
        $pdf::writeHTML($html, true, false, true, false, '');
        $filename = 'ContractorAreaSummeryReport.pdf';
        $pdf::output($filename , 'D' );

//        $pdf = PDF::loadView('reports.view_contractor_area_summery_report', $data)->setPaper('a4', 'landscape');
//        return $pdf->download('ContractorAreaSummeryReport.pdf');
//        return $pdf->stream();
    }

    public function getCustomerMemberJobsReport (){
        $customers = Customer::where('is_active' , 1)->get();
        return view('reports.get_customer_member_jobs_report',compact('customers'));
    }
    public function viewCustomerMemberJobsReport (Request $request){

        $from_date = str_replace('T', ' ' , $request->from_date );
        $to_date = str_replace('T', ' ' , $request->to_date );
        $from_date = Carbon::parse($from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($to_date)->format('Y-m-d H:i:s');
//        dd($request->all());
        if($request->customer_id == 0 || $request->customer_id == "" ){
            $customer_name = "ALL";
            $member_name = "ALL";
        }
        else{
            $customer  = Customer::find($request->customer_id);
            $customer_name = $customer->name;
            if($request->member_id == 0 || $request->member_id == "" ){
                $member_name = "ALL";
            }
            else{
                $member  = Member::find($request->member_id);
                $member_name = $member->membership_no;
            }
        }

        $jobs = JobData::select('customer_id' , 'member_id', 'customer_name', 'member_name' ,'member_number' , 'id' ,
            'date','vehicle_no' , 'member_mobile' , 'service_name' , 'from_area_name' , 'driver_name' , 'driver_no');
        if($request->customer_id != 0 && $request->customer_id != "" ){
            $jobs = $jobs->where('customer_id' , $request->customer_id);
            if($request->member_id != 0 && $request->member_id != "" ){
                $jobs = $jobs->where('member_id' , $request->member_id);
            }
        }
        $jobs = $jobs->where('created_at' , '>=' , $from_date)
            ->where('created_at' , '<=' , $to_date)
            ->orderBy('customer_name' , 'ASC')
            ->orderBy('member_number' , 'ASC')
            ->orderBy('id' , 'ASC')
            ->get();
        $output = array();
        $total_count = $jobs->count();
        foreach($jobs as $job){
            $output[$job->customer_id]['customer_name'] = $job->customer_name;
            $output[$job->customer_id]['members'][$job->member_number]['member_no'] = $job->member_number;
            $output[$job->customer_id]['members'][$job->member_number]['member_name'] = $job->member_name;
            $output[$job->customer_id]['members'][$job->member_number]['jobs'][] = $job->toArray();
            if(isset($output[$job->customer_id]['customer_jobs_total'])){
                $output[$job->customer_id]['customer_jobs_total'] += 1;
            }else{
                $output[$job->customer_id]['customer_jobs_total'] = 1;
            }
            if(isset($output[$job->customer_id]['members'][$job->member_number]['member_jobs_total'])){
                $output[$job->customer_id]['members'][$job->member_number]['member_jobs_total'] += 1;
            }else{
                $output[$job->customer_id]['members'][$job->member_number]['member_jobs_total'] = 1;
            }
        }

        $from_date = Carbon::parse($from_date)->format('d-m-Y h:i:s A');
        $to_date = Carbon::parse($to_date)->format('d-m-Y h:i:s A');
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $total_count = $total_count;

        $data['customer_name'] = $customer_name;
        $data['member_name'] = $member_name;
        $customers  = $output;
        $company_name = get_company()->name;
        $company_logo = 'storage/app/'.get_company()->logo;
        $print_time = Carbon::now()->format('h:i:s A');
        $print_date = Carbon::now()->format('d/m/Y');

        $filename = 'CustomerMemberJobs.pdf';
        $view = view('reports.view_customer_member_jobs_report' , compact('company_name','company_logo',
            'print_time',
            'print_date','from_date','to_date' ,'customers','customer_name','member_name','total_count'));

        $html = $view->render();

        $pdf = new TCPDF('L');
        $pdf::setHeaderCallback(function($pdf) use ($company_name ,$company_logo,$print_time,$customer_name , $member_name,
            $print_date,$from_date,$to_date) {
            $pdf->Ln(10);
            $tbl = '<table style="font-size: 10px">
                        <tr>
                            <td align="left"><b>'.$company_name.'</b></td>
                            <td align="center"><img height="30px" width="100px" src="'.asset($company_logo).'" ></td>
                            <td align="right">Print Date : '.$print_date.'<br />Print Time : '.$print_time.'</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">Customer - Members Detailed Jobs Report <br>For the period of '.$from_date.' - '.$to_date.'<br>Customer : '.$customer_name.'  Member : '.$member_name.'
                                </td>
                            <td align="right" >Page no '.$pdf->getPage().'</td>
                        </tr>                 
                    </table>
                    ';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
            $tbl = '<table style="font-size: 7px">
                        <tr>
                            <td style="width: 125px"></td>
                            <td style="width: 50px">Member</td>
                            <td style="width: 70px">Name</td>
                            <td style="width: 50px">Job No</td>
                            <td style="width: 60px">Job Date</td>
                            <td style="width: 60px">Vehicle No</td>
                            <td style="width: 60px">Member No</td>
                            <td style="width: 80px">Service</td>
                            <td style="width: 80px">Area</td>
                            <td style="width: 60px">Driver No</td>
                            <td style="width: 100px">Driver Name</td>
                        </tr>
                    </table>';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
        });
        $pdf::AddPage('L', 'A4');
        $pdf::SetFontSize(7);
        $pdf::setTopMargin(45);
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::output($filename , 'D');
        
//        $pdf = PDF::loadView('reports.view_customer_member_jobs_report', $data)->setPaper('a4', 'landscape');
//        return $pdf->stream();
//        return $pdf->download('CustomerMemberJobs.pdf');
    }

    public function getMembersReport (){
        $customers = Customer::where('is_active' , 1)->get();
        return view('reports.get_members_list_report',compact('customers'));
    }
    public function viewMembersReport(Request $request){
        $customer = Customer::find($request->customer_id);
        $members = Member::select('membership_no' , 'member_name', 'vehicle_no', 'engine_no' ,'chassis_no','expiry_date')
            ->where('customer_id' , $request->customer_id)
            ->orderBy('membership_no' , 'ASC')
            ->orderBy('member_name' , 'ASC')
            ->get()->toArray();
        $company_name  = get_company()->name;
        $customer_name  = $customer->name;
        $company_logo  = 'storage/app/'.get_company()->logo;
        $print_time = Carbon::now()->format('h:i:s A');
        $print_date = Carbon::now()->format('d/m/Y');
        $view = view('reports.viewMembersReport' , compact('members'));
        $html = $view->render();
        $pdf = new TCPDF();
        $pdf::setHeaderCallback(function($pdf) use ($company_name ,$company_logo,$print_time,$customer_name,
            $print_date) {
            $pdf->Ln(10);
            $tbl = '<table style="font-size: 10px">
                        <tr>
                            <td align="left"><b>'.$company_name.'</b></td>
                            <td align="center"><img height="30px" width="100px" src="'.asset($company_logo).'" ></td>
                            <td align="right">Print Date : '.$print_date.'<br />Print Time : '.$print_time.'</td>
                        </tr>
                        <tr>
                            <td  align="left"><b>Member List</b></td>
                            <td  align="left"><b>Customer : '.$customer_name.'</b></td>
                            <td align="right" >Page no '.$pdf->getPage().'</td>
                        </tr>
                    </table>
                    ';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
            $tbl = '<table style="font-size: 9px">
                        <tr>
                            <td style="width: 100px">Member No</td>
                            <td style="width: 95px">Vehicle No</td>
                            <td style="width: 85px">Engine No</td>
                            <td style="width: 90px">Chassis No</td>
                            <td style="width: 120px">Name</td>
                            <td style="width: 60px">Expiry Date</td>
                        </tr>
                    </table>';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
        });
        $pdf::AddPage();
        $pdf::SetFontSize(8);
        $pdf::setTopMargin(38);
        $pdf::writeHTML($html, true, false, true, false, '');
        $filename = 'CustomerMembersList.pdf';
        $pdf::output($filename ,'D');
    }

    public function getAreaSummeryChart (){
        $areas = ServiceAreas::where('is_active' , 1)->get();
        return view('reports.get_area_summery_chart',compact('areas'));
    }
    public function ViewAreaSummeryChart (Request $request){
        $from_date = str_replace('T', ' ' , $request->from_date );
        $to_date = str_replace('T', ' ' , $request->to_date );
        $from_date = Carbon::parse($from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($to_date)->format('Y-m-d H:i:s');
        $counts = JobData::select('from_area_name' ,'from_area', DB::raw('count(*) as job_count'))
            ->where('created_at' , '>=' , $from_date)
            ->where('created_at' , '<=' , $to_date)
            ->groupBy('from_area')
            ->orderBy('from_area_name' , 'ASC')
            ->get()->toArray();
        $areas = [];
        $colors=[];
        $area_counts=[];
        $output = [];
        foreach($counts as $count){
            $areas[] =  $count['from_area_name'];
            $area_counts[] = $count['job_count'];
            $colors[] =  rand_color();
            $array = array(
                'from_area_name' => $count['from_area_name'],
                'count' => $count['job_count']
            );
            if($count['job_count'] > 0) {
                $output[] = $array;
            }
        }
        if(count($output) == 0){
            return back()->with('flash_error' , 'No jobs found.');
        }
        $from_date = Carbon::parse($from_date)->format('d-m-Y h:i:s A');
        $to_date = Carbon::parse($to_date)->format('d-m-Y h:i:s A');
        $company_name = get_company()->name;
        $company_logo = 'storage/app/'.get_company()->logo;
        $print_time = Carbon::now()->format('h:i:s A');
        $print_date = Carbon::now()->format('d/m/Y');
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;


        $data['company_name'] = $company_name;
        $data['company_logo'] = $company_logo;
        $data['print_time'] = Carbon::now()->format('h:i:s A');
        $data['print_date'] = Carbon::now()->format('d/m/Y');

        return view('reports.view_area_summery_chart' , compact('from_date' , 'to_date',
            'company_name','company_logo','print_time' , 'print_date' , 'areas' , 'area_counts' , 'colors'));

    }

    public function getCustomerMemberSummeryJobReport (){
        $customers = Customer::where('is_active' , 1)->get();
        return view('reports.get_customer_member_summery_report',compact('customers'));
    }
    public function ViewCustomerMemberSummeryJobReport (Request $request){
        $from_date = str_replace('T', ' ' , $request->from_date );
        $to_date = str_replace('T', ' ' , $request->to_date );
        $from_date = Carbon::parse($from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($to_date)->format('Y-m-d H:i:s');
        if($request->has('customer_id') && $request->customer_id != NULL && $request->customer_id != 0){
            $customer = Customer::find($request->customer_id);
            if($customer != NULL){
                $customer_name = $customer->name;
            }
            else{
                $customer_name = "ALL";
            }
        }else{
            $customer_name = "ALL";
        }
        $counts = JobData::select('customer_id' ,'customer_name' , 'member_number' , 'member_name' ,'member_id',
            DB::raw('count(*) as job_count'));
        if($request->has('customer_id') && $request->customer_id != NULL && $request->customer_id != 0){
            $counts = $counts->where('customer_id' , $request->customer_id);
        }
        $counts = $counts->where('created_at' , '>=' , $from_date)
            ->where('created_at' , '<=' , $to_date)
            ->groupBy('member_number' , 'customer_id')
            ->orderBy('customer_name' , 'ASC')
            ->orderBy('member_name' , 'ASC')
            ->get()->toArray();
        $customers = array();
        foreach($counts as $count){
            $customers[$count['customer_id']]['id'] = $count['customer_id'];
            $customers[$count['customer_id']]['name'] = $count['customer_name'];
            $customers[$count['customer_id']]['job_counts'][$count['member_id']]['member_number'] = $count['member_number'];
            $customers[$count['customer_id']]['job_counts'][$count['member_id']]['name'] = $count['member_name'];
            $customers[$count['customer_id']]['job_counts'][$count['member_id']]['count'] =  $count['job_count'];
            if(isset($customers[$count['customer_id']]['total_job_count'])){
                $customers[$count['customer_id']]['total_job_count'] +=  $count['job_count'];
            }else{
                $customers[$count['customer_id']]['total_job_count'] =  $count['job_count'];
            }
        }
        $from_date = Carbon::parse($from_date)->format('d-m-Y h:i:s A');
        $to_date = Carbon::parse($to_date)->format('d-m-Y h:i:s A');
//        dd($from_date);
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['customers'] = $customers;
        $data['customer_name'] = $customer_name;
        $data['company_name'] = get_company()->name;
        $data['company_logo'] = 'storage/app/'.get_company()->logo;
        $data['print_time'] = Carbon::now()->format('h:i:s A');
        $data['print_date'] = Carbon::now()->format('d/m/Y');

        $from_date = Carbon::parse($from_date)->format('d-m-Y h:i:s A');
        $to_date = Carbon::parse($to_date)->format('d-m-Y h:i:s A');
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;

        $data['customer_name'] = $customer_name;
        $company_name = get_company()->name;
        $company_logo = 'storage/app/'.get_company()->logo;
        $print_time = Carbon::now()->format('h:i:s A');
        $print_date = Carbon::now()->format('d/m/Y');

        $filename = 'CustomerMemberSummery.pdf';
        $view = view('reports.view_customer_member_summery_report' , compact('company_name','company_logo',
            'print_time',
            'print_date','from_date','to_date' ,'customers','customer_name'));

        $html = $view->render();

        $pdf = new TCPDF('L');
        $pdf::setHeaderCallback(function($pdf) use ($company_name ,$company_logo,$print_time,$customer_name ,
            $print_date,$from_date,$to_date) {
            $pdf->Ln(10);
            $tbl = '<table style="font-size: 10px">
                        <tr>
                            <td align="left"><b>'.$company_name.'</b></td>
                            <td align="center"><img height="30px" width="100px" src="'.asset($company_logo).'" ></td>
                            <td align="right">Print Date : '.$print_date.'<br />Print Time : '.$print_time.'</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">Customer - Member Summery Report <br>For the period of '.$from_date.' - '.$to_date.'<br>Customer : '.$customer_name.' 
                                </td>
                            <td align="right" >Page no '.$pdf->getPage().'</td>
                        </tr>                 
                    </table>
                    ';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
            $tbl = '<table style="font-size: 7px">
                        <tr>
                            <td style="width: 155px">Customer</td>
                            <td style="width: 80px">Member No</td>
                            <td style="width: 180px">Member Name</td>
                            <td style="width: 50px">No of Jobs</td>
                        </tr>
                    </table>';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
        });
        $pdf::AddPage();
        $pdf::SetFontSize(7);
        $pdf::setTopMargin(45);
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::output($filename , "D");


//        $pdf = PDF::loadView('reports.view_customer_member_summery_report', $data)->setPaper('a4');
//        return $pdf->download('CustomerMemberSummery.pdf');
//        return $pdf->stream();
    }

    public function getCustomerServiceSummeryJobReport (){
        $customers = Customer::where('is_active' , 1)->get();
        $services = Service::where('is_active' , 1)->get();
        return view('reports.get_customer_service_summery_report',compact('services','customers'));
    }
    public function ViewCustomerServiceSummeryJobReport (Request $request){
        $from_date = str_replace('T', ' ' , $request->from_date );
        $to_date = str_replace('T', ' ' , $request->to_date );
        $from_date = Carbon::parse($from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($to_date)->format('Y-m-d H:i:s');
        if($request->has('customer_id') && $request->customer_id != NULL && $request->customer_id != 0){
            $customer = Customer::find($request->customer_id);
            if($customer != NULL){
                $customer_name = $customer->name;
            }
            else{
                $customer_name = "ALL";
            }
        }else{
            $customer_name = "ALL";
        }
        if($request->has('service_id') && $request->service_id != NULL && $request->service_id != 0){
            $service = Service::find($request->service_id);
            if($service != NULL){
                $service_name = $service->name;
            }
            else{
                $service_name = "ALL";
            }
        }else{
            $service_name = "ALL";
        }
//        dd($request->all());
//        dd($request->all());
        $counts = JobData::select('service_master_id' ,  'service_name' ,'customer_id' ,'customer_name' ,
            DB::raw('count(*) as job_count'));
        if($request->has('customer_id') && $request->customer_id != NULL && $request->customer_id != 0){
            $counts = $counts->where('customer_id' , $request->customer_id);
        }
        if($request->has('service_id') && $request->service_id != NULL && $request->service_id != 0){
            $counts = $counts->where('service_master_id' , $request->service_id);
        }
        $counts = $counts->where('created_at' , '>=' , $from_date)
            ->where('created_at' , '<=' , $to_date)
            ->groupBy('service_master_id' , 'customer_id')
            ->orderBy('service_master_id' , 'ASC')
            ->orderBy('customer_id' , 'ASC')
            ->get()->toArray();

        $customers = array();
        foreach($counts as $count){
            $customers[$count['customer_id']]['id'] = $count['customer_id'];
            $customers[$count['customer_id']]['name'] = $count['customer_name'];
            $customers[$count['customer_id']]['job_counts'][$count['service_master_id']]['name'] = $count['service_name'];
            $customers[$count['customer_id']]['job_counts'][$count['service_master_id']]['count'] =  $count['job_count'];

            if(isset($customers[$count['customer_id']]['total_job_count'])){
                $customers[$count['customer_id']]['total_job_count'] +=  $count['job_count'];
            }else{
                $customers[$count['customer_id']]['total_job_count'] =  $count['job_count'];
            }
        }
        $from_date = Carbon::parse($from_date)->format('d-m-Y h:i:s A');
        $to_date = Carbon::parse($to_date)->format('d-m-Y h:i:s A');
//        dd($from_date);
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['customers'] = $customers;
        $data['customer_name'] = $customer_name;
        $data['service_name'] = $service_name;
        $company_name = $data['company_name'] = get_company()->name;
        $company_logo = $data['company_logo'] = 'storage/app/'.get_company()->logo;
        $print_time = $data['print_time'] = Carbon::now()->format('h:i:s A');
        $print_date = $data['print_date'] = Carbon::now()->format('d/m/Y');


        $filename = 'CustomerServiceSummeryReport.pdf';
        $view = view('reports.view_customer_service_summery_report' , compact('company_name','company_logo',
            'print_time',
            'print_date','from_date','to_date' ,'customers','customer_name','service_name'));

        $html = $view->render();

        $pdf = new TCPDF('L');
        $pdf::setHeaderCallback(function($pdf) use ($company_name ,$company_logo,$print_time,$customer_name ,
            $print_date,$from_date,$to_date) {
            $pdf->Ln(10);
            $tbl = '<table style="font-size: 10px">
                        <tr>
                            <td align="left"><b>'.$company_name.'</b></td>
                            <td align="center"><img height="30px" width="100px" src="'.asset($company_logo).'" ></td>
                            <td align="right">Print Date : '.$print_date.'<br />Print Time : '.$print_time.'</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">Customer - Service Summery Report <br>For the period of '.$from_date.' - '.$to_date.'<br>Customer : '.$customer_name.' 
                                </td>
                            <td align="right" >Page no '.$pdf->getPage().'</td>
                        </tr>                 
                    </table>
                    ';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
            $tbl = '<table style="font-size: 10px">
                        <tr>
                            <td style="width: 155px"></td>
                            <td style="width: 80px">S.No</td>
                            <td style="width: 180px">Area Name</td>
                            <td style="width: 80px">No of Jobs</td>
                            <td style="width: 50px"></td>
                        </tr>
                    </table>';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
        });
        $pdf::AddPage();
        $pdf::SetFontSize(9);
        $pdf::setTopMargin(45);
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::output($filename ,'D');

//        $pdf = PDF::loadView('reports.view_customer_service_summery_report', $data)->setPaper('a4');
//        return $pdf->download('CustomerServiceSummeryReport.pdf');
//        return $pdf->stream();
    }

    public function getDailyReport(){
        $users = User::get();
        foreach($users as $key => $user){
            if($user->role->is_superadmin == 1){
                unset($users[$key]);
            }
        }
        return view('reports.get_daily_report',compact('users'));
    }
    public function viewDailyReport(Request $request){
        ini_set('max_execution_time', '0');
        ini_set("memory_limit", "-1");
        set_time_limit(0);
        
        if($request->has('from_date') && $request->has('to_date') && $request->has('status') ){
//            $jobs = JobData::where('created_at', '>=' ,$request->from_date)
            $jobs = Job::select('jobs.*' , 'user_logs.user_id')
                ->join('user_logs', function($log)
                {
                    $log->on('user_logs.job_id', '=', 'jobs.id');
                    $log->where('user_logs.operation_key', '=', 'ADD_JOB');
                })
                ->where('jobs.created_at', '>=' ,$request->from_date)
                ->where('jobs.created_at', '<=' ,$request->to_date);
            $user_name = "ALL";
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);
            $numberOfDays = $startDate->diffInDays($endDate);

            
            if($request->has('user_id') && $request->user_id == "" && $request->user_id == 0 && $numberOfDays >= 15){
//                return back()->with('flash_error' , 'Please Select User.');
            }
            
            if($request->has('user_id') && $request->user_id != "" && $request->user_id != 0){
                $jobs = $jobs->where('user_id' , $request->user_id);
                $user = User::find($request->user_id);
                $user_name = $user->name;
            }

            if($request->status != 0){
                $jobs = $jobs->where('status' , $request->status);
            }
            $jobs = $jobs->orderBy('date')->get()->toArray();
            if(count($jobs) == 0){
                return back()->with('flash_error' , 'No jobs found.');
            }
            $from_date = Carbon::createFromFormat('Y-m-d',$request->from_date)->format('d/M/Y');
            $to_date = Carbon::createFromFormat('Y-m-d',$request->to_date)->format('d/M/Y');
            $data['jobs'] = $jobs;
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['user_name'] = $user_name;
            $company_name = $data['company_name'] = get_company()->name;
            $company_logo = $data['company_logo'] = 'storage/app/'.get_company()->logo;
            $print_time = $data['print_time'] = Carbon::now()->format('h:i:s A');
            $print_date = $data['print_date'] = Carbon::now()->format('d/m/Y');
            if($request->fileType == 2){
                $heading = array('Job No','Is Credit Cash','Date','Vehicle No','Member Number','Customer Name','Member Mobile','Service Name','From Area Name','To Area Name','Amount','Receipt No','Driver Name','Driver No','Status','Username');
                exportData($data['jobs'],'DailyReport.csv',$heading);
            }
            else if($request->fileType == 1){
            $filename = 'DailyReport.pdf';

            $services_query = Service::all();
            $services = [];
            foreach($services_query as $service){
                $services[$service->id] = $service->name;
            }

            $areas_query = ServiceAreas::all();
            $areas = [];
            foreach($areas_query as $area){
                $areas[$area->id] = $area->name;
            }

            $vehicle_query = Vehicle::all();
            $vehicles = [];
            foreach($vehicle_query as $vehicle){
                $vehicles[$vehicle->id] = $vehicle->vehicle_no;
            }

            $user_query = User::all();
            $users = [];
            foreach($user_query as $user){
                $users[$user->id] = $user->name;
            }

            $contractor_query = Contractor::all();
                $contractors = [];
            foreach($contractor_query as $contractor){
                $contractors[$contractor->id] = $contractor->name;
            }

            $view = view('reports.view_daily_report' , compact('company_name','company_logo',
                'print_time',
                'print_date','from_date','to_date' ,'user_name' , 'jobs' , 'services','areas' , 'vehicles' , 'contractors','users'));

            $html = $view->render();

            $pdf = new TCPDF('L');
            $pdf::setHeaderCallback(function($pdf) use ($company_name ,$company_logo,$print_time,$user_name ,
                $print_date,$from_date,$to_date) {
                $pdf->Ln(10);
                $tbl = '<table style="font-size: 10px">
                        <tr>
                            <td align="left"><b>'.$company_name.'</b></td>
                            <td align="center"><img height="30px" width="100px" src="'.asset($company_logo).'" ></td>
                            <td align="right">Print Date : '.$print_date.'<br />Print Time : '.$print_time.'</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">Daily Report <br>For the period of '.$from_date.' - '.$to_date.'<br>User : '.$user_name.'
                                </td>
                            <td align="right" >Page no '.$pdf->getPage().'</td>
                        </tr>                 
                    </table>
                    ';
                $pdf->writeHTML($tbl, FALSE, false, false, false, '');
                $pdf->Ln(2);
                $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
                $pdf->Ln(2);
                $tbl = '<table style="font-size: 7px">
                        <tr>
                            <th style="width: 35px">Job No</th>
                            <th style="width: 40px">Date</th>
                            <th style="width: 40px">Vehicle No</th>
                            <th style="width: 45px">Member</th>
                            <th style="width: 90px">Customer</th>
                            <th style="width: 40px">Mobile No</th>
                            <th style="width: 60px">Service</th>
                            <th style="width: 70px">From Area</th>
                            <th style="width: 70px">To Area</th>
                            <th style="width: 40px">Job Amount</th>
                            <th style="width: 40px">Rcpt #</th>
                            <th style="width: 80px">Driver Name</th>
                            <th style="width: 40px">Number</th>
                            <th style="width: 40px">Status</th>
                            <th style="width: 60px">User</th>
                        </tr>
        
                    </table>';
                $pdf->writeHTML($tbl, FALSE, false, false, false, '');
                $pdf->Ln(2);
                $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
                $pdf->Ln(2);
            });
            $pdf::AddPage('L', 'A4');
            $pdf::SetFontSize(6);
            $pdf::setTopMargin(45);
            $pdf::writeHTML($html, true, false, true, false, '');
            $pdf::output($filename );


            $pdf = PDF::loadView('reports.view_daily_report', $data)->setPaper('a4', 'landscape');
            return $pdf->stream();
        }
        }else{
            return back()->with('flash_error' , 'Something went wrong');
        }
    }

    public function getBatchReport(){
        $batches = Job::select('batch_no' , 'name')
            ->JOIN('contractors' , 'contractor_id','contractors.id')
            ->groupBy('batch_no')
            ->where('batch_no', '!=', "")
            ->get();
        return view('reports.get_batch_report',compact('batches'));
    }
    public function viewBatchReport(Request $request){

        if($request->has('batch_no')){
            $jobs = Job::with('service' , 'vehicle','from_service_area','to_service_area','contractor')
                ->where('assign_to' , 1)
                ->where('batch_no' , $request->batch_no)
                ->get();
            $job = $jobs[0];
            $contractor_id = $job->contractor_id;
            $contractor = Contractor::findOrFail($contractor_id);
            $contractor_name = $contractor->name;
            $batch_no = $request->batch_no;
            $data['batch_no'] = $batch_no;
            $data['jobs'] = $jobs;
            $data['contractor_name'] = $contractor_name;
            $company_name = get_company()->name;
            $company_logo = 'storage/app/'.get_company()->logo;
            $print_time = Carbon::now()->format('h:i:s A');
            $print_date = Carbon::now()->format('d/m/Y');
            //echo '<pre>';print_r($data);die;
            if($request->fileType == 2){
                $heading = array('S no.','Job No','Vehicle No','Member Mobile','Member Number','Service Name','From Area Name','To Area Name','Contractor Amount','Contractor Invoice','Contractor Invoice Date','ChequeNo');
               $i = 1;
                foreach($jobs as $job){
                    $jodDetails[] = array(
                        'sno' => $i,
                        'id'=>$job->id,
                        'vehicleNo'=>$job->vehicle_no,
                        'memberMobile'=>$job->member_mobile,
                        'memberNumber'=>$job->member_number,
                        'serviceName'=> ($job->service != NULL) ? $job->service->name : "",
                        'fromArea'=>($job->from_service_area != NULL) ? $job->from_service_area->name : "",
                        'toArea'=>($job->to_service_area != NULL) ? $job->to_service_area->name : "",
                        'contractorAmount'=>number_format((float)$job->contractor_amount , 3),
                        'contractorInvoice'=>$job->contractor_invoice,
                        'contractorInvoiceDate'=>display_date($job->contractor_invoice_date),
                        'chequeNo'=>$job->cheque_no,
                        'chequeNo'=>$job->cheque_date != NULL ? display_date($job->cheque_date) : ""
                        );
                }
                //echo '<pre>';print_r($jodDetails);die;
                exportData($jodDetails,'BatchReport.csv',$heading);
            }
           else if($request->fileType == 1){
            $filename = 'BatchReport.pdf';
            $view = view('reports.view_batch_report' , compact('jobs' ,'contractor_name' , 'batch_no'));
            $html = $view->render();
            $pdf = new TCPDF('L');
            $pdf::setHeaderCallback(function($pdf) use ($company_name ,$company_logo,$print_time,$contractor_name ,$batch_no,
                $print_date) {
                $pdf->Ln(10);
                $tbl = '<table >
                        <tr>
                            <td align="left"><b>'.$company_name.'</b></td>
                            <td align="center"><img height="30px" width="100px" src="'.asset($company_logo).'" ></td>
                            <td align="right">Print Date : '.$print_date.'<br />Print Time : '.$print_time.'</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">Batch Report  <br>Batch No. : '.$batch_no.'<br>Contractor : '.$contractor_name.'
                                </td>
                            <td align="right" >Page no '.$pdf->getPage().'</td>
                        </tr>                 
                    </table>
                    ';
                $pdf->writeHTML($tbl, FALSE, false, false, false, '');
                $pdf->Ln(2);
                $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
                $pdf->Ln(2);
                $tbl = '<table style="font-size: 8px">
                            <tr>
                                <th style="width: 40px">S.No</th>
                                <th style="width: 50px">Job No</th>
                                <th style="width: 50px">Vehicle No</th>
                                <th style="width: 50px">Customer No.</th>
                                <th style="width: 60px">Membership #</th>
                                <th style="width: 80px">Service Used</th>
                                <th style="width: 95px">From Area</th>
                                <th style="width: 95px">To Area</th>
                                <th style="width: 50px">Contractor Amount</th>
                                <th style="width: 50px">Invoice #</th>
                                <th style="width: 50px">Date</th>
                                <th style="width: 50px">Chq Number</th>
                                <th style="width: 50px">Chq Date</th>
                            </tr>
                    </table>';
                $pdf->writeHTML($tbl, FALSE, false, false, false, '');
                $pdf->Ln(2);
                $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
                $pdf->Ln(2);
            });
            $pdf::AddPage('L', 'A4');
            $pdf::SetFontSize(8);
            $pdf::setTopMargin(52);
            $pdf::writeHTML($html, true, false, true, false, '');
            $pdf::output($filename ,'D');
}
//            $pdf = PDF::loadView('reports.view_batch_report', $data)->setPaper('a4', 'landscape');
//            return $pdf->download('BatchReport.pdf');
        }else{
            return back()->with('flash_error' , 'Something went wrong');
        }
    }

    public function getCustomerDailyReport(){
        $customers = Customer::select('id' , 'name')->where('is_active' , 1)->get();
        return view('reports.get_customer_daily_report',compact('customers'));
    }
    public function ViewCustomerDailyReport(Request $request){
        set_time_limit(0);
        if($request->has('from_date') && $request->has('to_date') && $request->has('status') ){
            $jobs = JobData::where('created_at', '>=' ,$request->from_date." 00:00:00")
                ->where('created_at', '<=' ,$request->to_date." 23:59:59" );
            if($request->status != 0){
                $jobs = $jobs->where('status' , $request->status);
            }
            if($request->customer_id == NULL || $request->customer_id == 0){
                $customer_name = "All";
            }else{
                $jobs = $jobs->where('customer_id' , $request->customer_id);
                $customer = Customer::find($request->customer_id);
                $customer_name = $customer->name;
            }
            $jobs = $jobs->select('id' , 'is_credit_cash','date' , 'vehicle_no' ,'member_number' , 'customer_name','member_mobile',
                'service_name','from_area_name','to_area_name' , 'amount' , 'receipt_no' , 'driver_name' , 'driver_no','status')
                ->orderBy('date')
                ->get()->toArray();
            if(count($jobs) == 0){
                return back()->with('flash_error' , 'No jobs found.');
            }
            $from_date = Carbon::createFromFormat('Y-m-d',$request->from_date)->format('d/M/Y');
            $to_date = Carbon::createFromFormat('Y-m-d',$request->to_date)->format('d/M/Y');
            $data['jobs'] = $jobs;
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['customer_name'] = $customer_name;

            $company_name = $data['company_name'] = get_company()->name;
            $company_logo = $data['company_logo'] = 'storage/app/'.get_company()->logo;
            $print_time = $data['print_time'] = Carbon::now()->format('h:i:s A');
            $print_date = $data['print_date'] = Carbon::now()->format('d/m/Y');
            //echo '<pre>';print_r($data);die;
            if($request->fileType == 2){
                $heading = array('Job No','Is Credit Cash','Date','Vehicle No','Member Number','Customer Name','Member No','Service','From Area','To Area','Job Amount Rcpt #','Receipt No','Driver Name','Driver No','Status');
                exportData($data['jobs'],'CustomerJobsReport.csv',$heading);
            }
           else if($request->fileType == 1){
            $filename = 'CustomerJobsReport.pdf';
            $view = view('reports.view_customer_daily_report' , compact('jobs'));

            $html = $view->render();

            $pdf = new TCPDF('L');
            $pdf::setHeaderCallback(function($pdf) use ($company_name ,$company_logo,$print_time,$customer_name ,
                $print_date,$from_date,$to_date) {
                $pdf->Ln(10);
                $tbl = '<table style="font-size: 10px">
                        <tr>
                            <td align="left"><b>'.$company_name.'</b></td>
                            <td align="center"><img height="30px" width="100px" src="'.asset($company_logo).'" ></td>
                            <td align="right">Print Date : '.$print_date.'<br />Print Time : '.$print_time.'</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">Daily Report <br>For the period of '.$from_date.' - '.$to_date.'<br>Customer : '.$customer_name.'
                                </td>
                            <td align="right" >Page no '.$pdf->getPage().'</td>
                        </tr>                 
                    </table>
                    ';
                $pdf->writeHTML($tbl, FALSE, false, false, false, '');
                $pdf->Ln(2);
                $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
                $pdf->Ln(2);
                $tbl = '<table style="font-size: 7px">
                        <tr>
                            <th style="width: 43px">Job No</th>
                            <th style="width: 45px">Date</th>
                            <th style="width: 45px">Vehicle No</th>
                            <th style="width: 50px">Member</th>
                            <th style="width: 100px">Customer</th>
                            <th style="width: 40px">Mobile No</th>
                            <th style="width: 60px">Service</th>
                            <th style="width: 80px">From Area</th>
                            <th style="width: 80px">To Area</th>
                            <th style="width: 40px">Job Amount</th>
                            <th style="width: 40px">Rcpt #</th>
                            <th style="width: 90px">Driver Name</th>
                            <th style="width: 40px">Number</th>
                            <th style="width: 40px">Status</th>
                        </tr>
        
                    </table>';
                $pdf->writeHTML($tbl, FALSE, false, false, false, '');
                $pdf->Ln(2);
                $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
                $pdf->Ln(2);
            });
            $pdf::AddPage('L', 'A4');
            $pdf::SetFontSize(7);
            $pdf::setTopMargin(45);
            $pdf::writeHTML($html, true, false, true, false, '');
            $pdf::output($filename , 'D');
        }

//            $pdf = PDF::loadView('reports.view_customer_daily_report', $data)->setPaper('a4', 'landscape');
//            return $pdf->download('CustomerJobsReport.pdf');
        }else{
            return back()->with('flash_error' , 'Something went wrong');
        }
    }

    public function getContractorJobReport(){
        $contractors = Contractor::select('id' , 'name')->get();
        return view('reports.get_contractor_report',compact('contractors'));
    }
    public function viewContractorJobReport(Request $request){
        if($request->contractor_id == NULL || $request->contractor_id == 0){
            $contractor_name = "All";
            $contractors = Contractor::select('id','name')->where('is_active' , 1)->orderBy('name' , 'ASC')->get()->toArray();
        }else{
            $contractor = Contractor::find($request->contractor_id);
            $contractor_name = $contractor->name;
            $contractors = Contractor::select('id','name')->where('id' , $request->contractor_id)->orderBy('name' , 'ASC')->get()->toArray();
        }
        if($request->type_id == 1){
            $payment_status = NULL;
        }elseif($request->type_id == 2){
            $payment_status = 0;
        }elseif($request->type_id == 3){
            $payment_status = 1;
        }elseif($request->type_id == 4){
            $payment_status = 2;
        }else{
            $payment_status = NULL;
        }
//        dd($request->all());
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $total_contractor_amount = 0;
        $total_jobs_count = 0;
        foreach($contractors as $key => $contractor){
            $jobs = JobData::select('driver_name' , 'driver_no','id','date','member_number','member_mobile',
                'vehicle_no','service_name','to_area_name','contractor_amount','contractor_invoice','cheque_no')
                ->where('contractor_id' , $contractor['id'])
                ->where('date' ,'>=' , $from_date)
                ->where('date' ,'<=' , $to_date)
                ->where('assign_to' , 1);

            if($payment_status !== NULL){
                $jobs = $jobs->where('payment_status' , $payment_status);
            }
            $jobs = $jobs->get()
                ->toArray();
            foreach($jobs as $key2 => $job){
                $jobs[$key2]['contractor_amount'] = number_format($job['contractor_amount'] , 3);
                $jobs[$key2]['date'] = display_date($job['date']);
            }
            $jobs_total = JobData::where('contractor_id' , $contractor['id'])
                ->where('date' ,'>=' , $from_date)
                ->where('date' ,'<=' , $to_date)
                ->where('assign_to' , 1);
            if($payment_status != NULL){
                $jobs_total = $jobs_total->where('payment_status' , $payment_status);
            }
            $jobs_total = $jobs_total->sum('contractor_amount');
            $count = count($jobs);
            if($count == 0){
                unset($contractors[$key]);
            }else{
                $contractors[$key]['jobs'] = $jobs;
                $contractors[$key]['job_count'] = $count;
                $contractors[$key]['jobs_total'] = number_format($jobs_total , 3);
                $total_contractor_amount += $jobs_total;
                $total_jobs_count += $count;
            }
        }
        $data['from_date'] = $request->from_date;
        $data['to_date'] = $request->to_date;
        $data['contractors'] = $contractors;
        $data['contractor_name'] = $contractor_name;
        $data['company_name'] = get_company()->name;
        $data['total_contractor_amount'] = number_format((float)$total_contractor_amount , 3);
        $data['company_logo'] = 'storage/app/'.get_company()->logo;
        $data['print_time'] = Carbon::now()->format('h:i:s A');
        $data['print_date'] = Carbon::now()->format('d/m/Y');
        $company_name = $data['company_name'] = get_company()->name;
        $company_logo = $data['company_logo'] = 'storage/app/'.get_company()->logo;
        $print_time = $data['print_time'] = Carbon::now()->format('h:i:s A');
        $print_date = $data['print_date'] = Carbon::now()->format('d/m/Y');
//        dd($contractor_name);

if($request->fileType == 2){
                $heading = array('Driver Name','Driver No','Job No','Date','Member Number','Member Mobile','Vehicle No','Service Name','To Area Name','Contractor Amount','Contractor Invoice','Cheque No');
                exportData($data['contractors'][0]['jobs'],'ContractorJobsReport.csv',$heading);
            }
           else if($request->fileType == 1){
        $filename = 'ContractorJobsReport.pdf';
        $view = view('reports.view_contractor_report' , compact('jobs' ,'company_name' ,'company_logo',
            'print_time','print_date','from_date','to_date' , 'contractor_name','contractors','total_contractor_amount'));

        $html = $view->render();
        $pdf = new TCPDF('L');
        $pdf::setHeaderCallback(function($pdf) use ($company_name ,$company_logo,$print_time,$contractor_name ,
            $print_date,$from_date,$to_date) {
            $pdf->Ln(10);
            $tbl = '<table style="font-size: 10px">
                        <tr>
                            <td align="left"><b>'.$company_name.'</b></td>
                            <td align="center"><img height="30px" width="100px" src="'.asset($company_logo).'" ></td>
                            <td align="right">Print Date : '.$print_date.'<br />Print Time : '.$print_time.'</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">Jobs done by Contractors for the period of '.$from_date.' - '.$to_date.'<br>Contractor  : '.$contractor_name.'
                                </td>
                            <td align="right" >Page no '.$pdf->getPage().'</td>
                        </tr>                 
                    </table>
                    ';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
            $tbl = '<table style="font-size: 7px">
                        <tr>
                            <td style="width: 84px"></td>
                            <td style="width: 90px">Driver Name</td>
                            <td style="width: 50px">Driver Contact</td>
                            <td style="width: 40px">Job No</td>
                            <td style="width: 45px">Job Date</td>
                            <td style="width: 70px">MemberShip</td>
                            <td style="width: 50px">Member No</td>
                            <td style="width: 50px">Member Vehicle</td>
                            <td style="width: 80px">Service</td>
                            <td style="width: 100px">Service Area</td>
                            <td style="width: 40px">Cont Amt</td>
                            <td style="width: 50px">Inv No</td>
                            <td style="width: 60px">AAA Chq</td>
                        </tr>
        
                    </table>';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
        });
        $pdf::AddPage('L', 'A4');
        $pdf::SetFontSize(7);
        $pdf::setTopMargin(45);
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::output($filename , 'D');
}




        $pdf = PDF::loadView('reports.view_contractor_report', $data)->setPaper('a4', 'landscape');
//        dd($data);
        return $pdf->download('ContractorJobsReport.pdf');
        return $pdf->stream();
        return view('reports.view_contractor_report' , compact('jobs' , 'contractor_name',
            'company_name','company_logo','print_time','print_date'));

        return view('reports.view_contractor_report',compact('contractors'));
    }

    public function getAAAVehicleJobReport(Request $request){
        $vehicles = Vehicle::select('id' , 'vehicle_no')->where('is_active' , 1)->get();
        return view('reports.get_aaa_vehicle_report',compact('vehicles'));
    }
    public function viewAAAVehicleJobReport (Request $request){
        $from_date = str_replace('T', ' ' , $request->from_date );
        $to_date = str_replace('T', ' ' , $request->to_date );
        $from_date = Carbon::parse($from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($to_date)->format('Y-m-d H:i:s');
        if($request->vehicle_id == 0 || $request->vehicle_id == "" ){
            $vehicle_name = "ALL";
            $vehicles = Vehicle::select('id' , 'vehicle_no')->where('is_active' , 1)->get()->toArray();
        }else{
            $vehicle = Vehicle::find($request->vehicle_id);
            $vehicle_name = $vehicle->vehicle_no;
            $vehicles = Vehicle::select('id' , 'vehicle_no')->where('id' , $request->vehicle_id)->get()->toArray();
        }
        foreach($vehicles as $key => $vehicle){
            $jobs = JobData::select('driver_name','driver_no','id','date','member_number','member_mobile','vehicle_no',
                'service_name','to_area_name','created_at')
                ->where('assign_to' , 0)
                ->where('vehicle_id' , $vehicle['id'])
                ->where('created_at' , '>=' , $from_date)
                ->where('created_at' , '<=' , $to_date)
                ->get()->toArray();
            foreach($jobs as $key2 => $job){
                $jobs[$key2]['date'] = Carbon::parse($job['date'])->format(config('app.timeformate'));
                $jobs[$key2]['created_at'] = Carbon::parse($job['created_at'])->format(config('app.timeformate'). " h:i:s A");
            }
            $vehicles[$key]['jobs'] = $jobs;
            $vehicles[$key]['job_count'] = count($jobs);
            if(count($jobs) == 0){
                unset($vehicles[$key]);
            }
        }
        if(count($vehicles) == 0){
            return back()->with('flash_error' , 'No jobs found.');
        }

        $from_date = Carbon::parse($from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($to_date)->format('Y-m-d H:i:s');
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['vehicles'] = $vehicles;

        $company_name = $data['company_name'] = get_company()->name;
        $company_logo = $data['company_logo'] = 'storage/app/'.get_company()->logo;
        $print_time = $data['print_time'] = Carbon::now()->format('h:i:s A');
        $print_date = $data['print_date'] = Carbon::now()->format('d/m/Y');

        $filename = 'AAAVehicleReport.pdf';
        $view = view('reports.view_aaa_vehicle_report' , compact('vehicles','company_name','company_logo',
            'print_time','print_date','from_date','to_date'));
        $html = $view->render();
        $pdf = new TCPDF('L');
        $pdf::setHeaderCallback(function($pdf) use ($company_name ,$company_logo,$print_time,
            $print_date,$from_date,$to_date) {
            $pdf->Ln(10);
            $tbl = '<table style="font-size: 10px">
                        <tr>
                            <td align="left"><b>'.$company_name.'</b></td>
                            <td align="center"><img height="30px" width="100px" src="'.asset($company_logo).'" ></td>
                            <td align="right">Print Date : '.$print_date.'<br />Print Time : '.$print_time.'</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">Jobs done by AAA Vehicles for the period of '.$from_date.' - '.$to_date.'
                                </td>
                            <td align="right" >Page no '.$pdf->getPage().'</td>
                        </tr>                 
                    </table>
                    ';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
            $tbl = '<table style="font-size: 7px">
                        <tr>
                            <td style="width: 73px"></td>
                            <td style="width: 100px">Driver Name</td>
                            <td style="width: 60px">Driver Contact</td>
                            <td style="width: 40px">Job No</td>
                            <td style="width: 50px">Job Date</td>
                            <td style="width: 70px">MemberShip</td>
                            <td style="width: 60px">Member No</td>
                            <td style="width: 55px">Member Vehicle</td>
                            <td style="width: 85px">Service</td>
                            <td style="width: 100px">Service Area</td>
                            <td style="width: 100px">Date/Time</td>
                        </tr>
                    </table>';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
        });
        $pdf::AddPage('L', 'A4');
        $pdf::SetFontSize(7);
        $pdf::setTopMargin(36);
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::output($filename , "D");

//        $pdf = PDF::loadView('reports.view_aaa_vehicle_report', $data)->setPaper('a4', 'landscape');
//        return $pdf->download('AAAVehicleReport.pdf');
//        return $pdf->stream();
    }

    public function getServiceAreaSummeryJobReport (){
        $services = Service::where('is_active' , 1)->get();
        return view('reports.get_service_area_summery_report',compact('services'));
    }
    public function ViewServiceAreaSummeryJobReport (Request $request){
        $from_date = str_replace('T', ' ' , $request->from_date );
        $to_date = str_replace('T', ' ' , $request->to_date );
        $from_date = Carbon::parse($from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($to_date)->format('Y-m-d H:i:s');
        if($request->service_id == 0 || $request->service_id == "" ){
            $service_name = "ALL";
            $services = Service::select('id' , 'name')->where('is_active' , 1)->get()->toArray();
        }
        else{
            $service = Service::find($request->service_id);
            $service_name = $service->name;
            $services = Service::select('id' , 'name')->where('id' , $request->service_id)->get()->toArray();
        }
        $counts = JobData::select('service_master_id' , 'to_area', 'to_area_name', 'service_name' ,
            DB::raw('count(*) as job_count'))
            ->where('created_at' , '>=' , $from_date)
            ->where('created_at' , '<=' , $to_date)
            ->groupBy('service_master_id' , 'to_area')
            ->orderBy('service_master_id' , 'ASC')
            ->orderBy('to_area' , 'ASC')
            ->get()->toArray();
        $services = array();
        foreach($counts as $count){
            $array = array(
                'to_area_name' => $count['to_area_name'],
                'count' => $count['job_count']
            );
            $services[$count['service_master_id']]['name'] = $count['service_name'];
            if(isset($services[$count['service_master_id']]['total_job_count'])){
                $services[$count['service_master_id']]['total_job_count'] += $count['job_count'];
            }else{
                $services[$count['service_master_id']]['total_job_count'] = $count['job_count'];
            }
            $services[$count['service_master_id']]['jobs_count'][$count['to_area']] = $array;
        }
//        dd($services);
        $from_date = Carbon::parse($from_date)->format('d-m-Y h:i:s A');
        $to_date = Carbon::parse($to_date)->format('d-m-Y h:i:s A');
//        dd($from_date);
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['services'] = $services;
        $company_name = $data['company_name'] = get_company()->name;
        $company_logo = $data['company_logo'] = 'storage/app/'.get_company()->logo;
        $print_time = $data['print_time'] = Carbon::now()->format('h:i:s A');
        $print_date = $data['print_date'] = Carbon::now()->format('d/m/Y');

        $filename = 'ServiceAreaSummeryReport.pdf';
        $view = view('reports.view_service_area_summery_report' , compact('services','company_name','company_logo',
            'print_time','print_date','from_date','to_date'));
        $html = $view->render();
        $pdf = new TCPDF('L');
        $pdf::setHeaderCallback(function($pdf) use ($company_name ,$company_logo,$print_time,
            $print_date,$from_date,$to_date) {
            $pdf->Ln(10);
            $tbl = '<table style="font-size: 10px">
                        <tr>
                            <td align="left"><b>'.$company_name.'</b></td>
                            <td align="center"><img height="30px" width="100px" src="'.asset($company_logo).'" ></td>
                            <td align="right">Print Date : '.$print_date.'<br />Print Time : '.$print_time.'</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">Service - Areawise Jobs Summary Report <br> for the period of '.$from_date.' - '.$to_date.'
                                </td>
                            <td align="right" >Page no '.$pdf->getPage().'</td>
                        </tr>                 
                    </table>
                    ';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
            $tbl = '<table style="font-size: 7px">
                        <tr>
                            <td style="width: 130px"></td>
                            <td style="width: 70px">S.No</td>
                            <td style="width: 185px">Area Name</td>
                            <td style="width: 80px">No of Jobs</td>
                        </tr>
                    </table>';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
        });
        $pdf::AddPage();
        $pdf::SetFontSize(7);
        $pdf::setTopMargin(40);
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::output($filename ,'D');


//        $pdf = PDF::loadView('reports.view_service_area_summery_report', $data)->setPaper('a4', 'landscape');
//        return $pdf->download('ServiceAreaSummeryReport.pdf');
//        return $pdf->stream();
    }

    public function getAAADriverJobReport(Request $request){
        $drivers = Driver::select('id' , 'name')->where('is_active' , 1)->get();
        return view('reports.get_aaa_driver_report',compact('drivers'));
    }
    public function viewAAADriverJobReport (Request $request){
        $from_date = str_replace('T', ' ' , $request->from_date );
        $to_date = str_replace('T', ' ' , $request->to_date );
        $from_date = Carbon::parse($from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($to_date)->format('Y-m-d H:i:s');

        if($request->driver_id == 0 || $request->driver_id == "" ){
            $driver_name = "ALL";
            $drivers = Driver::select('id' , 'name')->where('is_active' , 1)->get()->toArray();
        }else{
            $driver = Driver::find($request->driver_id);
            $driver_name = $driver->name;
            $drivers = Driver::select('id' , 'name')->where('id' , $driver->id)->get()->toArray();
        }

        foreach($drivers as $key => $driver){
            $jobs = JobData::select('driver_name','driver_no','id','date','customer_name','member_number','member_mobile','vehicle_no','aaa_vehicle_no',
                'service_name','to_area_name','created_at')
                ->where('assign_to' , 0)
                ->where('driver_id' , $driver['id'])
                ->where('created_at' , '>=' , $from_date)
                ->where('created_at' , '<=' , $to_date)
                ->get()->toArray();
            foreach($jobs as $key2 => $job){
                $jobs[$key2]['date'] = Carbon::parse($job['date'])->format(config('app.timeformate'));
                $jobs[$key2]['created_at'] = Carbon::parse($job['created_at'])->format(config('app.timeformate'). " h:i:s A");
            }
            $drivers[$key]['jobs'] = $jobs;
            $drivers[$key]['job_count'] = count($jobs);
            if(count($jobs) == 0){
                unset($drivers[$key]);
            }
        }
        if(count($drivers) == 0){
            return back()->with('flash_error' , 'No jobs found.');
        }

        $from_date = Carbon::parse($from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($to_date)->format('Y-m-d H:i:s');
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['drivers'] = $drivers;
        $data['driver_name'] = $driver_name;

        $company_name = $data['company_name'] = get_company()->name;
        $company_logo = $data['company_logo'] = 'storage/app/'.get_company()->logo;
        $print_time = $data['print_time'] = Carbon::now()->format('h:i:s A');
        $print_date = $data['print_date'] = Carbon::now()->format('d/m/Y');

        $filename = 'AAADriverReport.pdf';
        $view = view('reports.view_aaa_driver_report' , compact('company_name','company_logo',
            'print_time','print_date','from_date','to_date' ,'driver_name' ,'drivers'));
        $html = $view->render();
        $pdf = new TCPDF('L');
        $pdf::setHeaderCallback(function($pdf) use ($company_name ,$company_logo,$print_time,
            $print_date,$from_date,$to_date,$driver_name) {
            $pdf->Ln(10);
            $tbl = '<table style="font-size: 10px">
                        <tr>
                            <td align="left"><b>'.$company_name.'</b></td>
                            <td align="center"><img height="30px" width="100px" src="'.asset($company_logo).'" ></td>
                            <td align="right">Print Date : '.$print_date.'<br />Print Time : '.$print_time.'</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">Jobs done by AAA Drivers for the period of '.$from_date.' - '.
                                $to_date.'<br>Driver : '.$driver_name.'
                            </td>
                            <td align="right" >Page no '.$pdf->getPage().'</td>
                        </tr>                 
                    </table>
                    ';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
            $tbl = '<table style="font-size: 7px">
                        <tr>
                            <td style="width: 103px"></td>
                            <td style="width: 60px">AAA Vehicle No</td>
                            <td style="width: 50px">Job No</td>
                            <td style="width: 100px">Job Date</td>
                            <td style="width: 60px">MemberShip</td>
                            <td style="width: 120px">Customer</td>
                            <td style="width: 60px">Member No</td>
                            <td style="width: 60px">Member Vehicle</td>
                            <td style="width: 80px">Service</td>
                            <td style="width: 100px">Service Area</td>
                        </tr>
                    </table>';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
        });
        $pdf::AddPage('L', 'A4');
        $pdf::SetFontSize(7);
        $pdf::setTopMargin(42);
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::output($filename , 'D');


//        $pdf = PDF::loadView('reports.view_aaa_driver_report', $data)->setPaper('a4', 'landscape');
//        return $pdf->download('AAADriverReport.pdf');
//        return $pdf->stream();
    }

    public function getMemberVehicleWiseReport (){
        $members = array();
        return view('reports.get_member_vehicle_wise_report',compact('members'  ));
    }
    public function ViewMemberVehicleWiseReport(Request $request){

        $from_date = str_replace('T', ' ' , $request->from_date );
        $to_date = str_replace('T', ' ' , $request->to_date );
        $from_date = Carbon::parse($from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($to_date)->format('Y-m-d H:i:s');

        $jobs = JobData::select('id','member_number','member_name','vehicle_no','member_mobile','date',
            'service_name','from_area_name', 'driver_name','driver_no');


        $jobs = $jobs->where('created_at' , '>=' , $from_date)
            ->where('created_at' , '<=' , $to_date)
            ->orderBy('member_number' , 'ASC')
            ->orderBy('vehicle_no' , 'ASC')
            ->get()->toArray();
        $total_jobs_count = count($jobs);
        $members = array();
        foreach($jobs as $job){
            $job['date'] = display_date($job['date']);
            $members[$job['member_number']]['member_no'] = $job['member_number'];
            $members[$job['member_number']]['member_name'] = $job['member_name'];
            $members[$job['member_number']]['vehicles'][$job['vehicle_no']]['vehicle_no'] = $job['vehicle_no'];
            $members[$job['member_number']]['vehicles'][$job['vehicle_no']]['jobs'][] = $job;

            if(isset($members[$job['member_number']]['vehicles'][$job['vehicle_no']]['member_vehicle_jobs_count'])){
                $members[$job['member_number']]['vehicles'][$job['vehicle_no']]['member_vehicle_jobs_count'] += 1;
            }else{
                $members[$job['member_number']]['vehicles'][$job['vehicle_no']]['member_vehicle_jobs_count'] = 1;
            }
            if(isset($members[$job['member_number']]['member_jobs_count'])){
                $members[$job['member_number']]['member_jobs_count'] += 1;
            }else{
                $members[$job['member_number']]['member_jobs_count'] = 1;
            }
        }

        $from_date = Carbon::parse($from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($to_date)->format('Y-m-d H:i:s');
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['members'] = $members;
        $data['total_jobs_count'] = $total_jobs_count;

        $data['company_name'] = get_company()->name;
        $data['company_logo'] = 'storage/app/'.get_company()->logo;
        $data['print_time'] = Carbon::now()->format('h:i:s A');
        $data['print_date'] = Carbon::now()->format('d/m/Y');

        $company_name = $data['company_name'] = get_company()->name;
        $company_logo = $data['company_logo'] = 'storage/app/'.get_company()->logo;
        $print_time = $data['print_time'] = Carbon::now()->format('h:i:s A');
        $print_date = $data['print_date'] = Carbon::now()->format('d/m/Y');

        $filename = 'MemberVehicleDetailedReport.pdf';
        $view = view('reports.view_members_vehicles_report' , compact('company_name','company_logo',
            'print_time','print_date','from_date','to_date' ,'members','total_jobs_count'));
        $html = $view->render();
        $pdf = new TCPDF('L');
        $pdf::setHeaderCallback(function($pdf) use ($company_name ,$company_logo,$print_time,
            $print_date,$from_date,$to_date) {
            $pdf->Ln(10);
            $tbl = '<table style="font-size: 10px">
                        <tr>
                            <td align="left"><b>'.$company_name.'</b></td>
                            <td align="center"><img height="30px" width="100px" src="'.asset($company_logo).'" ></td>
                            <td align="right">Print Date : '.$print_date.'<br />Print Time : '.$print_time.'</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">Member Vehicle Services for the period of '.$from_date.' - '.
                $to_date.'
                            </td>
                            <td align="right" >Page no '.$pdf->getPage().'</td>
                        </tr>
                    </table>
                    ';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
            $tbl = '<table style="font-size: 7px">
                        <tr>
                            <td style="width: 50px">Member No.</td>
                            <td style="width: 100px">Member Name</td>
                            <td style="width: 50px">Member Vehicle</td>
                            <td style="width: 70px">Member Mobile No.</td>
                            <td style="width: 30px"></td>
                            <td style="width: 50px">Job No.</td>
                            <td style="width: 50px">Date</td>
                            <td style="width: 100px">Service</td>
                            <td style="width: 90px">Area</td>
                            <td style="width: 100px">Driver Name</td>
                            <td style="width: 50px">Driver No</td>
                        </tr>
                    </table>';
            $pdf->writeHTML($tbl, FALSE, false, false, false, '');
            $pdf->Ln(2);
            $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
            $pdf->Ln(2);
        });
        $pdf::AddPage('L', 'A4');
        $pdf::SetFontSize(7);
        $pdf::setTopMargin(42);
//        return $html;
        $pdf::writeHTML($html);
        $pdf::output($filename , 'D');

//        $pdf = PDF::loadView('reports.view_members_vehicles_report', $data)->setPaper('a4', 'landscape');
//        return $pdf->download('MemberVehicleDetailedReport.pdf');
//        return $pdf->stream();
    }


    
    public function getCustomerCostAnalysisReport(){
        $customers = Customer::select('id' , 'name')->where('is_active' , 1)->get();
        return view('reports.get_customer_cost_analysis_report',compact('customers'));
    }
    public function ViewCustomerCostAnalysisReport(Request $request){
        set_time_limit(0);

        if($request->has('from_date') && $request->has('to_date')){
            $jobs = JobData::where('created_at', '>=' ,$request->from_date." 00:00:00")
                ->where('created_at', '<=' ,$request->to_date." 23:59:59" );
            if($request->customer_id == NULL || $request->customer_id == 0){
                $customer_name = "All";
            }else{
                $jobs = $jobs->where('customer_id' , $request->customer_id);
                $customer = Customer::find($request->customer_id);
                $customer_name = $customer->name;
            }
            $jobs = $jobs->select('id' , 'date' , 'member_number','member_name' ,
                        'from_area_name','to_area_name' , 'assign_to','contractor_name', 'amount','contractor_amount','aaa_charges')
                ->orderBy('date')
                ->get()->toArray();
            // dd($jobs);
            if(count($jobs) == 0){
                return back()->with('flash_error' , 'No jobs found.');
            }
            $from_date = Carbon::createFromFormat('Y-m-d',$request->from_date)->format('d/M/Y');
            $to_date = Carbon::createFromFormat('Y-m-d',$request->to_date)->format('d/M/Y');
            $data['jobs'] = $jobs;
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['customer_name'] = $customer_name;
            

            $company_name = $data['company_name'] = get_company()->name;
            $company_logo = $data['company_logo'] = 'storage/app/'.get_company()->logo;
            $print_time = $data['print_time'] = Carbon::now()->format('h:i:s A');
            $print_date = $data['print_date'] = Carbon::now()->format('d/m/Y');

            $filename = 'CustomerCostAnalysisReport.pdf';
            $view = view('reports.view_customer_cost_analysis_report' , compact('jobs'));
            

    
            $html = $view->render();
            if($request->fileType == 2){
                $heading = array('Job No','Date','Member Number','Member Name','From Area Name','To Area Name','Assign To','Sub-Contractor','Sub-Contractor Charges','AAA Charges','Total');
              
             exportData($data['jobs'],'CustomerCostAnalysisReport.csv',$heading);
            }
            if($request->fileType == 1){

            $pdf = new TCPDF('L');
            $pdf::setHeaderCallback(function($pdf) use ($company_name ,$company_logo,$print_time,$customer_name ,
                $print_date,$from_date,$to_date) {
                $pdf->Ln(10);
                $tbl = '<table style="font-size: 10px">
                        <tr>
                            <td align="left"><b>'.$company_name.'</b></td>
                            <td align="center"><img height="30px" width="100px" src="'.asset($company_logo).'" ></td>
                            <td align="right">Print Date : '.$print_date.'<br />Print Time : '.$print_time.'</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">Customer Cost Analysis Report <br>For the period of '.$from_date.' - '.
                    $to_date.'<br>Customer : '.$customer_name.'
                                </td>
                            <td align="right" >Page no '.$pdf->getPage().'</td>
                        </tr>                 
                    </table>
                    ';
                $pdf->writeHTML($tbl, FALSE, false, false, false, '');
                $pdf->Ln(2);
                $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
                $pdf->Ln(2);
                $tbl = '<table style="font-size: 10px">
                        <tr>
                            <th style="width: 40px">S.No</th>
                            <th style="width: 50px">Date</th>
                            <th style="width: 50px">Job No</th>
                            <th style="width: 50px">Member No</th>
                            <th style="width: 110px">From Area</th>
                            <th style="width: 110px">To Area</th>
                            <th style="width: 150px">Sub-Contractor</th>
             
                            <th style="width: 90px">Sub Contractor Charges</th>
                            <th style="width: 70px">AAA Charges</th>
                            <th style="width: 60px">Total</th>
                        </tr>
                    </table>';
                $pdf->writeHTML($tbl, FALSE, false, false, false, '');
                $pdf->Ln(2);
                $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
                $pdf->Ln(2);
            });
            $pdf::AddPage('L', 'A4');
            $pdf::SetFontSize(7);
            $pdf::setTopMargin(50);
            $pdf::writeHTML($html, true, false, true, false, '');
            $pdf::output($filename ,'D');
           }

//            $pdf = PDF::loadView('reports.view_customer_daily_report', $data)->setPaper('a4', 'landscape');
//            return $pdf->download('CustomerJobsReport.pdf');
        }else{
            return back()->with('flash_error' , 'Something went wrong');
        }
    }
    


    public function getSubContractorsReport(){
        $customers = Customer::select('id' , 'name')->where('is_active' , 1)->get();
        return view('reports.get_sub_contractors_report',compact('customers'));
    }
    public function ViewSubContractorsReport(Request $request){
        set_time_limit(0);

        if($request->has('from_date') && $request->has('to_date')){
            $jobs = JobData::where('payment_at', '>=' ,$request->from_date." 00:00:00")
                ->where('payment_at', '<=' ,$request->to_date." 23:59:59" );
            if($request->customer_id == NULL || $request->customer_id == 0){
                $customer_name = "All";
            }else{
                $jobs = $jobs->where('customer_id' , $request->customer_id);
                $customer = Customer::find($request->customer_id);
                $customer_name = $customer->name;
            }
            $jobs = $jobs->select('id' , 'date' , 'member_number','member_name' ,
                        'from_area_name','to_area_name' , 'assign_to','contractor_name', 'amount','aaa_charges','batch_no',DB::raw("SUM(contractor_amount) as contractor_amount"), DB::raw("DATE_FORMAT(payment_at, '%d-%b-%Y') as payment_at"),'cheque_no', DB::raw("DATE_FORMAT(cheque_date, '%d-%b-%Y') as cheque_date"),'contractor_id')
                ->groupBy('batch_no')
                ->orderBy('payment_at')
                ->get()->toArray();
            // dd($jobs);
            // $jobs_total = $jobs_total->sum('contractor_amount');
            // $count = count($jobs);
            if(count($jobs) == 0){
                return back()->with('flash_error' , 'No jobs found.');
            }
            $from_date = Carbon::createFromFormat('Y-m-d',$request->from_date)->format('d/M/Y');
            $to_date = Carbon::createFromFormat('Y-m-d',$request->to_date)->format('d/M/Y');
            $data['jobs'] = $jobs;
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['customer_name'] = $customer_name;
            

            $company_name = $data['company_name'] = get_company()->name;
            $company_logo = $data['company_logo'] = 'storage/app/'.get_company()->logo;
            $print_time = $data['print_time'] = Carbon::now()->format('h:i:s A');
            $print_date = $data['print_date'] = Carbon::now()->format('d/m/Y');

            $filename = 'SubContractorsReport.pdf';
            $view = view('reports.view_sub_contractors_report' , compact('jobs'));
            

    
            $html = $view->render();
            if($request->fileType == 2){
                $heading = array('S No.','Contractor Name','Batch No','Batch Date','Cheque No','Cheque Date','Amount');
              
             exportData($data['jobs'],'SubContractorsReport.csv',$heading);
            }
            if($request->fileType == 1){

            $pdf = new TCPDF('L');
            $pdf::setHeaderCallback(function($pdf) use ($company_name ,$company_logo,$print_time,$customer_name ,
                $print_date,$from_date,$to_date) {
                $pdf->Ln(10);
                $tbl = '<table style="font-size: 10px">
                        <tr>
                            <td align="left"><b>'.$company_name.'</b></td>
                            <td align="center"><img height="30px" width="100px" src="'.asset($company_logo).'" ></td>
                            <td align="right">Print Date : '.$print_date.'<br />Print Time : '.$print_time.'</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">Sub Contractors Report <br>For the period of '.$from_date.' - '.
                    $to_date.'<br>Customer : '.$customer_name.'
                                </td>
                            <td align="right" >Page no '.$pdf->getPage().'</td>
                        </tr>                 
                    </table>
                    ';
                $pdf->writeHTML($tbl, FALSE, false, false, false, '');
                $pdf->Ln(2);
                $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
                $pdf->Ln(2);
                $tbl = '<table style="font-size: 10px">
                        <tr>
                            <th style="width: 50px">S.No</th>
                            <th style="width: 230px">Contractor Name</th>
                            <th style="width: 90px">Batch No.</th>
                            <th style="width: 120px">Batch Date</th>
                            <th style="width: 120px">Cheque No</th>
                            <th style="width: 120px">Cheque Date</th>
                            <th style="width: 110px">Amount</th>
                            
                        </tr>
                    </table>';
                $pdf->writeHTML($tbl, FALSE, false, false, false, '');
                $pdf->Ln(2);
                $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
                $pdf->Ln(2);
            });
            $pdf::AddPage('L', 'A4');
            $pdf::SetFontSize(10);
            $pdf::setTopMargin(50);
            $pdf::writeHTML($html, true, false, true, false, '');
            $pdf::output($filename ,'D');
           }

//            $pdf = PDF::loadView('reports.view_customer_daily_report', $data)->setPaper('a4', 'landscape');
//            return $pdf->download('CustomerJobsReport.pdf');
        }else{
            return back()->with('flash_error' , 'Something went wrong');
        }
    }
 


    public function getSubContractorsBatchReport(){
        $customers = Customer::select('id' , 'name')->where('is_active' , 1)->get();
        return view('reports.get_sub_contractors_batch_report',compact('customers'));
    }
    public function ViewSubContractorsBatchReport(Request $request){
        set_time_limit(0);

        if($request->has('from_date') && $request->has('to_date')){
            $jobs = JobData::where('payment_at', '>=' ,$request->from_date." 00:00:00")
                ->where('payment_at', '<=' ,$request->to_date." 23:59:59" );
            if($request->customer_id == NULL || $request->customer_id == 0){
                $customer_name = "All";
            }else{
                $jobs = $jobs->where('customer_id' , $request->customer_id);
                $customer = Customer::find($request->customer_id);
                $customer_name = $customer->name;
            }
            $jobs = $jobs->select('id' , 'date' , 'member_number','member_name' ,
                'from_area_name','to_area_name' , 'assign_to','contractor_name', 'amount','aaa_charges','batch_no',DB::raw("SUM(contractor_amount) as contractor_amount"), DB::raw("DATE_FORMAT(payment_at, '%d-%b-%Y') as payment_at"),'cheque_no', DB::raw("DATE_FORMAT(cheque_date, '%d-%b-%Y') as cheque_date"),'contractor_id')
                ->groupBy('batch_no')
                ->orderBy('payment_at')
                ->get()->toArray();
            // dd($jobs);
            // $jobs_total = $jobs_total->sum('contractor_amount');
            // $count = count($jobs);
            if(count($jobs) == 0){
                return back()->with('flash_error' , 'No jobs found.');
            }
            $from_date = Carbon::createFromFormat('Y-m-d',$request->from_date)->format('d/M/Y');
            $to_date = Carbon::createFromFormat('Y-m-d',$request->to_date)->format('d/M/Y');
            $data['jobs'] = $jobs;
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['customer_name'] = $customer_name;


            $company_name = $data['company_name'] = get_company()->name;
            $company_logo = $data['company_logo'] = 'storage/app/'.get_company()->logo;
            $print_time = $data['print_time'] = Carbon::now()->format('h:i:s A');
            $print_date = $data['print_date'] = Carbon::now()->format('d/m/Y');

            $filename = 'SubContractorsBatchReport.pdf';
            $view = view('reports.view_sub_contractors_batch_report' , compact('jobs'));



            $html = $view->render();
            if($request->fileType == 2){
                $heading = array('S No.','Contractor Name','Batch No','Batch Date','Amount');
                exportData($data['jobs'],'SubContractorsBatchReport.csv',$heading);
            }
            if($request->fileType == 1){

                $pdf = new TCPDF('L');
                $pdf::setHeaderCallback(function($pdf) use ($company_name ,$company_logo,$print_time,$customer_name ,
                    $print_date,$from_date,$to_date) {
                    $pdf->Ln(10);
                    $tbl = '<table style="font-size: 10px">
                        <tr>
                            <td align="left"><b>'.$company_name.'</b></td>
                            <td align="center"><img height="30px" width="100px" src="'.asset($company_logo).'" ></td>
                            <td align="right">Print Date : '.$print_date.'<br />Print Time : '.$print_time.'</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">Sub Contractors Batch Report <br>For the period of '.$from_date.' - '.
                        $to_date.'<br>Contractors : '.$customer_name.'
                                </td>
                            <td align="right" >Page no '.$pdf->getPage().'</td>
                        </tr>
                    </table>
                    ';
                    $pdf->writeHTML($tbl, FALSE, false, false, false, '');
                    $pdf->Ln(2);
                    $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
                    $pdf->Ln(2);
                    $tbl = '<table style="font-size: 10px">
                        <tr>
                            <th style="width: 50px">S.No</th>
                            <th style="width: 230px">Contractor Name</th>
                            <th style="width: 90px">Batch No.</th>
                            <th style="width: 120px">Batch Date</th>
                            <th style="width: 110px">Amount</th>

                        </tr>
                    </table>';
                    $pdf->writeHTML($tbl, FALSE, false, false, false, '');
                    $pdf->Ln(2);
                    $pdf->writeHTML("<hr>", FALSE, false, false, false, '');
                    $pdf->Ln(2);
                });
                $pdf::AddPage('L', 'A4');
                $pdf::SetFontSize(10);
                $pdf::setTopMargin(50);
                $pdf::writeHTML($html, true, false, true, false, '');
                $pdf::output($filename ,'D');
            }

//            $pdf = PDF::loadView('reports.view_customer_daily_report', $data)->setPaper('a4', 'landscape');
//            return $pdf->download('CustomerJobsReport.pdf');
        }else{
            return back()->with('flash_error' , 'Something went wrong');
        }
    }


public function get_jobs_list(){
    $customers = Customer::select('id' , 'name')->where('is_active' , 1)->get();
    return view('reports.get_jobs_list',compact('customers'));
}

public function view_get_jobs_list(Request $request)
{
    $jobs = Job::select(
            'jobs.date',
            'jobs.id as job_no',
            'jobs.created_at as start_time',
            'jobs.member_name',
            'jobs.member_number',
            'jobs.customer_name',
            'jobs.vehicle_no',
            'jobs.member_expiry_date as expiry_date',
            DB::raw("'' as model"),
            'jobs.chassis_no',
            'services.name as service',
            'from_area.name as from_area',
            'to_area.name as to_area',
            'jobs.completed_date as completed_time',
            'jobs.driver_name',
            'users.name as user_name',
            DB::raw("CASE WHEN jobs.assign_to = 1 THEN 'Contractor' ELSE 'AAA' END as job_type"),
            'jobs.amount',
            'contractors.name as contractor_name',
            'jobs.is_credit_cash as payment_type',
            'jobs.created_at',
            'jobs.updated_at'
           

        )
        ->leftJoin('service_master as services', 'jobs.service_master_id', '=', 'services.id')
        ->leftJoin('service_area_master as from_area', 'jobs.from_area', '=', 'from_area.id')
        ->leftJoin('service_area_master as to_area', 'jobs.to_area', '=', 'to_area.id')
        ->leftJoin('users', 'jobs.created_at', '=', 'users.id')
        ->leftJoin('contractors', 'jobs.contractor_id', '=', 'contractors.id')
        // ->leftJoin('members', 'jobs.member_id', '=', 'members.id')
        ->where('jobs.date', '>=', $request->from_date)
        ->where('jobs.date', '<=', $request->to_date);

    if ($request->filled('customer_id') && $request->customer_id != '') {
        $jobs->where('jobs.customer_id', $request->customer_id);
    }

    
    $jobs = $jobs->orderBy('jobs.date', 'desc')
                 ->orderBy('jobs.id', 'desc')
                 ->get()
                 ->toArray();

    if (count($jobs) == 0) {
        return back()->with('flash_error', 'No jobs found in selected period.');
    }

    $company_name = get_company()->name;
    $company_logo = 'storage/app/' . get_company()->logo;
    $print_time   = Carbon::now()->format('h:i:s A');
    $print_date   = Carbon::now()->format('d/m/Y');
    $from_date_disp = Carbon::parse($request->from_date)->format('d-m-Y');
    $to_date_disp   = Carbon::parse($request->to_date)->format('d-m-Y');

    $filename = 'JobsList_' . $from_date_disp . '_to_' . $to_date_disp;

    if ($request->fileType == 2) {
        $heading = [
            'Date', 'Job NO', 'Start Time', 'Member Name', 'Member Number', 'Customer',
            'Veh No', 'Expiry Date', 'Model', 'Chassis No', 'Service', 'From Area',
            'To Area', 'Completed Time', 'Driver Name', 'User Name', 'Job Type', 'Amount',
            'Contractor Name', 'Payment Type', 'Created At', 'Updated At'
        ];

        foreach ($jobs as &$job) {
            $job['start_time'] = isset($job['start_time']) ? Carbon::parse($job['start_time'])->format('Y-m-d H:i:s') : '';
            $job['completed_time'] = isset($job['completed_time']) && $job['completed_time'] ? Carbon::parse($job['completed_time'])->format('Y-m-d H:i:s') : '';
            $job['date'] = isset($job['date']) ? Carbon::parse($job['date'])->format('Y-m-d') : '';
            $job['expiry_date'] = isset($job['expiry_date']) && $job['expiry_date'] ? Carbon::parse($job['expiry_date'])->format('Y-m-d') : '';
            $job['created_at'] = isset($job['created_at']) ? Carbon::parse($job['created_at'])->format('Y-m-d H:i:s') : '';
            $job['updated_at'] = isset($job['updated_at']) ? Carbon::parse($job['updated_at'])->format('Y-m-d H:i:s') : '';
            
            // Format payment type
            if ($job['payment_type'] == 1) {
                $job['payment_type'] = 'Cash';
            } elseif ($job['payment_type'] == 2) {
                $job['payment_type'] = 'Credit';
            } else {
                $job['payment_type'] = 'Member';
            }
        }

        exportData($jobs, $filename . '.csv', $heading);
    } 
    else {
        $view = view('reports.view_get_jobs_list', compact(
            'jobs', 'company_name', 'company_logo', 'print_time', 'print_date',
            'from_date_disp', 'to_date_disp'
        ));

        $html = $view->render();

        $pdf = new TCPDF('L', 'A4', true, 'UTF-8');
        $pdf::setPrintHeader(false);
        $pdf::setPrintFooter(false);
        $pdf::SetMargins(3, 3, 3);
        $pdf::SetAutoPageBreak(true, 3);
        $pdf::AddPage();
        $pdf::SetFont('helvetica', '', 6);
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::output($filename . '.pdf', 'D');
    }
}

private function generateJobsListHTML($jobs, $company_name, $company_logo, $print_time, $print_date, $from_date_disp, $to_date_disp)
{
    $total_amount = 0;
    $rows = '';
    
    foreach($jobs as $job) {
        $amount = isset($job['amount']) ? floatval($job['amount']) : 0;
        $total_amount += $amount;
        
        $date = isset($job['date']) ? date('d-m-Y', strtotime($job['date'])) : '';
        $start_time = isset($job['start_time']) && $job['start_time'] ? date('H:i:s', strtotime($job['start_time'])) : '';
        $completed_time = isset($job['completed_time']) && $job['completed_time'] ? date('H:i:s', strtotime($job['completed_time'])) : '';
        $expiry_date = isset($job['expiry_date']) && $job['expiry_date'] ? date('d-m-Y', strtotime($job['expiry_date'])) : '';
        $created_at = isset($job['created_at']) ? date('d-m-Y H:i:s', strtotime($job['created_at'])) : '';
        $updated_at = isset($job['updated_at']) ? date('d-m-Y H:i:s', strtotime($job['updated_at'])) : '';
        
        // Format payment type
        $payment_type_text = '';
        if (isset($job['payment_type'])) {
            if ($job['payment_type'] == 1) {
                $payment_type_text = 'Cash';
            } elseif ($job['payment_type'] == 2) {
                $payment_type_text = 'Credit';
            } else {
                $payment_type_text = 'Member';
            }
        }
        
        // Clean and truncate long text
        $member_name = mb_substr($job['member_name'] ?? '', 0, 25);
        $customer_name = mb_substr($job['customer_name'] ?? '', 0, 20);
        $from_area = mb_substr($job['from_area'] ?? '', 0, 20);
        $to_area = mb_substr($job['to_area'] ?? '', 0, 20);
        $driver_name = mb_substr($job['driver_name'] ?? '', 0, 20);
        $service = mb_substr($job['service'] ?? '', 0, 15);
        $contractor_name = mb_substr($job['contractor_name'] ?? '', 0, 20);
        
        $rows .= '<tr>
            <td style="width: 5%;">' . $date . '</td>
            <td style="width: 4%;">' . ($job['job_no'] ?? '') . '</td>
            <td style="width: 5%;">' . $start_time . '</td>
            <td style="width: 7%;">' . $member_name . '</td>
            <td style="width: 5%;">' . ($job['member_number'] ?? '') . '</td>
            <td style="width: 7%;">' . $customer_name . '</td>
            <td style="width: 5%;">' . ($job['vehicle_no'] ?? '') . '</td>
            <td style="width: 5%;">' . $expiry_date . '</td>
            <td style="width: 3%;">' . ($job['model'] ?? '') . '</td>
            <td style="width: 5%;">' . ($job['chassis_no'] ?? '') . '</td>
            <td style="width: 6%;">' . $service . '</td>
            <td style="width: 6%;">' . $from_area . '</td>
            <td style="width: 6%;">' . $to_area . '</td>
            <td style="width: 5%;">' . $completed_time . '</td>
            <td style="width: 6%;">' . $driver_name . '</td>
            <td style="width: 6%;">' . ($job['user_name'] ?? '') . '</td>
            <td style="width: 4%;">' . ($job['job_type'] ?? '') . '</td>
            <td style="width: 5%; text-align: right;">' . number_format($amount, 3) . '</td>
            <td style="width: 6%;">' . $contractor_name . '</td>
            <td style="width: 5%;">' . $payment_type_text . '</td>
            <td style="width: 8%;">' . $created_at . '</td>
            <td style="width: 8%;">' . $updated_at . '</td>
        </tr>';
    }
    
    $logo_html = '';
    $logo_path = public_path($company_logo);
    if (file_exists($logo_path)) {
        $logo_html = '<img src="' . $logo_path . '" height="35" width="120" />';
    }
    
    $html = <<<EOD
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body {
    font-family: freeserif, dejavusans, helvetica, sans-serif;
    font-size: 6px;
    margin: 0;
    padding: 0;
}
.header-table {
    width: 100%;
    margin-bottom: 8px;
    border-collapse: collapse;
}
.header-table td {
    padding: 4px;
    border: none;
    vertical-align: top;
}
.company-name {
    font-size: 14px;
    font-weight: bold;
    color: #333;
}
.report-title {
    font-size: 16px;
    font-weight: bold;
    color: #000;
    margin-top: 5px;
}
.period {
    font-size: 10px;
    font-weight: normal;
    color: #555;
    margin-top: 3px;
}
hr {
    margin: 5px 0;
    border: 0.5px solid #999;
}
.data-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 5px;
}
.data-table th {
    border: 0.8px solid #000;
    padding: 4px;
    text-align: center;
    vertical-align: middle;
    background-color: #e0e0e0;
    font-weight: bold;
    font-size: 6px;
}
.data-table td {
    border: 0.5px solid #666;
    padding: 3px;
    text-align: left;
    vertical-align: top;
    font-size: 5.5px;
}
.text-right {
    text-align: right;
}
.text-center {
    text-align: center;
}
.footer-total {
    font-weight: bold;
    background-color: #f5f5f5;
}
.footer-total td {
    border-top: 1.5px solid #000;
}
</style>
</head>
<body>

<table class="header-table">
    <tr>
        <td width="33%" align="left">
            <div class="company-name">{$company_name}</div>
        </td>
        <td width="33%" align="center">
            {$logo_html}
        </td>
        <td width="33%" align="right" style="font-size: 7px;">
            Print Date: {$print_date}<br/>
            Print Time: {$print_time}
        </td>
    </tr>
    <tr>
        <td colspan="3" align="left">
            <div class="report-title">Jobs List Report</div>
            <div class="period">Period: {$from_date_disp} to {$to_date_disp}</div>
        </td>
    </tr>
</table>

<hr/>

<table class="data-table">
    <thead>
        <tr>
            <th width="5%">Date</th>
            <th width="4%">Job No</th>
            <th width="5%">Start Time</th>
            <th width="7%">Member Name</th>
            <th width="5%">Member No</th>
            <th width="7%">Customer</th>
            <th width="5%">Veh No</th>
            <th width="5%">Expiry Date</th>
            <th width="3%">Model</th>
            <th width="5%">Chassis No</th>
            <th width="6%">Service</th>
            <th width="6%">From Area</th>
            <th width="6%">To Area</th>
            <th width="5%">Comp Time</th>
            <th width="6%">Driver Name</th>
            <th width="6%">User Name</th>
            <th width="4%">Job Type</th>
            <th width="5%">Amount</th>
            <th width="6%">Contractor Name</th>
            <th width="5%">Payment Type</th>
            <th width="8%">Created At</th>
            <th width="8%">Updated At</th>
        </tr>
    </thead>
    <tbody>
        {$rows}
    </tbody>
    <tfoot>
        <tr class="footer-total">
            <td colspan="21" align="right"><strong>TOTAL:</strong></td>
            <td style="text-align: right;"><strong>' . number_format($total_amount, 3) . '</strong></td>
        </tr>
    </tfoot>
</table>

</body>
</html>
EOD;

    return $html;
}

}




