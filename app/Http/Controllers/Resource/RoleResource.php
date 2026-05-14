<?php

namespace App\Http\Controllers\Resource;

use App\Contractor;
use App\Features;
use App\Role;
use App\RoleFeature;
use App\ServiceAreas;
use App\ServiceCountry;
use App\User;
use Exception;
//use Illuminate\Http\File;
//use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RoleResource extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::where('is_active' , 1)->get();
        foreach($roles as $key => $role){
            if($role->id == 1){
                unset($roles[$key]);
            }else{
                if($role->is_superadmin == 1){
                    $role->image = 'YES';
                }else{
                    $role->image = 'NO';
                }
            }
        }
        return view('roles.index', compact('roles'));
    }
    public function create(Request $request){
        return view('roles.create');
    }
    public function edit($id){
        $role = Role::findOrFail($id);
        $features = Features::orderBy('FeatureId' ,'ASC')->orderBy('MenuOrder' ,'ASC')->get();
        $role_features = RoleFeature::select('FeatureId')->where('RoleId' , $id)->get()->pluck('FeatureId')->toArray();
        return view('roles.edit', compact('role' , 'features' , 'role_features'));
    }
    public function store(Request $request){

        $this->validate($request, [
            'name' => 'required|max:50|min:4',
        ]);
        try{
            $role = new Role();
            $role->name = $request->name;
            if($request->has('is_super_admin') && $request->is_super_admin == 'ON'){
                $role->is_superadmin = 1;
            }else{
                $role->is_superadmin = 0;
            }
            $role->save();
            return redirect()->route('roles.index')->with('flash_success', 'Privilege added successfully.');
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
            'name' => 'required|max:50|min:4',
            'FeatureId' => 'required',
        ]);
        try{
            DB::beginTransaction();
            $role = Role::findOrFail($id);
            $role->name = $request->name;
            if($request->has('is_super_admin') && $request->is_super_admin == 'ON'){
                $role->is_superadmin = 1;
            }else {
                $role->is_superadmin = 0;
            }
            $role->save();
            if($role->is_superadmin == 0){
                $features = Features::orderBy('FeatureId' ,'ASC')->orderBy('MenuOrder' ,'ASC')->get();
                RoleFeature::where('RoleId',$role->id)->delete();
                foreach($features as $feature){

                    if(in_array($role->id."_".$feature->FeatureId , $request->FeatureId)){
                        if(RoleFeature::where('RoleId' , $role->id)->where('FeatureId' , $feature->Origin)->count() == 0){
                            RoleFeature::insert(['RoleId' => $role->id , 'FeatureId' => $feature->Origin]);
                        }
                        RoleFeature::insert(['RoleId' => $role->id , 'FeatureId' => $feature->FeatureId]);
                    }
                }
            }
            DB::commit();
            return redirect()->route('roles.index')->with('flash_success', 'Role Features updated successfully.');
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
            $role = Role::findOrFail($id);
            $role->is_active = 0;
            $role->save();
            User::where('role_id' , $id)->update(['is_active' => 0]);
            return redirect()->route('roles.index')->with('flash_success', 'Role deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}