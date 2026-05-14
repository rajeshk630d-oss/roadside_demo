<?php

namespace App\Http\Controllers\Resource;

use App\Contractor;
use App\Customer;
use App\Job;
use App\Member;
use App\MembershipType;
use App\UploadLog;
use App\User;
use App\VehicleBrandMaster;
use App\VehicleRegistrationType;
use App\VehicleType;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Excel;

class BatchResource extends Controller
{
    public function index(Request $request)
    {
        ini_set('memory_limit', '-1');
        $batch_ids = Job::select('batch_no' , 'contractor_id')
            ->where('batch_no' , '!=' , NULL)
            ->where('payment_status' , '!=' , 0)
            ->where('status' , 2);
        if($request->has('contractor_id') && $request->contractor_id != NULL){
            $batch_ids = $batch_ids->where('contractor_id' , $request->contractor_id);
        }
        $batch_ids = $batch_ids->groupBy('batch_no')
            ->get();
        $batches = array();
        foreach($batch_ids as $batch_id){
            $job = Job::where('batch_no' , $batch_id->batch_no)->first();
            if($job->payment_status == 2){
                $batch['can_edit'] = 0;
            }else{
                $batch['can_edit'] = 1;
            }
            $batch['batch_no'] = $batch_id->batch_no;
            $batch['contractor_id'] = $batch_id->contractor_id;
            $batch['contractor'] = Contractor::select('name')->first($batch_id->contractor_id);
            $batch['job_count'] = Job::where('payment_status' , '!=' , 0)
                ->where('batch_no'  , $batch_id->batch_no)->count();
            $job = Job::where('batch_no'  , $batch_id->batch_no)->first();
            $batch['created_by'] = User::select('name')->find($job->contractor_invoice_by);
            $batch['created_at'] = Carbon::createFromFormat('Y-m-d H:i:s' , $job->contractor_invoice_at)
                ->format('d-m-Y');
            $batches[] = $batch;
        }
        return view('batch.index', compact('batches'));
    }
    public function create(Request $request){

    }
    public function edit(Request $request , $id){
        $batch_no = $id;
        $job = Job::where('batch_no' , $id)->first();
        if($job->payment_status == 2){
            return back()->with('flash_error','Payment already completed can not edit now.')->withInput();
        }
        $contractor_id = $job->contractor_id;
        $contractor = Contractor::findOrFail($contractor_id);
        $completed_job_ids = Job::where('assign_to' , 1)
            ->where('batch_no' , $id)
            ->orderBy('id' , 'ASC')
            ->get()->pluck('id');
        $jobs_completed = Job::with('from_service_area','to_service_area')
            ->whereIn('id' , $completed_job_ids)
            ->orderBy('id' , 'ASC')
            ->get();
        $pending_job_ids = Job::where('assign_to' , 1)
            ->where('payment_status' , 0)
            ->where('status' , 2)
            ->where('contractor_id' , $job->contractor_id)
            ->where('batch_no' , NULL)
            ->orderBy('id' , 'ASC')
            ->get()->pluck('id');
        $jobs_pending = Job::with('from_service_area','to_service_area')
            ->whereIn('id' , $pending_job_ids)
            ->orderBy('id' , 'ASC')
            ->get();

        $jobs = [];
        foreach($jobs_completed as $job){
            $jobs[] = $job;
        }
        foreach($jobs_pending as $job){
            $jobs[] = $job;
        }
        $data = $request->all();
        return view('batch.edit', compact('jobs','contractor','contractor_id','data','batch_no'));
    }
    public function store(Request $request){

    }
    public function update(Request $request , $id){
        try{
            DB::beginTransaction();
            $batch_no = $id;
            $job = Job::where('batch_no' , $id)->first();
            if($job->payment_status == 2){
                return back()->with('flash_error','Payment already completed can not edit now.')->withInput();
            }
            $contractor_id = $job->contractor_id;
            $contractor = Contractor::findOrFail($contractor_id);
            $completed_job_ids = Job::where('assign_to' , 1)
                ->where('batch_no' , $id)
                ->orderBy('id' , 'ASC')
                ->get()->pluck('id');
            $jobs_completed = Job::with('from_service_area','to_service_area')
                ->whereIn('id' , $completed_job_ids)
                ->orderBy('id' , 'ASC')
                ->get();
            $pending_job_ids = Job::where('assign_to' , 1)
                ->where('payment_status' , 0)
                ->where('status' , 2)
                ->where('contractor_id' , $job->contractor_id)
                ->where('batch_no' , NULL)
                ->orderBy('id' , 'ASC')
                ->get()->pluck('id');
            $jobs_pending = Job::with('from_service_area','to_service_area')
                ->whereIn('id' , $pending_job_ids)
                ->orderBy('id' , 'ASC')
                ->get();

            $jobs = [];
            foreach($jobs_completed as $job){
                $jobs[] = $job;
            }
            foreach($jobs_pending as $job){
                $jobs[] = $job;
            }

            if(count($jobs) > 0) {
                $allowed_jobs = [];
                foreach ($jobs as $job) {
                    $job_status = 0;
                    $can_process = 1;
                    if ($request->has('invoice_no_' . $job->id) && $request->input('invoice_no_' . $job->id) != NULL) {
                        if ($request->has('contractor_amount_' . $job->id)
                            && $request->input('contractor_amount_' . $job->id) != 0
                            && $request->input('contractor_amount_' . $job->id) != NULL
                        ) {
                            $job_status += 1;
                        } else {
                            $can_process = 0;
                        }
                        if ($request->has('invoice_no_' . $job->id) && $request->input('invoice_no_' . $job->id) != NULL) {
                            $job_status += 1;
                        } else {
                            $can_process = 0;
                        }
                        if ($request->has('invoice_date_' . $job->id) && $request->input('invoice_date_' . $job->id) != NULL) {
                            $job_status += 1;
                        } else {
                            $can_process = 0;
                        }

                        if ($job_status != 0 && $job_status != 3) {
                            $status = FALSE;
                            $msg = "Details entered for job #" . $job->id . " are wrong.";
                            return back()->with('flash_error',$msg);
                        } else {
                            if ($can_process)
                                $allowed_jobs[] = $job->id;
                        }
                    }
                }

                if (count($allowed_jobs) == 0) {
                    $status = FALSE;
                    $msg = "Please enter details for any one job properly.";
                    return back()->with('flash_error',$msg);
                }else{
                    Job::where('batch_no' , $id)->update([
                        'payment_status' => 0,
                        'batch_no' => NULL,
                        'contractor_invoice' => NULL,
                        'contractor_invoice_date' => NULL,
                        'contractor_invoice_by' => NULL,
                        'contractor_invoice_at' => NULL,
                        'invoice_no' => NULL,
                        'cheque_no' => NULL,
                        'cheque_date' => NULL,
                        'payment_by' => NULL,
                        'payment_at' => NULL,
                    ]);
                    foreach($allowed_jobs as $job_id){
                        $job = Job::findOrFail($job_id);
                        $job->contractor_amount = $request->input('contractor_amount_'.$job->id);
                        $job->contractor_invoice = $request->input('invoice_no_'.$job->id);
                        $job->contractor_invoice_date = $request->input('invoice_date_'.$job->id);
                        $job->contractor_invoice_by = Auth::user()->id;
                        $job->contractor_invoice_at = Carbon::now();
                        $job->batch_no = $id;
                        $job->payment_status = 1;
                        $job->save();
                    }
                    return redirect()->route('batch.index')->with('flash_success', 'Batch updated successfully.');
                }
            }else{
                $status = FALSE;
                $msg = "No Jobs Found.";
                return back()->with('flash_error',$msg);
            }
//            return redirect()->route('members.index')->with('flash_success', 'Member updated successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    public function destroy(Request $request , $id){
        if(!is_admin(Auth::user()->id)){
            return back()->with('flash_error','Access denied!');
        }
        try{
            Job::where('batch_no' , $id)->update([
                'payment_status' => 0,
                'batch_no' => NULL,
                'contractor_invoice' => NULL,
                'contractor_invoice_date' => NULL,
                'contractor_invoice_by' => NULL,
                'contractor_invoice_at' => NULL,
                'invoice_no' => NULL,
                'cheque_no' => NULL,
                'cheque_date' => NULL,
                'payment_by' => NULL,
                'payment_at' => NULL,
            ]);
            return redirect()->route('batch.index')->with('flash_success', 'Batch deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}