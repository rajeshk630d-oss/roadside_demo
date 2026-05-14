<?php

namespace App\Http\Controllers\Resource;

use App\ServiceAreas;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceAreaResource extends Controller
{
    public function index(Request $request)
    {
        $areas = ServiceAreas::where('is_active' , 1)->get();
        return view('services.area.index', compact('areas'));
    }
    public function create(Request $request){
        return view('services.area.create');
    }
    public function edit($id){
        $area = ServiceAreas::findOrFail($id);
        return view('services.area.edit', compact('area'));
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:service_area_master,name|max:50',
        ]);
//        dd($request->all());
        try{
            $area = new ServiceAreas();
            $area->name = $request->name;
            $area->remark = $request->remark;
            $area->save();
            return redirect()->route('serviceArea.index')->with('flash_success', 'Area added successfully.');
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
            'name' => 'required|unique:service_area_master,name,'.$id,
        ]);

        try{
            $area = ServiceAreas::findOrFail($id);
            $area->name = $request->name;
            $area->remark = $request->remark;
            $area->save();
            return redirect()->route('serviceArea.index')->with('flash_success', 'Area updated successfully.');
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
            $type = ServiceAreas::findOrFail($id);
            $type->is_active = 0;
            $type->save();
            return redirect()->route('serviceArea.index')->with('flash_success', 'Area deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}