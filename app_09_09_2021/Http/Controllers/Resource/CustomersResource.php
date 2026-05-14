<?php

namespace App\Http\Controllers\Resource;

use App\Contractor;
use App\Customer;
use App\Salesman;
use App\ServiceAreas;
use App\ServiceCountry;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomersResource extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::with('salesperson')->where('is_active' , 1)->get();
        return view('customers.customers.index', compact('customers'));
    }
    public function create(Request $request){
        $sales_persons = Salesman::where('is_active' , 1)->get();
        return view('customers.customers.create', compact('sales_persons'));
    }
    public function edit($id){
        $customer = Customer::findOrFail($id);
        $sales_persons = Salesman::where('is_active' , 1)->get();
        return view('customers.customers.edit', compact('customer' ,'sales_persons'));
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:50',
            'type' => 'required|max:50',
            'sales_person_id' => 'required|exists:salesmans,id',
            'email' => 'required|unique:customers,email|max:50',
            'address_line1' => 'required|max:200',
            'address_line2' => 'required|max:200',
            'address_line3' => 'required|max:200',
            'telephone' => 'required|max:20',
            'fax' => 'required|max:20',
            'contact_person' => 'required|max:50',
            'contact_person_mobile' => 'required|max:20',
            'contact_person_email' => 'required|max:50',
        ]);
        try{
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->type = $request->type;
            $customer->address_line1 = $request->address_line1;
            $customer->address_line2 = $request->address_line2;
            $customer->address_line3 = $request->address_line3;
            $customer->email = $request->email;
            $customer->telephone = $request->telephone;
            $customer->fax = $request->fax;
            $customer->contact_person = $request->contact_person;
            $customer->sales_person_id = $request->sales_person_id;
            $customer->contact_person_mobile = $request->contact_person_mobile;
            $customer->contact_person_email = $request->contact_person_email;
            $customer->save();
            return redirect()->route('customers.index')->with('flash_success', 'Customer added successfully.');
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
            'name' => 'required|max:50',
            'type' => 'required|max:50',
            'sales_person_id' => 'required|exists:salesmans,id',
            'email' => 'required|max:50|unique:customers,email,'.$id,
            'address_line1' => 'required|max:200',
            'address_line2' => 'required|max:200',
            'address_line3' => 'required|max:200',
            'telephone' => 'required|max:20',
            'fax' => 'required|max:20',
            'contact_person' => 'required|max:50',
            'contact_person_mobile' => 'required|max:20',
            'contact_person_email' => 'required|max:50',
        ]);
        try{
            $customer = Customer::findOrFail($id);
            $customer->name = $request->name;
            $customer->type = $request->type;
            $customer->address_line1 = $request->address_line1;
            $customer->address_line2 = $request->address_line2;
            $customer->address_line3 = $request->address_line3;
            $customer->email = $request->email;
            $customer->sales_person_id = $request->sales_person_id;
            $customer->telephone = $request->telephone;
            $customer->fax = $request->fax;
            $customer->contact_person = $request->contact_person;
            $customer->contact_person_mobile = $request->contact_person_mobile;
            $customer->contact_person_email = $request->contact_person_email;
            $customer->save();
            return redirect()->route('customers.index')->with('flash_success', 'Customer updated successfully.');
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
            $customer = Customer::findOrFail($id);
            $customer->is_active = 0;
            $customer->save();
            return redirect()->route('customers.index')->with('flash_success', 'Customer deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}