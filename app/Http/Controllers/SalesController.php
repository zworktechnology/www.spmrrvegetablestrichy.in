<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Branch;
use App\Models\Bank;
use App\Models\Customer;
use App\Models\Productlist;
use App\Models\Sales;
use App\Models\SalesProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SalesController extends Controller
{
    public function index()
    {
        $data = Sales::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $Sales_data = [];
        $sales_terms = [];
        foreach ($data as $key => $datas) {
            $branch_name = Branch::findOrFail($datas->branch_id);
            $customer_name = Customer::findOrFail($datas->customer_id);

            $SalesProducts = SalesProduct::where('sales_id', '=', $datas->id)->get();
            foreach ($SalesProducts as $key => $SalesProducts_arrdata) {

                $productlist_ID = Productlist::findOrFail($SalesProducts_arrdata->productlist_id);
                $sales_terms[] = array(
                    'bag' => $SalesProducts_arrdata->bag,
                    'kgs' => $SalesProducts_arrdata->kgs,
                    'price_per_kg' => $SalesProducts_arrdata->price_per_kg,
                    'total_price' => $SalesProducts_arrdata->total_price,
                    'product_name' => $productlist_ID->name,
                    'sales_id' => $SalesProducts_arrdata->sales_id,

                );
            }



            $Sales_data[] = array(
                'unique_key' => $datas->unique_key,
                'branch_name' => $branch_name->name,
                'customer_name' => $customer_name->name,
                'date' => $datas->date,
                'time' => $datas->time,
                'gross_amount' => $datas->gross_amount,
                'bill_no' => $datas->bill_no,
                'id' => $datas->id,
                'sales_terms' => $sales_terms,
            );
        }

        $allbranch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        return view('page.backend.sales.index', compact('Sales_data','allbranch'));
    }


    public function branchdata($branch_id)
    {
        $branchwise_data = Sales::where('branch_id', '=', $branch_id)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $Sales_data = [];
        $sales_terms = [];
        foreach ($branchwise_data as $key => $branchwise_datas) {
            $branch_name = Branch::findOrFail($branchwise_datas->branch_id);
            $customer_name = Customer::findOrFail($branchwise_datas->customer_id);


            $SalesProducts = SalesProduct::where('sales_id', '=', $branchwise_datas->id)->get();
            foreach ($SalesProducts as $key => $SalesProducts_arrdata) {

                $productlist_ID = Productlist::findOrFail($SalesProducts_arrdata->productlist_id);
                $sales_terms[] = array(
                    'bag' => $SalesProducts_arrdata->bag,
                    'kgs' => $SalesProducts_arrdata->kgs,
                    'price_per_kg' => $SalesProducts_arrdata->price_per_kg,
                    'total_price' => $SalesProducts_arrdata->total_price,
                    'product_name' => $productlist_ID->name,
                    'sales_id' => $SalesProducts_arrdata->sales_id,

                );
            }

            $Sales_data[] = array(
                'unique_key' => $branchwise_datas->unique_key,
                'branch_name' => $branch_name->name,
                'customer_name' => $customer_name->name,
                'date' => $branchwise_datas->date,
                'time' => $branchwise_datas->time,
                'gross_amount' => $branchwise_datas->gross_amount,
                'bill_no' => $branchwise_datas->bill_no,
                'id' => $branchwise_datas->id,
                'sales_terms' => $sales_terms,
            );
        }
        $allbranch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        return view('page.backend.sales.index', compact('Sales_data', 'allbranch', 'branch_id'));
    }

    public function create()
    {
        $productlist = Productlist::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $customer = Customer::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $bank = Bank::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');


        $last_salesid = Sales::where('soft_delete', '!=', 1)->where('status', '!=', 1)->latest('id')->first();
        if($last_salesid != ''){
            $salesbillno = $last_salesid->bill_no + 1;
        }else {
            $salesbillno = 1;
        }
        return view('page.backend.sales.create', compact('productlist', 'branch', 'customer', 'today', 'timenow', 'bank', 'salesbillno'));
    }



    public function store(Request $request)
    {
        // Sales Table
        $randomkey = Str::random(5);

        $data = new Sales();

        $data->unique_key = $randomkey;
        $data->customer_id = $request->get('sales_customerid');
        $data->branch_id = $request->get('sales_branch_id');
        $data->date = $request->get('sales_date');
        $data->time = $request->get('sales_time');
        $data->bill_no = $request->get('sales_billno');
        $data->bank_id = $request->get('sales_bank_id');
        $data->total_amount = $request->get('sales_total_amount');
        $data->note = $request->get('sales_extracost_note');
        $data->extra_cost = $request->get('sales_extracost');
        $data->gross_amount = $request->get('sales_gross_amount');
        $data->old_balance = $request->get('sales_old_balance');
        $data->grand_total = $request->get('sales_grand_total');
        $data->paid_amount = $request->get('salespayable_amount');
        $data->balance_amount = $request->get('sales_pending_amount');
        $data->save();

        $insertedId = $data->id;

        // Purchase Products Table
        foreach ($request->get('sales_product_id') as $key => $sales_product_id) {

            $salesprandomkey = Str::random(5);

            $SalesProduct = new SalesProduct;
            $SalesProduct->unique_key = $salesprandomkey;
            $SalesProduct->sales_id = $insertedId;
            $SalesProduct->productlist_id = $sales_product_id;
            $SalesProduct->bag = $request->sales_bag[$key];
            $SalesProduct->kgs = $request->sales_kgs[$key];
            $SalesProduct->price_per_kg = $request->sales_priceperkg[$key];
            $SalesProduct->total_price = $request->sales_total_price[$key];
            $SalesProduct->save();

            $product_ids = $request->sales_product_id[$key];


            $sales_branch_id = $request->get('sales_branch_id');
            $product_Data = Product::where('productlist_id', '=', $product_ids)->where('branchtable_id', '=', $sales_branch_id)->first();
            
            if($product_Data != ""){
                if($sales_branch_id == $product_Data->branchtable_id){

                    $bag_count = $product_Data->available_stockin_bag;
                    $kg_count = $product_Data->available_stockin_kilograms;
    
                    $New_bagcount = $request->sales_bag[$key];
                    $New_kgcount = $request->sales_kgs[$key];
        
                    $totalbag_count = $bag_count - $New_bagcount;
                    $totalkg_count = $kg_count - $New_kgcount;
    
                    DB::table('products')->where('productlist_id', $product_ids)->where('branchtable_id', $sales_branch_id)->update([
                        'available_stockin_bag' => $totalbag_count,  'available_stockin_kilograms' => $totalkg_count
                    ]);
                }
            }
            

        }

        return redirect()->route('sales.index')->with('add', 'Sales Data added successfully!');
    }



    public function edit($unique_key)
    {
        $SalesData = Sales::where('unique_key', '=', $unique_key)->first();
        $productlist = Productlist::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $customer = Customer::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $bank = Bank::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $SalesProducts = SalesProduct::where('sales_id', '=', $SalesData->id)->get();

        return view('page.backend.sales.edit', compact('productlist', 'branch', 'customer', 'bank', 'SalesData', 'SalesProducts'));
    }




    public function update(Request $request, $unique_key)
    {

        $branch_id = $request->get('sales_branch_id');


        $Sales_Data = Sales::where('unique_key', '=', $unique_key)->first();

        $Sales_Data->customer_id = $request->get('sales_customerid');
        $Sales_Data->branch_id = $request->get('sales_branch_id');
        $Sales_Data->date = $request->get('sales_date');
        $Sales_Data->time = $request->get('sales_time');
        $Sales_Data->bill_no = $request->get('sales_billno');
        $Sales_Data->bank_id = $request->get('sales_bank_id');
        $Sales_Data->total_amount = $request->get('sales_total_amount');
        $Sales_Data->note = $request->get('sales_extracost_note');
        $Sales_Data->extra_cost = $request->get('sales_extracost');
        $Sales_Data->gross_amount = $request->get('sales_gross_amount');
        $Sales_Data->old_balance = $request->get('sales_old_balance');
        $Sales_Data->grand_total = $request->get('sales_grand_total');
        $Sales_Data->paid_amount = $request->get('salespayable_amount');
        $Sales_Data->balance_amount = $request->get('sales_pending_amount');
        $Sales_Data->update();

        $SalesId = $Sales_Data->id;

        // Purchase Products Table

        $getinsertedP_Products = SalesProduct::where('sales_id', '=', $SalesId)->get();
        $Purchaseproducts = array();
        foreach ($getinsertedP_Products as $key => $getinserted_P_Products) {
            $Purchaseproducts[] = $getinserted_P_Products->id;
        }

        $updatedpurchaseproduct_id = $request->sales_detail_id;
        $updated_PurchaseProduct_id = array_filter($updatedpurchaseproduct_id);
        $different_ids = array_merge(array_diff($Purchaseproducts, $updated_PurchaseProduct_id), array_diff($updated_PurchaseProduct_id, $Purchaseproducts));

        if (!empty($different_ids)) {
            foreach ($different_ids as $key => $differents_id) {

                $getPurchaseOld = SalesProduct::where('id', '=', $differents_id)->first();

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
                SalesProduct::where('id', $different_id)->delete();
            }
        }

        foreach ($request->get('sales_detail_id') as $key => $sales_detail_id) {
            if ($sales_detail_id > 0) {

                $updatesales_product_id = $request->sales_product_id[$key];

                $ids = $sales_detail_id;
                $Sales_Id = $SalesId;
                $productlist_id = $request->sales_product_id[$key];
                $bag = $request->sales_bag[$key];
                $kgs = $request->sales_kgs[$key];
                $price_per_kg = $request->sales_priceperkg[$key];
                $total_price = $request->sales_total_price[$key];

                DB::table('sales_products')->where('id', $ids)->update([
                    'sales_id' => $Sales_Id,  'productlist_id' => $updatesales_product_id,  'bag' => $bag,  'kgs' => $kgs, 'price_per_kg' => $price_per_kg, 'total_price' => $total_price
                ]);

            } else if ($sales_detail_id == '') {
                if ($request->sales_product_id[$key] > 0) {


                    $p_prandomkey = Str::random(5);

                    $SalesProduct = new SalesProduct;
                    $SalesProduct->unique_key = $p_prandomkey;
                    $SalesProduct->purchase_id = $SalesId;
                    $SalesProduct->productlist_id = $request->sales_product_id[$key];
                    $SalesProduct->bag = $request->sales_bag[$key];
                    $SalesProduct->kgs = $request->sales_kgs[$key];
                    $SalesProduct->price_per_kg = $request->sales_priceperkg[$key];
                    $SalesProduct->total_price = $request->sales_total_price[$key];
                    $SalesProduct->save();



                    $Product_id = $request->sales_product_id[$key];
                    $product_Data = Product::where('productlist_id', '=', $Product_id)->where('branchtable_id', '=', $branch_id)->first();
            
                    if($product_Data != ""){

                        if($branch_id == $product_Data->branchtable_id){
        
                            $bag_count = $product_Data->available_stockin_bag;
                            $kg_count = $product_Data->available_stockin_kilograms;
            
                            $New_bagcount = $request->bag[$key];
                            $New_kgcount = $request->kgs[$key];
                
                            $totalbag_count = $bag_count - $New_bagcount;
                            $totalkg_count = $kg_count - $New_kgcount;
            
                            DB::table('products')->where('productlist_id', $Product_id)->where('branchtable_id', $branch_id)->update([
                                'available_stockin_bag' => $totalbag_count,  'available_stockin_kilograms' => $totalkg_count
                            ]);
                        }
                    }
                    

                }
            }
        }

        return redirect()->route('sales.index')->with('update', 'Updated Sales information has been added to your list.');

    }



    public function getoldbalanceforSales()
    {
        $sales_customerid = request()->get('sales_customerid');
        $sales_branch_id = request()->get('sales_branch_id');

        $get_OldBalanceforSales = Sales::where('soft_delete', '!=', 1)->where('status', '!=', 1)->where('customer_id', '=', $sales_customerid)->where('branch_id', '=', $sales_branch_id)->latest('id')->first();
        if($get_OldBalanceforSales != ""){
            $userData['data'] = $get_OldBalanceforSales->balance_amount;
        }else {
            $userData['data'] = 'null';
        }
        echo json_encode($userData);
    }


    public function getSalesview()
    {
        $sales_id = request()->get('sales_id');
        $get_Sales = Sales::where('soft_delete', '!=', 1)
                                    ->where('status', '!=', 1)
                                    ->where('id', '=', $sales_id)
                                    ->get();
        $output = [];
        foreach ($get_Sales as $key => $get_Sales_data) {

            $customer_namearr = Customer::where('id', '=', $get_Sales_data->customer_id)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->first();
            $branch_namearr = Branch::where('id', '=', $get_Sales_data->branch_id)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->first();
            $bank_namearr = Bank::where('id', '=', $get_Sales_data->bank_id)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->first();

            $output[] = array(
                'sales_customername' => $customer_namearr->name,
                'sales_customercontact_number' => $customer_namearr->contact_number,
                'sales_customershop_name' => $customer_namearr->shop_name,
                'sales_customershop_address' => $customer_namearr->shop_address,
                'sales_branchname' => $branch_namearr->name,
                'salesbranch_contact_number' => $branch_namearr->contact_number,
                'salesbranch_shop_name' => $branch_namearr->shop_name,
                'salesbranch_address' => $branch_namearr->address,

                'sales_date' => date('d m Y', strtotime($get_Sales_data->date)),
                'sales_time' => date('h:i A', strtotime($get_Sales_data->time)),

                'sales_bank_namedata' => $bank_namearr->name,
                'sales_total_amount' => $get_Sales_data->total_amount,
                'sales_extra_cost' => $get_Sales_data->extra_cost,
                'sales_old_balance' => $get_Sales_data->old_balance,
                'sales_grand_total' => $get_Sales_data->grand_total,
                'sales_paid_amount' => $get_Sales_data->paid_amount,
                'sales_balance_amount' => $get_Sales_data->balance_amount,
                'sales_bill_no' => $get_Sales_data->bill_no,
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

}
