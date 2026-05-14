<?php

namespace App\Http\Controllers\Resource;

use App\Contractor;
use App\ContractorContract;
use App\Service;
use App\ServiceAreas;
use App\ServiceCountry;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ContractorContractsResource extends Controller
{
    public function index(Request $request)
    {
        $contracts = ContractorContract::with('contractor' , 'service')
            ->where('is_active' , 1)->get();
        return view('sub_contractor.contracts.index', compact('contracts'));
    }
    public function create(Request $request){
        $contractors = Contractor::where('is_active' , 1)->get();
        $services = Service::where('is_active' , 1)->get();
        return view('sub_contractor.contracts.create', compact('contractors' , 'services'));
    }
    public function edit($id){
        $contractors = Contractor::where('is_active' , 1)->get();
        $services = Service::where('is_active' , 1)->get();
        $contract = ContractorContract::findOrFail($id);
        return view('sub_contractor.contracts.edit', compact('contractors' , 'services' , 'contract'));
    }
    public function store(Request $request){
        $this->validate($request, [
            'contractor_master_id' => 'required|exists:contractors,id',
            'service_master_id' => 'required|exists:service_master,id',
            'charges' => 'required',
            'minimum_km' => 'required',
            'extracharges_km' => 'required',
            'payment_terms' => 'required',
            'contract_pdf' => 'required'
        ]);
        $path = "";
        if($request->hasFile('contract_pdf')){
            $path = Storage::put('uploads/contractor/contracts', $request->contract_pdf);
        }
        try{
            $contract = new ContractorContract();
            $contract->contractor_master_id = $request->contractor_master_id;
            $contract->service_master_id = $request->service_master_id;
            $contract->charges = $request->charges;
            $contract->minimum_km = $request->minimum_km;
            $contract->extracharges_km = $request->extracharges_km;
            $contract->payment_terms = $request->payment_terms;
            $contract->contract_pdf = $path;
            $contract->save();
            return redirect()->route('contractorContracts.index')->with('flash_success', 'Contract added successfully.');
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
            'contractor_master_id' => 'required|exists:contractors,id',
            'service_master_id' => 'required|exists:service_master,id',
            'charges' => 'required',
            'minimum_km' => 'required',
            'extracharges_km' => 'required',
            'payment_terms' => 'required'
        ]);

        try{
            $contract = ContractorContract::findOrFail($id);
            if($request->hasFile('contract_pdf')){
                $path = Storage::put('uploads/contractor/contracts', $request->contract_pdf);
                $contract->contract_pdf = $path;
            }
            $contract->contractor_master_id = $request->contractor_master_id;
            $contract->service_master_id = $request->service_master_id;
            $contract->charges = $request->charges;
            $contract->minimum_km = $request->minimum_km;
            $contract->extracharges_km = $request->extracharges_km;
            $contract->payment_terms = $request->payment_terms;
            $contract->save();
            return redirect()->route('contractorContracts.index')->with('flash_success', 'Contract updated successfully.');
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
            $contract = ContractorContract::findOrFail($id);
            $contract->is_active = 0;
            $contract->save();
            return redirect()->route('contractorContracts.index')->with('flash_success', 'Contract deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}