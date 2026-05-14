<?php

namespace App\Http\Controllers\Resource;

use App\Customer;
use App\Member;
use App\MembershipType;
use App\UploadLog;
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

class MembersResource extends Controller
{
    public function index(Request $request)
    {
        //dd($request->all());
        if($request->has('search_key')){
            $members = Member::with('customer')
                ->where('members.is_active' , 1)
                ->where('membership_no' , 'like' , '%'.$request->search_key.'%')
                ->Orwhere('member_name' , 'like' , '%'.$request->search_key.'%')
                ->Orwhere('mobile' , 'like' , '%'.$request->search_key.'%')
                ->Orwhere('vehicle_no' , 'like' , '%'.$request->search_key.'%')
                ->Orwhere('chassis_no' , 'like' , '%'.$request->search_key.'%')
                ->Orwhere('engine_no' , 'like' , '%'.$request->search_key.'%')
                ->limit(1000)
                ->OrderBy('members.created_at','desc')
                ->get();
        }else{
            $search_key = "";
            $members = array();
        }

        return view('members.members.index', compact('members'));
    }
    public function create(Request $request){
        $membership_types = MembershipType::where('is_active' , 1)->get();
        $customers = Customer::where('is_active' , 1)->get();
        $brands= VehicleBrandMaster::where('is_active' , 1)->get();
        $vehicle_types= VehicleType::where('is_active' , 1)->get();
        $vehicle_reg_types= VehicleRegistrationType::where('is_active' , 1)->get();
        return view('members.members.create', compact('membership_types' , 'customers','brands','vehicle_types','vehicle_reg_types'));
    }
    public function edit($id){
        $membership_types = MembershipType::where('is_active' , 1)->get();
        $customers = Customer::where('is_active' , 1)->get();
        $brands= VehicleBrandMaster::where('is_active' , 1)->get();
        $vehicle_types= VehicleType::where('is_active' , 1)->get();
        $vehicle_reg_types= VehicleRegistrationType::where('is_active' , 1)->get();
        $member = Member::findOrFail($id);
        return view('members.members.edit', compact('member' , 'membership_types' , 'customers','brands','vehicle_types','vehicle_reg_types'));
    }
    public function store(Request $request){
        $this->validate($request, [
            'membership_no' => 'required',
            'member_name' => 'required|max:50',
            'membership_type_id' => 'required|exists:membership_type,id',
            'customer_id' => 'required|exists:customers,id',

//            'vehicle_no' => 'required|max:15',
//            'chassis_no' => 'required|max:20',
//            'engine_no' => 'required|max:20',
//            'vehicle_brand_id' => 'required|exists:vehicle_brand_master,id',
//            'vehicle_type_id' => 'required|exists:vehicle_type_master,id',
//            'vehicle_reg_type_id' => 'required|exists:vehicle_registration_type_master,id',

//            'mfg_year' => 'required|max:4|min:4',
            'expiry_date' => 'required|date',
            'ref_no' => 'max:20',
        ]);
        $count = Member::where('membership_no' , $request->membership_no)->where('vehicle_no' , $request->vehicle_no)->count();
        if($count > 0){
            return back()->with('flash_error','Member with this membership number and vehicle number already exist.')->withInput();
        }
//        dd($request->all());
        try{
            $member = new Member();
            $member->membership_no = $request->membership_no;
            $member->member_name = $request->member_name;
            $member->mobile = $request->mobile;
            $member->membership_type_id = $request->membership_type_id;
            $member->customer_id = $request->customer_id;
            $member->vehicle_no = $request->vehicle_no;
            $member->chassis_no = $request->chassis_no;
            $member->engine_no = $request->engine_no;
            $member->vehicle_brand_id = $request->vehicle_brand_id;
            $member->vehicle_type_id = $request->vehicle_type_id;
            $member->vehicle_reg_type_id = $request->vehicle_reg_type_id;
            $member->mfg_year = $request->mfg_year;
            $member->expiry_date = $request->expiry_date;
            $member->ref_no = $request->ref_no;
            $member->save();
            return redirect()->route('members.index')->with('flash_success', 'Member added successfully.');
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
            'membership_no' => 'required|max:30',
            'member_name' => 'required|max:50',
            'membership_type_id' => 'required|exists:membership_type,id',
            'customer_id' => 'required|exists:customers,id',

//            'vehicle_no' => 'required|max:15',
//            'chassis_no' => 'required|max:20',
//            'engine_no' => 'required|max:20',
//            'vehicle_brand_id' => 'required|exists:vehicle_brand_master,id',
//            'vehicle_type_id' => 'required|exists:vehicle_type_master,id',
//            'vehicle_reg_type_id' => 'required|exists:vehicle_registration_type_master,id',

//            'mfg_year' => 'required|max:4|min:4',
            'expiry_date' => 'required|date',
//            'ref_no' => 'max:20',
        ]);
        try{
            if(Member::where('membership_no',$request->membership_no)->where('customer_id' , '!=' , $request->customer_id)->count() > 0){
                return back()->with('flash_error','Membership number already taken by another customer.');
            }
            if(Member::where('membership_no',$request->membership_no)
                    ->where('vehicle_no' , $request->vehicle_no)
                    ->where('customer_id' , $request->customer_id)
                    ->where('id' ,'!=', $id)
                    ->count() > 0){
                return back()->with('flash_error','Membership number already taken by another member.');
            }

            $member = Member::findOrFail($id);
            $member->membership_no = $request->membership_no;
            $member->membership_type_id = $request->membership_type_id;
            $member->member_name = $request->member_name;
            $member->mobile = $request->mobile;
            $member->customer_id = $request->customer_id;
            $member->vehicle_no = $request->vehicle_no;
            $member->chassis_no = $request->chassis_no;
            $member->engine_no = $request->engine_no;
            $member->vehicle_brand_id = $request->vehicle_brand_id;
            $member->vehicle_type_id = $request->vehicle_type_id;
            $member->vehicle_reg_type_id = $request->vehicle_reg_type_id;
            $member->mfg_year = $request->mfg_year;
            $member->expiry_date = $request->expiry_date;
            $member->ref_no = $request->ref_no;
            $member->save();
            return redirect()->route('members.index')->with('flash_success', 'Member updated successfully.');
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
            $member = Member::findOrFail($id);
            $member->is_active = 0;
            $member->save();
            return redirect()->route('members.index')->with('flash_success', 'Member deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    public function get_members(Request $request){
        $id = $request->search;
        $members = array();
        if($id != NULL && strlen($id) > 2) {
            $users = Member::select('members.*')->JOIN('customers' , 'members.customer_id' , 'customers.id')
                ->where('membership_no', 'like','%'.$id.'%')
                ->orWhere('vehicle_no', 'like','%'.$id.'%')
                ->orWhere('member_name', 'like','%'.$id.'%')
                ->orWhere('mobile', 'like','%'.$id.'%')
                ->orWhere('customers.name', 'like','%'.$id.'%')
                ->limit(100)
                ->get();
            $customer_ids = [];

            foreach($users as $key => $user){
                $member['id'] = $user->id."_".$user->customer_id;
                $member['text'] = $user->membership_no;
                $member['member_no'] = $user->membership_no;
                $member['member_name'] = $user->member_name;
                $member['vehicle_no'] = $user->vehicle_no;
                $member['customer_name'] = $user->customer->name;
                $members[] = $member;
                $customer_ids[] = $user->customer_id;
            }
//            if($request->has('is_cash_credit') && $request->is_cash_credit != 0) {
                $cust_count = 100 - count($users);
                $customers = Customer::Where('name', 'like', '%' . $id . '%')
                    ->whereNotIn('id', $customer_ids)
                    ->limit($cust_count)->get();

                foreach ($customers as $key => $customer) {
                    $member['id'] = "_" . $customer->id;
                    $member['text'] = "N/A";
                    $member['member_no'] = "N/A";
                    $member['member_name'] = "N/A";
                    $member['vehicle_no'] = "N/A";
                    $member['customer_name'] = $customer->name;
                    $members[] = $member;
                }
//            }
        }
        $data['total_count'] = count($members);
        $data['items'] = $members;
        return response()->json($data);
    }
    public function get_member_details($id){
        $request = explode('_',$id);
        $member_id = $request[0];
        $customer_id = $request[1];
        $member = Member::find($member_id);
        $customer = Customer::find($customer_id);
        $data['customer_id'] = $customer_id;
        $data['customer_name'] = $customer->name;
        $data['member_id'] = $member_id;
        $data['member_name'] = $member != NULL ? $member->member_name : "";
        $data['member_number'] = $member != NULL ? $member->membership_no  : "";
        $data['vehicle_number'] = $member != NULL ? $member->vehicle_no  : "";
        $data['member_expiry_date'] = $member != NULL ? $member->expiry_date  : "";
        $data['chassis_no'] = $member != NULL ? $member->chassis_no  : "";
        $data['engine_no'] = $member != NULL ? $member->engine_no  : "";
        $data['member_mobile'] = $member != NULL ? $member->mobile  : "";
        return response()->json($data);
    }
    public function import_members(Request $request){
        return view('members.members.import_members');
    }
    public function save_import_members(Request $request){
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
                $log->type = "MEMBER";
                $log->file_name = $file_name;
                $log->upload_by = Auth::user()->id;
                $log->uploaded_at = Carbon::now();
                $log->status = 0;
                $log->remarks = $msg;
                $log->save();
                Session::put('flash_error' , $msg);
                return view('members.members.import_members');
            }

            if($fileSize > 2000000){
                $msg = "Failed due to file is more than 2 MB.";
                $log = new UploadLog();
                $log->type = "MEMBER";
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
            $path = Storage::put('uploads/member_uploads', $request->import_data);
            $log = new UploadLog();
            $log->type = "MEMBER";
            $log->file_name = $path;
            $log->upload_by = Auth::user()->id;
            $log->uploaded_at = Carbon::now();
            $log->status = 1;
            $log->remarks = "";
            $log->save();
            $exceldata = Excel::toArray(new Member(), request()->file('import_data'));

            $exceldata = $exceldata[0];
            unset($exceldata[0]);
            $count = 0;
            DB::beginTransaction();
            $added_count = $updated_count = 0;
            foreach($exceldata as $key => $line){
                //dd($line);
                if(strlen(trim($line[0])) != 0 ){
                    $member_type = MembershipType::where('name',trim($line[0]))->first();
                    if($member_type == NULL){
                        $message = ("Membership Type can not find with name ".$line[0]." in line number ".($key+1));
                        return back()->with('flash_error' , $message);
                    }
                    $membership_id = $member_type->id;
                }else{
                    $membership_id = "";
                }
                if(strlen(trim($line[1])) == 0){
                    $message = ("Customer can not be empty  in line number ".($key+1));
                    return back()->with('flash_error' , $message);
                }
                $customer = Customer::where('name' , $line[1])->first();
                if($customer == NULL){
                    $message = ("Customer can not find with name ".$line[0]." in line number ".($key+1));
                    return back()->with('flash_error' , $message);
                }else{
                    $customer_id = $customer->id;
                }
                $member_no = trim($line[2]);
                $mobile_no = trim($line[4]);
                if(strlen($mobile_no) > 20){
                    $message = ("Mobile number can not be more than 20 digits in  ".($key+1));
                    return back()->with('flash_error' , $message);
                }
                $vehicle_no = trim($line[5]);
                $member_count = Member::where('customer_id' ,'!=', $customer_id)->where('membership_no',$member_no)->count();
                if($member_count > 0){
                    $message = ("Member number ".$line[0]." in line number ".($key+1)." already taken for another customer ");
                    return back()->with('flash_error' , $message);
                }
                $member_name = trim($line[3]);
                if(strlen($member_name) == 0){
                    $message = ("Member Name can not be empty  in line number ".($key+1));
                    return back()->with('flash_error' , $message);
                }
                $expiry_date = intval($line[6]);

                $expiry_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($expiry_date)->format('d/m/Y');

                $error = date_parse_from_format("d/m/Y",$expiry_date);
                if($error['error_count'] > 0){
                    $message = ("Given date in line number ".($key+1)." is invalid , date must be like d/m/Y ");
                    return back()->with('flash_error' , $message);
                }
                $date2 = Carbon::createFromFormat('m/d/Y', $expiry_date);

                if(Carbon::now()->gt($date2)){
                    $message = ("Date formate is wrong or Date entered is less than today date in line number ".($key+1));
                    return back()->with('flash_error' , $message);
                }
                //echo "<br>";continue;
                $expiry_date = (Carbon::createFromFormat('d/m/Y',$expiry_date)->format('Y-m-d'));
                $chassis_no = trim($line[7]);
                $engine_no = trim($line[8]);
                $vehicle_brand = trim($line[9]);
                $vehicle_type = trim($line[10]);
                $vehicle_reg_type = trim($line[11]);
                $manufacture_year = trim($line[12]);
                $refrence = trim($line[13]);
                if(strlen($vehicle_brand) != 0 ){
                    $brand = VehicleBrandMaster::where('name',$vehicle_brand)->first();
                    if($brand == NULL){
                        $message = ("Vehicle brand can not find with name ".$vehicle_brand." in line number ".($key+1));
                        return back()->with('flash_error' , $message);
                    }
                    $brand_id = $brand->id;
                }else{
                    $brand_id = "";
                }
                if(strlen($vehicle_type) != 0 ){
                    $type = VehicleType::where('name',$vehicle_type)->first();
                    if($type == NULL){
                        $message = ("Vehicle type can not find with name ".$vehicle_type." in line number ".($key+1));
                        return back()->with('flash_error' , $message);
                    }
                    $vehicle_type_id = $type->id;
                }else{
                    $vehicle_type_id = "";
                }
                if(strlen($vehicle_reg_type) != 0 ){
                    $reg_type = VehicleRegistrationType::where('name',$vehicle_reg_type)->first();
                    if($reg_type == NULL){
                        $message = ("Vehicle registration type can not find with name ".$vehicle_reg_type." in line number ".($key+1));
                        return back()->with('flash_error' , $message);
                    }
                    $vehicle_reg_type_id = $reg_type->id;
                }else{
                    $vehicle_reg_type_id = "";
                }
                if($manufacture_year != NULL){
                    if(strlen($manufacture_year) != 4){
                        $message = ("Registration year ".$manufacture_year." is invalid in line number ".($key+1));
                        return back()->with('flash_error' , $message);
                    }
                }
                $member_count = Member::where('membership_no',$member_no)->where('vehicle_no',$vehicle_no)->count();
                if($member_count == 0){
                    $member = new Member();
                    $added_count++;
                }else{
                    $updated_count++;
                    $member = Member::where('membership_no',$member_no)->where('vehicle_no',$vehicle_no)->first();
                }
                $member->membership_no = $member_no;
                $member->member_name = $member_name;
                $member->mobile = $mobile_no;
                $member->customer_id = $customer_id;
                $member->membership_type_id = $membership_id;
                $member->vehicle_no = $vehicle_no;
                $member->chassis_no = $chassis_no;
                $member->engine_no = $engine_no;
                $member->vehicle_brand_id = $brand_id;
                $member->vehicle_type_id = $vehicle_type_id;
                $member->vehicle_reg_type_id = $vehicle_reg_type_id;
                $member->mfg_year = $manufacture_year;
                $member->expiry_date = $expiry_date;
                $member->ref_no = $refrence;
                $member->save();
                $count++;
            }
            DB::commit();
            $message = "";
            if($added_count != 0){
                $message .= $added_count." Members added successfully";
            }
            if($updated_count != 0){
                $message .= $updated_count." Members updated successfully";
            }

            return back()->with('flash_success' , $message);
        }
        else{
            return back()->with('flash_error' , "Please select excell file to upload members.");
        }
    }
    public function getCustomerMembersDropdown($id){
        $members = Member::where('customer_id' , $id)->limit(1000)->get();
        $output = "";
        foreach($members as $member){
            $output .= "<option value='$member->id'>$member->membership_no | Name: $member->member_name | Veh.no: $member->vehicle_no</option>";
        }
        return $output;
    }
}