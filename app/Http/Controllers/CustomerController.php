<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $context = [
            'customers' => Customer::all(),
        ];

        return view('customer', $context);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $code = 'CSTMR';
        $customer = Customer::orderBy('created_at', 'desc')->first();

        if(!is_null($customer)) {
            $customer_code = $code.strval($customer->customer_id + 1);
        } else {
            $customer_code = $code.'1';
        }

        Customer::create([
            'customer_code' => $customer_code,
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('customer.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Customer::where('customer_code', $id)->update([
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('customer.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $customer = Customer::where('customer_code', $id)->delete();

        return redirect()->route('customer.index');
    }
}
