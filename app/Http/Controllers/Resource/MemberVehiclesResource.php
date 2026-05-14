<?php

namespace App\Http\Controllers\Resource;

use App\Contractor;
use App\ContractorVehicle;
use App\Member;
use App\MembershipType;
use App\MemberVehicle;
use App\ServiceAreas;
use App\ServiceCountry;
use App\VehicleBrandMaster;
use App\VehicleRegistrationType;
use App\VehicleType;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberVehiclesResource extends Controller
{
    public function index(Request $request)
    {
        $vehicles = MemberVehicle::with('membership_type','vehicle_brand','vehicle_type','vehicle_registration_type')
            ->where('is_active' , 1)
            ->limit(100)
            ->OrderBy('created_at','desc')
            ->get();
//        dd($vehicles->first()->toArray());
        return view('members.vehicles.index', compact('vehicles'));
    }
    public function create(Request $request){
        $membership_types = MembershipType::where('is_active' , 1)->get();
        $brands = VehicleBrandMaster::where('is_active' , 1)->get();
        $vehicle_types = VehicleType::where('is_active' , 1)->get();
        $reg_types = VehicleRegistrationType::where('is_active' , 1)->get();
        return view('members.vehicles.create', compact('membership_types' , 'brands' ,
            'vehicle_types' , 'reg_types'));
    }
    public function edit($id){
        $membership_types = MembershipType::where('is_active' , 1)->get();
        $brands = VehicleBrandMaster::where('is_active' , 1)->get();
        $vehicle_types = VehicleType::where('is_active' , 1)->get();
        $reg_types = VehicleRegistrationType::where('is_active' , 1)->get();
        $vehicle = MemberVehicle::findOrFail($id);
        return view('members.vehicles.edit', compact('vehicle','membership_types' , 'brands' ,
            'vehicle_types' , 'reg_types'));
    }
    public function store(Request $request){

        $this->validate($request, [
            'membership_type_id' => 'required|exists:membership_type,id',
            'vehicle_brand_master_id' => 'required|exists:vehicle_brand_master,id',
            'vehicle_type_master_id' => 'required|exists:vehicle_type_master,id',
            'vehicle_registration_type_master_id' => 'required|exists:vehicle_registration_type_master,id',

            'membership_no' => 'required',
            'vehicle_registration_no' => 'required',
            'chassis_no' => 'required',
            'engine_no' => 'required',

            'v_no' => 'required',
            'mfg_year' => 'required',
            'color' => 'required',
            'owner_name' => 'required',

            'registration_expiry_date' => 'required',
            'insurance_company' => 'required',
            'insurance_expiry_date' => 'required',
        ]);
        try{
            $vehicle = new MemberVehicle();
            $vehicle->membership_type_id = $request->membership_type_id;
            $vehicle->vehicle_brand_master_id = $request->vehicle_brand_master_id;
            $vehicle->vehicle_type_master_id = $request->vehicle_type_master_id;
            $vehicle->vehicle_registration_type_master_id = $request->vehicle_registration_type_master_id;

            $vehicle->membership_no = $request->membership_no;
            $vehicle->vehicle_registration_no = $request->vehicle_registration_no;
            $vehicle->chassis_no = $request->chassis_no;
            $vehicle->engine_no = $request->engine_no;

            $vehicle->v_no = $request->v_no;
            $vehicle->mfg_year = $request->mfg_year;
            $vehicle->color = $request->color;
            $vehicle->owner_name = $request->owner_name;

            $vehicle->registration_expiry_date = $request->registration_expiry_date;
            $vehicle->insurance_company = $request->insurance_company;
            $vehicle->insurance_expiry_date = $request->insurance_expiry_date;
            $vehicle->save();
            return redirect()->route('memberVehicles.index')->with('flash_success', 'Vehicle added successfully.');
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
            'membership_type_id' => 'required|exists:membership_type,id',
            'vehicle_brand_master_id' => 'required|exists:vehicle_brand_master,id',
            'vehicle_type_master_id' => 'required|exists:vehicle_type_master,id',
            'vehicle_registration_type_master_id' => 'required|exists:vehicle_registration_type_master,id',

            'membership_no' => 'required',
            'vehicle_registration_no' => 'required',
            'chassis_no' => 'required',
            'engine_no' => 'required',

            'v_no' => 'required',
            'mfg_year' => 'required',
            'color' => 'required',
            'owner_name' => 'required',

            'registration_expiry_date' => 'required',
            'insurance_company' => 'required',
            'insurance_expiry_date' => 'required',
        ]);
        try{
            $vehicle = MemberVehicle::findOrFail($id);
            $vehicle->membership_type_id = $request->membership_type_id;
            $vehicle->vehicle_brand_master_id = $request->vehicle_brand_master_id;
            $vehicle->vehicle_type_master_id = $request->vehicle_type_master_id;
            $vehicle->vehicle_registration_type_master_id = $request->vehicle_registration_type_master_id;

            $vehicle->membership_no = $request->membership_no;
            $vehicle->vehicle_registration_no = $request->vehicle_registration_no;
            $vehicle->chassis_no = $request->chassis_no;
            $vehicle->engine_no = $request->engine_no;

            $vehicle->v_no = $request->v_no;
            $vehicle->mfg_year = $request->mfg_year;
            $vehicle->color = $request->color;
            $vehicle->owner_name = $request->owner_name;

            $vehicle->registration_expiry_date = $request->registration_expiry_date;
            $vehicle->insurance_company = $request->insurance_company;
            $vehicle->insurance_expiry_date = $request->insurance_expiry_date;
            $vehicle->save();
            return redirect()->route('memberVehicles.index')->with('flash_success', 'Vehicle updated successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!')->withInput();
        }
    }
    public function destroy(Request $request , $id){
        try{
            $vehicle = MemberVehicle::findOrFail($id);
            $vehicle->is_active = 0;
            $vehicle->save();
            return redirect()->route('memberVehicles.index')->with('flash_success', 'Vehicle deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}