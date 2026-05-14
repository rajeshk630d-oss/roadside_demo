<?php

namespace App\Http\Controllers\Resource;

use App\Contractor;
use App\ContractorVehicle;
use App\Member;
use App\MembershipType;
use App\MemberVehicle;
use App\ServiceAreas;
use App\ServiceCountry;
use App\Vehicle;
use App\VehicleBrandMaster;
use App\VehicleRegistrationType;
use App\VehicleType;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AAAVehicleResource extends Controller
{
    public function index(Request $request)
    {
        $vehicles = Vehicle::with('vehicle_brand','vehicle_type')
            ->where('is_active' , 1)
            ->limit(100)
            ->OrderBy('created_at','desc')
            ->get();
        return view('aaa.vehicles.index', compact('vehicles'));
    }
    public function create(Request $request){
        $brands = VehicleBrandMaster::where('is_active' , 1)->get();
        $vehicle_types = VehicleType::where('is_active' , 1)->get();
        $reg_types = VehicleRegistrationType::where('is_active' , 1)->get();
        return view('aaa.vehicles.create', compact('brands' ,
            'vehicle_types' , 'reg_types'));
    }
    public function edit($id){
        $brands = VehicleBrandMaster::where('is_active' , 1)->get();
        $vehicle_types = VehicleType::where('is_active' , 1)->get();
        $reg_types = VehicleRegistrationType::where('is_active' , 1)->get();
        $vehicle = Vehicle::findOrFail($id);

        return view('aaa.vehicles.edit', compact('vehicle', 'brands' ,
            'vehicle_types' , 'reg_types'));
    }
    public function store(Request $request){

        $this->validate($request, [
            'vehicle_no' => 'required|max:10|unique:vehicles,vehicle_no',
            'vehicle_brand_master_id' => 'required|exists:vehicle_brand_master,id',
            'vehicle_type_master_id' => 'required|exists:vehicle_type_master,id',
//            'vehicle_registration_type_master_id' => 'required|exists:vehicle_registration_type_master,id',
            'model' => 'required|max:20',
            'mfg_year' => 'required|max:4|min:4',
            'engine_no' => 'required|max:50',
            'chassis_no' => 'required|max:50',
//            'v_no' => 'required',
            'registration_expiry_date' => 'required|date',
            'insurance_company' => 'required|max:100',
            'insurance_expiry_date' => 'required|date',
        ]);

        try{
            $vehicle = new Vehicle();
            $vehicle->vehicle_no = $request->vehicle_no;
            $vehicle->vehicle_brand_master_id = $request->vehicle_brand_master_id;
            $vehicle->vehicle_type_master_id = $request->vehicle_type_master_id;
            $vehicle->model = $request->model;
            $vehicle->mfg_year = $request->mfg_year;
            $vehicle->engine_no = $request->engine_no;
            $vehicle->chassis_no = $request->chassis_no;
//            $vehicle->v_no = $request->v_no;
            $vehicle->registration_expiry_date = $request->registration_expiry_date;
            $vehicle->insurance_company = $request->insurance_company;
            $vehicle->insurance_expiry_date = $request->insurance_expiry_date;
            $vehicle->save();
            return redirect()->route('aaaVehicle.index')->with('flash_success', 'Vehicle added successfully.');
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
            'vehicle_no' => 'required|max:10|unique:vehicles,vehicle_no,'.$id,
            'vehicle_brand_master_id' => 'required|exists:vehicle_brand_master,id',
            'vehicle_type_master_id' => 'required|exists:vehicle_type_master,id',
//            'vehicle_registration_type_master_id' => 'required|exists:vehicle_registration_type_master,id',
            'model' => 'required|max:20',
            'mfg_year' => 'required|max:4|min:4',
            'engine_no' => 'required|max:50',
            'chassis_no' => 'required|max:50',
//            'v_no' => 'required',
            'registration_expiry_date' => 'required|date',
            'insurance_company' => 'required|max:100',
            'insurance_expiry_date' => 'required|date',
        ]);
        try{
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->vehicle_no = $request->vehicle_no;
            $vehicle->vehicle_brand_master_id = $request->vehicle_brand_master_id;
            $vehicle->vehicle_type_master_id = $request->vehicle_type_master_id;
            $vehicle->model = $request->model;
            $vehicle->mfg_year = $request->mfg_year;
            $vehicle->engine_no = $request->engine_no;
            $vehicle->chassis_no = $request->chassis_no;
//            $vehicle->v_no = $request->v_no;
            $vehicle->registration_expiry_date = $request->registration_expiry_date;
            $vehicle->insurance_company = $request->insurance_company;
            $vehicle->insurance_expiry_date = $request->insurance_expiry_date;
            $vehicle->save();
            return redirect()->route('aaaVehicle.index')->with('flash_success', 'Vehicle updated successfully.');
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
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->is_active = 0;
            $vehicle->save();
            return redirect()->route('aaaVehicle.index')->with('flash_success', 'Vehicle deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!')->withInput();
        }
    }
}