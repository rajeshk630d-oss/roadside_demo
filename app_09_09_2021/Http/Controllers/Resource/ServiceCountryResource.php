<?php

namespace App\Http\Controllers\Resource;

use App\ServiceCountry;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceCountryResource extends Controller
{
    public function index(Request $request)
    {
        $countries = ServiceCountry::where('is_active' , 1)->get();
        return view('services.country.index', compact('countries'));
    }
    public function create(Request $request){
        return view('services.country.create');
    }
    public function edit($id){
        $country = ServiceCountry::findOrFail($id);
        return view('services.country.edit', compact('country'));
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:service_country_master,name',
        ]);
        //dd($request->all());
        try{
            $country = new ServiceCountry();
            $country->name = $request->name;
            $country->remark = $request->remark;
            $country->save();
            return redirect()->route('serviceCountry.index')->with('flash_success', 'Country added successfully.');
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
            'name' => 'required|unique:service_country_master,name,'.$id,
        ]);

        try{
            $type = ServiceCountry::findOrFail($id);
            $type->name = $request->name;
            $type->remark = $request->remark;
            $type->save();
            return redirect()->route('serviceCountry.index')->with('flash_success', 'Country updated successfully.');
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
            $type = ServiceCountry::findOrFail($id);
            $type->is_active = 0;
            $type->save();
            return redirect()->route('serviceCountry.index')->with('flash_success', 'Country deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}