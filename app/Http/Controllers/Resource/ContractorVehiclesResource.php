<?php

namespace App\Http\Controllers\Resource;

use App\Contractor;
use App\ContractorVehicle;
use App\ServiceAreas;
use App\ServiceCountry;
use App\VehicleBrandMaster;
use App\VehicleRegistrationType;
use App\VehicleType;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContractorVehiclesResource extends Controller
{
    public function index(Request $request)
    {
        $vehicles = ContractorVehicle::with('contractor','vehicle_brand','vehicle_type','vehicle_registration_type')
            ->where('is_active' , 1)->get();
        return view('sub_contractor.vehicles.index', compact('vehicles'));
    }
    public function create(Request $request){
        $contractors = Contractor::where('is_active' , 1)->get();
        $brands = VehicleBrandMaster::where('is_active' , 1)->get();
        $vehicle_types = VehicleType::where('is_active' , 1)->get();
        $reg_types = VehicleRegistrationType::where('is_active' , 1)->get();
        return view('sub_contractor.vehicles.create', compact('contractors' , 'brands' , 'vehicle_types' , 'reg_types'));
    }
    public function edit($id){
        $contractors = Contractor::where('is_active' , 1)->get();
        $brands = VehicleBrandMaster::where('is_active' , 1)->get();
        $vehicle_types = VehicleType::where('is_active' , 1)->get();
        $reg_types = VehicleRegistrationType::where('is_active' , 1)->get();
        $vehicle = ContractorVehicle::findOrFail($id);
        return view('sub_contractor.vehicles.edit', compact('vehicle','contractors' , 'brands' ,
            'vehicle_types' , 'reg_types'));
    }
    public function store(Request $request){

        $this->validate($request, [
            'contractor_master_id' => 'required',
            'vehicle_no' => 'required',
            'vehicle_brand_master_id' => 'required',
            'vehicle_type_master_id' => 'required',
            'vehicle_registration_type_master_id' => 'required',
            'model_year' => 'required',
            'engine_no' => 'required',
            'chassis_no' => 'required',
            'v_no' => 'required',
            'registration_expiry_date' => 'required',
            'insurance_company' => 'required',
            'insurance_expiry_date' => 'required',
        ]);

        try{
            $vehicle = new ContractorVehicle();
            $vehicle->contractor_master_id = $request->contractor_master_id;
            $vehicle->vehicle_no = $request->vehicle_no;
            $vehicle->vehicle_brand_master_id = $request->vehicle_brand_master_id;
            $vehicle->vehicle_type_master_id = $request->vehicle_type_master_id;
            $vehicle->vehicle_registration_type_master_id = $request->vehicle_registration_type_master_id;
            $vehicle->model_year = $request->model_year;
            $vehicle->engine_no = $request->engine_no;
            $vehicle->chassis_no = $request->chassis_no;
            $vehicle->v_no = $request->v_no;
            $vehicle->registration_expiry_date = $request->registration_expiry_date;
            $vehicle->insurance_company = $request->insurance_company;
            $vehicle->insurance_expiry_date = $request->insurance_expiry_date;
            $vehicle->save();
            return redirect()->route('contractorVehicles.index')->with('flash_success', 'Vehicle added successfully.');
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
            'contractor_master_id' => 'required',
            'vehicle_no' => 'required',
            'vehicle_brand_master_id' => 'required',
            'vehicle_type_master_id' => 'required',
            'vehicle_registration_type_master_id' => 'required',
            'model_year' => 'required',
            'engine_no' => 'required',
            'chassis_no' => 'required',
            'v_no' => 'required',
            'registration_expiry_date' => 'required',
            'insurance_company' => 'required',
            'insurance_expiry_date' => 'required',
        ]);
        try{
            $vehicle = ContractorVehicle::findOrFail($id);
            $vehicle->contractor_master_id = $request->contractor_master_id;
            $vehicle->vehicle_no = $request->vehicle_no;
            $vehicle->vehicle_brand_master_id = $request->vehicle_brand_master_id;
            $vehicle->vehicle_type_master_id = $request->vehicle_type_master_id;
            $vehicle->vehicle_registration_type_master_id = $request->vehicle_registration_type_master_id;
            $vehicle->model_year = $request->model_year;
            $vehicle->engine_no = $request->engine_no;
            $vehicle->chassis_no = $request->chassis_no;
            $vehicle->v_no = $request->v_no;
            $vehicle->registration_expiry_date = $request->registration_expiry_date;
            $vehicle->insurance_company = $request->insurance_company;
            $vehicle->insurance_expiry_date = $request->insurance_expiry_date;
            $vehicle->save();
            return redirect()->route('contractorVehicles.index')->with('flash_success', 'Vehicle updated successfully.');
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
            $vehicle = ContractorVehicle::findOrFail($id);
            $vehicle->is_active = 0;
            $vehicle->save();
            return redirect()->route('contractorVehicles.index')->with('flash_success', 'Vehicle deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}