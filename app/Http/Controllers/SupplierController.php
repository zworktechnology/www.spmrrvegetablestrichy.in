<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Branch;
use App\Models\Purchase;
use App\Models\PurchasePayment;
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
            // Grand total
            $total_purchase_amt = Purchase::where('soft_delete', '!=', 1)->where('supplier_id', '=', $datas->id)->sum('gross_amount');
            if($total_purchase_amt != ""){
                $tot_purchaseAmount = $total_purchase_amt;
            }else {
                $tot_purchaseAmount = '0';
            }

            // Total Paid
            $total_paid = Purchase::where('soft_delete', '!=', 1)->where('supplier_id', '=', $datas->id)->sum('paid_amount');
            if($total_paid != ""){
                $total_paid_Amount = $total_paid;
            }else {
                $total_paid_Amount = '0';
            }
            $payment_total_paid = PurchasePayment::where('soft_delete', '!=', 1)->where('supplier_id', '=', $datas->id)->sum('amount');
            if($payment_total_paid != ""){
                $total_payment_paid = $payment_total_paid;
            }else {
                $total_payment_paid = '0';
            }

            $total_amount_paid = $total_paid_Amount + $total_payment_paid;
            


            // Total Balance
            $total_balance = $tot_purchaseAmount - $total_amount_paid;
            


            $supplierarr_data[] = array(
                'unique_key' => $datas->unique_key,
                'name' => $supplier_name->name,
                'contact_number' => $datas->contact_number,
                'shop_name' => $datas->shop_name,
                'status' => $datas->status,
                'id' => $datas->id,
                'total_purchase_amt' => $tot_purchaseAmount,
                'total_paid' => $total_amount_paid,
                'email_address' => $datas->email_address,
                'shop_address' => $datas->shop_address,
                'shop_contact_number' => $datas->shop_contact_number,
                'balance_amount' => $total_balance,
            );
        }
        $alldata_branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $tot_balance_Arr = [];

        foreach ($alldata_branch as $key => $alldata_branchs) {
            $Supplier_array = Supplier::where('soft_delete', '!=', 1)->get();
            foreach ($Supplier_array as $key => $Supplier_arra) {


        $last_idrow = Purchase::where('soft_delete', '!=', 1)
                                ->where('supplier_id', '=', $Supplier_arra->id)
                                ->where('branch_id', '=', $alldata_branchs->id)
                                ->latest('id')
                                ->first();

        if($last_idrow != ""){
            if($last_idrow->payment_pending != NULL){
                $tot_balace = $last_idrow->payment_pending;

            }else if($last_idrow->payment_pending == NULL){

                if($last_idrow->balance_amount != NULL){
                    
                    $tot_balace = $last_idrow->balance_amount;
                }else if($last_idrow->balance_amount == NULL){

                    $secondlastrow = Purchase::orderBy('created_at', 'desc')->where('supplier_id', '=', $Supplier_arra->id)->where('branch_id', '=', $alldata_branchs->id)->skip(1)->take(1)->first();
                    if($secondlastrow != ""){
                        if($secondlastrow->payment_pending != NULL){
                            $tot_balace = $secondlastrow->payment_pending;
                        }else if($secondlastrow->payment_pending == NULL){
                            $tot_balace = $secondlastrow->balance_amount;
                        }
                    }
                    
                    
                }
                
            }
        }else {
            $tot_balace = 0;
        }



       

                $tot_balance_Arr[] = array(
                    'Supplier_name' => $Supplier_arra->name,
                    'branch_name' => $alldata_branchs->shop_name,
                    'Supplier_id' => $Supplier_arra->id,
                    'balance_amount' => $tot_balace
                );

            }
        }




        return view('page.backend.supplier.index', compact('supplierarr_data', 'tot_balance_Arr'));
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
                    'branch' => $get_all_branch->shop_name,
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
