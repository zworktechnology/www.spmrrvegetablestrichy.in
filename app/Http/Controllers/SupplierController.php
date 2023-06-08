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
        return view('page.backend.supplier.index', compact('data'));
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


    public function checkbalance($id)
    {
       
        $supplier = Supplier::findOrFail($id);
        $suppliername = $supplier->name;

        $branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $supplier_output = [];
        $total_amount = 0;
        foreach ($branch as $key => $get_all_branch) {

            $get_all_balance = Purchase::where('soft_delete', '!=', 1)
                                        ->where('status', '!=', 1)
                                        ->where('supplier_id', '=', $id)
                                        ->where('branch_id', '=', $get_all_branch->id)
                                        ->latest('id')
                                        ->first();
            
           if($get_all_balance != ""){

                $total_amount += $get_all_balance->balance_amount;
                
                $supplier_output[] = array(
                    'total' => $get_all_balance->balance_amount,
                    'total_amount' => $total_amount,
                    'branch' => $get_all_branch->name,
                );
           }else {
                $supplier_output[] = array(
                    'total' => '',
                    'total_amount' => '',
                    'branch' => '',
                );
           }

                
            
            

            
            
        }
        
        return view('page.backend.supplier.checkbalance', compact('supplier_output', 'suppliername', 'total_amount'));
    }

}
