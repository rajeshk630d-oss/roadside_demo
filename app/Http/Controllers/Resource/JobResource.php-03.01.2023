<?php

namespace App\Http\Controllers\Resource;

use App\Contractor;
use App\ContractorContract;
use App\Customer;
use App\CustomerContracts;
use App\CustomerServices;
use App\Driver;
use App\Job;
use App\JobData;
use App\Member;
use App\Service;
use App\ServiceAreas;
use App\ServiceCountry;
use App\UploadLog;
use App\Vehicle;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Excel;

class JobResource extends Controller
{
    public function __construct()
    {
        ini_set('max_execution_time', '0');
        ini_set("memory_limit", "-1");
    }
    public function index(Request $request)
    {
        ini_set('memory_limit', '-1');
        if(!$request->has('from_date')){
            $request->from_date = Carbon::now()->addMonth(-1)->format('Y-m-d') ;
            $request->to_date = Carbon::now()->endOfDay()->format('Y-m-d');
        }
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $jobs = JobData::where('created_at', '>=' ,$from_date." 00:00:00")
            ->where('created_at', '<=' ,$to_date." 23:59:59" )
            ->where('status' , 0)
            ->orderBy('created_at','DESC')
            ->get();

        return view('jobs.index', compact('jobs' , 'from_date','to_date'));
    }
    public function assgned_jobs(Request $request)
    {
        ini_set('memory_limit', '-1');
        if(!$request->has('from_date')){
            $request->from_date = Carbon::now()->addMonth(-1)->format('Y-m-d');
            $request->to_date = Carbon::now()->format('Y-m-d');
        }
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $jobs = JobData::where('created_at', '>=' ,$from_date." 00:00:00")
            ->where('created_at', '<=' ,$to_date." 23:59:59" )
            ->where('status' , 1)
            ->orderBy('created_at','DESC')
            ->get();

        return view('jobs.assignedJobs', compact('jobs' , 'from_date','to_date'));
    }
    public function not_done_jobs(Request $request)
    {
        ini_set('memory_limit', '-1');
        if(!$request->has('from_date')){
            $request->from_date = Carbon::now()->addMonth(-1)->format('Y-m-d');
            $request->to_date = Carbon::now()->format('Y-m-d');
        }
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $jobs = JobData::where('created_at', '>=' ,$from_date." 00:00:00")
            ->where('created_at', '<=' ,$to_date." 23:59:59" )
            ->where('status' , 4)
            ->orderBy('created_at','DESC')
            ->get();

        return view('jobs.not_done_jobs', compact('jobs' , 'from_date','to_date'));
    }
    public function completed_jobs(Request $request)
    {
        ini_set('memory_limit', '-1');
        if($request->has('from_date') || $request->has('to_date') || $request->has('search_key')){
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            $search_key = trim($request->search_key);
            $jobs = JobData::where('status', 2);
            if(!$request->has('search_key') || strlen($request->search_key) == 0){
                $jobs = $jobs->where('created_at', '>=', $from_date . " 00:00:00")
                    ->where('created_at', '<=', $to_date . " 23:59:59");
            }else{
                $jobs = $jobs->Where(function ($query ) use ($search_key){
                    $query->where('id' , 'LIKE' , '%'.$search_key.'%');
                    $query->orWhere('customer_name', 'LIKE' , '%'.$search_key.'%');
                    $query->orWhere('member_name' , 'LIKE' , '%'.$search_key.'%');
                    $query->orWhere('member_number', 'LIKE' , '%'.$search_key.'%');
                    $query->orWhere('member_mobile', 'LIKE' , '%'.$search_key.'%');
                    $query->orWhere('vehicle_no', 'LIKE' , '%'.$search_key.'%');
                    $query->orWhere('chassis_no', 'LIKE' , '%'.$search_key.'%');
                    $query->orWhere('engine_no', 'LIKE' , '%'.$search_key.'%');
                    $query->orWhere('driver_no' , 'LIKE' , '%'.$search_key.'%');
                    $query->orWhere('receipt_no' , 'LIKE' , '%'.$search_key.'%');
                });
            }
            $jobs = $jobs->orderBy('created_at', 'DESC')
                ->get();
        }else{
            $request->from_date = Carbon::now()->addMonth(-1)->format('Y-m-d');
            $request->to_date = Carbon::now()->format('Y-m-d');
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            $search_key = $request->search_key;
            $jobs = array();
        }
        return view('jobs.completed_jobs', compact('jobs' , 'from_date','to_date','search_key'));
    }
    public function cancelled_jobs(Request $request)
    {
        ini_set('memory_limit', '-1');
        if(!$request->has('from_date')){
            $request->from_date = Carbon::now()->addMonth(-1)->format('Y-m-d');
            $request->to_date = Carbon::now()->format('Y-m-d');
        }
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $jobs = JobData::where('created_at', '>=' ,$from_date." 00:00:00")
            ->where('created_at', '<=' ,$to_date." 23:59:59" )
            ->where('status' , 3)
            ->orderBy('created_at','DESC')
            ->get();

        return view('jobs.cancelled_jobs', compact('jobs' , 'from_date','to_date'));
    }
    public function all_jobs(Request $request)
    {
        ini_set('memory_limit', '-1');
        if($request->has('from_date') || $request->has('to_date') || $request->has('search_key')){
            if(!$request->has('from_date')){
                $request->from_date = Carbon::now()->addMonth(-1)->format('Y-m-d');
                $request->to_date = Carbon::now()->format('Y-m-d');
            }
            $search_key = trim($request->search_key);
            $from_date = $request->from_date;
            $to_date = $request->to_date;

            if(!$request->has('search_key') || strlen($request->search_key) == 0){
                $jobs = JobData::where('created_at', '>=', $from_date . " 00:00:00")
                    ->where('created_at', '<=', $to_date . " 23:59:59");
            }else{
                $jobs = JobData::Where(function ($query ) use ($search_key){
                    $query->where('id' , 'LIKE' , '%'.$search_key.'%');
                    $query->orWhere('customer_name', 'LIKE' , '%'.$search_key.'%');
                    $query->orWhere('member_name' , 'LIKE' , '%'.$search_key.'%');
                    $query->orWhere('member_number', 'LIKE' , '%'.$search_key.'%');
                    $query->orWhere('member_mobile', 'LIKE' , '%'.$search_key.'%');
                    $query->orWhere('vehicle_no', 'LIKE' , '%'.$search_key.'%');
                    $query->orWhere('chassis_no', 'LIKE' , '%'.$search_key.'%');
                    $query->orWhere('engine_no', 'LIKE' , '%'.$search_key.'%');
                    $query->orWhere('driver_no' , 'LIKE' , '%'.$search_key.'%');
                    $query->orWhere('receipt_no' , 'LIKE' , '%'.$search_key.'%');
                });
            }
            $jobs = $jobs->orderBy('created_at', 'DESC')
                ->get();
            return view('jobs.all_jobs', compact('jobs' , 'from_date','to_date','search_key'));
        }else{
            $request->from_date = Carbon::now()->addMonth(-1)->format('Y-m-d');
            $request->to_date = Carbon::now()->format('Y-m-d');
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            $search_key = "";
            $jobs = array();
            return view('jobs.all_jobs', compact('jobs' , 'from_date','to_date','search_key'));
        }
    }

    public function create(Request $request){
        $customers = Customer::where('is_active' , 1)->get();
        $services = Service::where('is_active' , 1)->get();
        $areas = ServiceAreas::where('is_active' , 1)->get();
        return view('jobs.create', compact('customers' ,'services' ,  'areas'));
    }
    public function edit($id){
        $customers = Customer::where('is_active' , 1)->get();
        $services = Service::where('is_active' , 1)->get();
        $areas = ServiceAreas::where('is_active' , 1)->get();
        $vehicles = Vehicle::where('is_active' , 1)->get();
        $contractors = Contractor::where('is_active' , 1)->get();
        $drivers = Driver::where('is_active' , 1)->get();
        $job = Job::findOrFail($id);
        return view('jobs.edit', compact('customers' , 'services' ,
            'areas','vehicles','contractors','drivers','job'));
    }
    public function show($id){
        $job = Job::with('service','vehicle','from_service_area','to_service_area','contractor')->findOrFail($id);
        return view('jobs.show', compact('job'));
    }
    public function store(Request $request){
        $this->validate($request, [
            'is_credit_cash' => 'required||in:0,1,2',
            'date' => 'required|date',
            'member_name' => 'required|max:50',
            'member_number' => 'required|max:50',
            'vehicle_number' => 'max:10',
            'member_mobile' => 'max:20',
            'chassis_no' => 'max:50',
            'engine_no' => 'max:50',
            'service_master_id' => 'required|exists:service_master,id',
            'customer_id2' => 'required|exists:customers,id',
            'from_area' => 'required|exists:service_area_master,id',
            'to_area' => 'required|exists:service_area_master,id',
            'remarks' => 'max:50',
        ]);
        if($request->hasFile('attachment')){
            $this->validate($request, [
                'attachment' => 'max:2040000',
            ]);
        }

        if($request->has('member_id') && $request->member_id != NULL){
            $this->validate($request, [
                'member_id' => 'required|exists:members,id',
            ]);
        }
        if($request->is_credit_cash != 0){
            $this->validate($request, [
                'amount' => 'required',
            ]);
            if(!$request->has('amount') || $request->amount ==NULL){
                return back()->with('flash_error','Amount can not be less than zero.')->withInput();
            }
        }
        if(!$request->has('amount') || $request->amount ==NULL){
            $request->amount = 0;
        }

        try {
            DB::beginTransaction();
            $job = new Job();
//            dd($request->all());
            if($member = Member::where('membership_no', $request->member_number)
                ->where('customer_id', '!=' , $request->customer_id2)->count() > 0){
                return back()->with('flash_error', 'Member number Allocated to another customer.')->withInput();
            }
            $member = Member::where('membership_no', $request->member_number)
                ->where('customer_id', $request->customer_id2)
                ->where('vehicle_no', $request->vehicle_number)
                ->first();

            if ($member == NULL) {
//                if (Member::where('membership_no', $request->member_number)->count() > 0) {
//                    return back()->with('flash_error', 'Member number already taken.')->withInput();
//                }
                $member = new Member();
                $member->membership_no = $request->member_number;
                $member->member_name = $request->member_name;
                $member->membership_type_id = 0;
                $member->customer_id = $request->customer_id2;
                $member->vehicle_no = $request->vehicle_number;
                $member->chassis_no = $request->chassis_no;
                $member->mobile = $request->member_mobile;
                $member->engine_no = $request->engine_no;
                $member->vehicle_brand_id = 0;
                $member->vehicle_type_id = 0;
                $member->vehicle_reg_type_id = 0;
                $member->mfg_year = null;
                $member->expiry_date = $request->member_expiry_date;
                $member->ref_no = "";
                $member->add_by_job = 1;
            } else {
                $member->vehicle_no = $request->vehicle_number;
                $member->expiry_date = $request->member_expiry_date;
                $member->member_name = $request->member_name;
                $member->chassis_no = $request->chassis_no;
                $member->engine_no = $request->engine_no;
            }
            $member->save();
            $path = "";
            if($request->hasFile('attachment')){
                $path = Storage::put('uploads/jobs/attachments', $request->attachment);
                $job->attachment = $path;
            }
            $customer = Customer::find($request->customer_id2);
            $job->is_credit_cash = $request->is_credit_cash;
            $job->date = $request->date;
            $job->member_id = $request->member_id;
            $job->customer_id = $request->customer_id2;
            $job->customer_name = $customer->name;
            $job->member_name = $request->member_name;
            $job->member_number = $request->member_number;
            $job->member_mobile = $request->member_mobile;
            $job->vehicle_no = $request->vehicle_number;
            $job->member_expiry_date = $request->member_expiry_date;
            $job->chassis_no = $request->chassis_no;
            $job->engine_no = $request->engine_no;
            $job->service_master_id = $request->service_master_id;
            $job->from_area = $request->from_area;
            $job->to_area = $request->to_area;
            $job->amount = $request->amount;
            $job->remarks = $request->remarks;
            $job->invoice_no = generate_invoice_no();
            $job->save();
            add_user_log(Auth::user()->id , 'ADD_JOB',$job->id);
            DB::commit();
            if ($job->is_credit_cash != 2) {
                return redirect()->route('pending_jobs')->with('flash_success', 'Job added successfully having job id # ' . $job->id . '.');
            } else {
                return redirect()->route('job_invoice', $job->id)->with('flash_success', 'Job added successfully having job id # ' . $job->id . '.');
            }
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!')->withInput();
        }
    }
    public function update(Request $request , $id){

        $this->validate($request, [
            'is_credit_cash' => 'required||in:0,1,2',
            'date' => 'required|date',
            'customer_id2' => 'required|exists:customers,id',
            'member_name' => 'required|max:50',
            'member_number' => 'required|max:50',
//            'member_expiry_date' => 'date',
            'service_master_id' => 'required|exists:service_master,id',
            'from_area' => 'required|exists:service_area_master,id',
            'to_area' => 'required|exists:service_area_master,id',
            'remarks' => 'max:50',
        ]);
        if($request->is_credit_cash != 0){
            $this->validate($request, [
                'amount' => 'required',
            ]);
        }
        if($request->is_credit_cash != 0){
            $this->validate($request, [
                'amount' => 'required',
            ]);
            if(!$request->has('amount') || $request->amount == NULL){
                return back()->with('flash_error','Amount can not be less than zero.')->withInput();
            }
        }
        if(!$request->has('amount') || $request->amount ==NULL){
            $request->amount = 0;
        }
        if($request->hasFile('attachment')){
            $this->validate($request, [
                'attachment' => 'max:2040000',
            ]);
        }
        if($request->status == 1 || $request->status == 2){
            if(!$request->has('contractor_amount') || $request->contractor_amount < 0){
                $request->contractor_amount = 0;
            }
            $this->validate($request, [
                'assign_to' => 'required',
            ]);
            if($request->assign_to == 0){
                $this->validate($request, [
                    'vehicle_id' => 'required',
                    'driver_id' => 'required',
                    'driver_no' => 'required|max:20',
                ]);
            }else{
                $this->validate($request, [
                    'contractor_id' => 'required',
                    'driver_name' => 'required:max:50',
                    'driver_no' => 'required|max:20',
                ]);
            }
        }
        if($request->status == 2){
            if($request->is_credit_cash == 1){
                $this->validate($request, [
                    'amount' => 'required',
                    'receipt_no' => 'required:max:50',
                ]);
            }elseif($request->is_credit_cash == 2){
                $this->validate($request, [
                    'amount' => 'required',
                ]);
                if(!$request->has('receipt_no')){
                    $request->receipt_no = "";
                }
            }else{
                if($request->amount != NULL && $request->amount > 0 ){
                    $this->validate($request, [
                        'receipt_no' => 'required:max:50',
                    ]);
                }else{
                    $request->receipt_no = "";
                }
            }
        }
        if($request->status == 3){
            $this->validate($request, [
                'cancelled_reason' => 'required',
            ]);
        }
        if($request->status == 4){
            $this->validate($request, [
                'not_done_reason' => 'required',
            ]);
        }

        try{
            DB::beginTransaction();
            $job = Job::findOrFail($id);
            $path = "";
            if($request->hasFile('attachment')){
                $path = Storage::put('uploads/jobs/attachments', $request->attachment);
                $job->attachment = $path;
            }
            $old_status = $job->status;
            $member = Member::where('id', $request->member_id)
                ->where('vehicle_no', $request->vehicle_number)
                ->where('customer_id', $request->customer_id2)
                ->first();
            if ($member == NULL) {
                if (Member::where('membership_no', $request->member_number)
                        ->where('customer_id','!=', $request->customer_id2)
                        ->count() > 0 ) {
                    return back()->with('flash_error', 'Member number already taken.')->withInput();
                }
                $member = new Member();
                $member->membership_no = $request->member_number;
                $member->member_name = $request->member_name;
                $member->membership_type_id = 0;
                $member->customer_id = $request->customer_id2;
                $member->vehicle_no = $request->vehicle_number;
                $member->chassis_no = $request->chassis_no;
                $member->engine_no = $request->engine_no;
                $member->vehicle_brand_id = 0;
                $member->vehicle_type_id = 0;
                $member->vehicle_reg_type_id = 0;
                $member->mfg_year = null;
                $member->expiry_date = $request->member_expiry_date;
                $member->ref_no = "";
                $member->add_by_job = 1;
            }
            else {
                $member->member_name = $request->member_name;
                $member->expiry_date = $request->member_expiry_date;
                $member->chassis_no = $request->chassis_no;
                $member->engine_no = $request->engine_no;
            }
            $member->save();
            $customer = Customer::find($request->customer_id2);

            $job->is_credit_cash = $request->is_credit_cash;
            $job->date = $request->date;
            $job->member_id = $request->member_id;
            $job->customer_id = $request->customer_id2;
            $job->customer_name = $customer->name;
            $job->member_name = $request->member_name;
            $job->member_number = $request->member_number;
            $job->vehicle_no = $request->vehicle_number;
            $job->member_expiry_date = $request->member_expiry_date;
            $job->chassis_no = $request->chassis_no;
            $job->engine_no = $request->engine_no;
            $job->service_master_id = $request->service_master_id;
            $job->from_area = $request->from_area;
            $job->to_area = $request->to_area;
            $job->amount = $request->amount;
            $job->remarks = $request->remarks;
            $job->status = $request->status;
            $job->save();

            $job->assign_to = $request->assign_to;
            $driver = Driver::find($request->driver_id);
            if($driver == NULL){
                if($request->assign_to == 0){
                    $job->driver_name = "";
                }else{
                    $job->driver_name = $request->driver_name;
                }
            }else{
                $job->driver_name = $driver->name;
            }
            $job->driver_no = $request->driver_no;
            $job->vehicle_id = $request->vehicle_id;
            $job->driver_id = $request->driver_id;
            $job->contractor_id = $request->contractor_id;
            $job->contractor_amount = $request->contractor_amount;
            $job->receipt_no = $request->receipt_no;
            if($old_status != $request->status){
                if($old_status == 0){
                    if($request->status == 1 ){
                        $job->assigned_date = Carbon::now();
                    }elseif($request->status == 2){
                        $job->assigned_date = Carbon::now();
                        $job->completed_date = Carbon::now();
                    }
                }
                if($old_status == 1){
                    if($request->status == 2){
                        $job->completed_date = Carbon::now();
                    }
                }
            }
            if($job->status == 4){
                $job->not_done_reason = $request->not_done_reason;
                $job->not_done_by = Auth::user()->id;
                $job->not_done_at = Carbon::now();
            }elseif($job->status == 3){
                $job->cancelled_reason = $request->cancelled_reason;
                $job->cancelled_by = Auth::user()->id;
                $job->cancelled_at = Carbon::now();
            }else{
                $job->not_done_reason = NULL;
                $job->not_done_by = NULL;
                $job->not_done_at = NULL;
                $job->cancelled_reason = NULL;
                $job->cancelled_by = NULL;
                $job->cancelled_at = NULL;
            }

            $job->save();
            add_user_log(Auth::user()->id , 'EDIT_JOB',$job->id);

            return redirect()->route('pending_jobs')->with('flash_success', 'Job updated successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    public function destroy(Request $request , $id){
        try{
            $job = Job::findOrFail($id);
            $job->is_active = 0;
            $job->save();
            add_user_log(Auth::user()->id , 'DELETE_JOB',$job->id);

            return redirect()->route('pending_jobs')->with('flash_success', 'Job deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function assign($id){

        $job = Job::findOrFail($id);
        $vehicles = Vehicle::where('is_active' , 1)->get();
        $contractors = Contractor::where('is_active' , 1)->get();
        $drivers = Driver::where('is_active' , 1)->get();
        return view('jobs.assign', compact('job' , 'vehicles','contractors','drivers'));
    }
    public function assign_driver (Request $request , $id){
        if(!$request->has('contractor_amount') || $request->contractor_amount < 0){
            $request->contractor_amount = 0;
        }
        $this->validate($request, [
            'assign_to' => 'required',
            'remarks' => 'required|max:50',
        ]);
        if($request->assign_to == 0){
            $this->validate($request, [
                'vehicle_id' => 'required',
                'driver_id' => 'required',
                'driver_no' => 'required|max:20',
            ]);
            $driver = Driver::find($request->driver_id);
            $request->contractor_id = NULL;
            $request->driver_name = $driver->name;
        }else{
            $this->validate($request, [
                'contractor_id' => 'required',
                'driver_name' => 'required:max:50',
                'driver_no' => 'required|max:20',
            ]);
            $request->vehicle_id = NULL;
            $request->driver_id = NULL;
        }
        try {
            DB::beginTransaction();
            $job = Job::findOrFail($id);
            $job->assign_to = $request->assign_to;
            $job->vehicle_id = $request->vehicle_id;
            $job->driver_id = $request->driver_id;
            $job->contractor_id = $request->contractor_id;
            $job->driver_name = $request->driver_name;
            $job->driver_no = $request->driver_no;
            $job->amount = $request->amount;
            $job->contractor_amount = $request->contractor_amount;
            $job->remarks = $request->remarks;
            $job->status = 1;
            $job->assigned_date = Carbon::now();
            $job->save();
            add_user_log(Auth::user()->id , 'ASSIGN_JOB',$job->id);
            DB::commit();
            return redirect()->route('pending_jobs')->with('flash_success', 'Job assigned successfully.');
        }
        catch (Exception $e) {
            return back()->with('flash_error' , 'Something went wrong')->withInput();
        }
    }
    public function get_assigned_job($id){
        $job = Job::findOrFail($id);
        return view('jobs.complete', compact('job'));
    }
    public function complete_job (Request $request , $id){

        $job = Job::find($id);
        if(!$request->has('contractor_amount') || $request->contractor_amount < 0){
            $request->contractor_amount = 0;
        }
//        $this->validate($request, [
//            'remarks' => 'required|max:50',
//        ]);
        if($job->is_credit_cash == 1){
            $this->validate($request, [
                'amount' => 'required',
                'receipt_no' => 'required:max:50',
            ]);
        }elseif($job->is_credit_cash == 2){
            $this->validate($request, [
                'amount' => 'required',
            ]);
            if(!$request->has('receipt_no')){
                $request->receipt_no = "";
            }
        }else{
            if($request->amount != NULL && $request->amount > 0 ){
                $this->validate($request, [
                    'receipt_no' => 'required:max:50',
                ]);
            }else{
                $request->receipt_no = "";
            }
        }
        try{
            DB::beginTransaction();
            $job = Job::findOrFail($id);
            $job->amount = $request->amount;
            $job->contractor_amount = $request->contractor_amount;
            $job->receipt_no = $request->receipt_no;
            $job->remarks = $request->remarks;
            $job->status = 2;
            $job->completed_date = Carbon::now();
            $job->save();

            $cust_service = CustomerServices::where('customer_id' , $job->customer_id)
                ->where('service_id' , $job->service_master_id)
                ->first();

            if($cust_service == NULL){
                $cust_service = new CustomerServices();
                $service = Service::find($job->service_master_id);
                $cust_service->customer_id = $job->customer_id;
                $cust_service->service_id = $job->service_master_id;
                $cust_service->max_services = 0;
                $cust_service->rate = $service->charges;
                $cust_service->completed_services = 1;
            }else{
                $cust_service->completed_services = $cust_service->completed_services + 1;
            }
            $cust_service->save();
            add_user_log(Auth::user()->id , 'COMPLETE_JOB',$job->id);

            DB::commit();
            return redirect()->route('assigned_jobs')->with('flash_success', 'Job completed successfully.');
        }
        catch (Exception $e) {
            return back()->with('flash_error' , 'Something went wrong')->withInput();
        }
    }
    public function not_done_job(Request $request){
        try{
            $job = Job::findOrFail($request->job_id);
            $job->status = 4;
            $job->not_done_reason = $request->not_done_reason;
            $job->not_done_by = Auth::user()->id;
            $job->not_done_at = Carbon::now();
            $job->save();
            add_user_log(Auth::user()->id , 'NOT_DONE_JOB',$job->id);

            return back()->with('flash_success' , 'Job status changed to not done.');
        }catch (Exception $e) {
            return back()->with('flash_error' , 'Something went wrong')->withInput();
        }
    }
    public function cancel_job(Request $request){
        try{
//            dd($request->all());
            $job = Job::findOrFail($request->job_id);
            $job->status = 3;
            $job->not_done_reason = $request->cancelled_reason;
            $job->cancelled_reason = $request->cancelled_reason;
            $job->cancelled_by = Auth::user()->id;
            $job->cancelled_at = Carbon::now();
            $job->save();
            add_user_log(Auth::user()->id , 'CANCELLED_JOB',$job->id);

            return back()->with('flash_success' , 'Job cancelled successfully.');
        }catch (Exception $e) {
            return back()->with('flash_error' , 'Something went wrong')->withInput();
        }
    }
    public function get_customer_history_popup(Request $request){
        $customer_id = $request->customer_id;
        $member_no = $request->member_no;
        $service_id = $request->service_id;

        $customer = Customer::find($customer_id);
        $member = Member::where('membership_no',$member_no)->first();
        $service = CustomerServices::where('customer_id',$customer_id)->where('service_id',$service_id)->first();
        $jobs = Job::with('service','from_service_area','to_service_area')->where('customer_id' , $customer_id);
        if($request->has('service_id') && $request->service_id != NULL && $request->service_id != 0){
            $jobs = $jobs->where('service_master_id' , $service_id);
        }
        if($request->has('member_no') && $request->member_no != NULL && $request->member_no != 0){
            $jobs = $jobs->where('member_number' , $member_no);
        }
        $jobs = $jobs->limit(1000)->get();

//        dd(DB::getQueryLog());
        return view('models.customer_history', compact('customer','member' , 'jobs','service'));
    }

    public function get_job_invoice(Request $request , $id){
        try {
            $job = Job::with('member', 'customer', 'service', 'vehicle', 'from_service_area', 'to_service_area', 'contractor')
                ->findOrFail($id);
            return view('jobs.job_invoice',compact('job'));
        }catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!')->withInput();
        }

    }
    public function print_job_invoice(Request $request , $id){
        try {
            $job = Job::with('member', 'customer', 'service', 'vehicle', 'from_service_area', 'to_service_area', 'contractor')
                ->findOrFail($id);
            return view('jobs.print_job_invoice',compact('job'));
        }catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!')->withInput();
        }
    }
    public function import_jobs (Request $request){
        return view('jobs.import_jobs');
    }
    public function save_import_jobs(Request $request){
//        $date = "17.01.2021";
//        dd(validate_excel_date($date));
        try{
            if($request->hasFile('import_data')){
                ini_set('memory_limit', '-1');

                $file = $request->file('import_data');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileSize = $file->getSize();
                $allow_formates = array('xlsx' , 'csv');
                $file_name = Carbon::now()->format('d_m_Y_H_i_s')."_".$filename;
                if(!in_array($extension , $allow_formates)){
                    $msg = 'File formate is not supported, import only .CSV , .XLSX';
                    $log = new UploadLog();
                    $log->type = "JOB";
                    $log->file_name = $file_name;
                    $log->upload_by = Auth::user()->id;
                    $log->uploaded_at = Carbon::now();
                    $log->status = 0;
                    $log->remarks = $msg;
                    $log->save();
                    Session::put('flash_error' , $msg);
                    return view('members.members.import_members');
                }
                if($fileSize > 20000000){
                    $msg = "Failed due to file is more than 20 MB.";
                    $log = new UploadLog();
                    $log->type = "JOB";
                    $log->file_name = $file_name;
                    $log->upload_by = Auth::user()->id;
                    $log->uploaded_at = Carbon::now();
                    $log->status = 0;
                    $log->remarks = $msg;
                    $log->save();
                    Session::put('flash_error' , $msg);
                    return view('members.members.import_members');
                }
                $path = "";
//                $path = Storage::put('uploads/member_uploads', $request->import_data);
                $log = new UploadLog();
                $log->type = "MEMBER";
                $log->file_name = $file_name;
                $log->upload_by = Auth::user()->id;
                $log->uploaded_at = Carbon::now();
                $log->status = 1;
                $log->remarks = "";
                $log->save();
                $exceldata = Excel::toArray(new Member(), request()->file('import_data'));
                $exceldata = $exceldata[0];
                unset($exceldata[0]);
                $jobs = array();
                $job_ids = array();
//                dd($exceldata);
                foreach($exceldata as $key => $line) {
                    $job_id = (int)$line[0];

                    if($job_id == NULL || $job_id == 0){
                        DB::rollBack();
                        $message = ("Job number can not be empty or zero in line ".($key+1));
                        return back()->with('flash_error' , $message);
                    }

                    if(!is_int($line[1])){
                        DB::rollBack();
                        $message = ("Given date in line number ".($key+1)." is invalid , date must be like m/d/Y ");
                        return back()->with('flash_error' , $message);
                    }
                    $job_date = intval($line[1]);
                    $job_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($job_date)->format('m/d/Y');

                    $error = date_parse_from_format("d/m/Y",$job_date);
                    if($error['error_count'] > 0){
                        DB::rollBack();
                        $message = ("Given date in line number ".($key+1)." is invalid , date must be like d/m/Y ");
                        return back()->with('flash_error' , $message);
                    }
//                    dd($job_date);
                    $job_date = (Carbon::createFromFormat('m/d/Y',$job_date)->format('Y-m-d'));

                    if(strlen(trim($line[2])) == 0){
                        DB::rollBack();
                        $message = ("Customer can not be empty  in line number ".($key+1));
                        return back()->with('flash_error' , $message);
                    }
                    $customer = Customer::where('name' , $line[2])->first();
                    if($customer == NULL){
                        DB::rollBack();
                        $message = ("Customer can not find with name ".$line[2]." in line number ".($key+1));
                        return back()->with('flash_error' , $message);
                    }else{
                        $customer_id = $customer->id;
                    }
                    $is_credit_cash = trim($line[3]);
                    if(!in_array($is_credit_cash , array_keys(config('view.job_types'))) ){
                        //throw new ArgumentExceptio
                        DB::rollBack();
                        $message = ("Invalid Cash / Credit value in line number ".($key+1).". Its must be 0 or 1 or 2");
                        return back()->with('flash_error' , $message);
                    }
                    if(strlen(trim($line[4])) == 0){
                        DB::rollBack();
                        $message = ("Member number can not be empty  in line number ".($key+1));
                        return back()->with('flash_error' , $message);
                    }
                    $member_no = $line[4];
                    if(strlen(trim($line[4])) == 0){
                        DB::rollBack();
                        $message = ("Member name can not be empty  in line number ".($key+1));
                        return back()->with('flash_error' , $message);
                    }
                    $member_name = $line[5];
                    $member_number = $line[6];
                    $expiry_date = intval($line[7]);
                    $expiry_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($expiry_date)->format('d/m/Y');
                    $error = date_parse_from_format("d/m/Y",$expiry_date);
                    if($error['error_count'] > 0){
                        DB::rollBack();
                        $message = ("Given date in line number ".($key+1)." is invalid , date must be like d/m/Y ");
                        return back()->with('flash_error' , $message);
                    }

//                    $date2 = Carbon::createFromFormat('d/m/Y', $expiry_date);
//                    if(Carbon::now()->gt($date2)){
//                        DB::rollBack();
//                        $message = ("Date formate is wrong or Date entered is less than today date in line number ".($key+1));
//                        return back()->with('flash_error' , $message);
//                    }
                    $expiry_date = (Carbon::createFromFormat('d/m/Y',$expiry_date)->format('Y-m-d'));
                    $member_count = Member::where('membership_no' , $member_no)->where('customer_id','!=',$customer_id)->first();
                    if($member_count != NULL){
                        DB::rollBack();
                        $message = ("Member number $member_no in  line ".($key+1)." already taken by another customer ");
                        return back()->with('flash_error' , $message);
                    }
//                    echo $expiry_date;
//                    dd($line);
                    $vehicle_no = trim($line['8']);
                    $chassis_no = trim($line['9']);
                    $engine_no = trim($line['10']);
                    $member = Member::where('membership_no' , $member_no)
                        ->where('customer_id',$customer_id)
                        ->where('vehicle_no',$vehicle_no)->first();
                    if($member == NULL){
                        $member = new Member();
                        $member->membership_no = $member_no;
                        $member->member_name = $member_name;
                        $member->membership_type_id = 0;
                        $member->customer_id = $customer_id;
                        $member->vehicle_no = $vehicle_no;
                        $member->chassis_no = $chassis_no;
                        $member->engine_no = $chassis_no;
                        $member->vehicle_brand_id = 0;
                        $member->vehicle_type_id = 0;
                        $member->vehicle_reg_type_id = 0;
                        $member->mfg_year = null;
                        $member->expiry_date = $expiry_date;
                        $member->ref_no = "";
                        $member->add_by_job = 1;
                    }else{
                        $member->member_name = $member_name;
                        $member->chassis_no = $chassis_no;
                        $member->engine_no = $engine_no;
                        $member->expiry_date = $expiry_date;
                    }
                    $member->save();
                    $member_id = $member->id;
                    $service_name = trim($line['11']);

                    if(strlen(trim($service_name)) == 0){
                        DB::rollBack();
                        $message = ("Service can not be empty  in line number ".($key+1));
                        return back()->with('flash_error' , $message);
                    }
                    $service = Service::where('name' , $service_name)->first();
                    if($service == NULL){
                        DB::rollBack();
                        $message = ("Service can not find with name ".$service_name." in line number ".($key+1));
                        return back()->with('flash_error' , $message);
                    }else{
                        $service_id = $service->id;
                    }

                    $from_area_name = trim($line['12']);
                    if(strlen(trim($from_area_name)) == 0){
                        DB::rollBack();
                        $message = ("From area can not be empty  in line number ".($key+1));
                        return back()->with('flash_error' , $message);
                    }
                    $from_area = ServiceAreas::where('name' , $from_area_name)->first();
                    if($from_area == NULL){
                        DB::rollBack();
                        $message = ("From area can not find with name ".$from_area." in line number ".($key+1));
                        return back()->with('flash_error' , $message);
                    }else{
                        $from_area_id = $from_area->id;
                    }
                    $to_area_name = trim($line['13']);
                    if(strlen(trim($to_area_name)) == 0){
                        DB::rollBack();
                        $message = ("To area can not be empty  in line number ".($key+1));
                        return back()->with('flash_error' , $message);
                    }
                    $to_area = ServiceAreas::where('name' , $to_area_name)->first();
                    if($from_area == NULL){
                        DB::rollBack();
                        $message = ("To area can not find with name ".$to_area." in line number ".($key+1));
                        return back()->with('flash_error' , $message);
                    }else{
                        $to_area_id = $to_area->id;
                    }

                    $amount = $line['14'];
                    if($amount < 0){
                        DB::rollBack();
                        $message = ("Amount Can not be less than zero in line number ".($key+1));
                        return back()->with('flash_error' , $message);
                    }

                    if($is_credit_cash != 0){
                        if($amount == 0 || $amount == ""){
                            DB::rollBack();
                            $message = ("Amount Can not be zero in line number ".($key+1));
                            return back()->with('flash_error' , $message);
                        }
                    }else{
                        if($amount == ""){
                            $amount = 0;
                        }
                    }

                    $remarks = trim($line['15']);
                    $job_status_name = trim($line['16']);
//                    dd($job_status_name);
                    if(!in_array($job_status_name , ['ADDED' , 'COMPLETED' , 'ASSIGNED', 'COMPLETED', 'NOT DONE' , 'CANCELLED'])){
                        DB::rollBack();

                        $message = ("Invalid status in line number ".($key+1).". Status must be  in ADDED ,COMPLETED , ASSIGNED , COMPLETED, NOT DONE , CANCELLED");
                        //dd($message);
                        return back()->with('flash_error' , $message);
                    }
                    $job_status = 0;
                    if($job_status_name == 'ADDED') $job_status = 0;
                    elseif($job_status_name == 'ASSIGNED')  $job_status = 1;
                    elseif($job_status_name == 'COMPLETED') $job_status = 2;
                    elseif($job_status_name == 'NOT DONE')  $job_status = 4;
                    elseif($job_status_name == 'CANCELLED') $job_status = 3;
                    $assign_to_name = trim($line['17']);
                    $driver_vehicle_id = NULL;
                    $driver_id = NULL;
                    $contractor_id = NULL;
                    if($assign_to_name == 'AAA') $assign_to = 0;
                    elseif($assign_to_name == 'CONTRACTOR') $assign_to = 1;
                    else $assign_to = "";
                    $driver_vehicle_no = trim($line['18']);
                    $contractor_name = trim($line['19']);
                    $driver_name = trim($line['20']);
                    $driver_number = trim($line['21']);
                    $contractor_amount = $line['22'];
                    $receipt_no = trim($line['23']);
                    $cancel_reason = trim($line['24']);

                    $not_done_reason = trim($line['25']);
                    if($job_status == 4){
                        if(strlen($not_done_reason) == 0){
                            DB::rollBack();
                            $message = ("Not done reason in line number ".($key+1)." can not be empty");
                            return back()->with('flash_error' , $message);
                        }
                    }
                    if($job_status == 3){
                        if(strlen($cancel_reason) == 0){
                            DB::rollBack();
                            $message = ("Cancel reason in line number ".($key+1)." can not be empty");
                            return back()->with('flash_error' , $message);
                        }
                    }

                    if($job_status != 0 && $assign_to !== ""){
                        if(!in_array($assign_to_name , ['AAA' , 'CONTRACTOR'])){
                            DB::rollBack();
                            $message = ("Invalid status in line number ".($key+1).". Status must be  in AAA , CONTRACTOR");
                            return back()->with('flash_error' , $message);
                        }

                        if($assign_to === 0){
                            if($driver_vehicle_no ==  NULL){
                                DB::rollBack();
                                $message = ("Driver vehicle number can not be empty in line ".($key+1) );
                                return back()->with('flash_error' , $message);
                            }
                            $driver_vehicle = Vehicle::where('vehicle_no' , $driver_vehicle_no)->first();
                            if($driver_vehicle == NULL){
                                DB::rollBack();
                                $message = ('Driver vehicle number '.$driver_vehicle_no." given in line ".($key+1)." can not found" );
                                return back()->with('flash_error' , $message);
                            }
                            $driver_vehicle_id = $driver_vehicle->id;
                            if($driver_name ==  NULL){
                                DB::rollBack();
                                $message = ("Driver name can not be empty in line ".($key+1) );
                                return back()->with('flash_error' , $message);
                            }
                            $driver = Driver::where('name' , $driver_name)->first();

                            if($driver_name == NULL){

                                DB::rollBack();
                                $message = ('Driver name '.$driver_name." given in line ".($key+1)." can not found" );
                                return back()->with('flash_error' , $message);
                            }
                            $driver_id = $driver_vehicle->id;
                            $contractor_id = NULL;
                        }
                        elseif($assign_to === 1){
                            $driver_vehicle_id = NULL;
                            $driver_id = NULL;
                            if($contractor_name ==  NULL){
                                DB::rollBack();
                                $message = ("Contractor name can not be empty in line ".($key+1) );
                                return back()->with('flash_error' , $message);
                            }
                            $contractor = Contractor::where('name' , $contractor_name)->first();
                            if($contractor == NULL){
                                DB::rollBack();
                                $message = ('Contractor name '.$contractor_name." given in line ".($key+1)." can not found" );
                                return back()->with('flash_error' , $message);
                            }
                            $contractor_id = $contractor->id;
                            if($driver_name == NULL){
                                DB::rollBack();
                                $message = ('Driver name '.$driver_name." given in line ".($key+1)." can not found" );
                                return back()->with('flash_error' , $message);
                            }
                        }
                        if($driver_number == NULL){
                            DB::rollBack();
                            $message = ('Driver number can not be empty in line '.($key+1)." can not found" );
                            return back()->with('flash_error' , $message);
                        }
                    }
                    if($contractor_amount < 0){
                        DB::rollBack();
                        $message = ("Contractor amount given in line ".($key+1)." can not be less than zero" );
                        return back()->with('flash_error' , $message);
                    }
                    if($is_credit_cash == 0 && $job_status != 0){
                        if($amount != 0 || $amount != NULL){
                            if(strlen($receipt_no) == 0){
                                DB::rollBack();
                                $message = ("Receipt number given in line ".($key+1)." can not be empty" );
                                return back()->with('flash_error' , $message);
                            }
                        }
                        if($amount == NULL){
                            $amount = 0;
                        }
                    }elseif($is_credit_cash == 1 && $job_status != 0){
                        if(strlen($receipt_no) == 0){
                            DB::rollBack();
                            $message = ("Receipt number given in line ".($key+1)." can not be empty" );
                            return back()->with('flash_error' , $message);
                        }
                        if($amount == NULL || $amount == 0){
                            DB::rollBack();
                            $message = ("Amount given in line ".($key+1)." can not be zero or less than zero." );
                            return back()->with('flash_error' , $message);
                        }
                    }elseif($is_credit_cash == 2 && $job_status != 0){
                        if($amount == NULL || $amount == 0){
                            DB::rollBack();
                            $message = ("Amount given in line ".($key+1)." can not be zero or less than zero." );
                            return back()->with('flash_error' , $message);
                        }
                    }


                    $line_payment_status_name = trim($line['26']);
                    $line_batch_no = (int)($line['27']);
                    $line_invoice_no = trim($line['28']);
                    $line_invoice_date = $line['29'];
                    $line_cheque_number = trim($line['30']);
                    $line_cheque_date = $line['31'];
                    $create_at_date = $line['32'];
                    $assign_at_date = $line['33'];
                    $complete_at_date = $line['34'];
                    if($create_at_date == NULL){
                        DB::rollBack();
                        $message = ("Created time in line ".($key+1)." can not be empty." );
                        return back()->with('flash_error' , $message);
                    }
                    $create_at_date = intval($create_at_date);
                    $create_at_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($create_at_date)
                        ->format('d/m/Y h:i:s A');

                    $error = date_parse_from_format('d/m/Y h:i:s A',$create_at_date);
                    if($error['error_count'] > 0){
                        DB::rollBack();
                        $message = ("Created at in line number ".($key+1)." is invalid , date must be like d/m/Y h:i:s A ");
                        return back()->with('flash_error' , $message);
                    }
                    $create_at = (Carbon::createFromFormat('d/m/Y h:i:s A',$create_at_date)->format('Y-m-d H:i:s'));
                    if($assign_at_date == NULL && ($job_status == 0 || $job_status == 3  || $job_status == 4 )){
                        $assign_at = NULL;
                    }elseif($assign_at_date == NULL && ($job_status == 1 || $job_status == 2)){
                        DB::rollBack();
                        $message = ("Assigned at in line number ".($key+1)." can not be empty ");
                        return back()->with('flash_error' , $message);
                    }
                    else{
                        $assign_at_date = intval($assign_at_date);
                        $assign_at_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($assign_at_date)
                            ->format('d/m/Y h:i:s A');

                        $error = date_parse_from_format('d/m/Y h:i:s A',$assign_at_date);
                        if($error['error_count'] > 0){
                            DB::rollBack();
                            $message = ("Assigned at in line number ".($key+1)." is invalid , date must be like d/m/Y h:i:s A ");
                            return back()->with('flash_error' , $message);
                        }
                        $assign_at = (Carbon::createFromFormat('d/m/Y h:i:s A',$assign_at_date)->format('Y-m-d H:i:s'));
                    }
                    if($complete_at_date == NULL && ($job_status != 2)){
                        $complete_at = NULL;
                    }elseif($complete_at_date == NULL && $job_status == 2){
                        DB::rollBack();
                        $message = ("Completed at in line number ".($key+1)." can not be empty ");
                        return back()->with('flash_error' , $message);
                    }else{
                        $complete_at_date = intval($complete_at_date);
                        $complete_at_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($complete_at_date)
                            ->format('d/m/Y h:i:s A');

                        $error = date_parse_from_format('d/m/Y h:i:s A',$complete_at_date);
                        if($error['error_count'] > 0){
                            DB::rollBack();
                            $message = ("Assigned at in line number ".($key+1)." is invalid , date must be like d/m/Y h:i:s A ");
                            return back()->with('flash_error' , $message);
                        }
                        $complete_at = (Carbon::createFromFormat('d/m/Y h:i:s A',$complete_at_date)->format('Y-m-d H:i:s'));
                    }


                    if($job_status != 2 ){
                        if($line_payment_status_name != NULL || $line_batch_no != NULL || $line_invoice_no != NULL ||
                            $line_invoice_date != NULL || $line_cheque_number != NULL || $line_cheque_date != NULL){
                            DB::rollBack();
                            $message = ("Can not proceed to payment with out completion of job in line ".($key+1));
                            return back()->with('flash_error' , $message);
                        }
                    }
                    if($line_payment_status_name == NULL){
                        if($line_payment_status_name != NULL || $line_batch_no != NULL || $line_invoice_no != NULL ||
                            $line_invoice_date != NULL || $line_cheque_number != NULL || $line_cheque_date != NULL){

                            DB::rollBack();
                            $message = ("Payment status is empty in line ".($key+1)."( But give payment details )");
                            return back()->with('flash_error' , $message);
                        }
                    }
                    $payment_status = 0;
                    $batch_no = NULL;
                    $contractor_invoice = NULL;
                    $contractor_invoice_date = NULL;
                    $contractor_invoice_by = NULL;
                    $contractor_invoice_at = NULL;
                    $cheque_no = NULL;
                    $cheque_date = NULL;
                    $payment_by = NULL;
                    $payment_at = NULL;
                    if($line_payment_status_name != NULL){
                        if(!in_array($line_payment_status_name , ['INVOICE' , 'CHEQUE'])){
                            DB::rollBack();
                            $message = ("Invalid payment status in line number ".($key+1).". Status must be  in INVOICE , CHEQUE");
                            return back()->with('flash_error' , $message);
                        }
                        if($line_payment_status_name == "") $payment_status = 0;
                        elseif($line_payment_status_name == "INVOICE") $payment_status = 1;
                        elseif($line_payment_status_name == "CHEQUE") $payment_status = 2;

                        if($line_batch_no == NULL ){
                            DB::rollBack();
                            $message = ("Batch number can not be empty and has to be integer in line ".($key+1));
                            return back()->with('flash_error' , $message);
                        }
                        $batch_no = str_pad($line_batch_no, 3, 0, STR_PAD_LEFT);
                        if($line_invoice_no == NULL ){
                            DB::rollBack();
                            $message = ("Contractor Invoice Number can not be empty  in line ".($key+1));
                            return back()->with('flash_error' , $message);
                        }
                        $contractor_invoice = $line_invoice_no;

                        $invoice_date = intval($line_invoice_date);
                        $invoice_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($invoice_date)
                            ->format('d/m/Y');
                        $error = date_parse_from_format("d/m/Y",$invoice_date);
                        if($error['error_count'] > 0){
                            DB::rollBack();
                            $message = ("Given date in line number ".($key+1)." is invalid , date must be like d/m/Y ");
                            return back()->with('flash_error' , $message);
                        }
                        $invoice_date = (Carbon::createFromFormat('d/m/Y',$invoice_date)->format('Y-m-d'));
                        $contractor_invoice_date = $invoice_date;
                        $contractor_invoice_by = Auth::user()->id;
                        $contractor_invoice_at = Carbon::now();
                        if($line_payment_status_name == 'CHEQUE'){
                            if($line_cheque_number == '' || $line_cheque_number == 0){
                                DB::rollBack();
                                $message = ("Check number can not be empty in line ".($key+1));
                                return back()->with('flash_error' , $message);
                            }

                            $cheque_date = intval($line_cheque_date);
                            $cheque_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($cheque_date)
                                ->format('d/m/Y');
                            $error = date_parse_from_format("d/m/Y",$cheque_date);
                            if($error['error_count'] > 0){
                                DB::rollBack();
                                $message = ("Given date in line number ".($key+1)." is invalid , date must be like d/m/Y ");
                                return back()->with('flash_error' , $message);
                            }
                            $cheque_date = (Carbon::createFromFormat('d/m/Y',$cheque_date)->format('Y-m-d'));
                            $payment_by = Auth::user()->id;
                            $payment_at = Carbon::now();
                        }
                    }

                    $job = array();
                    $job['is_credit_cash'] = $is_credit_cash;
                    $job['date'] = $job_date ;
                    $job['member_id'] = $member_id ;
                    $job['customer_id'] = $customer_id ;
                    $job['customer_name'] = $customer->name ;
                    $job['member_name'] = $member_name ;
                    $job['member_number'] = $member_no ;
                    $job['vehicle_no'] = $vehicle_no ;
                    $job['member_expiry_date'] = $expiry_date ;
                    $job['chassis_no'] = $chassis_no ;
                    $job['engine_no'] = $engine_no ;
                    $job['service_master_id'] = $service_id ;
                    $job['from_area'] = $from_area_id ;
                    $job['to_area'] = $to_area_id ;
                    $job['amount'] = $amount ;
                    $job['receipt_no'] = $receipt_no ;
                    $job['remarks'] = $remarks ;
                    $job['assign_to'] = $assign_to ;
                    $job['vehicle_id'] = $driver_vehicle_id ;
                    $job['driver_id'] = $driver_id ;
                    $job['contractor_id'] = $contractor_id ;
                    $job['driver_name'] = $driver_name ;
                    $job['driver_no'] = $driver_number ;
                    $job['status'] = $job_status ;
                    $job['contractor_amount'] = $contractor_amount ;
                    $job['invoice_no'] = generate_invoice_no() ;
                    $job['created_at'] = $create_at ;
                    $job['assigned_date'] = $assign_at ;
                    $job['completed_date'] = $complete_at ;

                    if($job_status == 3){
                        $job['cancelled_reason'] = $cancel_reason;
                        $job['cancelled_at'] = Carbon::now();
                        $job['cancelled_by'] = Auth::user()->id;
                    }
                    if($job_status == 4){
                        $job['not_done_reason'] = $not_done_reason;
                        $job['not_done_at'] = Carbon::now();
                        $job['not_done_by'] = Auth::user()->id;
                    }
                    if($job_status == 0){
                        $job['not_done_at'] = NULL;
                        $job['assigned_date'] = NULL;
                        $job['completed_date'] = NULL;
                        $job['cancelled_reason'] = NULL;
                        $job['cancelled_at'] = NULL;
                        $job['cancelled_by'] = NULL;
                        $job['not_done_reason'] = NULL;
                        $job['not_done_at'] = NULL;
                        $job['not_done_by'] = NULL;
                    }
                    if($job_status == 1){
                        $job['not_done_at'] = NULL;
                        $job['completed_date'] = NULL;
                        $job['cancelled_reason'] = NULL;
                        $job['cancelled_at'] = NULL;
                        $job['cancelled_by'] = NULL;
                        $job['not_done_reason'] = NULL;
                        $job['not_done_at'] = NULL;
                        $job['not_done_by'] = NULL;
                    }
                    if($job_status == 2){
                        $job['not_done_at'] = NULL;
                        $job['cancelled_reason'] = NULL;
                        $job['cancelled_at'] = NULL;
                        $job['cancelled_by'] = NULL;
                        $job['not_done_reason'] = NULL;
                        $job['not_done_at'] = NULL;
                        $job['not_done_by'] = NULL;
                    }
                    $job['payment_status'] = $payment_status;
                    $job['batch_no'] = $batch_no;
                    $job['contractor_invoice'] = $contractor_invoice;
                    $job['contractor_invoice_date'] = $contractor_invoice_date;
                    $job['contractor_invoice_by'] = $contractor_invoice_by;
                    $job['contractor_invoice_at'] = $contractor_invoice_at;
                    $job['cheque_no'] = $cheque_no;
                    $job['cheque_date'] = $cheque_date;
                    $job['payment_by'] = $payment_by;
                    $job['payment_at'] = $payment_at;
                    $job['id'] = $job_id;
                    $jobs[] = $job;
//                    dd($job);
                }
//                dd($jobs);
//                Job::where('id' , '>' , 0)->delete();
                $added_count=$update_count=0;
                foreach($jobs as $job){
                    $id = $job['id'];
                    if(Job::find($id) != NULL){
                        unset($job['id']);
                        $update_count++;
                        Job::where('id' , $id)->update($job);
                    }else{
                        $added_count++;
                        Job::insert($job);
                    }
                }
                $msg = "";
                if($update_count != 0){
                    $msg .= $update_count." records updated. ";
                }
                if($added_count != 0){
                    $msg .= $added_count." records added. ";
                }

//                foreach(DB::getQueryLog() as $line){
//                    echo $line['query']."<br>";
//                }
                return back()->with('flash_success' , $msg);
            }
            else{
                return back()->with('flash_error' , "Please select excell file to upload jobs.");
            }
        }catch (Exception $e){
            DB::rollBack();
            return back()->with('flash_error' , "Something went wrong.");
        }
    }
}