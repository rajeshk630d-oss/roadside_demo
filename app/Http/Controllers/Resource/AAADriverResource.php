<?php

namespace App\Http\Controllers\Resource;

use App\Driver;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AAADriverResource extends Controller
{
    public function index(Request $request)
    {
        $drivers = Driver::where('is_active' , 1)->get();
        return view('aaa.drivers.index', compact('drivers'));
    }
    public function create(Request $request){
        return view('aaa.drivers.create');
    }
    public function edit($id){
        $driver = Driver::findOrFail($id);
        return view('aaa.drivers.edit', compact('driver'));
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:100',
            'mobile_no' => 'required|max:20',
            'address' => 'required|max:200',
            'id_no' => 'required|max:10',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        ]);

        try{
            $path = "";
            if($request->hasFile('photo')){
                $path = Storage::put('uploads/drivers/profile', $request->photo);
            }
            $driver = new Driver();
            $driver->name = $request->name;
            $driver->mobile_no = $request->mobile_no;
            $driver->address = $request->address;
            $driver->id_no = $request->id_no;
            $driver->photo = $path;
            $driver->save();
            return redirect()->route('aaaDriver.index')->with('flash_success', 'Driver added successfully.');
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
            'name' => 'required|max:100',
            'mobile_no' => 'required|max:20',
            'address' => 'required|max:200',
            'id_no' => 'required|max:20'
        ]);
        try{
            $driver = Driver::findOrFail($id);
            if($request->hasFile('photo')){
                $path = Storage::put('uploads/salesman/profile', $request->photo);
                $driver->photo = $path;
            }
            $driver->name = $request->name;
            $driver->mobile_no = $request->mobile_no;
            $driver->address = $request->address;
            $driver->id_no = $request->id_no;
            $driver->save();
            return redirect()->route('aaaDriver.index')->with('flash_success', 'Driver updated successfully.');
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
            $driver = Driver::findOrFail($id);
            $driver->is_active = 0;
            $driver->save();
            return redirect()->route('aaaDriver.index')->with('flash_success', 'Driver deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!')->withInput();
        }
    }
    public function get_driver($id){
        $driver = Driver::find($id);
        return $driver;
    }
}