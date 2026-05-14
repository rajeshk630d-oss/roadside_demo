<?php

namespace App\Http\Controllers\Resource;

use App\Salesman;
use App\VehicleBrandMaster;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AAASalesmanResource extends Controller
{
    public function index(Request $request)
    {
        $salesmen = Salesman::where('is_active' , 1)->get();
        return view('aaa.salesman.index', compact('salesmen'));
    }
    public function create(Request $request){
        return view('aaa.salesman.create');
    }
    public function edit($id){
        $salesman = Salesman::findOrFail($id);
        return view('aaa.salesman.edit', compact('salesman'));
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:salesmans,name|max:50',
            'mobile_no' => 'required|max:20',
            'email' => 'required|unique:salesmans,email|max:50',
            "photo" => "required"
        ]);

        try{
            $path = "";
            if($request->hasFile('photo')){
                $path = Storage::put('uploads/salesman/profile', $request->photo);
            }

            $salesman = new Salesman();
            $salesman->name = $request->name;
            $salesman->mobile_no = $request->mobile_no;
            $salesman->email = $request->email;
            $salesman->photo = $path;
            $salesman->save();
            return redirect()->route('aaaSalesman.index')->with('flash_success', 'Salesman added successfully.');
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
            'name' => 'required|max:50|unique:salesmans,name,'.$id,
            'mobile_no' => 'required|max:20',
            'email' => 'required|unique:salesmans,email,'.$id,
        ]);
        try{
            $salesman = Salesman::findOrFail($id);
            if($request->hasFile('photo')){
                $path = Storage::put('uploads/salesman/profile', $request->photo);
                $salesman->photo = $path;
            }

            $salesman->name = $request->name;
            $salesman->mobile_no = $request->mobile_no;
            $salesman->email = $request->email;
            $salesman->save();
            return redirect()->route('aaaSalesman.index')->with('flash_success', 'Salesman updated successfully.');
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
            $salesman = Salesman::findOrFail($id);
            $salesman->is_active = 0;
            $salesman->save();
            return redirect()->route('aaaSalesman.index')->with('flash_success', 'Salesman deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!')->withInput();
        }
    }
}