<?php

namespace App\Http\Controllers\Resource;

use App\Contractor;
use App\Role;
use App\ServiceAreas;
use App\ServiceCountry;
use App\User;
use Exception;
//use Illuminate\Http\File;
//use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserResource extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('role')->where('is_active' , 1)->get();
        foreach($users as $key => $user){
            if($user->id == 1){
                unset($users[$key]);
            }
            $image = asset('storage/app/'.$user->photo);
            if(@getimagesize($image)){
                $user->image = $image;
            }else{
                $user->image = "";
            }
        }
//        dd($users);
        return view('users.index', compact('users'));
    }
    public function create(Request $request){
        $roles = Role::get();
        return view('users.create', compact('roles' ));
    }
    public function edit($id){
        $roles = Role::get();
        $user = User::findOrFail($id);
        return view('users.edit', compact('user' , 'roles'));
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|max:50',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|min:6',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        try{
            $count = User::where('email' , $request->email)->where('is_active' , 1)->count();
            if($count != 0){
                return back()->with('flash_error','E-mail already taken.')->withInput();
            }
            $path = "";
            if($request->hasFile('photo')){
                $path = Storage::put('uploads/users/profile', $request->photo);
            }
            $password = Hash::make($request->password);
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $password;
            $user->photo = $path;
            $user->role_id = $request->role_id;
            $user->save();
            return redirect()->route('users.index')->with('flash_success', 'User added successfully.');
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
            'name' => 'required',
            'email' => 'required',
            'role_id' => 'required|exists:roles,id',
        ]);

        if($request->has('password') && strlen(trim($request->password)) != 0){
            $this->validate($request, [
                'password' => 'required|min:6',
            ]);
        }

        if($request->hasFile('photo')){
            $this->validate($request, [
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
        }

        try{
            $count = User::where('email' , $request->email)->where('is_active' , 1)->where('id' ,'!=', $id)->count();
            if($count != 0){
                return back()->with('flash_error','E-mail already taken.')->withInput();
            }

            $user = User::findOrFail($id);
            if($request->hasFile('photo')){
                $path = Storage::put('uploads/users/profile', $request->photo);
                $user->photo = $path;
            }
            if($request->has('password') && strlen(trim($request->password)) != 0){
                $password = Hash::make($request->password);
                $user->password = $password;
            }
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role_id = $request->role_id;
            $user->save();
            return redirect()->route('users.index')->with('flash_success', 'User updated successfully.');
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
            $user = User::findOrFail($id);
            $user->is_active = 0;
            $user->save();
            return redirect()->route('users.index')->with('flash_success', 'User deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}