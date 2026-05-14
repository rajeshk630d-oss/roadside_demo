<?php

namespace App\Http\Controllers\Resource;

use App\VehicleType;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleTypeResource extends Controller
{
    public function index(Request $request)
    {
        $types = VehicleType::where('is_active' , 1)->get();
        return view('vehicles.types.index', compact('types'));
    }
    public function create(Request $request){
        return view('vehicles.types.create');
    }
    public function edit($id){
        $type = VehicleType::findOrFail($id);
        return view('vehicles.types.edit', compact('type'));
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:30|unique:vehicle_type_master,name',
        ]);
        try{
            $type = new VehicleType();
            $type->name = $request->name;
            $type->remark = $request->remark;
            $type->save();
            return redirect()->route('vehicleType.index')->with('flash_success', 'Type added successfully.');
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
            'name' => 'required|max:30|unique:vehicle_type_master,name,'.$id,
        ]);

        try{
            $type = VehicleType::findOrFail($id);
            $type->name = $request->name;
            $type->remark = $request->remark;
            $type->save();
            return redirect()->route('vehicleType.index')->with('flash_success', 'Type updated successfully.');
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
            $type = VehicleType::findOrFail($id);
            $type->is_active = 0;
            $type->save();
            return redirect()->route('vehicleType.index')->with('flash_success', 'Type deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}