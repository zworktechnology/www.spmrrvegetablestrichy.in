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

        $today = Carbon::now()->format('Y-m-d');
        $data = Purchase::where('date', '=', $today)->where('soft_delete', '!=', 1)->get();
        $purchase_data = [];
        $terms = [];
        foreach ($data as $key => $datas) {
            $branch_name = Branch::findOrFail($datas->branch_id);
            $supplier_name = Supplier::findOrFail($datas->supplier_id);

            $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $datas->id)->get();
            foreach ($PurchaseProducts as $key => $PurchaseProducts_arrdata) {

                $productlist_ID = Productlist::findOrFail($PurchaseProducts_arrdata->productlist_id);
                $terms[] = array(
                    'bag' => $PurchaseProducts_arrdata->bagorkg,
                    'kgs' => $PurchaseProducts_arrdata->count,
                    'price_per_kg' => $PurchaseProducts_arrdata->price_per_kg,
                    'total_price' => $PurchaseProducts_arrdata->total_price,
                    'product_name' => $productlist_ID->name,
                    'purchase_id' => $PurchaseProducts_arrdata->purchase_id,

                );

            }

            $purchase_data[] = array(
                'unique_key' => $datas->unique_key,
                'branch_name' => $branch_name->name,
                'supplier_name' => $supplier_name->name,
                'date' => $datas->date,
                'time' => $datas->time,
                'gross_amount' => $datas->gross_amount,
                'bill_no' => $datas->bill_no,
                'id' => $datas->id,
                'supplier_id' => $datas->supplier_id,
                'branch_id' => $datas->branch_id,
                'bank_id' => $datas->bank_id,
                'status' => $datas->status,
                'terms' => $terms,
            );
        }
        $allbranch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();


        $productlist = Productlist::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $supplier = Supplier::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $bank = Bank::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $timenow = Carbon::now()->format('H:i');


        $last_purchaseid = Purchase::where('soft_delete', '!=', 1)->where('status', '!=', 1)->latest('id')->first();
        if($last_purchaseid != ''){
            $billno = $last_purchaseid->bill_no + 1;
        }else {
            $billno = 1;
        }

        return view('page.backend.purchase.index', compact('purchase_data', 'allbranch', 'today', 'productlist', 'branch', 'supplier', 'timenow', 'bank', 'billno'));
    }


    public function branchdata($branch_id)
    {
        $branchwise_data = Purchase::where('branch_id', '=', $branch_id)->where('soft_delete', '!=', 1)->get();
        $purchase_data = [];
        foreach ($branchwise_data as $key => $branchwise_datas) {
            $branch_name = Branch::findOrFail($branchwise_datas->branch_id);
            $supplier_name = Supplier::findOrFail($branchwise_datas->supplier_id);


            $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $branchwise_datas->id)->get();
            foreach ($PurchaseProducts as $key => $PurchaseProducts_arrdata) {

                $productlist_ID = Productlist::findOrFail($PurchaseProducts_arrdata->productlist_id);
                $terms[] = array(
                    'bag' => $PurchaseProducts_arrdata->bagorkg,
                    'kgs' => $PurchaseProducts_arrdata->count,
                    'price_per_kg' => $PurchaseProducts_arrdata->price_per_kg,
                    'total_price' => $PurchaseProducts_arrdata->total_price,
                    'product_name' => $productlist_ID->name,
                    'purchase_id' => $PurchaseProducts_arrdata->purchase_id,

                );
            }

            $purchase_data[] = array(
                'unique_key' => $branchwise_datas->unique_key,
                'branch_name' => $branch_name->name,
                'supplier_name' => $supplier_name->name,
                'date' => $branchwise_datas->date,
                'time' => $branchwise_datas->time,
                'gross_amount' => $branchwise_datas->gross_amount,
                'bill_no' => $branchwise_datas->bill_no,
                'id' => $branchwise_datas->id,
                'terms' => $terms,
                'status' => $branchwise_datas->status,
            );
        }
        $today = Carbon::now()->format('Y-m-d');
        $allbranch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        return view('page.backend.purchase.index', compact('purchase_data', 'allbranch', 'branch_id', 'today'));
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


            $data = new Purchase();

            $data->unique_key = $randomkey;
            $data->supplier_id = $request->get('supplier_id');
            $data->branch_id = $request->get('branch_id');
            $data->date = $request->get('date');
            $data->time = $request->get('time');
            $data->bill_no = $request->get('billno');
            $data->bank_id = $request->get('bank_id');
            $data->save();

            $insertedId = $data->id;

            // Purchase Products Table
            foreach ($request->get('product_id') as $key => $product_id) {

                $pprandomkey = Str::random(5);

                $PurchaseProduct = new PurchaseProduct;
                $PurchaseProduct->unique_key = $pprandomkey;
                $PurchaseProduct->purchase_id = $insertedId;
                $PurchaseProduct->productlist_id = $product_id;
                $PurchaseProduct->bagorkg = $request->bagorkg[$key];
                $PurchaseProduct->count = $request->count[$key];
                $PurchaseProduct->save();

                $product_ids = $request->product_id[$key];


                $branch_id = $request->get('branch_id');
                $product_Data = Product::where('productlist_id', '=', $product_ids)->where('branchtable_id', '=', $branch_id)->first();

                if($product_Data != ""){
                    if($branch_id == $product_Data->branchtable_id){

                        $bag_count = $product_Data->available_stockin_bag;
                        $kg_count = $product_Data->available_stockin_kilograms;

                        if($request->bagorkg[$key] == 'bag'){
                            $totalbag_count = $bag_count + $request->count[$key];
                            $totalkg_count = $kg_count + 0;
                        }else if($request->bagorkg[$key] == 'kg'){
                            $totalkg_count = $kg_count + $request->count[$key];
                            $totalbag_count = $bag_count + 0;
                        }


                        DB::table('products')->where('productlist_id', $product_ids)->where('branchtable_id', $branch_id)->update([
                            'available_stockin_bag' => $totalbag_count,  'available_stockin_kilograms' => $totalkg_count
                        ]);
                    }
                }else {
                        $product_randomkey = Str::random(5);


                        if($request->bagorkg[$key] == 'bag'){
                            $New_bagcount = $request->count[$key];
                            $New_kgcount = 0;
                        }else if($request->bagorkg[$key] == 'kg'){
                            $New_kgcount = $request->count[$key];
                            $New_bagcount = 0;
                        }

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
        $Purchase_Data->bill_no = $request->get('billno');
        $Purchase_Data->bank_id = $request->get('bank_id');
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

                $product_Data = Product::where('soft_delete', '!=', 1)->where('productlist_id', '=', $getPurchaseOld->productlist_id)->where('branchtable_id', '=', $Purchase_Data->branch_id)->first();
                if($branch_id == $product_Data->branchtable_id){

                        $bag_count = $product_Data->available_stockin_bag;
                        $kg_count = $product_Data->available_stockin_kilograms;


                        if($getPurchaseOld->bagorkg == 'bag'){
                            $totalbag_count = $bag_count - $getPurchaseOld->count;
                            $totalkg_count = $kg_count - 0;
                        }else if($getPurchaseOld->bagorkg == 'kg'){
                            $totalkg_count = $kg_count - $getPurchaseOld->count;
                            $totalbag_count = $bag_count - 0;
                        }




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
                $bagorkg = $request->bagorkg[$key];
                $count = $request->count[$key];

                DB::table('purchase_products')->where('id', $ids)->update([
                    'purchase_id' => $purchaseID,  'productlist_id' => $updateproduct_id,  'bagorkg' => $bagorkg,  'count' => $count
                ]);

            } else if ($purchase_detail_id == '') {
                if ($request->product_id[$key] > 0) {


                    $p_prandomkey = Str::random(5);

                    $PurchaseProduct = new PurchaseProduct;
                    $PurchaseProduct->unique_key = $p_prandomkey;
                    $PurchaseProduct->purchase_id = $PurchaseId;
                    $PurchaseProduct->productlist_id = $request->product_id[$key];
                    $PurchaseProduct->bagorkg = $request->bagorkg[$key];
                    $PurchaseProduct->count = $request->count[$key];
                    $PurchaseProduct->save();



                    $Product_id = $request->product_id[$key];
                    $product_Data = Product::where('productlist_id', '=', $Product_id)->where('branchtable_id', '=', $branch_id)->first();

                    if($product_Data != ""){

                        if($branch_id == $product_Data->branchtable_id){

                            $bag_count = $product_Data->available_stockin_bag;
                            $kg_count = $product_Data->available_stockin_kilograms;


                            if($request->bagorkg[$key] == 'bag'){
                                $totalbag_count = $bag_count + $request->count[$key];
                                $totalkg_count = $kg_count + 0;
                            }else if($request->bagorkg[$key] == 'kg'){
                                $totalkg_count = $kg_count + $request->count[$key];
                                $totalbag_count = $bag_count + 0;
                            }



                            DB::table('products')->where('productlist_id', $Product_id)->where('branchtable_id', $branch_id)->update([
                                'available_stockin_bag' => $totalbag_count,  'available_stockin_kilograms' => $totalkg_count
                            ]);
                        }
                    }else {
                        $updateproduct_randomkey = Str::random(5);



                        if($request->bagorkg[$key] == 'bag'){
                            $New_bagcount = $request->count[$key];
                            $New_kgcount = 0;
                        }else if($request->bagorkg[$key] == 'kg'){
                            $New_kgcount = $request->count[$key];
                            $New_bagcount = 0;
                        }

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
        $PurchaseData = Purchase::where('unique_key', '=', $unique_key)->first();
        $productlist = Productlist::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $supplier = Supplier::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $bank = Bank::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $PurchaseData->id)->get();

        return view('page.backend.purchase.invoice', compact('productlist', 'branch', 'supplier', 'bank', 'PurchaseData', 'PurchaseProducts'));
    }



    public function invoice_update(Request $request, $unique_key)
    {


        $Purchase_Data = Purchase::where('unique_key', '=', $unique_key)->first();
        
        $Purchase_Data->total_amount = $request->get('total_amount');
        $Purchase_Data->note = $request->get('extracost_note');
        $Purchase_Data->extra_cost = $request->get('extracost');
        $Purchase_Data->gross_amount = $request->get('gross_amount');
        $Purchase_Data->old_balance = $request->get('old_balance');
        $Purchase_Data->grand_total = $request->get('grand_total');
        $Purchase_Data->paid_amount = $request->get('payable_amount');
        $Purchase_Data->balance_amount = $request->get('pending_amount');
        $Purchase_Data->status = 1;
        $Purchase_Data->update();
        $PurchaseId = $Purchase_Data->id;

        // Purchase Products Table

        

        foreach ($request->get('purchase_detail_id') as $key => $purchase_detail_id) {
            if ($purchase_detail_id > 0) {

                $updateproduct_id = $request->product_id[$key];

                $ids = $purchase_detail_id;
                $purchaseID = $PurchaseId;
                $price_per_kg = $request->price_per_kg[$key];
                $total_price = $request->total_price[$key];

                DB::table('purchase_products')->where('id', $ids)->update([
                    'purchase_id' => $purchaseID, 'price_per_kg' => $price_per_kg, 'total_price' => $total_price
                ]);

            } 
        }

        return redirect()->route('purchase.index')->with('update', 'Updated Purchase information has been added to your list.');

    }



    public function print_view($unique_key) {

        $PurchaseData = Purchase::where('unique_key', '=', $unique_key)->first();

        $suppliername = Supplier::where('id', '=', $PurchaseData->supplier_id)->first();
        $supplier_upper = strtoupper($suppliername->name);
        $branchname = Branch::where('id', '=', $PurchaseData->branch_id)->first();
        $bankname = Bank::where('id', '=', $PurchaseData->bank_id)->first();

        $productlist = Productlist::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $PurchaseData->id)->get();

        return view('page.backend.purchase.print_view', compact('PurchaseData', 'suppliername', 'branchname', 'bankname', 'PurchaseProducts', 'productlist', 'supplier_upper'));
    }


    public function delete($unique_key)
    {
    }



    public function datefilter(Request $request) {

        
        $today = $request->get('from_date');



        $data = Purchase::where('date', '=', $today)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $purchase_data = [];
        $terms = [];
        foreach ($data as $key => $datas) {
            $branch_name = Branch::findOrFail($datas->branch_id);
            $supplier_name = Supplier::findOrFail($datas->supplier_id);

            $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $datas->id)->get();
            foreach ($PurchaseProducts as $key => $PurchaseProducts_arrdata) {

                $productlist_ID = Productlist::findOrFail($PurchaseProducts_arrdata->productlist_id);
                $terms[] = array(
                    'bag' => $PurchaseProducts_arrdata->bagorkg,
                    'kgs' => $PurchaseProducts_arrdata->count,
                    'price_per_kg' => $PurchaseProducts_arrdata->price_per_kg,
                    'total_price' => $PurchaseProducts_arrdata->total_price,
                    'product_name' => $productlist_ID->name,
                    'purchase_id' => $PurchaseProducts_arrdata->purchase_id,

                );
            }

            $purchase_data[] = array(
                'unique_key' => $datas->unique_key,
                'branch_name' => $branch_name->name,
                'supplier_name' => $supplier_name->name,
                'date' => $datas->date,
                'time' => $datas->time,
                'gross_amount' => $datas->gross_amount,
                'bill_no' => $datas->bill_no,
                'id' => $datas->id,
                'terms' => $terms,
                'status' => $datas->status,
            );
        }
        $allbranch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();




        return view('page.backend.purchase.index', compact('purchase_data', 'allbranch', 'today'));

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


    

    public function getPurchaseview()
    {
        $purchase_id = request()->get('purchase_id');
        $get_Purchase = Purchase::where('soft_delete', '!=', 1)
                                    ->where('id', '=', $purchase_id)
                                    ->get();
        $output = [];
        foreach ($get_Purchase as $key => $get_Purchase_data) {

            $Supplier_namearr = Supplier::where('id', '=', $get_Purchase_data->supplier_id)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->first();
            $branch_namearr = Branch::where('id', '=', $get_Purchase_data->branch_id)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->first();
            $bank_namearr = Bank::where('id', '=', $get_Purchase_data->bank_id)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->first();

            $output[] = array(
                'suppliername' => $Supplier_namearr->name,
                'supplier_contact_number' => $Supplier_namearr->contact_number,
                'supplier_shop_name' => $Supplier_namearr->shop_name,
                'supplier_shop_address' => $Supplier_namearr->shop_address,
                'branchname' => $branch_namearr->name,
                'branch_contact_number' => $branch_namearr->contact_number,
                'branch_shop_name' => $branch_namearr->shop_name,
                'branch_address' => $branch_namearr->address,

                'date' => date('d m Y', strtotime($get_Purchase_data->date)),
                'time' => date('h:i A', strtotime($get_Purchase_data->time)),

                'bank_namedata' => $bank_namearr->name,
                'purchase_total_amount' => $get_Purchase_data->total_amount,
                'purchase_extra_cost' => $get_Purchase_data->extra_cost,
                'purchase_old_balance' => $get_Purchase_data->old_balance,
                'purchase_grand_total' => $get_Purchase_data->grand_total,
                'purchase_paid_amount' => $get_Purchase_data->paid_amount,
                'purchase_balance_amount' => $get_Purchase_data->balance_amount,
                'purchase_bill_no' => $get_Purchase_data->bill_no,
            );
        }

        if (isset($output) & !empty($output)) {
            echo json_encode($output);
        }else{
            echo json_encode(
                array('status' => 'false')
            );
        }

    }



    public function report() {
        $branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $supplier = Supplier::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $purchase_data = [];
        $purchase_data[] = array(
            'unique_key' => '',
            'branch_name' => '',
            'supplier_name' => '',
            'date' => '',
            'time' => '',
            'gross_amount' => '',
            'bill_no' => '',
            'id' => '',
            'terms' => '',
        );



        return view('page.backend.purchase.report', compact('branch', 'supplier', 'purchase_data'));
    }


    public function report_view(Request $request)
    {
        $purchasereport_fromdate = $request->get('purchasereport_fromdate');
        $purchasereport_todate = $request->get('purchasereport_todate');
        $purchasereport_branch = $request->get('purchasereport_branch');
        $purchasereport_supplier = $request->get('purchasereport_supplier');
        


        $branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $supplier = Supplier::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();


        if($purchasereport_branch){

            $GetBranch = Branch::findOrFail($purchasereport_branch);
            $purchase_data = [];

            $branchwise_report = Purchase::where('branch_id', '=', $purchasereport_branch)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
            if($branchwise_report != ''){

               
                $terms = [];
                foreach ($branchwise_report as $key => $branchwise_datas) {
                    $branch_name = Branch::findOrFail($branchwise_datas->branch_id);
                    $supplier_name = Supplier::findOrFail($branchwise_datas->supplier_id);
    
    
                    $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $branchwise_datas->id)->get();
                    foreach ($PurchaseProducts as $key => $PurchaseProducts_arrdata) {
    
                        $productlist_ID = Productlist::findOrFail($PurchaseProducts_arrdata->productlist_id);
                        $terms[] = array(
                            'bag' => $PurchaseProducts_arrdata->bag,
                            'kgs' => $PurchaseProducts_arrdata->kgs,
                            'price_per_kg' => $PurchaseProducts_arrdata->price_per_kg,
                            'total_price' => $PurchaseProducts_arrdata->total_price,
                            'product_name' => $productlist_ID->name,
                            'purchase_id' => $PurchaseProducts_arrdata->purchase_id,
    
                        );
                    }
    
    
    
                    $purchase_data[] = array(
                        'unique_key' => $branchwise_datas->unique_key,
                        'branch_name' => $branch_name->name,
                        'supplier_name' => $supplier_name->name,
                        'date' => $branchwise_datas->date,
                        'time' => $branchwise_datas->time,
                        'gross_amount' => $branchwise_datas->gross_amount,
                        'bill_no' => $branchwise_datas->bill_no,
                        'id' => $branchwise_datas->id,
                        'terms' => $terms,
                        'heading' => $branch_name->name . ' - Branch',
    
                    );
                }
            }else {
                $purchase_data[] = array(
                    'heading' => $GetBranch->name . ' - Branch',
                    'unique_key' => '',
                    'branch_name' => '',
                    'supplier_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'terms' => '',
                    
                );
            }
            
            
        }




        if($purchasereport_supplier){
            $GetSupplier = Supplier::findOrFail($purchasereport_supplier);

            $supplierwise_report = Purchase::where('supplier_id', '=', $purchasereport_supplier)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
            $purchase_data = [];

            if($supplierwise_report != ''){
                $supplier_terms = [];

                foreach ($supplierwise_report as $key => $supplierwise_report_datas) {

                    $branch_name = Branch::findOrFail($supplierwise_report_datas->branch_id);
                    $supplier_name = Supplier::findOrFail($supplierwise_report_datas->supplier_id);


                    $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $supplierwise_report_datas->id)->get();
                    foreach ($PurchaseProducts as $key => $PurchaseProducts_arrdata) {

                        $productlist_ID = Productlist::findOrFail($PurchaseProducts_arrdata->productlist_id);
                        $supplier_terms[] = array(
                            'bag' => $PurchaseProducts_arrdata->bag,
                            'kgs' => $PurchaseProducts_arrdata->kgs,
                            'price_per_kg' => $PurchaseProducts_arrdata->price_per_kg,
                            'total_price' => $PurchaseProducts_arrdata->total_price,
                            'product_name' => $productlist_ID->name,
                            'purchase_id' => $PurchaseProducts_arrdata->purchase_id,

                        );
                    }


                    $purchase_data[] = array(
                        'unique_key' => $supplierwise_report_datas->unique_key,
                        'branch_name' => $branch_name->name,
                        'supplier_name' => $supplier_name->name,
                        'date' => $supplierwise_report_datas->date,
                        'time' => $supplierwise_report_datas->time,
                        'gross_amount' => $supplierwise_report_datas->gross_amount,
                        'bill_no' => $supplierwise_report_datas->bill_no,
                        'id' => $supplierwise_report_datas->id,
                        'terms' => $supplier_terms,
                        'heading' => $GetSupplier->name . ' - Supplier',
                    );



                }
            }else{

                $purchase_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'supplier_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'terms' => '',
                    'heading' => $GetSupplier->name . ' - Supplier',
                );
            }

        }





        if($purchasereport_fromdate != ""){

            $fromdate_report = Purchase::where('date', '=', $purchasereport_fromdate)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
            $purchase_data = [];
            if($fromdate_report != ''){
                $fromdate_terms = [];

                foreach ($fromdate_report as $key => $fromdate_report_datas) {


                    $branch_name = Branch::findOrFail($fromdate_report_datas->branch_id);
                    $supplier_name = Supplier::findOrFail($fromdate_report_datas->supplier_id);


                    $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $fromdate_report_datas->id)->get();
                    foreach ($PurchaseProducts as $key => $PurchaseProducts_arrdata) {

                        $productlist_ID = Productlist::findOrFail($PurchaseProducts_arrdata->productlist_id);
                        $fromdate_terms[] = array(
                            'bag' => $PurchaseProducts_arrdata->bag,
                            'kgs' => $PurchaseProducts_arrdata->kgs,
                            'price_per_kg' => $PurchaseProducts_arrdata->price_per_kg,
                            'total_price' => $PurchaseProducts_arrdata->total_price,
                            'product_name' => $productlist_ID->name,
                            'purchase_id' => $PurchaseProducts_arrdata->purchase_id,

                        );
                    }


                    $purchase_data[] = array(
                        'unique_key' => $fromdate_report_datas->unique_key,
                        'branch_name' => $branch_name->name,
                        'supplier_name' => $supplier_name->name,
                        'date' => $fromdate_report_datas->date,
                        'time' => $fromdate_report_datas->time,
                        'gross_amount' => $fromdate_report_datas->gross_amount,
                        'bill_no' => $fromdate_report_datas->bill_no,
                        'id' => $fromdate_report_datas->id,
                        'terms' => $fromdate_terms,
                        'heading' => date('d-M-Y', strtotime($purchasereport_fromdate)) . ' - Report',
                    );



                }
            }else{

                $purchase_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'supplier_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'terms' => '',
                    'heading' => date('d-M-Y', strtotime($purchasereport_fromdate)),
                );
            }


        }





        if($purchasereport_todate != ""){

            $todate_report = Purchase::where('date', '=', $purchasereport_todate)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
            $purchase_data = [];
            if($todate_report != ''){
                $todate_terms = [];


                foreach ($todate_report as $key => $todate_report_datas) {

                    $branch_name = Branch::findOrFail($todate_report_datas->branch_id);
                    $supplier_name = Supplier::findOrFail($todate_report_datas->supplier_id);


                    $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $todate_report_datas->id)->get();
                    foreach ($PurchaseProducts as $key => $PurchaseProducts_arrdata) {

                        $productlist_ID = Productlist::findOrFail($PurchaseProducts_arrdata->productlist_id);
                        $todate_terms[] = array(
                            'bag' => $PurchaseProducts_arrdata->bag,
                            'kgs' => $PurchaseProducts_arrdata->kgs,
                            'price_per_kg' => $PurchaseProducts_arrdata->price_per_kg,
                            'total_price' => $PurchaseProducts_arrdata->total_price,
                            'product_name' => $productlist_ID->name,
                            'purchase_id' => $PurchaseProducts_arrdata->purchase_id,

                        );
                    }


                    $purchase_data[] = array(
                        'unique_key' => $todate_report_datas->unique_key,
                        'branch_name' => $branch_name->name,
                        'supplier_name' => $supplier_name->name,
                        'date' => $todate_report_datas->date,
                        'time' => $todate_report_datas->time,
                        'gross_amount' => $todate_report_datas->gross_amount,
                        'bill_no' => $todate_report_datas->bill_no,
                        'id' => $todate_report_datas->id,
                        'terms' => $todate_terms,
                        'heading' => date('d-M-Y', strtotime($purchasereport_todate)) . ' - Report',
                    );

                }

            }else{

                $purchase_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'supplier_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'terms' => '',
                    'heading' => date('d-M-Y', strtotime($purchasereport_todate)) . ' - Report',
                );
            }
        }





        if($purchasereport_fromdate && $purchasereport_supplier){
            $GetSupplier = Supplier::findOrFail($purchasereport_supplier);

            $datefilter_report = Purchase::where('date', '=', $purchasereport_fromdate)->where('supplier_id', '=', $purchasereport_supplier)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
            $purchase_data = [];
            if($datefilter_report != ''){
                $todate_terms = [];


                foreach ($datefilter_report as $key => $datefilter_report_arr) {

                    $branch_name = Branch::findOrFail($datefilter_report_arr->branch_id);
                    $supplier_name = Supplier::findOrFail($datefilter_report_arr->supplier_id);


                    $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $datefilter_report_arr->id)->get();
                    foreach ($PurchaseProducts as $key => $PurchaseProducts_arrdata) {

                        $productlist_ID = Productlist::findOrFail($PurchaseProducts_arrdata->productlist_id);
                        $todate_terms[] = array(
                            'bag' => $PurchaseProducts_arrdata->bag,
                            'kgs' => $PurchaseProducts_arrdata->kgs,
                            'price_per_kg' => $PurchaseProducts_arrdata->price_per_kg,
                            'total_price' => $PurchaseProducts_arrdata->total_price,
                            'product_name' => $productlist_ID->name,
                            'purchase_id' => $PurchaseProducts_arrdata->purchase_id,

                        );
                    }


                    $purchase_data[] = array(
                        'unique_key' => $datefilter_report_arr->unique_key,
                        'branch_name' => $branch_name->name,
                        'supplier_name' => $supplier_name->name,
                        'date' => $datefilter_report_arr->date,
                        'time' => $datefilter_report_arr->time,
                        'gross_amount' => $datefilter_report_arr->gross_amount,
                        'bill_no' => $datefilter_report_arr->bill_no,
                        'id' => $datefilter_report_arr->id,
                        'terms' => $todate_terms,
                        'heading' => date('d-M-Y', strtotime($purchasereport_fromdate)) . ' - Supplier(' . $GetSupplier->name . ')'
                    );

                }
            }else{

                $purchase_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'supplier_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'terms' => '',
                    'heading' => date('d-M-Y', strtotime($purchasereport_fromdate)) . ' - Supplier(' . $GetSupplier->name . ')'
                );
            }

        }




        if($purchasereport_todate && $purchasereport_supplier){
            $GetSupplier = Supplier::findOrFail($purchasereport_supplier);
            $datefilter_report = Purchase::where('date', '=', $purchasereport_todate)->where('supplier_id', '=', $purchasereport_supplier)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();


            $purchase_data = [];
            if($datefilter_report != ''){
                $todate_terms = [];


                    foreach ($datefilter_report as $key => $datefilter_report_arr) {

                        $branch_name = Branch::findOrFail($datefilter_report_arr->branch_id);
                        $supplier_name = Supplier::findOrFail($datefilter_report_arr->supplier_id);


                        $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $datefilter_report_arr->id)->get();
                        foreach ($PurchaseProducts as $key => $PurchaseProducts_arrdata) {

                            $productlist_ID = Productlist::findOrFail($PurchaseProducts_arrdata->productlist_id);
                            $todate_terms[] = array(
                                'bag' => $PurchaseProducts_arrdata->bag,
                                'kgs' => $PurchaseProducts_arrdata->kgs,
                                'price_per_kg' => $PurchaseProducts_arrdata->price_per_kg,
                                'total_price' => $PurchaseProducts_arrdata->total_price,
                                'product_name' => $productlist_ID->name,
                                'purchase_id' => $PurchaseProducts_arrdata->purchase_id,

                            );
                        }


                        $purchase_data[] = array(
                            'unique_key' => $datefilter_report_arr->unique_key,
                            'branch_name' => $branch_name->name,
                            'supplier_name' => $supplier_name->name,
                            'date' => $datefilter_report_arr->date,
                            'time' => $datefilter_report_arr->time,
                            'gross_amount' => $datefilter_report_arr->gross_amount,
                            'bill_no' => $datefilter_report_arr->bill_no,
                            'id' => $datefilter_report_arr->id,
                            'terms' => $todate_terms,
                            'heading' => date('d-M-Y', strtotime($purchasereport_todate)) . ' - Supplier(' . $GetSupplier->name . ')'
                        );

                    }
            }else{

                $purchase_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'supplier_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'terms' => '',
                    'heading' => date('d-M-Y', strtotime($purchasereport_todate)) . ' - Supplier(' . $GetSupplier->name . ')'
                );
            }
        }



        if($purchasereport_branch && $purchasereport_supplier){

            $GetSupplier = Supplier::findOrFail($purchasereport_supplier);
            $GetBrach = Branch::findOrFail($purchasereport_branch);

            $datefilter_report = Purchase::where('branch_id', '=', $purchasereport_branch)->where('supplier_id', '=', $purchasereport_supplier)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();

            $purchase_data = [];
            if($datefilter_report != ''){
            $todate_terms = [];


                foreach ($datefilter_report as $key => $datefilter_report_arr) {

                    $branch_name = Branch::findOrFail($datefilter_report_arr->branch_id);
                    $supplier_name = Supplier::findOrFail($datefilter_report_arr->supplier_id);


                    $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $datefilter_report_arr->id)->get();
                    foreach ($PurchaseProducts as $key => $PurchaseProducts_arrdata) {

                        $productlist_ID = Productlist::findOrFail($PurchaseProducts_arrdata->productlist_id);
                        $todate_terms[] = array(
                            'bag' => $PurchaseProducts_arrdata->bag,
                            'kgs' => $PurchaseProducts_arrdata->kgs,
                            'price_per_kg' => $PurchaseProducts_arrdata->price_per_kg,
                            'total_price' => $PurchaseProducts_arrdata->total_price,
                            'product_name' => $productlist_ID->name,
                            'purchase_id' => $PurchaseProducts_arrdata->purchase_id,

                        );
                    }


                    $purchase_data[] = array(
                        'unique_key' => $datefilter_report_arr->unique_key,
                        'branch_name' => $branch_name->name,
                        'supplier_name' => $supplier_name->name,
                        'date' => $datefilter_report_arr->date,
                        'time' => $datefilter_report_arr->time,
                        'gross_amount' => $datefilter_report_arr->gross_amount,
                        'bill_no' => $datefilter_report_arr->bill_no,
                        'id' => $datefilter_report_arr->id,
                        'terms' => $todate_terms,
                        'heading' => $GetBrach->name . '(Branch) - Supplier(' . $GetSupplier->name . ')'
                    );

                }
            }else{

                $purchase_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'supplier_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'terms' => '',
                    'heading' => $GetBrach->name . '(Branch) - Supplier(' . $GetSupplier->name . ')'
                );
            }

        }



        if($purchasereport_fromdate && $purchasereport_branch){
            $GetBrach = Branch::findOrFail($purchasereport_branch);
            $datefilter_report = Purchase::where('date', '=', $purchasereport_fromdate)->where('branch_id', '=', $purchasereport_branch)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();

            $purchase_data = [];
            if($datefilter_report != ''){
                $todate_terms = [];

                foreach ($datefilter_report as $key => $datefilter_report_arr) {

                    $branch_name = Branch::findOrFail($datefilter_report_arr->branch_id);
                    $supplier_name = Supplier::findOrFail($datefilter_report_arr->supplier_id);

                    $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $datefilter_report_arr->id)->get();
                    foreach ($PurchaseProducts as $key => $PurchaseProducts_arrdata) {

                        $productlist_ID = Productlist::findOrFail($PurchaseProducts_arrdata->productlist_id);
                        $todate_terms[] = array(
                            'bag' => $PurchaseProducts_arrdata->bag,
                            'kgs' => $PurchaseProducts_arrdata->kgs,
                            'price_per_kg' => $PurchaseProducts_arrdata->price_per_kg,
                            'total_price' => $PurchaseProducts_arrdata->total_price,
                            'product_name' => $productlist_ID->name,
                            'purchase_id' => $PurchaseProducts_arrdata->purchase_id,

                        );
                    }

                    $purchase_data[] = array(
                        'unique_key' => $datefilter_report_arr->unique_key,
                        'branch_name' => $branch_name->name,
                        'supplier_name' => $supplier_name->name,
                        'date' => $datefilter_report_arr->date,
                        'time' => $datefilter_report_arr->time,
                        'gross_amount' => $datefilter_report_arr->gross_amount,
                        'bill_no' => $datefilter_report_arr->bill_no,
                        'id' => $datefilter_report_arr->id,
                        'terms' => $todate_terms,
                        'heading' => date('d-M-Y', strtotime($purchasereport_fromdate)) . ' - ' . $GetBrach->name . '(Branch)'
                    );

                }
            }else{

                $purchase_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'supplier_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'terms' => '',
                    'heading' => date('d-M-Y', strtotime($purchasereport_fromdate)) . ' - ' . $GetBrach->name . '(Branch)'
                );
            }
        }




        if($purchasereport_todate && $purchasereport_branch){
            $GetBrach = Branch::findOrFail($purchasereport_branch);
            $datefilter_report = Purchase::where('date', '=', $purchasereport_todate)->where('branch_id', '=', $purchasereport_branch)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();

            $purchase_data = [];
            if($datefilter_report != ''){
                $todate_terms = [];

                foreach ($datefilter_report as $key => $datefilter_report_arr) {

                    $branch_name = Branch::findOrFail($datefilter_report_arr->branch_id);
                    $supplier_name = Supplier::findOrFail($datefilter_report_arr->supplier_id);

                    $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $datefilter_report_arr->id)->get();
                    foreach ($PurchaseProducts as $key => $PurchaseProducts_arrdata) {

                        $productlist_ID = Productlist::findOrFail($PurchaseProducts_arrdata->productlist_id);
                        $todate_terms[] = array(
                            'bag' => $PurchaseProducts_arrdata->bag,
                            'kgs' => $PurchaseProducts_arrdata->kgs,
                            'price_per_kg' => $PurchaseProducts_arrdata->price_per_kg,
                            'total_price' => $PurchaseProducts_arrdata->total_price,
                            'product_name' => $productlist_ID->name,
                            'purchase_id' => $PurchaseProducts_arrdata->purchase_id,

                        );
                    }


                    $purchase_data[] = array(
                        'unique_key' => $datefilter_report_arr->unique_key,
                        'branch_name' => $branch_name->name,
                        'supplier_name' => $supplier_name->name,
                        'date' => $datefilter_report_arr->date,
                        'time' => $datefilter_report_arr->time,
                        'gross_amount' => $datefilter_report_arr->gross_amount,
                        'bill_no' => $datefilter_report_arr->bill_no,
                        'id' => $datefilter_report_arr->id,
                        'terms' => $todate_terms,
                        'heading' => date('d-M-Y', strtotime($purchasereport_todate)) . ' - ' . $GetBrach->name . '(Branch)'
                    );

                }
            }else{

                $purchase_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'supplier_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'terms' => '',
                    'heading' => date('d-M-Y', strtotime($purchasereport_todate)) . ' - ' . $GetBrach->name . '(Branch)'
                );
            }


        }





        if($purchasereport_fromdate && $purchasereport_todate){


            $datefilter_report = Purchase::whereBetween('date', [$purchasereport_fromdate, $purchasereport_todate])->where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
            $purchase_data = [];
            if($datefilter_report != ''){
                $todate_terms = [];

                foreach ($datefilter_report as $key => $datefilter_report_arr) {

                    $branch_name = Branch::findOrFail($datefilter_report_arr->branch_id);
                    $supplier_name = Supplier::findOrFail($datefilter_report_arr->supplier_id);


                    $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $datefilter_report_arr->id)->get();
                    foreach ($PurchaseProducts as $key => $PurchaseProducts_arrdata) {

                        $productlist_ID = Productlist::findOrFail($PurchaseProducts_arrdata->productlist_id);
                        $todate_terms[] = array(
                            'bag' => $PurchaseProducts_arrdata->bag,
                            'kgs' => $PurchaseProducts_arrdata->kgs,
                            'price_per_kg' => $PurchaseProducts_arrdata->price_per_kg,
                            'total_price' => $PurchaseProducts_arrdata->total_price,
                            'product_name' => $productlist_ID->name,
                            'purchase_id' => $PurchaseProducts_arrdata->purchase_id,

                        );
                    }


                    $purchase_data[] = array(
                        'unique_key' => $datefilter_report_arr->unique_key,
                        'branch_name' => $branch_name->name,
                        'supplier_name' => $supplier_name->name,
                        'date' => $datefilter_report_arr->date,
                        'time' => $datefilter_report_arr->time,
                        'gross_amount' => $datefilter_report_arr->gross_amount,
                        'bill_no' => $datefilter_report_arr->bill_no,
                        'id' => $datefilter_report_arr->id,
                        'terms' => $todate_terms,
                        'heading' => date('d-M-Y', strtotime($purchasereport_fromdate)) . ' - ' . date('d-M-Y', strtotime($purchasereport_todate))
                    );

                }
            }else{

                $purchase_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'supplier_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'terms' => '',
                    'heading' => date('d-M-Y', strtotime($purchasereport_fromdate)) . ' - ' . date('d-M-Y', strtotime($purchasereport_todate))
                );
            }


        }



        if($purchasereport_fromdate && $purchasereport_todate && $purchasereport_branch){
            $GetBrach = Branch::findOrFail($purchasereport_branch);
            $datefilter_report = Purchase::whereBetween('date', [$purchasereport_fromdate, $purchasereport_todate])
                                            ->where('branch_id', '=', $purchasereport_branch)
                                            ->where('soft_delete', '!=', 1)
                                            ->where('status', '!=', 1)->get();
            $purchase_data = [];
            if($datefilter_report != ''){
                $todate_terms = [];

                foreach ($datefilter_report as $key => $datefilter_report_arr) {

                    $branch_name = Branch::findOrFail($datefilter_report_arr->branch_id);
                    $supplier_name = Supplier::findOrFail($datefilter_report_arr->supplier_id);


                    $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $datefilter_report_arr->id)->get();
                    foreach ($PurchaseProducts as $key => $PurchaseProducts_arrdata) {

                        $productlist_ID = Productlist::findOrFail($PurchaseProducts_arrdata->productlist_id);
                        $todate_terms[] = array(
                            'bag' => $PurchaseProducts_arrdata->bag,
                            'kgs' => $PurchaseProducts_arrdata->kgs,
                            'price_per_kg' => $PurchaseProducts_arrdata->price_per_kg,
                            'total_price' => $PurchaseProducts_arrdata->total_price,
                            'product_name' => $productlist_ID->name,
                            'purchase_id' => $PurchaseProducts_arrdata->purchase_id,

                        );
                    }

                    $purchase_data[] = array(
                        'unique_key' => $datefilter_report_arr->unique_key,
                        'branch_name' => $branch_name->name,
                        'supplier_name' => $supplier_name->name,
                        'date' => $datefilter_report_arr->date,
                        'time' => $datefilter_report_arr->time,
                        'gross_amount' => $datefilter_report_arr->gross_amount,
                        'bill_no' => $datefilter_report_arr->bill_no,
                        'id' => $datefilter_report_arr->id,
                        'terms' => $todate_terms,
                        'heading' => $GetBrach->name . ' Branch - (' . date('d-M-Y', strtotime($purchasereport_fromdate)) . ' - ' . date('d-M-Y', strtotime($purchasereport_todate)) . ')'
                    );

                }
            }else{

                $purchase_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'supplier_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'terms' => '',
                    'heading' => $GetBrach->name . ' Branch - (' . date('d-M-Y', strtotime($purchasereport_fromdate)) . ' - ' . date('d-M-Y', strtotime($purchasereport_todate)) . ')'
                );
            }
        }



        if($purchasereport_fromdate && $purchasereport_todate && $purchasereport_supplier){
            $GetSupplier = Supplier::findOrFail($purchasereport_supplier);

            $datefilter_report = Purchase::whereBetween('date', [$purchasereport_fromdate, $purchasereport_todate])
                                                    ->where('supplier_id', '=', $purchasereport_supplier)
                                                    ->where('soft_delete', '!=', 1)
                                                    ->where('status', '!=', 1)->get();
                $purchase_data = [];
                if($datefilter_report != ''){
                        $todate_terms = [];
    
                    foreach ($datefilter_report as $key => $datefilter_report_arr) {
        
                        $branch_name = Branch::findOrFail($datefilter_report_arr->branch_id);
                        $supplier_name = Supplier::findOrFail($datefilter_report_arr->supplier_id);
        
        
                        $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $datefilter_report_arr->id)->get();
                        foreach ($PurchaseProducts as $key => $PurchaseProducts_arrdata) {
        
                        $productlist_ID = Productlist::findOrFail($PurchaseProducts_arrdata->productlist_id);
                            $todate_terms[] = array(
                            'bag' => $PurchaseProducts_arrdata->bag,
                            'kgs' => $PurchaseProducts_arrdata->kgs,
                            'price_per_kg' => $PurchaseProducts_arrdata->price_per_kg,
                            'total_price' => $PurchaseProducts_arrdata->total_price,
                            'product_name' => $productlist_ID->name,
                            'purchase_id' => $PurchaseProducts_arrdata->purchase_id,
        
                            );
                        }
        
        
                            $purchase_data[] = array(
                                'unique_key' => $datefilter_report_arr->unique_key,
                                'branch_name' => $branch_name->name,
                                'supplier_name' => $supplier_name->name,
                                'date' => $datefilter_report_arr->date,
                                'time' => $datefilter_report_arr->time,
                                'gross_amount' => $datefilter_report_arr->gross_amount,
                                'bill_no' => $datefilter_report_arr->bill_no,
                                'id' => $datefilter_report_arr->id,
                                'terms' => $todate_terms,
                                'heading' => $GetSupplier->name . ' (Supplier) - (' . date('d-M-Y', strtotime($purchasereport_fromdate)) . ' - ' . date('d-M-Y', strtotime($purchasereport_todate)) . ')'
                            );
        
                    }
                }else{
    
                    $purchase_data[] = array(
                        'unique_key' => '',
                        'branch_name' => '',
                        'supplier_name' => '',
                        'date' => '',
                        'time' => '',
                        'gross_amount' => '',
                        'bill_no' => '',
                        'id' => '',
                        'terms' => '',
                        'heading' => $GetSupplier->name . ' (Supplier) - (' . date('d-M-Y', strtotime($purchasereport_fromdate)) . ' - ' . date('d-M-Y', strtotime($purchasereport_todate)) . ')'
                    );
                }

            }


        return view('page.backend.purchase.report', compact('purchasereport_fromdate', 'branch', 'supplier', 'purchasereport_todate','purchasereport_branch', 'purchasereport_supplier', 'purchase_data'));
    }




}
