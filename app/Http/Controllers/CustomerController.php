<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function index()
    {
        $data = Customer::where('soft_delete', '!=', 1)->get();

        $customerarr_data = [];
        foreach ($data as $key => $datas) {
            $Customer_name = Customer::findOrFail($datas->id);

            $total_sale_amt = Sales::where('soft_delete', '!=', 1)->where('status', '!=', 1)->where('customer_id', '=', $datas->id)->sum('grand_total');
            $total_paid = Sales::where('soft_delete', '!=', 1)->where('status', '!=', 1)->where('customer_id', '=', $datas->id)->sum('paid_amount');
            $tot_bal = Sales::where('soft_delete', '!=', 1)
                                    ->where('status', '!=', 1)
                                    ->where('customer_id', '=', $datas->id)
                                    ->latest('id')
                                    ->first();

            $customerarr_data[] = array(
                'unique_key' => $datas->unique_key,
                'name' => $Customer_name->name,
                'contact_number' => $datas->contact_number,
                'shop_name' => $datas->shop_name,
                'status' => $datas->status,
                'id' => $datas->id,
                'total_sale_amt' => $total_sale_amt,
                'total_paid' => $total_paid,
                'email_address' => $datas->email_address,
                'shop_address' => $datas->shop_address,
                'shop_contact_number' => $datas->shop_contact_number,
                'balance_amount' => $tot_bal->balance_amount,
            );     
        }        

        return view('page.backend.customer.index', compact('customerarr_data'));
    }

    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new Customer();

        $data->unique_key = $randomkey;
        $data->name = $request->get('name');
        $data->contact_number = $request->get('contact_number');
        $data->email_address = $request->get('email');
        $data->shop_name = $request->get('shop_name');
        $data->shop_address = $request->get('shop_address');
        $data->shop_contact_number = $request->get('shop_contact_number');
        
        $data->save();


        return redirect()->route('customer.index')->with('add', 'Customer Data added successfully!');
    }


    public function edit(Request $request, $unique_key)
    {
        $CustomerData = Customer::where('unique_key', '=', $unique_key)->first();

        $CustomerData->name = $request->get('name');
        $CustomerData->contact_number = $request->get('contact_number');
        $CustomerData->email_address = $request->get('email');
        $CustomerData->shop_name = $request->get('shop_name');
        $CustomerData->shop_address = $request->get('shop_address');
        $CustomerData->shop_contact_number = $request->get('shop_contact_number');
        $CustomerData->status = $request->get('status');

        $CustomerData->update();

        return redirect()->route('customer.index')->with('update', 'Customer Data updated successfully!');
    }


    public function delete($unique_key)
    {
        $data = Customer::where('unique_key', '=', $unique_key)->first();

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('customer.index')->with('soft_destroy', 'Successfully deleted the customer !');
    }

}
