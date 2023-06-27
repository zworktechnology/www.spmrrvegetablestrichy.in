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

        $today = Carbon::now()->format('Y-m-d');
        $data = Sales::where('date', '=', $today)->where('soft_delete', '!=', 1)->get();
        $Sales_data = [];
        $sales_terms = [];
        foreach ($data as $key => $datas) {
            $branch_name = Branch::findOrFail($datas->branch_id);
            $customer_name = Customer::findOrFail($datas->customer_id);

            $SalesProducts = SalesProduct::where('sales_id', '=', $datas->id)->get();
            foreach ($SalesProducts as $key => $SalesProducts_arrdata) {

                $productlist_ID = Productlist::findOrFail($SalesProducts_arrdata->productlist_id);
                $sales_terms[] = array(
                    'bag' => $SalesProducts_arrdata->bagorkg,
                    'kgs' => $SalesProducts_arrdata->count,
                    'price_per_kg' => $SalesProducts_arrdata->price_per_kg,
                    'total_price' => $SalesProducts_arrdata->total_price,
                    'product_name' => $productlist_ID->name,
                    'sales_id' => $SalesProducts_arrdata->sales_id,

                );
            }



            $Sales_data[] = array(
                'unique_key' => $datas->unique_key,
                'branch_name' => $branch_name->shop_name,
                'customer_name' => $customer_name->name,
                'date' => $datas->date,
                'time' => $datas->time,
                'gross_amount' => $datas->gross_amount,
                'bill_no' => $datas->bill_no,
                'id' => $datas->id,
                'sales_terms' => $sales_terms,
                'status' => $datas->status,
            );
        }

        $allbranch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        return view('page.backend.sales.index', compact('Sales_data','allbranch', 'today'));
    }


    public function branchdata($branch_id)
    {
        $today = Carbon::now()->format('Y-m-d');
        $branchwise_data = Sales::where('branch_id', '=', $branch_id)->where('soft_delete', '!=', 1)->get();
        $Sales_data = [];
        $sales_terms = [];
        foreach ($branchwise_data as $key => $branchwise_datas) {
            $branch_name = Branch::findOrFail($branchwise_datas->branch_id);
            $customer_name = Customer::findOrFail($branchwise_datas->customer_id);


            $SalesProducts = SalesProduct::where('sales_id', '=', $branchwise_datas->id)->get();
            foreach ($SalesProducts as $key => $SalesProducts_arrdata) {

                $productlist_ID = Productlist::findOrFail($SalesProducts_arrdata->productlist_id);
                $sales_terms[] = array(
                    'bag' => $SalesProducts_arrdata->bagorkg,
                    'kgs' => $SalesProducts_arrdata->count,
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
                'status' => $branchwise_datas->status,
            );
        }
        $allbranch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        return view('page.backend.sales.index', compact('Sales_data', 'allbranch', 'branch_id', 'today'));
    }

    public function datefilter(Request $request) {


        $today = $request->get('from_date');


        $data = Sales::where('date', '=', $today)->where('soft_delete', '!=', 1)->get();
        $Sales_data = [];
        $sales_terms = [];
        foreach ($data as $key => $datas) {
            $branch_name = Branch::findOrFail($datas->branch_id);
            $customer_name = Customer::findOrFail($datas->customer_id);

            $SalesProducts = SalesProduct::where('sales_id', '=', $datas->id)->get();
            foreach ($SalesProducts as $key => $SalesProducts_arrdata) {

                $productlist_ID = Productlist::findOrFail($SalesProducts_arrdata->productlist_id);
                $sales_terms[] = array(
                    'bag' => $SalesProducts_arrdata->bagorkg,
                    'kgs' => $SalesProducts_arrdata->count,
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
                'status' => $datas->status,
            );
        }

        $allbranch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        return view('page.backend.sales.index', compact('Sales_data','allbranch', 'today'));

    }

    public function create()
    {
        $productlist = Productlist::orderBy('name', 'ASC')->where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $branch = Branch::orderBy('name', 'ASC')->where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $customer = Customer::orderBy('name', 'ASC')->where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $bank = Bank::orderBy('name', 'ASC')->where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');
        return view('page.backend.sales.create', compact('productlist', 'branch', 'customer', 'today', 'timenow', 'bank'));
    }



    public function store(Request $request)
    {
        // Sales Table

            $sales_branch_id = $request->get('sales_branch_id');
            $sales_date = $request->get('sales_date');
            $s_bill_no = 1;

            // Branch
            $GetBranch = Branch::findOrFail($sales_branch_id);
            $Branch_Name = $GetBranch->shop_name;
            $first_three_letter = substr($Branch_Name, 0, 3);
            $branch_upper = strtoupper($first_three_letter);

            //Date
            $billreport_date = date('dmY', strtotime($sales_date));


            $lastreport_OFBranch = Sales::where('branch_id', '=', $sales_branch_id)->where('date', '=', $sales_date)->latest('id')->first();
            if($lastreport_OFBranch != '')
            {
                $added_billno = substr ($lastreport_OFBranch->bill_no, -5);
                $invoiceno = $branch_upper . $billreport_date . 'S0000' . ($added_billno) + 1;
            } else {
                $invoiceno = $branch_upper . $billreport_date . 'S0000' . $s_bill_no;
            }


            $randomkey = Str::random(5);

            $data = new Sales();

            $data->unique_key = $randomkey;
            $data->customer_id = $request->get('sales_customerid');
            $data->branch_id = $request->get('sales_branch_id');
            $data->date = $request->get('sales_date');
            $data->time = $request->get('sales_time');
            $data->bill_no = $invoiceno;
            $data->save();

            $insertedId = $data->id;

            // Purchase Products Table
            foreach ($request->get('sales_product_id') as $key => $sales_product_id) {

                $salesprandomkey = Str::random(5);

                $SalesProduct = new SalesProduct;
                $SalesProduct->unique_key = $salesprandomkey;
                $SalesProduct->sales_id = $insertedId;
                $SalesProduct->productlist_id = $sales_product_id;
                $SalesProduct->bagorkg = $request->sales_bagorkg[$key];
                $SalesProduct->count = $request->sales_count[$key];
                $SalesProduct->save();

                $product_ids = $request->sales_product_id[$key];


                $sales_branch_id = $request->get('sales_branch_id');
                $product_Data = Product::where('productlist_id', '=', $product_ids)->where('branchtable_id', '=', $sales_branch_id)->first();

                if($product_Data != ""){
                    if($sales_branch_id == $product_Data->branchtable_id){

                        $bag_count = $product_Data->available_stockin_bag;
                        $kg_count = $product_Data->available_stockin_kilograms;


                        if($request->sales_bagorkg[$key] == 'bag'){
                            $totalbag_count = $bag_count - $request->sales_count[$key];
                            $totalkg_count = $kg_count - 0;
                        }else if($request->sales_bagorkg[$key] == 'kg'){
                            $totalkg_count = $kg_count - $request->sales_count[$key];
                            $totalbag_count = $bag_count - 0;
                        }



                        DB::table('products')->where('productlist_id', $product_ids)->where('branchtable_id', $sales_branch_id)->update([
                            'available_stockin_bag' => $totalbag_count,  'available_stockin_kilograms' => $totalkg_count
                        ]);
                    }
                }


            }

            return redirect()->route('sales.index')->with('add', 'Sales Data added successfully!');






    }


    public function print_view($unique_key) {

        $SalesData = Sales::where('unique_key', '=', $unique_key)->first();

        $customer_idname = Customer::where('id', '=', $SalesData->customer_id)->first();
            $branchname = Branch::where('id', '=', $SalesData->branch_id)->first();
            $bankname = Bank::where('id', '=', $SalesData->bank_id)->first();
            $customer_upper = strtoupper($customer_idname->name);
            $productlist = Productlist::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
            $SalesProduct_darta = SalesProduct::where('sales_id', '=', $SalesData->id)->get();

        return view('page.backend.sales.print_view', compact('customer_upper', 'SalesData', 'customer_idname', 'branchname', 'bankname', 'SalesProduct_darta', 'productlist'));
    }



    public function edit($unique_key)
    {
        $SalesData = Sales::where('unique_key', '=', $unique_key)->first();
        $productlist = orderBy('name', 'ASC')->Productlist::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $branch = Branch::orderBy('name', 'ASC')->where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $customer = Customer::orderBy('name', 'ASC')->where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $bank = Bank::orderBy('name', 'ASC')->where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
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
        $Sales_Data->bank_id = $request->get('sales_bank_id');
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

                        if($getPurchaseOld->bagorkg == 'bag'){
                            $totalbag_count = $bag_count + $getPurchaseOld->count;
                            $totalkg_count = $kg_count + 0;
                        }else if($getPurchaseOld->bagorkg == 'kg'){
                            $totalkg_count = $kg_count + $getPurchaseOld->count;
                            $totalbag_count = $bag_count + 0;
                        }

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
                $bagorkg = $request->sales_bagorkg[$key];
                $count = $request->sales_count[$key];

                DB::table('sales_products')->where('id', $ids)->update([
                    'sales_id' => $Sales_Id,  'productlist_id' => $updatesales_product_id,  'bagorkg' => $bagorkg,  'count' => $count
                ]);

            } else if ($sales_detail_id == '') {
                if ($request->sales_product_id[$key] > 0) {


                    $p_prandomkey = Str::random(5);

                    $SalesProduct = new SalesProduct;
                    $SalesProduct->unique_key = $p_prandomkey;
                    $SalesProduct->sales_id = $SalesId;
                    $SalesProduct->productlist_id = $request->sales_product_id[$key];
                    $SalesProduct->bagorkg = $request->sales_bagorkg[$key];
                    $SalesProduct->count = $request->sales_count[$key];
                    $SalesProduct->save();



                    $Product_id = $request->sales_product_id[$key];
                    $product_Data = Product::where('productlist_id', '=', $Product_id)->where('branchtable_id', '=', $branch_id)->first();

                    if($product_Data != ""){

                        if($branch_id == $product_Data->branchtable_id){

                            $bag_count = $product_Data->available_stockin_bag;
                            $kg_count = $product_Data->available_stockin_kilograms;

                            if($request->sales_bagorkg[$key] == 'bag'){
                                $totalbag_count = $bag_count - $request->sales_count[$key];
                                $totalkg_count = $kg_count - 0;
                            }else if($request->bagorkg[$key] == 'kg'){
                                $totalkg_count = $kg_count - $request->sales_count[$key];
                                $totalbag_count = $bag_count - 0;
                            }



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


    public function invoice($unique_key)
    {
        $SalesData = Sales::where('unique_key', '=', $unique_key)->first();
        $productlist = Productlist::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $customer = Customer::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $bank = Bank::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $SalesProducts = SalesProduct::where('sales_id', '=', $SalesData->id)->get();

        return view('page.backend.sales.invoice', compact('productlist', 'branch', 'customer', 'bank', 'SalesData', 'SalesProducts'));
    }


    public function invoice_update(Request $request, $unique_key)
    {

        $branch_id = $request->get('sales_branch_id');


        $Sales_Data = Sales::where('unique_key', '=', $unique_key)->first();

        $Sales_Data->bank_id = $request->get('sales_bank_id');
        $Sales_Data->total_amount = $request->get('sales_total_amount');
        $Sales_Data->note = $request->get('sales_extracost_note');
        $Sales_Data->extra_cost = $request->get('sales_extracost');
        $Sales_Data->gross_amount = $request->get('sales_gross_amount');
        $Sales_Data->old_balance = $request->get('sales_old_balance');
        $Sales_Data->grand_total = $request->get('sales_grand_total');
        $Sales_Data->paid_amount = $request->get('salespayable_amount');
        $Sales_Data->balance_amount = $request->get('sales_pending_amount');
        $Sales_Data->status = 1;
        $Sales_Data->update();

        $SalesId = $Sales_Data->id;

        // Purchase Products Table



        foreach ($request->get('sales_detail_id') as $key => $sales_detail_id) {
            if ($sales_detail_id > 0) {

                $updatesales_product_id = $request->sales_product_id[$key];

                $ids = $sales_detail_id;
                $Sales_Id = $SalesId;
                $price_per_kg = $request->sales_priceperkg[$key];
                $total_price = $request->sales_total_price[$key];

                DB::table('sales_products')->where('id', $ids)->update([
                    'sales_id' => $Sales_Id,  'productlist_id' => $updatesales_product_id, 'price_per_kg' => $price_per_kg, 'total_price' => $total_price
                ]);

            }
        }

        return redirect()->route('sales.index')->with('update', 'Updated Sales information has been added to your list.');

    }



    public function report() {
        $branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $Customer = Customer::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $Sales_data = [];
        $Sales_data[] = array(
            'unique_key' => '',
            'branch_name' => '',
            'customer_name' => '',
            'date' => '',
            'time' => '',
            'gross_amount' => '',
            'bill_no' => '',
            'id' => '',
            'terms' => '',
            'heading' => '',
        );



        return view('page.backend.sales.report', compact('branch', 'Customer', 'Sales_data'));
    }



    public function report_view(Request $request)
    {
        $salesreport_fromdate = $request->get('salesreport_fromdate');
        $salesreport_todate = $request->get('salesreport_todate');
        $salesreport_branch = $request->get('salesreport_branch');
        $salesreport_customer = $request->get('salesreport_customer');

        $branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $Customer = Customer::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();

        if($salesreport_branch != ""){
            $GetBranch = Branch::findOrFail($salesreport_branch);

            $branchwise_report = Sales::where('branch_id', '=', $salesreport_branch)->where('soft_delete', '!=', 1)->get();
            $Sales_data = [];
            if($branchwise_report != ""){
                $sales_terms = [];
                foreach ($branchwise_report as $key => $branchwise_datas) {
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
                        'status' => $branchwise_datas->status,
                        'branchheading' => $GetBranch->shop_name,
                        'customerheading' => '',
                        'fromdateheading' => '',
                        'todateheading' => '',

                    );
                }
            }else{

                $Sales_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'customer_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'sales_terms' => '',
                    'status' => '',
                    'branchheading' => $GetBranch->shop_name,
                    'customerheading' => '',
                    'fromdateheading' => '',
                    'todateheading' => '',
                );
            }
        }





        if($salesreport_customer != ""){
            $GetCustomer = Customer::findOrFail($salesreport_customer);

            $branchwise_report = Sales::where('customer_id', '=', $salesreport_customer)->where('soft_delete', '!=', 1)->get();
            $Sales_data = [];
            if($branchwise_report != ''){
                $sales_terms = [];
                foreach ($branchwise_report as $key => $branchwise_datas) {
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
                        'status' => $branchwise_datas->status,
                        'branchheading' => '',
                        'customerheading' => $GetCustomer->name,
                        'fromdateheading' => '',
                        'todateheading' => '',

                    );
                }
            }else{

                $Sales_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'customer_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'sales_terms' => '',
                    'status' => '',
                    'branchheading' => '',
                    'customerheading' => $GetCustomer->name,
                    'fromdateheading' => '',
                    'todateheading' => '',

                );
            }
        }





        if($salesreport_fromdate != ""){

            $branchwise_report = Sales::where('date', '=', $salesreport_fromdate)->where('soft_delete', '!=', 1)->get();
            $Sales_data = [];
            if($branchwise_report != ''){
                $sales_terms = [];
                foreach ($branchwise_report as $key => $branchwise_datas) {
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
                        'status' => $branchwise_datas->status,
                        'branchheading' => '',
                        'customerheading' => '',
                        'fromdateheading' => date('d-M-Y', strtotime($salesreport_fromdate)),
                        'todateheading' => '',

                    );
                }
            }else{

                $Sales_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'customer_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'sales_terms' => '',
                    'status' => '',
                    'branchheading' => '',
                    'customerheading' => '',
                    'fromdateheading' => date('d-M-Y', strtotime($salesreport_fromdate)),
                    'todateheading' => '',
                );
            }
        }




        if($salesreport_todate != ""){

            $branchwise_report = Sales::where('date', '=', $salesreport_todate)->where('soft_delete', '!=', 1)->get();
            $Sales_data = [];
            if($branchwise_report != ''){
                $sales_terms = [];
                foreach ($branchwise_report as $key => $branchwise_datas) {
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
                        'status' => $branchwise_datas->status,
                        'branchheading' => '',
                        'customerheading' => '',
                        'fromdateheading' => '',
                        'todateheading' => date('d-M-Y', strtotime($salesreport_todate)),

                    );
                }
            }else{

                $Sales_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'customer_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'sales_terms' => '',
                    'status' => '',
                    'branchheading' => '',
                    'customerheading' => '',
                    'fromdateheading' => '',
                    'todateheading' => date('d-M-Y', strtotime($salesreport_todate)),
                );
            }

        }


        if($salesreport_fromdate && $salesreport_customer){
            $GetCustomer = Customer::findOrFail($salesreport_customer);

            $branchwise_report = Sales::where('date', '=', $salesreport_fromdate)->where('customer_id', '=', $salesreport_customer)->where('soft_delete', '!=', 1)->get();
            $Sales_data = [];
            if($branchwise_report != ''){
                $sales_terms = [];
                foreach ($branchwise_report as $key => $branchwise_datas) {
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
                        'status' => $branchwise_datas->status,
                        'branchheading' => '',
                        'customerheading' => $GetCustomer->name,
                        'fromdateheading' => date('d-M-Y', strtotime($salesreport_fromdate)),
                        'todateheading' => '',

                    );
                }
            }else{

                $Sales_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'customer_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'sales_terms' => '',
                    'status' => '',
                    'branchheading' => '',
                    'customerheading' => $GetCustomer->name,
                    'fromdateheading' => date('d-M-Y', strtotime($salesreport_fromdate)),
                    'todateheading' => '',
                );
            }


        }





        if($salesreport_fromdate && $salesreport_todate){


            $branchwise_report = Sales::whereBetween('date', [$salesreport_fromdate, $salesreport_todate])->where('soft_delete', '!=', 1)->get();
            $Sales_data = [];
            if($branchwise_report != ''){
                $sales_terms = [];
                foreach ($branchwise_report as $key => $branchwise_datas) {
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
                        'status' => $branchwise_datas->status,
                        'branchheading' => '',
                        'customerheading' => '',
                        'fromdateheading' => date('d-M-Y', strtotime($salesreport_fromdate)),
                        'todateheading' => date('d-M-Y', strtotime($salesreport_todate)),

                    );
                }
            }else{

                $Sales_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'customer_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'sales_terms' => '',
                    'status' => '',
                    'branchheading' => '',
                    'customerheading' => '',
                    'fromdateheading' => date('d-M-Y', strtotime($salesreport_fromdate)),
                    'todateheading' => date('d-M-Y', strtotime($salesreport_todate)),

                );
            }



        }



        if($salesreport_todate && $salesreport_customer){
            $GetCustomer = Customer::findOrFail($salesreport_customer);

            $branchwise_report = Sales::where('date', '=', $salesreport_todate)->where('customer_id', '=', $salesreport_customer)->where('soft_delete', '!=', 1)->get();
            $Sales_data = [];
            if($branchwise_report != ''){
                $sales_terms = [];
                foreach ($branchwise_report as $key => $branchwise_datas) {
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
                        'status' => $branchwise_datas->status,
                        'branchheading' => '',
                        'customerheading' => $GetCustomer->name,
                        'fromdateheading' => '',
                        'todateheading' => date('d-M-Y', strtotime($salesreport_todate)),

                    );
                }
            }else{

                $Sales_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'customer_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'sales_terms' => '',
                    'status' => '',
                    'branchheading' => '',
                    'customerheading' => $GetCustomer->name,
                    'fromdateheading' => '',
                    'todateheading' => date('d-M-Y', strtotime($salesreport_todate)),
                );
            }


        }





        if($salesreport_branch && $salesreport_customer){

            $GetBranch = Branch::findOrFail($salesreport_branch);
            $GetCustomer = Customer::findOrFail($salesreport_customer);

            $branchwise_report = Sales::where('branch_id', '=', $salesreport_branch)->where('customer_id', '=', $salesreport_customer)->where('soft_delete', '!=', 1)->get();
            $Sales_data = [];
            if($branchwise_report != ''){
                $sales_terms = [];
                foreach ($branchwise_report as $key => $branchwise_datas) {
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
                        'status' => $branchwise_datas->status,
                        'branchheading' => $GetBranch->shop_name,
                        'customerheading' => $GetCustomer->name,
                        'fromdateheading' => '',
                        'todateheading' => '',

                    );
                }
            }else{

                $Sales_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'customer_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'sales_terms' => '',
                    'status' => '',
                    'branchheading' => $GetBranch->shop_name,
                    'customerheading' => $GetCustomer->name,
                    'fromdateheading' => '',
                    'todateheading' => '',
                );
            }


        }



        if($salesreport_branch && $salesreport_fromdate){
            $GetBranch = Branch::findOrFail($salesreport_branch);

            $branchwise_report = Sales::where('branch_id', '=', $salesreport_branch)->where('date', '=', $salesreport_fromdate)->where('soft_delete', '!=', 1)->get();
            $Sales_data = [];
            if($branchwise_report != ''){
                $sales_terms = [];
                foreach ($branchwise_report as $key => $branchwise_datas) {
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
                        'status' => $branchwise_datas->status,
                        'branchheading' => $GetBranch->shop_name,
                        'customerheading' => '',
                        'fromdateheading' => date('d-M-Y', strtotime($salesreport_fromdate)),
                        'todateheading' => '',

                    );
                }
            }else{

                $Sales_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'customer_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'sales_terms' => '',
                    'status' => '',
                    'branchheading' => $GetBranch->shop_name,
                    'customerheading' => '',
                    'fromdateheading' => date('d-M-Y', strtotime($salesreport_fromdate)),
                    'todateheading' => '',
                );
            }


        }




        if($salesreport_branch && $salesreport_todate){
            $GetBranch = Branch::findOrFail($salesreport_branch);

            $branchwise_report = Sales::where('branch_id', '=', $salesreport_branch)->where('date', '=', $salesreport_todate)->where('soft_delete', '!=', 1)->get();
            $Sales_data = [];
            if($branchwise_report != ''){
                $sales_terms = [];
                foreach ($branchwise_report as $key => $branchwise_datas) {
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
                        'status' => $branchwise_datas->status,
                        'branchheading' => $GetBranch->shop_name,
                        'customerheading' => '',
                        'fromdateheading' => '',
                        'todateheading' => date('d-M-Y', strtotime($salesreport_todate)),

                    );
                }
            }else{

                $Sales_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'customer_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'sales_terms' => '',
                    'status' => '',
                    'branchheading' => $GetBranch->shop_name,
                    'customerheading' => '',
                    'fromdateheading' => '',
                    'todateheading' => date('d-M-Y', strtotime($salesreport_todate)),
                );
            }


        }




        if($salesreport_fromdate && $salesreport_todate && $salesreport_branch){
            $GetBrach = Branch::findOrFail($salesreport_branch);

            $branchwise_report = Sales::whereBetween('date', [$salesreport_fromdate, $salesreport_todate])->where('branch_id', '=', $salesreport_branch)->where('soft_delete', '!=', 1)->get();
            $Sales_data = [];
            if($branchwise_report != ''){
                $sales_terms = [];
                foreach ($branchwise_report as $key => $branchwise_datas) {
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
                        'status' => $branchwise_datas->status,
                        'branchheading' => $GetBranch->shop_name,
                        'customerheading' => '',
                        'fromdateheading' => date('d-M-Y', strtotime($salesreport_fromdate)),
                        'todateheading' => date('d-M-Y', strtotime($salesreport_todate)),

                    );
                }
            }else{

                $Sales_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'customer_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'sales_terms' => '',
                    'status' => '',
                    'branchheading' => $GetBranch->shop_name,
                    'customerheading' => '',
                    'fromdateheading' => date('d-M-Y', strtotime($salesreport_fromdate)),
                    'todateheading' => date('d-M-Y', strtotime($salesreport_todate)),
                );
            }


        }



        if($salesreport_fromdate && $salesreport_todate && $salesreport_customer){

            $GetCustomer = Customer::findOrFail($salesreport_customer);

            $branchwise_report = Sales::whereBetween('date', [$salesreport_fromdate, $salesreport_todate])->where('customer_id', '=', $salesreport_customer)->where('soft_delete', '!=', 1)->get();
            $Sales_data = [];
            if($branchwise_report != ''){
                $sales_terms = [];
                foreach ($branchwise_report as $key => $branchwise_datas) {
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
                        'status' => $branchwise_datas->status,
                        'branchheading' => '',
                        'customerheading' => $GetCustomer->name,
                        'fromdateheading' => date('d-M-Y', strtotime($salesreport_fromdate)),
                        'todateheading' => date('d-M-Y', strtotime($salesreport_todate)),

                    );
                }
            }else{

                $Sales_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'customer_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'sales_terms' => '',
                    'status' => '',
                    'branchheading' => '',
                    'customerheading' => $GetCustomer->name,
                    'fromdateheading' => date('d-M-Y', strtotime($salesreport_fromdate)),
                    'todateheading' => date('d-M-Y', strtotime($salesreport_todate)),
                );
            }



        }




        if($salesreport_fromdate && $salesreport_todate && $salesreport_customer && $salesreport_branch){

            $GetCustomer = Customer::findOrFail($salesreport_customer);
            $GetBrach = Branch::findOrFail($salesreport_branch);

            $branchwise_report = Sales::whereBetween('date', [$salesreport_fromdate, $salesreport_todate])->where('customer_id', '=', $salesreport_customer)->where('branch_id', '=', $salesreport_branch)->where('soft_delete', '!=', 1)->get();
            $Sales_data = [];
            if($branchwise_report != ''){
                $sales_terms = [];
                foreach ($branchwise_report as $key => $branchwise_datas) {
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
                        'status' => $branchwise_datas->status,
                        'branchheading' => $GetBrach->shop_name,
                        'customerheading' => $GetCustomer->name,
                        'fromdateheading' => date('d-M-Y', strtotime($salesreport_fromdate)),
                        'todateheading' => date('d-M-Y', strtotime($salesreport_todate)),

                    );
                }
            }else{

                $Sales_data[] = array(
                    'unique_key' => '',
                    'branch_name' => '',
                    'customer_name' => '',
                    'date' => '',
                    'time' => '',
                    'gross_amount' => '',
                    'bill_no' => '',
                    'id' => '',
                    'sales_terms' => '',
                    'status' => '',
                    'branchheading' => $GetBrach->shop_name,
                    'customerheading' => $GetCustomer->name,
                    'fromdateheading' => date('d-M-Y', strtotime($salesreport_fromdate)),
                    'todateheading' => date('d-M-Y', strtotime($salesreport_todate)),
                );
            }



        }




        return view('page.backend.sales.report', compact('Sales_data', 'branch', 'Customer'));


    }








    public function getoldbalanceforSales()
    {
        $sales_customerid = request()->get('sales_customerid');
        $sales_branch_id = request()->get('sales_branch_id');


        $last_idrow = Sales::where('customer_id', '=', $sales_customerid)->where('branch_id', '=', $sales_branch_id)->latest('id')->first();
        if($last_idrow != ""){

            if($last_idrow->sales_paymentpending != NULL){

                $output[] = array(
                    'payment_pending' => $last_idrow->sales_paymentpending,
                    'payment_sales_id' => $last_idrow->id,
                );
            }else if($last_idrow->sales_paymentpending == NULL){

                if($last_idrow->balance_amount != NULL){
                    
                    $output[] = array(
                        'payment_pending' => $last_idrow->balance_amount,
                        'payment_sales_id' => $last_idrow->id,
                    );
                }else if($last_idrow->balance_amount == NULL){

                    $secondlastrow = Sales::orderBy('created_at', 'desc')->where('customer_id', '=', $sales_customerid)->where('branch_id', '=', $sales_branch_id)->skip(1)->take(1)->first();
                    if($secondlastrow->sales_paymentpending != NULL){
                        $output[] = array(
                            'payment_pending' => $secondlastrow->sales_paymentpending,
                            'payment_sales_id' => $secondlastrow->id,
                        );
                    }else {
                        $output[] = array(
                            'payment_pending' => $secondlastrow->balance_amount,
                            'payment_sales_id' => $secondlastrow->id,
                        );
                    }
                    
                }
                
            }
        }else {
            $output[] = array(
                'payment_pending' => '',
                'payment_sales_id' => '',
            );
        }


        echo json_encode($output);
    }


    public function getSalesview()
    {
        $sales_id = request()->get('sales_id');
        $get_Sales = Sales::where('soft_delete', '!=', 1)
                                    ->where('id', '=', $sales_id)
                                    ->get();
        $output = [];
        foreach ($get_Sales as $key => $get_Sales_data) {

            $customer_namearr = Customer::where('id', '=', $get_Sales_data->customer_id)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->first();
            $branch_namearr = Branch::where('id', '=', $get_Sales_data->branch_id)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->first();
            $bank_namearr = Bank::where('id', '=', $get_Sales_data->bank_id)->where('soft_delete', '!=', 1)->where('status', '!=', 1)->first();
            if($bank_namearr != ""){
                $bank_name = $bank_namearr->name;
            }else {
                $bank_name = '';
            }

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

                'sales_bank_namedata' => $bank_name,
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




    public function getbranchwiseProducts()
    {

        $sales_branch_id = request()->get('sales_branch_id');

        $GetProduct = Product::where('soft_delete', '!=', 1)->where('branchtable_id', '=', $sales_branch_id)->get();
        $output = [];
        foreach ($GetProduct as $key => $GetProducts) {
            $ProductList = Productlist::findOrFail($GetProducts->productlist_id);


            $output[] = array(
                'productlistid' => $ProductList->id,
                'productlist_name' => $ProductList->name,
                'available_stockin_bag' => $GetProducts->available_stockin_bag,
                'available_stockin_kilograms' => $GetProducts->available_stockin_kilograms,
            );

        }
        echo json_encode($output);
    }

    public function getProductsdetail()
    {
        $sales_product_id = request()->get('sales_product_id');
        $sales_branch_id = request()->get('sales_branch_id');
        
        $GetProduct[] = Product::where('soft_delete', '!=', 1)->where('productlist_id', '=', $sales_product_id)->where('branchtable_id', '=', $sales_branch_id)->get();
        echo json_encode($GetProduct);
    }



    public function oldbalanceforsalespayment()
    {
        $customer_id = request()->get('spayment_customer_id');
        $branch_id = request()->get('spayment_branch_id');



        $last_idrow = Sales::where('customer_id', '=', $customer_id)->where('branch_id', '=', $branch_id)->latest('id')->first();
        if($last_idrow != ""){

            if($last_idrow->sales_paymentpending != NULL){

                $output[] = array(
                    'payment_pending' => $last_idrow->sales_paymentpending,
                    'payment_sales_id' => $last_idrow->id,
                );
            }else if($last_idrow->sales_paymentpending == NULL){

                if($last_idrow->balance_amount != NULL){
                    
                    $output[] = array(
                        'payment_pending' => $last_idrow->balance_amount,
                        'payment_sales_id' => $last_idrow->id,
                    );
                }else if($last_idrow->balance_amount == NULL){

                    $secondlastrow = Sales::orderBy('created_at', 'desc')->where('customer_id', '=', $customer_id)->where('branch_id', '=', $branch_id)->skip(1)->take(1)->first();
                    if($secondlastrow->sales_paymentpending != NULL){
                        $output[] = array(
                            'payment_pending' => $secondlastrow->sales_paymentpending,
                            'payment_sales_id' => $secondlastrow->id,
                        );
                    }else {
                        $output[] = array(
                            'payment_pending' => $secondlastrow->balance_amount,
                            'payment_sales_id' => $secondlastrow->id,
                        );
                    }
                    
                }
                
            }
        }else {
            $output[] = array(
                'payment_pending' => '',
                'payment_sales_id' => '',
            );
        }



        echo json_encode($output);
    }


}

