<?php

namespace App\Http\Controllers\Resource;

use App\Contractor;
use App\ContractorContract;
use App\Customer;
use App\CustomerContracts;
use App\Service;
use App\ServiceAreas;
use App\ServiceCountry;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CustomerContractsResource extends Controller
{
    public function index(Request $request)
    {
        $contracts = CustomerContracts::with('customer' , 'service')
            ->where('is_active' , 1)->get();
        return view('customers.contracts.index', compact('contracts'));
    }
    public function create(Request $request){
        $customers = Customer::where('is_active' , 1)->get();
        $services = Service::where('is_active' , 1)->get();
        return view('customers.contracts.create', compact('customers' , 'services'));
    }
    public function edit($id){
        $customers = Customer::where('is_active' , 1)->get();
        $services = Service::where('is_active' , 1)->get();
        $contract = CustomerContracts::findOrFail($id);
        return view('customers.contracts.edit', compact('customers' , 'services' , 'contract'));
    }
    public function store(Request $request){
        $this->validate($request, [
            'customers_id' => 'required|exists:customers,id',
            'service_master_id' => 'required|exists:service_master,id',
            'charges' => 'required',
            'free_services_contract' => 'required',
            'minimum_km' => 'required',
            'extracharges_km' => 'required',
            'payment_terms' => 'required',
            'contract_pdf' => 'required'
        ]);
        $path = "";
        if($request->hasFile('contract_pdf')){
            $path = Storage::put('uploads/customer/contracts', $request->contract_pdf);
        }
        try{
            $contract = new CustomerContracts();
            $contract->customers_id = $request->customers_id;
            $contract->service_master_id = $request->service_master_id;
            $contract->charges = $request->charges;
            $contract->free_services_contract = $request->free_services_contract;
            $contract->minimum_km = $request->minimum_km;
            $contract->extracharges_km = $request->extracharges_km;
            $contract->payment_terms = $request->payment_terms;
            $contract->contract_pdf = $path;
            $contract->save();
            return redirect()->route('customerContracts.index')->with('flash_success', 'Contract added successfully.');
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
            'customers_id' => 'required|exists:customers,id',
            'service_master_id' => 'required|exists:service_master,id',
            'charges' => 'required',
            'free_services_contract' => 'required',
            'minimum_km' => 'required',
            'extracharges_km' => 'required',
            'payment_terms' => 'required',
        ]);

        try{
            $contract = CustomerContracts::findOrFail($id);
            if($request->hasFile('contract_pdf')){
                $path = Storage::put('uploads/customer/contracts', $request->contract_pdf);
                $contract->contract_pdf = $path;
            }
            $contract->customers_id = $request->customers_id;
            $contract->service_master_id = $request->service_master_id;
            $contract->charges = $request->charges;
            $contract->free_services_contract = $request->free_services_contract;
            $contract->minimum_km = $request->minimum_km;
            $contract->extracharges_km = $request->extracharges_km;
            $contract->payment_terms = $request->payment_terms;
            $contract->save();
            return redirect()->route('customerContracts.index')->with('flash_success', 'Contract updated successfully.');
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
            $contract = CustomerContracts::findOrFail($id);
            $contract->is_active = 0;
            $contract->save();
            return redirect()->route('customerContracts.index')->with('flash_success', 'Contract deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}