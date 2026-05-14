<?php

namespace App\Http\Controllers\Resource;

use App\Service;
use App\ServiceAreas;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceResource extends Controller
{
    public function index(Request $request)
    {
        $services = Service::where('is_active' , 1)->get();
        return view('services.services.index', compact('services'));
    }
    public function create(Request $request){
        return view('services.services.create');
    }
    public function edit($id){
        $service = Service::findOrFail($id);
        return view('services.services.edit', compact('service'));
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:service_master,name|max:100',
            'charges' => 'required|numeric:max:15',
            'minimum_km' => 'required|numeric:max:10',
            'extracharges_km' => 'required|numeric:15',
        ]);
        try{
            $service = new Service();
            $service->name = $request->name;
            $service->charges = $request->charges;
            $service->minimum_km = $request->minimum_km;
            $service->extracharges_km = $request->extracharges_km;
            $service->save();
            return redirect()->route('service.index')->with('flash_success', 'Service added successfully.');
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
            'name' => 'required|max:100|unique:service_master,name,'.$id,
            'charges' => 'required|numeric:max:15',
            'minimum_km' => 'required|numeric:max:10',
            'extracharges_km' => 'required|numeric:15',
        ]);

        try{
            $service = Service::findOrFail($id);
            $service->name = $request->name;
            $service->charges = $request->charges;
            $service->minimum_km = $request->minimum_km;
            $service->extracharges_km = $request->extracharges_km;
            $service->save();
            return redirect()->route('service.index')->with('flash_success', 'Service updated successfully.');
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
            $service = Service::findOrFail($id);
            $service->is_active = 0;
            $service->save();
            return redirect()->route('service.index')->with('flash_success', 'Service deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}