<?php

namespace App\Http\Controllers\Resource;

use App\VehicleBrandMaster;
use App\VehicleRegistrationType;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegistrationTypeResource extends Controller
{
    public function index(Request $request)
    {
        $types = VehicleRegistrationType::where('is_active' , 1)->get();
        return view('vehicles.registration_types.index', compact('types'));
    }
    public function create(Request $request){
        return view('vehicles.registration_types.create');
    }
    public function edit($id){
        $type = VehicleRegistrationType::findOrFail($id);
        return view('vehicles.registration_types.edit', compact('type'));
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:vehicle_registration_type_master,name',
        ]);
        try{
            $type = new VehicleRegistrationType();
            $type->name = $request->name;
            $type->remark = $request->remark;
            $type->save();
            return redirect()->route('registrationType.index')->with('flash_success', 'Registration Type added successfully.');
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
            'name' => 'required|unique:vehicle_registration_type_master,name,'.$id,
        ]);

        try{
            $type = VehicleRegistrationType::findOrFail($id);
            $type->name = $request->name;
            $type->remark = $request->remark;
            $type->save();
            return redirect()->route('registrationType.index')->with('flash_success', 'Registration Type updated successfully.');
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
            $type = VehicleRegistrationType::findOrFail($id);
            $type->is_active = 0;
            $type->save();
            return redirect()->route('registrationType.index')->with('flash_success', 'Registration Type deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}