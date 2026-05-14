<?php

namespace App\Http\Controllers\Resource;

use App\Companies;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AAACompanyResource extends Controller
{
    public function index(Request $request)
    {
        $companies = Companies::where('is_active' , 1)->get();
        foreach($companies as $company){
            $image = asset('storage/app/'.$company->logo);
            if(@getimagesize($image)){
                $company->image = $image;
            }else{
                $company->image = "";
            }
        }
        return view('aaa.company.index', compact('companies'));
    }
    public function create(Request $request){
        return view('aaa.company.create');
    }
    public function edit($id){
        $company = Companies::findOrFail($id);
        return view('aaa.company.edit', compact('company'));
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:companies,name|max:100',
            'email' => 'required|unique:companies,email|max:50',
            'address_line1' => 'required|max:100',
            'address_line2' => 'required|max:100',
            'address_line3' => 'required|max:100',
            'address_line4' => 'required|max:100',
            'telephone' => 'required|max:11',
            'vat_no' => 'required|max:15',
            'cr_no' => 'required|max:10',
            'logo' => 'required|image|mimes:jpeg,jpg,png|max:1024'
        ]);
        try{
            $path="";
            $company = new Companies();
            if($request->hasFile('logo')){
                $path = Storage::put('uploads/companies/profile', $request->logo);
            }

            $company->name = $request->name;
            $company->email = $request->email;
            $company->address_line1 = $request->address_line1;
            $company->address_line2 = $request->address_line2;
            $company->address_line3 = $request->address_line3;
            $company->address_line4 = $request->address_line4;
            $company->telephone = $request->telephone;
            $company->vat_no = $request->vat_no;
            $company->cr_no = $request->cr_no;
            $company->logo = $path;
            $company->save();
            return redirect()->route('aaaCompany.index')->with('flash_success', 'Company added successfully.');
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
            'name' => 'required|unique:companies,name,'.$id,
            'email' => 'required|unique:companies,email,'.$id,
            'address_line1' => 'required|max:100',
            'address_line2' => 'required|max:100',
            'address_line3' => 'required|max:100',
            'address_line4' => 'required|max:100',
            'telephone' => 'required|max:11',
            'vat_no' => 'required|max:15',
            'cr_no' => 'required|max:10',
        ]);
        if($request->hasFile('logo')){
            $this->validate($request, [
                'logo' => 'required|image|mimes:jpeg,jpg,png|max:1024'
            ]);
        }
        try{
            $company = Companies::findOrFail($id);
            if($request->hasFile('logo')){
                $path = Storage::put('uploads/users/profile', $request->logo);
                $company->logo = $path;
            }
            $company->name = $request->name;
            $company->email = $request->email;
            $company->address_line1 = $request->address_line1;
            $company->address_line2 = $request->address_line2;
            $company->address_line3 = $request->address_line3;
            $company->address_line4 = $request->address_line4;
            $company->telephone = $request->telephone;
            $company->vat_no = $request->vat_no;
            $company->cr_no = $request->cr_no;
            $company->save();
            return redirect()->route('aaaCompany.index')->with('flash_success', 'Company updated successfully.');
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
            $company = Companies::findOrFail($id);
            $company->is_active = 0;
            $company->save();
            return redirect()->route('aaaCompany.index')->with('flash_success', 'Company deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!')->withInput();
        }
    }
}