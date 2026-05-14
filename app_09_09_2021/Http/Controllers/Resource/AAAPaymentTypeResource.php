<?php

namespace App\Http\Controllers\Resource;

use App\PaymentType;
use App\VehicleBrandMaster;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AAAPaymentTypeResource extends Controller
{
    public function index(Request $request)
    {
        $payment_types = PaymentType::where('is_active' , 1)->get();
        return view('aaa.paymentTypes.index', compact('payment_types'));
    }
    public function create(Request $request){
        return view('aaa.paymentTypes.create');
    }
    public function edit($id){
        $payment_type  = PaymentType::findOrFail($id);
        return view('aaa.paymentTypes.edit', compact('payment_type'));
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:payment_types,name',
        ]);
        try{
            $payment_type  = new PaymentType();
            $payment_type ->name = $request->name;
            $payment_type ->remark = $request->remark;
            $payment_type ->save();
            return redirect()->route('aaaPaymentType.index')->with('flash_success', 'Payment type added successfully.');
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
            'name' => 'required|unique:payment_types,name,'.$id,
        ]);

        try{
            $payment_type  = PaymentType::findOrFail($id);
            $payment_type ->name = $request->name;
            $payment_type ->remark = $request->remark;
            $payment_type ->save();
            return redirect()->route('aaaPaymentType.index')->with('flash_success', 'Payment type updated successfully.');
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
            $payment_type  = PaymentType ::findOrFail($id);
            $payment_type ->is_active = 0;
            $payment_type ->save();
            return redirect()->route('aaaPaymentType.index')->with('flash_success', 'Payment type deleted successfully.');
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['status' => FALSE , 'data' => ""], 500);
            }
            return back()->with('flash_error','Something Went Wrong!')->withInput();
        }
    }
}