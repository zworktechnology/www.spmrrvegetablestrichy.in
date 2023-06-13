<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Branch;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SupplierController extends Controller
{
    public function index()
    {



        $data = Supplier::where('soft_delete', '!=', 1)->get();
        $supplierarr_data = [];
        foreach ($data as $key => $datas) {
            $supplier_name = Supplier::findOrFail($datas->id);

            $total_purchase_amt = Purchase::where('soft_delete', '!=', 1)->where('status', '!=', 1)->where('supplier_id', '=', $datas->id)->sum('grand_total');
            $total_paid = Purchase::where('soft_delete', '!=', 1)->where('status', '!=', 1)->where('supplier_id', '=', $datas->id)->sum('paid_amount');
            $tot_bal = Purchase::where('soft_delete', '!=', 1)->where('status', '!=', 1)->where('supplier_id', '=', $datas->id)->latest('id')->first();

            if($total_purchase_amt != ""){
                $tot_purchaseAmount = $total_purchase_amt;
            }else {
                $tot_purchaseAmount = '';
            }



            if($total_paid != ""){
                $total_paid_Amount = $total_paid;
            }else {
                $total_paid_Amount = '';
            }


            if($tot_bal != ""){
                $total_balance = $tot_bal->balance_amount;
            }else {
                $total_balance = '';
            }


            $supplierarr_data[] = array(
                'unique_key' => $datas->unique_key,
                'name' => $supplier_name->name,
                'contact_number' => $datas->contact_number,
                'shop_name' => $datas->shop_name,
                'status' => $datas->status,
                'id' => $datas->id,
                'total_purchase_amt' => $tot_purchaseAmount,
                'total_paid' => $total_paid_Amount,
                'email_address' => $datas->email_address,
                'shop_address' => $datas->shop_address,
                'shop_contact_number' => $datas->shop_contact_number,
                'balance_amount' => $total_balance,
            );
        }
        $alldata_branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();




        return view('page.backend.supplier.index', compact('supplierarr_data', 'alldata_branch'));
    }

    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new Supplier();

        $data->unique_key = $randomkey;
        $data->name = $request->get('name');
        $data->contact_number = $request->get('contact_number');
        $data->email_address = $request->get('email');
        $data->shop_name = $request->get('shop_name');
        $data->shop_address = $request->get('shop_address');
        $data->shop_contact_number = $request->get('shop_contact_number');

        $data->save();


        return redirect()->route('supplier.index')->with('add', 'Supplier Data added successfully!');
    }


    public function edit(Request $request, $unique_key)
    {
        $SupplierData = Supplier::where('unique_key', '=', $unique_key)->first();

        $SupplierData->name = $request->get('name');
        $SupplierData->contact_number = $request->get('contact_number');
        $SupplierData->email_address = $request->get('email');
        $SupplierData->shop_name = $request->get('shop_name');
        $SupplierData->shop_address = $request->get('shop_address');
        $SupplierData->shop_contact_number = $request->get('shop_contact_number');
        $SupplierData->status = $request->get('status');

        $SupplierData->update();

        return redirect()->route('supplier.index')->with('update', 'Supplier Data updated successfully!');
    }


    public function delete($unique_key)
    {
        $data = Supplier::where('unique_key', '=', $unique_key)->first();

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('supplier.index')->with('soft_destroy', 'Successfully deleted the Supplier !');
    }


    public function getsupplierbalance()
    {

        $supplierid = request()->get('supplierid');

        $branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $supplier_output = [];
        $total_bal_amount = 0;
        foreach ($branch as $key => $get_all_branch) {

            $get_all_balance = Purchase::where('soft_delete', '!=', 1)
                                        ->where('status', '!=', 1)
                                        ->where('supplier_id', '=', $supplierid)
                                        ->where('branch_id', '=', $get_all_branch->id)
                                        ->latest('id')
                                        ->first();

           if($get_all_balance != ""){



                $supplier_output[] = array(
                    'balance_amount' => $get_all_balance->balance_amount,
                    'branch' => $get_all_branch->name,
                );
           }

        }

        if (isset($supplier_output) & !empty($supplier_output)) {
            echo json_encode($supplier_output);
        }else{
            echo json_encode(
                array('status' => 'false')
            );
        }


    }

}
