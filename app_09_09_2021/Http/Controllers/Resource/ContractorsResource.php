<?php

namespace App\Http\Controllers\Resource;

use App\Contractor;
use App\ServiceAreas;
use App\ServiceCountry;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContractorsResource extends Controller
{
    public function index(Request $request)
    {
        $contractors = Contractor::with('service_country','service_area')
            ->where('is_active' , 1)->get();
        return view('sub_contractor.contractors.index', compact('contractors'));
    }
    public function create(Request $request){
        $countries = ServiceCountry::where('is_active' , 1)->get();
        $areas = ServiceAreas::where('is_active' , 1)->get();
        return view('sub_contractor.contractors.create', compact('countries' , 'areas'));
    }
    public function edit($id){
        $countries = ServiceCountry::where('is_active' , 1)->get();
        $areas = ServiceAreas::where('is_active' , 1)->get();
        $contractor = Contractor::findOrFail($id);
        return view('sub_contractor.contractors.edit', compact('contractor' , 'countries' , 'areas'));
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:contractors,name',
            'email' => 'required|unique:contractors,email',
            'address_line1' => 'required',
            'address_line2' => 'required',
            'address_line3' => 'required',
            'telephone' => 'required',
            'fax' => 'required',
            'cr_no' => 'required',
            'service_country_master_id' => 'required',
            'area_id' => 'required',
        ]);
        try{
            $contractor = new Contractor();
            $contractor->name = $request->name;
            $contractor->email = $request->email;
            $contractor->address_line1 = $request->address_line1;
            $contractor->address_line2 = $request->address_line2;
            $contractor->address_line3 = $request->address_line3;
            $contractor->telephone = $request->telephone;
            $contractor->fax = $request->fax;
            $contractor->cr_no = $request->cr_no;
            $contractor->service_country_master_id = $request->service_country_master_id;
            $contractor->area_id = $request->area_id;
            $contractor->save();
            return redirect()->route('contractors.index')->with('flash_success', 'Contractor added successfully.');
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
            'name' => 'required|unique:contractors,name,'.$id,
            'email' => 'required|unique:contractors,email,'.$id,
            'address_line1' => 'required',
            'address_line2' => 'required',
            'address_line3' => 'required',
            'telephone' => 'required',
            'fax' => 'required',
            'cr_no' => 'required',
            'service_country_master_id' => 'required',
            'area_id' => 'required',
        ]);
        try{
            $contractor = Contractor::findOrFail($id);
            $contractor->name = $request->name;
            $contractor->email = $request->email;
            $contractor->address_line1 = $request->address_line1;
            $contractor->address_line2 = $request->address_line2;
            $contractor->address_line3 = $request->address_line3;
            $contractor->telephone = $request->telephone;
            $contractor->fax = $request->fax;
            $contractor->cr_no = $request->cr_no;
            $contractor->service_country_master_id = $request->service_country_master_id;
            $contractor->area_id = $request->area_id;
            $contractor->save();
            return redirect()->route('contractors.index')->with('flash_success', 'Contractor updated successfully.');
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
            $contractor = Contractor::findOrFail($id);
            $contractor->is_active = 0;
            $contractor->save();
            return redirect()->route('contractors.index')->with('flash_success', 'Contractor deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}