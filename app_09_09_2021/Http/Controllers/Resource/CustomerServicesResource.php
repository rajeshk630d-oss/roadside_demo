<?php

namespace App\Http\Controllers\Resource;

use App\Customer;
use App\CustomerServices;
use App\MembershipType;
use App\Service;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerServicesResource extends Controller
{
    public function index(Request $request)
    {
        $services = CustomerServices::with("customer" , 'service')->where('is_active' , 1)->get();
        return view('customers.customerServices.index', compact('services'));
    }
    public function create(Request $request){
        $customers = Customer::where('is_active' , 1)->get();
        $services = Service::where('is_active' , 1)->get();
        return view('customers.customerServices.create', compact('customers','services'));
    }
    public function edit($id){
        $service = CustomerServices::findOrFail($id);
        $customers = Customer::where('is_active' , 1)->get();
        $services = Service::where('is_active' , 1)->get();
        return view('customers.customerServices.edit', compact('service','customers','services'));
    }
    public function store(Request $request){

        $this->validate($request, [
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:service_master,id',
            'rate' => 'required',
            'max_services' => 'required|numeric',
        ]);
        try{
            $count = CustomerServices::where('customer_id',$request->customer_id)
                ->where('service_id',$request->service_id)
                ->count();
            if($count > 0){
                $service = Service::find($request->service_id);
                $customer = Customer::find($request->customer_id);
                return back()->with('flash_error',$service->name.' already allocated to '.$customer->name)->withInput();
            }
            $service = new CustomerServices();
            $service->customer_id = $request->customer_id;
            $service->service_id = $request->service_id;
            $service->rate = $request->rate;
            $service->max_services = $request->max_services;
            $service->save();
            return redirect()->route('customerServices.index')->with('flash_success', 'Service added successfully.');
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
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:service_master,id',
            'rate' => 'required',
            'max_services' => 'required|numeric',
        ]);
        try{
            $count = CustomerServices::where('customer_id',$request->customer_id)
                ->where('service_id',$request->service_id)
                ->where('id','!=',$id)
                ->count();
            if($count > 0){
                $service = Service::find($request->service_id);
                $customer = Customer::find($request->customer_id);
                return back()->with('flash_error',$service->name.' already allocated to '.$customer->name)->withInput();
            }
            $service = CustomerServices::findOrFail($id);
            $service->customer_id = $request->customer_id;
            $service->service_id = $request->service_id;
            $service->rate = $request->rate;
            $service->max_services = $request->max_services;
            $service->save();
            return redirect()->route('customerServices.index')->with('flash_success', 'Service updated successfully.');
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
            $service = CustomerServices::findOrFail($id);
            $service->is_active = 0;
            $service->save();
            return redirect()->route('customerServices.index')->with('flash_success', 'Service deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}