<?php

namespace App\Http\Controllers;

use App\Contractor;
use App\Job;
use App\Member;
use App\User;
use App\UserLog;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }
    public function index()
    {
        $members = Member::where('is_active' , 1)->count();
        $pending_jobs = Job::where('status' , 0)->count();
        $assigned_jobs = Job::where('status' , 1)->count();
        $completed_jobs = Job::where('status' , 2)->count();
        $cancelled_jobs = Job::where('status' , 3)->count();
        $not_done_jobs = Job::where('status' , 4)->count();
        $all_jobs = Job::count();
        return view('home' , compact('members','pending_jobs','completed_jobs','all_jobs','assigned_jobs'));
    }
    public function get_pending_invoices(Request $request){
        $contractors = Contractor::where('is_active',1)->get();
        $contractor_id=NULL;
        if($request->has('contractor_id')){
            $contractor_id = $request->contractor_id;
            $jobs = Job::with('from_service_area','to_service_area')
                ->where('assign_to' , 1)
                ->where('payment_status' , 0)
                ->where('status' , 2)
                ->where('contractor_id' , $request->contractor_id)
                ->where('batch_no' , NULL)
                ->orderBy('id' , 'ASC')
                ->get();
        }else{
            $jobs = array();
        }
        $data = $request->all();
        return view('sub_contractor.contractor_invoice',compact('jobs','contractors','contractor_id','data'));
    }
    public function return_pending_invoices(Request $request , $status = false , $msg = ''){
        $contractors = Contractor::where('is_active',1)->get();
        $contractor_id=NULL;
        if($request->has('contractor_id')){
            $contractor_id = $request->contractor_id;
            $jobs = Job::with('from_service_area','to_service_area')->where('payment_status' , 0)
                ->where('status' , 2)
                ->where('assign_to' , 1)
                ->where('contractor_id' , $request->contractor_id)
                ->where('batch_no' , NULL)
                ->get();
        }else{
            $jobs = array();
        }
        $data = $request->all();
        if($status == FALSE){
            Session::put('flash_error' , $msg);
            return view('sub_contractor.contractor_invoice',compact('jobs','contractors',
                'contractor_id','data'));
        }
        return view('sub_contractor.contractor_invoice',compact('jobs','contractors','contractor_id','data'));
    }
    public function save_contractor_batch(Request $request){
        $this->validate($request, [
            'contractor_id' => 'required|exists:contractors,id'
        ]);
        try{
            $jobs = Job::with('from_service_area','to_service_area')->where('payment_status' , 0)
                ->where('status' , 2)
                ->where('assign_to' , 1)
                ->where('contractor_id' , $request->contractor_id)
                ->where('batch_no' , NULL)
                ->get();
            if(count($jobs) > 0){
                $allowed_jobs = [];
                foreach($jobs as $job){
                    $job_status = 0;
                    $can_process = 1;
                    if($request->has('invoice_no_'.$job->id) && $request->input('invoice_no_'.$job->id) != NULL ){
                        if($request->has('contractor_amount_'.$job->id)
                            && $request->input('contractor_amount_'.$job->id) != 0
                            && $request->input('contractor_amount_'.$job->id) != NULL){
                            $job_status += 1;
                        }else{$can_process = 0;}
                        if($request->has('invoice_no_'.$job->id) && $request->input('invoice_no_'.$job->id) != NULL ){
                            $job_status += 1;
                        }else{$can_process = 0;}
                        if($request->has('invoice_date_'.$job->id) && $request->input('invoice_date_'.$job->id) != NULL ){
                            $job_status += 1;
                        }else{$can_process = 0;}

                        if($job_status != 0 && $job_status != 3){
                            $status = FALSE;
                            $msg = "Details entered for job #".$job->id." are wrong.";
                            return $this->return_pending_invoices($request , $status , $msg);
                        }
                        else{
                            if($can_process)
                                $allowed_jobs[] = $job->id;
                        }
                    }
                }
                if(count($allowed_jobs) == 0){
                    $status = FALSE;
                    $msg = "Please enter details for any one job properly.";
                    return $this->return_pending_invoices($request , $status , $msg);
                }
                else{
                    $batch_no = generate_batch_no();
//                    dd($batch_no);
                    foreach($allowed_jobs as $job_id){
                        $job = Job::findOrFail($job_id);
                        $job->contractor_amount = $request->input('contractor_amount_'.$job->id);
                        $job->contractor_invoice = $request->input('invoice_no_'.$job->id);
                        $job->contractor_invoice_date = $request->input('invoice_date_'.$job->id);
                        $job->contractor_invoice_by = Auth::user()->id;
                        $job->contractor_invoice_at = Carbon::now();
                        $job->batch_no = $batch_no;
                        $job->payment_status = 1;
                        $job->save();
                    }
                    return redirect()->route('contractorInvoice')->with('flash_success', 'Batch added successfully.');
                }

            }else{
                $status = FALSE;
                $msg = "No Jobs Found.";
                return $this->return_pending_invoices($request , $status , $msg);
            }
        }catch (Exception $e) {
            $status = FALSE;
            $msg = "Something went wrong.";
            return $this->return_pending_invoices($request , $status , $msg);
        }
    }
    public function get_pending_batches(Request $request){
        $batches = Job::select('batch_no' , 'name')
            ->JOIN('contractors' , 'contractor_id','contractors.id')
            ->groupBy('batch_no')
            ->where('batch_no', '!=', "")
            ->where('payment_status',  "1")
            ->get();
        $contractors = Contractor::where('is_active',1)->get();
        $contractor_id = $request->contractor_id;
        if($request->has('batch_no') && $request->batch_no != NULL){
            $batch_no = $request->batch_no;
            $jobs = Job::with('from_service_area','to_service_area')->where('payment_status' , 1)
                ->where('status' , 2)
                ->where('assign_to' , 1)
                ->where('batch_no' , $request->batch_no)
                ->get();
        }else{
            $batch_no = "";
            $jobs = array();
        }
        $data = $request->all();
        return view('sub_contractor.contractor_payment',compact('jobs','batch_no','data' ,'contractor_id', 'contractors' , 'batches'));
    }
    public function save_contractor_payments(Request $request){
        $this->validate($request, [
            'batch_no' => 'required|exists:jobs,batch_no',
            'cheque_no' => 'required|max:20',
            'cheque_date' => 'required|date',
        ]);
        $jobs = Job::where('payment_status' , 1)
            ->where('status' , 2)
            ->where('assign_to' , 1)
            ->where('batch_no' , $request->batch_no)
            ->get();

        if(count($jobs) > 0){
            foreach($jobs as $job){
                $job = Job::find($job->id);
                $job->cheque_no = $request->cheque_no;
                $job->cheque_date = $request->cheque_date;
                $job->payment_by = Auth::user()->id;
                $job->payment_at = Carbon::now();
                $job->payment_status = 2;
                $job->save();
            }
            return redirect()->route('contractorPayment')->with('flash_success', 'Payment completed successfully.');
        }else{
            $status = FALSE;
            $msg = "No Jobs Found.";
            return $this->return_pending_batches($request , $status , $msg);
        }
    }
    public function return_pending_batches(Request $request , $status = false , $msg = ''){
        $batch_no = NULL;
        $batches = Job::select('batch_no' , 'name')
            ->JOIN('contractors' , 'contractor_id','contractors.id')
            ->groupBy('batch_no')
            ->where('batch_no', '!=', "")
            ->where('payment_status',  "1")
            ->get();
        if($request->has('batch_no')){
            $batch_no = $request->batch_no;
            $jobs = Job::with('from_service_area','to_service_area')->where('payment_status' , 1)
                ->where('status' , 2)
                ->where('assign_to' , 1)
                ->where('batch_no' , $request->batch_no)
                ->get();
        }else{
            $jobs = array();
        }
        $data = $request->all();
        if($status == FALSE){
            Session::put('flash_error' , $msg);
            return view('sub_contractor.contractor_payment',compact('jobs', 'batch_no','data','batches'));
        }
        return view('sub_contractor.contractor_payment',compact('jobs','batch_no','data','batches'));
    }
    public function get_contractor_inquiry(Request $request){
        $contractors = Contractor::where('is_active',1)->get();
        $contractor_id = $request->contractor_id;
        $jobs = Job::with('contractor','service')->where('status' , 2)->where('assign_to' , 1);
        if($request->has('contractor_id') && $request->contractor_id != NULL){
            $jobs = $jobs->where('contractor_id' , $request->contractor_id);
            $jobs = $jobs->get();
        }else{
            $jobs = array();
        }

        return view('sub_contractor.contractor_inquiry',compact('jobs','contractors','contractor_id'));
    }

    public function userLogs(Request $request){
//        dd(display_date_time('2022-07-27 21:37:13'));
        ini_set('memory_limit', '-1');
        if(!$request->has('from_date')){
            $request->from_date = Carbon::now()->addMonth(-1)->format('Y-m-d') ;
            $request->to_date = Carbon::now()->endOfDay()->format('Y-m-d');
        }
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $user_id = $request->user_id;
        $users = User::where('is_active' , 1)->get();
        $logs = UserLog::with('user')->where('created_at', '>=' ,$from_date." 00:00:00")
            ->where('created_at', '<=' , $to_date." 23:59:59" )
            ->orderBy('created_at','DESC');
        if($request->has('user_id') && $request->user_id != ''){
            $logs = $logs->where('user_id' , $request->user_id);
        }
        $logs = $logs->get();
        return view('users.user_log',compact('logs' , 'users' , 'from_date' , 'to_date','user_id'));

    }
    public function get_settings(){
        $settings = array();
        return view('settings',compact('settings'));
    }
    public function get_email_settings(){
        $settings = array();
        return view('email_settings',compact('settings'));
    }
    public function update_email_settings(Request $request){
        dd($request->all());
    }
    public function profile(Request $request){
        $user = User::with('role')->find(Auth::user()->id);
        if($user->photo == NULL){
            $user->photo = asset('public/dist/img/default-150x150.png');
        }else{
            $user->photo = asset('storage/app/'.$user->photo);
        }
        return view('profile' , compact('user'));
    }
    public function update_profile(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'user_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        try{
            $user = User::find(Auth::user()->id);
            $user->name = $request->name;
            if($request->hasFile('user_photo')){
                $path = Storage::put('uploads/users/profile', $request->user_photo);
                $user->photo = $path;
            }
            if($request->has('user_password') && trim($request->user_password) != NULL){
                $user->password = Hash::make($request->user_password);
            }
            if($user->save()){
                return back()->with('flash_success',"Profile updated succefully");
            }
            else{
                return back()->with('flash_error',"Something went wrong.")->withInput();
            }
        } catch (Exception $e) {
            $msg = "Something went wrong.";
            return back()->with('flash_error',$msg)->withInput();
        }
    }
}
