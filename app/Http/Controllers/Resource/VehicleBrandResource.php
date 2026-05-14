<?php

namespace App\Http\Controllers\Resource;

use App\VehicleBrandMaster;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class VehicleBrandResource extends Controller
{
    public function index(Request $request)
    {
        $brands = VehicleBrandMaster::where('is_active' , 1)->get();
        return view('vehicles.brands.index', compact('brands'));
    }
    public function create(Request $request){
        return view('vehicles.brands.create');
    }
    public function edit($id){
        $brand = VehicleBrandMaster::findOrFail($id);
        return view('vehicles.brands.edit', compact('brand'));
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:vehicle_brand_master,name|max:30',
        ]);
        try{
            $brand = new VehicleBrandMaster();
            $brand->name = $request->name;
            $brand->remark = $request->remark;
            $brand->save();
            return redirect()->route('vehicleBrand.index')->with('flash_success', 'Brand added successfully.');
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
            'name' => 'required|max:30|unique:vehicle_brand_master,name,'.$id,
        ]);

        try{
            $brand = VehicleBrandMaster::findOrFail($id);
            $brand->name = $request->name;
            $brand->remark = $request->remark;
            $brand->save();
            return redirect()->route('vehicleBrand.index')->with('flash_success', 'Brand updated successfully.');
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
            $brand = VehicleBrandMaster::findOrFail($id);
            $brand->is_active = 0;
            $brand->save();
            return redirect()->route('vehicleBrand.index')->with('flash_success', 'Brand deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}