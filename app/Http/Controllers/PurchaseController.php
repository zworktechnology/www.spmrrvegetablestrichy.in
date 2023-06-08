<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Branch;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Bank;
use App\Models\Productlist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    public function index()
    {
        $data = Purchase::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $purchase_data = [];
        foreach ($data as $key => $datas) {
            $branch_name = Branch::findOrFail($datas->branch_id);
            $supplier_name = Supplier::findOrFail($datas->supplier_id);


            $purchase_data[] = array(
                'unique_key' => $datas->unique_key,
                'branch_name' => $branch_name->name,
                'supplier_name' => $supplier_name->name,
                'date' => $datas->date,
                'time' => $datas->time,
                'gross_amount' => $datas->gross_amount,
                'bill_no' => $datas->bill_no,
            );
        }
        return view('page.backend.purchase.index', compact('purchase_data'));
    }


    public function create()
    {
        $productlist = Productlist::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $supplier = Supplier::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $bank = Bank::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');


        $last_purchaseid = Purchase::where('soft_delete', '!=', 1)->where('status', '!=', 1)->latest('id')->first();
        if($last_purchaseid != ''){
            $billno = $last_purchaseid->bill_no + 1;
        }else {
            $billno = 1;
        }
        return view('page.backend.purchase.create', compact('productlist', 'branch', 'supplier', 'today', 'timenow', 'bank', 'billno'));
    }



    public function store(Request $request)
    {
        // Purchase Table
        $randomkey = Str::random(5);
        
        $supplier_id = $request->get('supplier_id');
        $branchdata_s = $request->get('branch_id');
        $payable_amount = $request->get('payable_amount');

                        
        $data = new Purchase();

        $data->unique_key = $randomkey;
        $data->supplier_id = $request->get('supplier_id');
        $data->branch_id = $request->get('branch_id');
        $data->date = $request->get('date');
        $data->time = $request->get('time');
        $data->bill_no = $request->get('billno');
        $data->bank_id = $request->get('bank_id');
        $data->total_amount = $request->get('total_amount');
        $data->note = $request->get('extracost_note');
        $data->extra_cost = $request->get('extracost');
        $data->gross_amount = $request->get('gross_amount');
        $data->old_balance = $request->get('old_balance');
        $data->grand_total = $request->get('grand_total');
        $data->paid_amount = $request->get('payable_amount');
        $data->balance_amount = $request->get('pending_amount');
        $data->save();

        $insertedId = $data->id;

        // Purchase Products Table
        foreach ($request->get('product_id') as $key => $product_id) {

            $pprandomkey = Str::random(5);

            $PurchaseProduct = new PurchaseProduct;
            $PurchaseProduct->unique_key = $pprandomkey;
            $PurchaseProduct->purchase_id = $insertedId;
            $PurchaseProduct->productlist_id = $product_id;
            $PurchaseProduct->bag = $request->bag[$key];
            $PurchaseProduct->kgs = $request->kgs[$key];
            $PurchaseProduct->price_per_kg = $request->price_per_kg[$key];
            $PurchaseProduct->total_price = $request->total_price[$key];
            $PurchaseProduct->save();

            $product_ids = $request->product_id[$key];


            $branch_id = $request->get('branch_id');
            $product_Data = Product::where('productlist_id', '=', $product_ids)->where('branchtable_id', '=', $branch_id)->first();
            
            if($product_Data != ""){
                if($branch_id == $product_Data->branchtable_id){

                    $bag_count = $product_Data->available_stockin_bag;
                    $kg_count = $product_Data->available_stockin_kilograms;
    
                    $New_bagcount = $request->bag[$key];
                    $New_kgcount = $request->kgs[$key];
        
                    $totalbag_count = $bag_count + $New_bagcount;
                    $totalkg_count = $kg_count + $New_kgcount;
    
                    DB::table('products')->where('productlist_id', $product_ids)->where('branchtable_id', $branch_id)->update([
                        'available_stockin_bag' => $totalbag_count,  'available_stockin_kilograms' => $totalkg_count
                    ]);
                }
            }else {
                    $product_randomkey = Str::random(5);

                    $New_bagcount = $request->bag[$key];
                    $New_kgcount = $request->kgs[$key];

                    $ProductlistData = new Product;
                    $ProductlistData->unique_key = $product_randomkey;
                    $ProductlistData->productlist_id = $product_ids;
                    $ProductlistData->branchtable_id = $branch_id;
                    $ProductlistData->available_stockin_bag = $New_bagcount;
                    $ProductlistData->available_stockin_kilograms = $New_kgcount;
                    $ProductlistData->save();

                   
            }
            

        }

        return redirect()->route('purchase.index')->with('add', 'Purchase Data added successfully!');
    }




    public function edit($unique_key)
    {
        $PurchaseData = Purchase::where('unique_key', '=', $unique_key)->first();
        $productlist = Productlist::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $supplier = Supplier::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $bank = Bank::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $PurchaseData->id)->get();

        return view('page.backend.purchase.edit', compact('productlist', 'branch', 'supplier', 'bank', 'PurchaseData', 'PurchaseProducts'));
    }




    public function update(Request $request, $unique_key)
    {

        $branch_id = $request->get('branch_id');


        $Purchase_Data = Purchase::where('unique_key', '=', $unique_key)->first();

        $Purchase_Data->supplier_id = $request->get('supplier_id');
        $Purchase_Data->branch_id = $request->get('branch_id');
        $Purchase_Data->date = $request->get('date');
        $Purchase_Data->time = $request->get('time');
        $Purchase_Data->bill_no = $request->get('billno');
        $Purchase_Data->bank_id = $request->get('bank_id');
        $Purchase_Data->total_amount = $request->get('total_amount');
        $Purchase_Data->note = $request->get('extracost_note');
        $Purchase_Data->extra_cost = $request->get('extracost');
        $Purchase_Data->gross_amount = $request->get('gross_amount');
        $Purchase_Data->old_balance = $request->get('old_balance');
        $Purchase_Data->grand_total = $request->get('grand_total');
        $Purchase_Data->paid_amount = $request->get('payable_amount');
        $Purchase_Data->balance_amount = $request->get('pending_amount');
        $Purchase_Data->update();

        $PurchaseId = $Purchase_Data->id;

        // Purchase Products Table

        $getinsertedP_Products = PurchaseProduct::where('purchase_id', '=', $PurchaseId)->get();
        $Purchaseproducts = array();
        foreach ($getinsertedP_Products as $key => $getinserted_P_Products) {
            $Purchaseproducts[] = $getinserted_P_Products->id;
        }

        $updatedpurchaseproduct_id = $request->purchase_detail_id;
        $updated_PurchaseProduct_id = array_filter($updatedpurchaseproduct_id);
        $different_ids = array_merge(array_diff($Purchaseproducts, $updated_PurchaseProduct_id), array_diff($updated_PurchaseProduct_id, $Purchaseproducts));

        if (!empty($different_ids)) {
            foreach ($different_ids as $key => $differents_id) {

                $getPurchaseOld = PurchaseProduct::where('id', '=', $differents_id)->first();

                $product_Data = Product::where('soft_delete', '!=', 1)->where('productlist_id', '=', $getPurchaseOld->productlist_id)->where('branchtable_id', '=', $branch_id)->first();
                if($branch_id == $product_Data->branchtable_id){

                        $bag_count = $product_Data->available_stockin_bag;
                        $kg_count = $product_Data->available_stockin_kilograms;

                        $New_bagcount = $getPurchaseOld->bag;
                        $New_kgcount = $getPurchaseOld->kgs;
            
                        $totalbag_count =  $bag_count - $New_bagcount;
                        $totalkg_count =  $kg_count - $New_kgcount;

                        DB::table('products')->where('productlist_id', $getPurchaseOld->productlist_id)->where('branchtable_id', $branch_id)->update([
                            'available_stockin_bag' => $totalbag_count,  'available_stockin_kilograms' => $totalkg_count
                        ]);
                    }
            }
        }

        if (!empty($different_ids)) {
            foreach ($different_ids as $key => $different_id) {
                PurchaseProduct::where('id', $different_id)->delete();
            }
        }

        foreach ($request->get('purchase_detail_id') as $key => $purchase_detail_id) {
            if ($purchase_detail_id > 0) {

                $updateproduct_id = $request->product_id[$key];

                $ids = $purchase_detail_id;
                $purchaseID = $PurchaseId;
                $productlist_id = $request->product_id[$key];
                $bag = $request->bag[$key];
                $kgs = $request->kgs[$key];
                $price_per_kg = $request->price_per_kg[$key];
                $total_price = $request->total_price[$key];

                DB::table('purchase_products')->where('id', $ids)->update([
                    'purchase_id' => $purchaseID,  'productlist_id' => $updateproduct_id,  'bag' => $bag,  'kgs' => $kgs, 'price_per_kg' => $price_per_kg, 'total_price' => $total_price
                ]);

            } else if ($purchase_detail_id == '') {
                if ($request->product_id[$key] > 0) {


                    $p_prandomkey = Str::random(5);

                    $PurchaseProduct = new PurchaseProduct;
                    $PurchaseProduct->unique_key = $p_prandomkey;
                    $PurchaseProduct->purchase_id = $PurchaseId;
                    $PurchaseProduct->productlist_id = $request->product_id[$key];
                    $PurchaseProduct->bag = $request->bag[$key];
                    $PurchaseProduct->kgs = $request->kgs[$key];
                    $PurchaseProduct->price_per_kg = $request->price_per_kg[$key];
                    $PurchaseProduct->total_price = $request->total_price[$key];
                    $PurchaseProduct->save();



                    $Product_id = $request->product_id[$key];
                    $product_Data = Product::where('productlist_id', '=', $Product_id)->where('branchtable_id', '=', $branch_id)->first();
            
                    if($product_Data != ""){

                        if($branch_id == $product_Data->branchtable_id){
        
                            $bag_count = $product_Data->available_stockin_bag;
                            $kg_count = $product_Data->available_stockin_kilograms;
            
                            $New_bagcount = $request->bag[$key];
                            $New_kgcount = $request->kgs[$key];
                
                            $totalbag_count = $bag_count + $New_bagcount;
                            $totalkg_count = $kg_count + $New_kgcount;
            
                            DB::table('products')->where('productlist_id', $Product_id)->where('branchtable_id', $branch_id)->update([
                                'available_stockin_bag' => $totalbag_count,  'available_stockin_kilograms' => $totalkg_count
                            ]);
                        }
                    }else {
                        $updateproduct_randomkey = Str::random(5);

                        $New_bagcount = $request->bag[$key];
                        $New_kgcount = $request->kgs[$key];

                        $ProductlistData = new Product;
                        $ProductlistData->unique_key = $updateproduct_randomkey;
                        $ProductlistData->productlist_id = $Product_id;
                        $ProductlistData->branchtable_id = $branch_id;
                        $ProductlistData->available_stockin_bag = $New_bagcount;
                        $ProductlistData->available_stockin_kilograms = $New_kgcount;
                        $ProductlistData->save();
                    }
                    

                }
            }
        }

        return redirect()->route('purchase.index')->with('update', 'Updated Purchase information has been added to your list.');

    }


    public function invoice($unique_key)
    {
        return view('page.backend.purchase.invoice');
    }


    public function delete($unique_key)
    {
    }



    public function getProducts()
    {
        $GetProduct = productlist::where('soft_delete', '!=', 1)->get();
        $userData['data'] = $GetProduct;
        echo json_encode($userData);
    }

    public function getoldbalance()
    {
        $supplier_id = request()->get('supplier_id');
        $branch_id = request()->get('branch_id');

        $get_OldBalance = Purchase::where('soft_delete', '!=', 1)->where('status', '!=', 1)->where('supplier_id', '=', $supplier_id)->where('branch_id', '=', $branch_id)->latest('id')->first();
        if($get_OldBalance != ""){
            $userData['data'] = $get_OldBalance->balance_amount;
        }else {
            $userData['data'] = 'null';
        }
        echo json_encode($userData);
    }



    
}
