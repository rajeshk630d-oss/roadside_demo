<?php

namespace App\Http\Controllers\Resource;

use App\MembershipType;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MembershipTypesResource extends Controller
{
    public function index(Request $request)
    {
        $types = MembershipType::where('is_active' , 1)->get();
        return view('membership.membershipTypes.index', compact('types'));
    }
    public function create(Request $request){
        return view('membership.membershipTypes.create');
    }
    public function edit($id){
        $type = MembershipType::findOrFail($id);
        return view('membership.membershipTypes.edit', compact('type'));
    }
    public function store(Request $request){
        $this->validate($request, [
            'type' => 'required|unique:membership_type,type|max:100',
            'name' => 'required',
            'charges' => 'required',
        ]);
        try{
            $type = new MembershipType();
            $type->type = $request->type;
            $type->name = $request->name;
            $type->charges = $request->charges;
            $type->remark = $request->remark;
            $type->save();
            return redirect()->route('membershipTypes.index')->with('flash_success', 'Type added successfully.');
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
            'type' => 'required|max:100|unique:membership_type,type,'.$id,
            'name' => 'required',
            'charges' => 'required',
        ]);

        try{
            $type = MembershipType::findOrFail($id);
            $type->type = $request->type;
            $type->name = $request->name;
            $type->charges = $request->charges;
            $type->remark = $request->remark;
            $type->save();
            return redirect()->route('membershipTypes.index')->with('flash_success', 'Type updated successfully.');
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
            $type = MembershipType::findOrFail($id);
            $type->is_active = 0;
            $type->save();
            return redirect()->route('membershipTypes.index')->with('flash_success', 'Type deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}