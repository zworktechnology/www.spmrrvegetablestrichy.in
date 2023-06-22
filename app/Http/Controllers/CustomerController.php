<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Sales;
use App\Models\Branch;
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
            $tot_bal = Sales::where('soft_delete', '!=', 1)->where('status', '!=', 1)->where('customer_id', '=', $datas->id)->latest('id')->first();


            if($total_sale_amt != ""){
                $tot_saleAmount = $total_sale_amt;
            }else {
                $tot_saleAmount = '0';
            }



            if($total_paid != ""){
                $total_paid_Amount = $total_paid;
            }else {
                $total_paid_Amount = '0';
            }


            if($tot_bal != ""){
                $total_balance = $tot_bal->balance_amount;
            }else {
                $total_balance = '0';
            }


            $customerarr_data[] = array(
                'unique_key' => $datas->unique_key,
                'name' => $Customer_name->name,
                'contact_number' => $datas->contact_number,
                'shop_name' => $datas->shop_name,
                'status' => $datas->status,
                'id' => $datas->id,
                'total_sale_amt' => $tot_saleAmount,
                'total_paid' => $total_paid_Amount,
                'email_address' => $datas->email_address,
                'shop_address' => $datas->shop_address,
                'shop_contact_number' => $datas->shop_contact_number,
                'balance_amount' => $total_balance,
            );
        }


        $alldata_branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $tot_balance_Arr = [];

        foreach ($alldata_branch as $key => $alldata_branchs) {
            $Customer_array = Customer::where('soft_delete', '!=', 1)->get();
            foreach ($Customer_array as $key => $Customer_arra) {


                $get_all_balance = Sales::where('soft_delete', '!=', 1)
                                        ->where('status', '!=', 1)
                                        ->where('customer_id', '=', $Customer_arra->id)
                                        ->where('branch_id', '=', $alldata_branchs->id)
                                        ->latest('id')
                                        ->first();
                if($get_all_balance != ""){
                    $tot_balace = $get_all_balance->balance_amount;
                }else {
                    $tot_balace = 0;
                }

                $tot_balance_Arr[] = array(
                    'customer_name' => $Customer_arra->name,
                    'branch_name' => $alldata_branchs->name,
                    'customer_id' => $Customer_arra->id,
                    'balance_amount' => $tot_balace
                );

            }
        }

        return view('page.backend.customer.index', compact('customerarr_data', 'tot_balance_Arr'));
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
