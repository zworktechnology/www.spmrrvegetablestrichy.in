<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Sales;
use App\Models\Productlist;
use App\Models\SalesProduct;
use App\Models\Salespayment;
use App\Models\BranchwiseBalance;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function index()
    {
        $data = Customer::where('soft_delete', '!=', 1)->get();

        $customerarr_data = [];
        foreach ($data as $key => $datas) {
            $Customer_name = Customer::findOrFail($datas->id);

            // Total Sale
            $total_sale_amt = Sales::where('soft_delete', '!=', 1)->where('customer_id', '=', $datas->id)->sum('gross_amount');
            if($total_sale_amt != ""){
                $tot_saleAmount = $total_sale_amt;
            }else {
                $tot_saleAmount = '0';
            }


            // Total Paid
            $total_paid = Sales::where('soft_delete', '!=', 1)->where('customer_id', '=', $datas->id)->sum('paid_amount');
            if($total_paid != ""){
                $total_paid_Amount = $total_paid;
            }else {
                $total_paid_Amount = '0';
            }
            $payment_total_paid = Salespayment::where('soft_delete', '!=', 1)->where('customer_id', '=', $datas->id)->sum('amount');
            if($payment_total_paid != ""){
                $total_payment_paid = $payment_total_paid;
            }else {
                $total_payment_paid = '0';
            }
            $total_amount_paid = $total_paid_Amount + $total_payment_paid;


            // Total Balance
            $total_balance = $tot_saleAmount - $total_amount_paid;

            $customerarr_data[] = array(
                'unique_key' => $datas->unique_key,
                'name' => $Customer_name->name,
                'contact_number' => $datas->contact_number,
                'shop_name' => $datas->shop_name,
                'status' => $datas->status,
                'id' => $datas->id,
                'total_sale_amt' => $tot_saleAmount,
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
            $Customer_array = Customer::where('soft_delete', '!=', 1)->get();
            foreach ($Customer_array as $key => $Customer_arra) {


                $last_idrow = BranchwiseBalance::where('customer_id', '=', $Customer_arra->id)->where('branch_id', '=', $alldata_branchs->id)->first();

                if($last_idrow != ""){
                    if($last_idrow->sales_balance != NULL){
                        $tot_balace = $last_idrow->sales_balance;
        
                    }else {

                        $tot_balace = 0;
                       
                    }

                }else {
                    $tot_balace = 0;
                }

                $tot_balance_Arr[] = array(
                    'customer_name' => $Customer_arra->name,
                    'branch_name' => $alldata_branchs->shop_name,
                    'customer_id' => $Customer_arra->id,
                    'balance_amount' => $tot_balace
                );

            }
        }

        $allbranch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();

        $total_sale_amount = Sales::where('soft_delete', '!=', 1)->sum('gross_amount');
            if($total_sale_amount != ""){
                $totsaleAmount = $total_sale_amount;
            }else {
                $totsaleAmount = '0';
            }


            // Total Paid
            $total_salepaid = Sales::where('soft_delete', '!=', 1)->sum('paid_amount');
            if($total_salepaid != ""){
                $total_salepaid_Amount = $total_salepaid;
            }else {
                $total_salepaid_Amount = '0';
            }
            $payment_saletotal_paid = Salespayment::where('soft_delete', '!=', 1)->sum('amount');
            if($payment_saletotal_paid != ""){
                $total_sakepayment_paid = $payment_saletotal_paid;
            }else {
                $total_sakepayment_paid = '0';
            }
            $total_saleamount_paid = $total_salepaid_Amount + $total_sakepayment_paid;


            // Total Balance
            $saletotal_balance = $totsaleAmount - $total_saleamount_paid;

        return view('page.backend.customer.index', compact('customerarr_data', 'tot_balance_Arr', 'allbranch', 'totsaleAmount', 'total_saleamount_paid', 'saletotal_balance'));
    }


    public function branchdata($branch_id) 
    {
        $data = Customer::where('soft_delete', '!=', 1)->get();

        $customerarr_data = [];
        foreach ($data as $key => $datas) {
            $Customer_name = Customer::findOrFail($datas->id);

            // Total Sale
            $total_sale_amt = Sales::where('soft_delete', '!=', 1)->where('customer_id', '=', $datas->id)->where('branch_id', '=', $branch_id)->sum('gross_amount');
            if($total_sale_amt != ""){
                $tot_saleAmount = $total_sale_amt;
            }else {
                $tot_saleAmount = '0';
            }


            // Total Paid
            $total_paid = Sales::where('soft_delete', '!=', 1)->where('customer_id', '=', $datas->id)->where('branch_id', '=', $branch_id)->sum('paid_amount');
            if($total_paid != ""){
                $total_paid_Amount = $total_paid;
            }else {
                $total_paid_Amount = '0';
            }
            $payment_total_paid = Salespayment::where('soft_delete', '!=', 1)->where('customer_id', '=', $datas->id)->where('branch_id', '=', $branch_id)->sum('amount');
            if($payment_total_paid != ""){
                $total_payment_paid = $payment_total_paid;
            }else {
                $total_payment_paid = '0';
            }
            $total_amount_paid = $total_paid_Amount + $total_payment_paid;


            // Total Balance
            $total_balance = $tot_saleAmount - $total_amount_paid;

            $customerarr_data[] = array(
                'unique_key' => $datas->unique_key,
                'name' => $Customer_name->name,
                'contact_number' => $datas->contact_number,
                'shop_name' => $datas->shop_name,
                'status' => $datas->status,
                'id' => $datas->id,
                'total_sale_amt' => $tot_saleAmount,
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
            $Customer_array = Customer::where('soft_delete', '!=', 1)->get();
            foreach ($Customer_array as $key => $Customer_arra) {


                $last_idrow = BranchwiseBalance::where('customer_id', '=', $Customer_arra->id)->where('branch_id', '=', $alldata_branchs->id)->first();

                if($last_idrow != ""){
                    if($last_idrow->sales_balance != NULL){
                        $tot_balace = $last_idrow->sales_balance;
        
                    }else {

                        $tot_balace = 0;
                       
                    }

                }else {
                    $tot_balace = 0;
                }

                $tot_balance_Arr[] = array(
                    'customer_name' => $Customer_arra->name,
                    'branch_name' => $alldata_branchs->shop_name,
                    'customer_id' => $Customer_arra->id,
                    'balance_amount' => $tot_balace
                );

            }
        }
        $allbranch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();

            $total_sale_amount = Sales::where('soft_delete', '!=', 1)->where('branch_id', '=', $branch_id)->sum('gross_amount');
            if($total_sale_amount != ""){
                $totsaleAmount = $total_sale_amount;
            }else {
                $totsaleAmount = '0';
            }


            // Total Paid
            $total_salepaid = Sales::where('soft_delete', '!=', 1)->where('branch_id', '=', $branch_id)->sum('paid_amount');
            if($total_salepaid != ""){
                $total_salepaid_Amount = $total_salepaid;
            }else {
                $total_salepaid_Amount = '0';
            }
            $payment_saletotal_paid = Salespayment::where('soft_delete', '!=', 1)->where('branch_id', '=', $branch_id)->sum('amount');
            if($payment_saletotal_paid != ""){
                $total_sakepayment_paid = $payment_saletotal_paid;
            }else {
                $total_sakepayment_paid = '0';
            }
            $total_saleamount_paid = $total_salepaid_Amount + $total_sakepayment_paid;


            // Total Balance
            $saletotal_balance = $totsaleAmount - $total_saleamount_paid;

        return view('page.backend.customer.index', compact('customerarr_data', 'tot_balance_Arr', 'allbranch', 'totsaleAmount', 'total_saleamount_paid', 'saletotal_balance'));
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


    public function view($unique_key)
    {
        $CustomerData = Customer::where('unique_key', '=', $unique_key)->first();

        $today = Carbon::now()->format('Y-m-d');
        $data = Sales::where('customer_id', '=', $CustomerData->id)->where('soft_delete', '!=', 1)->get();
        $Sales_data = [];
        foreach ($data as $key => $datas) {

            $branch_name = Branch::findOrFail($datas->branch_id);
            $SalesProducts = SalesProduct::where('sales_id', '=', $datas->id)->get();
            foreach ($SalesProducts as $key => $SalesProducts_arr) {

                $productlist_ID = Productlist::findOrFail($SalesProducts_arr->productlist_id);
                $terms[] = array(
                    'bag' => $SalesProducts_arr->bagorkg,
                    'kgs' => $SalesProducts_arr->count,
                    'price_per_kg' => $SalesProducts_arr->price_per_kg,
                    'total_price' => $SalesProducts_arr->total_price,
                    'product_name' => $productlist_ID->name,
                    'sales_id' => $SalesProducts_arr->sales_id,

                );

            }


            $Sales_data[] = array(
                'unique_key' => $datas->unique_key,
                'branch_name' => $branch_name->shop_name,
                'Customer_name' => $CustomerData->name,
                'date' => $datas->date,
                'gross_amount' => $datas->gross_amount,
                'paid_amount' => $datas->paid_amount,
                'bill_no' => $datas->bill_no,
                'sales_order' => $datas->sales_order,
                'id' => $datas->id,
                'terms' => $terms,
            );
        }

        $branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $Customer = Customer::where('soft_delete', '!=', 1)->get();


        $Customername = $CustomerData->name;
        $customer_id = $CustomerData->id;
        $unique_key = $CustomerData->unique_key;




        $Salespayment = Salespayment::where('customer_id', '=', $CustomerData->id)->where('soft_delete', '!=', 1)->get();
        $salesPayment_data = [];

        foreach ($Salespayment as $key => $Salespayments) {
            $branch_name = Branch::findOrFail($Salespayments->branch_id);


            $salesPayment_data[] = array(
                'unique_key' => $Salespayments->unique_key,
                'branch_name' => $branch_name->shop_name,
                'customer_name' => $CustomerData->name,
                'date' => $Salespayments->date,
                'paid_amount' => $Salespayments->amount,
                'salespayment_discount' => $Salespayments->salespayment_discount,
            );
        }


        $fromdate = '';
        $todate = '';
        $branchid = '';
        $customerid = $CustomerData->id;


        return view('page.backend.customer.view', compact('CustomerData', 'Sales_data', 'branch', 'Customer', 'Customername', 'customer_id', 'unique_key', 'today',
                     'fromdate','todate', 'branchid', 'customerid', 'salesPayment_data'));
    }



    public function viewfilter(Request $request)
    {
        $fromdate = $request->get('fromdate');
        $todate = $request->get('todate');
        $branchid = $request->get('branchid');
        $customerid = $request->get('customerid');
        $viewall = $request->get('viewall');
        $unique_key = $request->get('uniquekey');
        $CustomerData = Customer::where('unique_key', '=', $unique_key)->first();

        $branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $Customer = Customer::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        

        if($branchid){

            $GetBranch = Branch::findOrFail($branchid);
            $Sales_data = [];

            $data = Sales::where('branch_id', '=', $branchid)->where('customer_id', '=', $customerid)->where('soft_delete', '!=', 1)->get();
            if($data != ''){

                $terms = [];
                foreach ($data as $key => $datas) {

                    $branch_name = Branch::findOrFail($datas->branch_id);
                    $SalesProducts = SalesProduct::where('sales_id', '=', $datas->id)->get();
                    foreach ($SalesProducts as $key => $SalesProducts_arr) {
        
                        $productlist_ID = Productlist::findOrFail($SalesProducts_arr->productlist_id);
                        $terms[] = array(
                            'bag' => $SalesProducts_arr->bagorkg,
                            'kgs' => $SalesProducts_arr->count,
                            'price_per_kg' => $SalesProducts_arr->price_per_kg,
                            'total_price' => $SalesProducts_arr->total_price,
                            'product_name' => $productlist_ID->name,
                            'sales_id' => $SalesProducts_arr->sales_id,
        
                        );
        
                    }
        
        
                    $Sales_data[] = array(
                        'unique_key' => $datas->unique_key,
                        'branch_name' => $branch_name->shop_name,
                        'Customer_name' => $CustomerData->name,
                        'date' => $datas->date,
                        'gross_amount' => $datas->gross_amount,
                        'paid_amount' => $datas->paid_amount,
                        'bill_no' => $datas->bill_no,
                        'sales_order' => $datas->sales_order,
                        'id' => $datas->id,
                        'terms' => $terms,
                    );
                }
            }


            $salesPayment_data = [];

            $Salespayment = Salespayment::where('branch_id', '=', $branchid)->where('customer_id', '=', $CustomerData->id)->where('soft_delete', '!=', 1)->get();
            if($Salespayment != ''){
                
                foreach ($Salespayment as $key => $Salespayments) {
                    $branch_name = Branch::findOrFail($Salespayments->branch_id);


                    $salesPayment_data[] = array(
                        'unique_key' => $Salespayments->unique_key,
                        'branch_name' => $branch_name->shop_name,
                        'customer_name' => $CustomerData->name,
                        'date' => $Salespayments->date,
                        'paid_amount' => $Salespayments->amount,
                        'salespayment_discount' => $Salespayments->salespayment_discount,
                    );
                }
            }



        }

        
        if($fromdate){
            $Sales_data = [];

            $data = Sales::where('date', '=', $fromdate)->where('customer_id', '=', $customerid)->where('soft_delete', '!=', 1)->get();
            if($data != ''){


                $terms = [];
                foreach ($data as $key => $datas) {

                    $branch_name = Branch::findOrFail($datas->branch_id);
                    $SalesProducts = SalesProduct::where('sales_id', '=', $datas->id)->get();
                    foreach ($SalesProducts as $key => $SalesProducts_arr) {
        
                        $productlist_ID = Productlist::findOrFail($SalesProducts_arr->productlist_id);
                        $terms[] = array(
                            'bag' => $SalesProducts_arr->bagorkg,
                            'kgs' => $SalesProducts_arr->count,
                            'price_per_kg' => $SalesProducts_arr->price_per_kg,
                            'total_price' => $SalesProducts_arr->total_price,
                            'product_name' => $productlist_ID->name,
                            'sales_id' => $SalesProducts_arr->sales_id,
        
                        );
        
                    }
        
        
                    $Sales_data[] = array(
                        'unique_key' => $datas->unique_key,
                        'branch_name' => $branch_name->shop_name,
                        'Customer_name' => $CustomerData->name,
                        'date' => $datas->date,
                        'gross_amount' => $datas->gross_amount,
                        'paid_amount' => $datas->paid_amount,
                        'bill_no' => $datas->bill_no,
                        'sales_order' => $datas->sales_order,
                        'id' => $datas->id,
                        'terms' => $terms,
                    );
                }
            }

            

            $salesPayment_data = [];

            $Salespayment = Salespayment::where('date', '=', $fromdate)->where('customer_id', '=', $CustomerData->id)->where('soft_delete', '!=', 1)->get();
            if($Salespayment != ''){
                
                foreach ($Salespayment as $key => $Salespayments) {
                    $branch_name = Branch::findOrFail($Salespayments->branch_id);


                    $salesPayment_data[] = array(
                        'unique_key' => $Salespayments->unique_key,
                        'branch_name' => $branch_name->shop_name,
                        'supplier_name' => $SupplierData->name,
                        'date' => $Salespayments->date,
                        'paid_amount' => $Salespayments->amount,
                        'salespayment_discount' => $Salespayments->salespayment_discount,
                    );
                }
            }


        }
        

        if($todate){
            $Sales_data = [];

            $data = Sales::where('date', '=', $todate)->where('customer_id', '=', $customerid)->where('soft_delete', '!=', 1)->get();
            if($data != ''){


                $terms = [];
                foreach ($data as $key => $datas) {

                    $branch_name = Branch::findOrFail($datas->branch_id);
                    $SalesProducts = SalesProduct::where('sales_id', '=', $datas->id)->get();
                    foreach ($SalesProducts as $key => $SalesProducts_arr) {
        
                        $productlist_ID = Productlist::findOrFail($SalesProducts_arr->productlist_id);
                        $terms[] = array(
                            'bag' => $SalesProducts_arr->bagorkg,
                            'kgs' => $SalesProducts_arr->count,
                            'price_per_kg' => $SalesProducts_arr->price_per_kg,
                            'total_price' => $SalesProducts_arr->total_price,
                            'product_name' => $productlist_ID->name,
                            'sales_id' => $SalesProducts_arr->sales_id,
        
                        );
        
                    }
        
        
                    $Sales_data[] = array(
                        'unique_key' => $datas->unique_key,
                        'branch_name' => $branch_name->shop_name,
                        'Customer_name' => $CustomerData->name,
                        'date' => $datas->date,
                        'gross_amount' => $datas->gross_amount,
                        'paid_amount' => $datas->paid_amount,
                        'bill_no' => $datas->bill_no,
                        'sales_order' => $datas->sales_order,
                        'id' => $datas->id,
                        'terms' => $terms,
                    );
                }
            }


            $salesPayment_data = [];

            $Salespayment = Salespayment::where('date', '=', $todate)->where('customer_id', '=', $CustomerData->id)->where('soft_delete', '!=', 1)->get();
            if($Salespayment != ''){
                
                foreach ($Salespayment as $key => $Salespayments) {
                    $branch_name = Branch::findOrFail($Salespayments->branch_id);


                    $salesPayment_data[] = array(
                        'unique_key' => $Salespayments->unique_key,
                        'branch_name' => $branch_name->shop_name,
                        'customer_name' => $CustomerData->name,
                        'date' => $Salespayments->date,
                        'paid_amount' => $Salespayments->amount,
                        'salespayment_discount' => $Salespayments->salespayment_discount,
                    );
                }
            }


        }
        

        if($fromdate && $todate){
            $Sales_data = [];

            $data = Sales::whereBetween('date', [$fromdate, $todate])->where('customer_id', '=', $customerid)->where('soft_delete', '!=', 1)->get();
            if($data != ''){


                $terms = [];
                foreach ($data as $key => $datas) {

                    $branch_name = Branch::findOrFail($datas->branch_id);
                    $SalesProducts = SalesProduct::where('sales_id', '=', $datas->id)->get();
                    foreach ($SalesProducts as $key => $SalesProducts_arr) {
        
                        $productlist_ID = Productlist::findOrFail($SalesProducts_arr->productlist_id);
                        $terms[] = array(
                            'bag' => $SalesProducts_arr->bagorkg,
                            'kgs' => $SalesProducts_arr->count,
                            'price_per_kg' => $SalesProducts_arr->price_per_kg,
                            'total_price' => $SalesProducts_arr->total_price,
                            'product_name' => $productlist_ID->name,
                            'sales_id' => $SalesProducts_arr->sales_id,
        
                        );
        
                    }
        
        
                    $Sales_data[] = array(
                        'unique_key' => $datas->unique_key,
                        'branch_name' => $branch_name->shop_name,
                        'Customer_name' => $CustomerData->name,
                        'date' => $datas->date,
                        'gross_amount' => $datas->gross_amount,
                        'paid_amount' => $datas->paid_amount,
                        'bill_no' => $datas->bill_no,
                        'sales_order' => $datas->sales_order,
                        'id' => $datas->id,
                        'terms' => $terms,
                    );
                }
            }



            $salesPayment_data = [];

            $Salespayment = Salespayment::whereBetween('date', [$fromdate, $todate])->where('customer_id', '=', $CustomerData->id)->where('soft_delete', '!=', 1)->get();
            if($Salespayment != ''){
                
                foreach ($Salespayment as $key => $Salespayments) {
                    $branch_name = Branch::findOrFail($Salespayments->branch_id);


                    $salesPayment_data[] = array(
                        'unique_key' => $Salespayments->unique_key,
                        'branch_name' => $branch_name->shop_name,
                        'customer_name' => $CustomerData->name,
                        'date' => $Salespayments->date,
                        'paid_amount' => $Salespayments->amount,
                        'salespayment_discount' => $Salespayments->salespayment_discount,
                    );
                }
            }
        }

        

        if($fromdate && $branchid){
            $Sales_data = [];

            $data = Sales::where('date', '=', $fromdate)->where('branch_id', '=', $branchid)->where('customer_id', '=', $customerid)->where('soft_delete', '!=', 1)->get();
            if($data != ''){


                $terms = [];
                foreach ($data as $key => $datas) {

                    $branch_name = Branch::findOrFail($datas->branch_id);
                    $SalesProducts = SalesProduct::where('sales_id', '=', $datas->id)->get();
                    foreach ($SalesProducts as $key => $SalesProducts_arr) {
        
                        $productlist_ID = Productlist::findOrFail($SalesProducts_arr->productlist_id);
                        $terms[] = array(
                            'bag' => $SalesProducts_arr->bagorkg,
                            'kgs' => $SalesProducts_arr->count,
                            'price_per_kg' => $SalesProducts_arr->price_per_kg,
                            'total_price' => $SalesProducts_arr->total_price,
                            'product_name' => $productlist_ID->name,
                            'sales_id' => $SalesProducts_arr->sales_id,
        
                        );
        
                    }
        
        
                    $Sales_data[] = array(
                        'unique_key' => $datas->unique_key,
                        'branch_name' => $branch_name->shop_name,
                        'Customer_name' => $CustomerData->name,
                        'date' => $datas->date,
                        'gross_amount' => $datas->gross_amount,
                        'paid_amount' => $datas->paid_amount,
                        'bill_no' => $datas->bill_no,
                        'sales_order' => $datas->sales_order,
                        'id' => $datas->id,
                        'terms' => $terms,
                    );
                }
            }


            $salesPayment_data = [];

            $Salespayment = Salespayment::where('date', '=', $fromdate)->where('branch_id', '=', $branchid)->where('customer_id', '=', $CustomerData->id)->where('soft_delete', '!=', 1)->get();
            if($Salespayment != ''){
                
                foreach ($Salespayment as $key => $Salespayments) {
                    $branch_name = Branch::findOrFail($Salespayments->branch_id);


                    $salesPayment_data[] = array(
                        'unique_key' => $Salespayments->unique_key,
                        'branch_name' => $branch_name->shop_name,
                        'customer_name' => $CustomerData->name,
                        'date' => $Salespayments->date,
                        'paid_amount' => $Salespayments->amount,
                        'salespayment_discount' => $Salespayments->salespayment_discount,
                    );
                }
            }
        }

      

        if($todate && $branchid){
            $Sales_data = [];

            $data = Sales::where('date', '=', $todate)->where('branch_id', '=', $branchid)->where('customer_id', '=', $customerid)->where('soft_delete', '!=', 1)->get();
            if($data != ''){


                $terms = [];
                foreach ($data as $key => $datas) {

                    $branch_name = Branch::findOrFail($datas->branch_id);
                    $SalesProducts = SalesProduct::where('sales_id', '=', $datas->id)->get();
                    foreach ($SalesProducts as $key => $SalesProducts_arr) {
        
                        $productlist_ID = Productlist::findOrFail($SalesProducts_arr->productlist_id);
                        $terms[] = array(
                            'bag' => $SalesProducts_arr->bagorkg,
                            'kgs' => $SalesProducts_arr->count,
                            'price_per_kg' => $SalesProducts_arr->price_per_kg,
                            'total_price' => $SalesProducts_arr->total_price,
                            'product_name' => $productlist_ID->name,
                            'sales_id' => $SalesProducts_arr->sales_id,
        
                        );
        
                    }
        
        
                    $Sales_data[] = array(
                        'unique_key' => $datas->unique_key,
                        'branch_name' => $branch_name->shop_name,
                        'Customer_name' => $CustomerData->name,
                        'date' => $datas->date,
                        'gross_amount' => $datas->gross_amount,
                        'paid_amount' => $datas->paid_amount,
                        'bill_no' => $datas->bill_no,
                        'sales_order' => $datas->sales_order,
                        'id' => $datas->id,
                        'terms' => $terms,
                    );
                }
            }

            $salesPayment_data = [];

            $Salespayment = Salespayment::where('date', '=', $todate)->where('branch_id', '=', $branchid)->where('customer_id', '=', $CustomerData->id)->where('soft_delete', '!=', 1)->get();
            if($Salespayment != ''){
                
                foreach ($Salespayment as $key => $Salespayments) {
                    $branch_name = Branch::findOrFail($Salespayments->branch_id);


                    $salesPayment_data[] = array(
                        'unique_key' => $Salespayments->unique_key,
                        'branch_name' => $branch_name->shop_name,
                        'customer_name' => $CustomerData->name,
                        'date' => $Salespayments->date,
                        'paid_amount' => $Salespayments->amount,
                        'salespayment_discount' => $Salespayments->salespayment_discount,
                    );
                }
            }


        }
        


        if($fromdate && $todate && $branchid){
            $Sales_data = [];

            $data = Sales::whereBetween('date', [$fromdate, $todate])->where('branch_id', '=', $branchid)->where('customer_id', '=', $customerid)->where('soft_delete', '!=', 1)->get();
            if($data != ''){


                $terms = [];
                foreach ($data as $key => $datas) {

                    $branch_name = Branch::findOrFail($datas->branch_id);
                    $SalesProducts = SalesProduct::where('sales_id', '=', $datas->id)->get();
                    foreach ($SalesProducts as $key => $SalesProducts_arr) {
        
                        $productlist_ID = Productlist::findOrFail($SalesProducts_arr->productlist_id);
                        $terms[] = array(
                            'bag' => $SalesProducts_arr->bagorkg,
                            'kgs' => $SalesProducts_arr->count,
                            'price_per_kg' => $SalesProducts_arr->price_per_kg,
                            'total_price' => $SalesProducts_arr->total_price,
                            'product_name' => $productlist_ID->name,
                            'sales_id' => $SalesProducts_arr->sales_id,
        
                        );
        
                    }
        
        
                    $Sales_data[] = array(
                        'unique_key' => $datas->unique_key,
                        'branch_name' => $branch_name->shop_name,
                        'Customer_name' => $CustomerData->name,
                        'date' => $datas->date,
                        'gross_amount' => $datas->gross_amount,
                        'paid_amount' => $datas->paid_amount,
                        'bill_no' => $datas->bill_no,
                        'sales_order' => $datas->sales_order,
                        'id' => $datas->id,
                        'terms' => $terms,
                    );
                }
            }


            $salesPayment_data = [];

            $Salespayment = Salespayment::whereBetween('date', [$fromdate, $todate])->where('branch_id', '=', $branchid)->where('customer_id', '=', $CustomerData->id)->where('soft_delete', '!=', 1)->get();
            if($Salespayment != ''){
                
                foreach ($Salespayment as $key => $Salespayments) {
                    $branch_name = Branch::findOrFail($Salespayments->branch_id);


                    $salesPayment_data[] = array(
                        'unique_key' => $Salespayments->unique_key,
                        'branch_name' => $branch_name->shop_name,
                        'customer_name' => $CustomerData->name,
                        'date' => $Salespayments->date,
                        'paid_amount' => $Salespayments->amount,
                        'salespayment_discount' => $Salespayments->salespayment_discount,
                    );
                }
            }

        }


        if($viewall == 'all'){
            $data = Sales::where('customer_id', '=', $CustomerData->id)->where('soft_delete', '!=', 1)->get();
            $Sales_data = [];
            foreach ($data as $key => $datas) {

                $branch_name = Branch::findOrFail($datas->branch_id);
                $SalesProducts = SalesProduct::where('sales_id', '=', $datas->id)->get();
                foreach ($SalesProducts as $key => $SalesProducts_arr) {

                    $productlist_ID = Productlist::findOrFail($SalesProducts_arr->productlist_id);
                    $terms[] = array(
                        'bag' => $SalesProducts_arr->bagorkg,
                        'kgs' => $SalesProducts_arr->count,
                        'price_per_kg' => $SalesProducts_arr->price_per_kg,
                        'total_price' => $SalesProducts_arr->total_price,
                        'product_name' => $productlist_ID->name,
                        'sales_id' => $SalesProducts_arr->sales_id,

                    );

                }


                $Sales_data[] = array(
                    'unique_key' => $datas->unique_key,
                    'branch_name' => $branch_name->shop_name,
                    'Customer_name' => $CustomerData->name,
                    'date' => $datas->date,
                    'gross_amount' => $datas->gross_amount,
                    'paid_amount' => $datas->paid_amount,
                    'bill_no' => $datas->bill_no,
                    'sales_order' => $datas->sales_order,
                    'id' => $datas->id,
                    'terms' => $terms,
                );
            }


            $Salespayment = Salespayment::where('customer_id', '=', $CustomerData->id)->where('soft_delete', '!=', 1)->get();
            $salesPayment_data = [];
    
            foreach ($Salespayment as $key => $Salespayments) {
                $branch_name = Branch::findOrFail($Salespayments->branch_id);
    
    
                $salesPayment_data[] = array(
                    'unique_key' => $Salespayments->unique_key,
                    'branch_name' => $branch_name->shop_name,
                    'customer_name' => $CustomerData->name,
                    'date' => $Salespayments->date,
                    'paid_amount' => $Salespayments->amount,
                    'salespayment_discount' => $Salespayments->salespayment_discount,
                );
            }
    
        }


      




        $Customername = $CustomerData->name;
        $customer_id = $CustomerData->id;
        $unique_key = $CustomerData->unique_key;


        return view('page.backend.customer.view', compact('Sales_data', 'branch', 'Customer', 'fromdate','todate', 'branchid', 'customerid',
                         'Customername', 'customer_id', 'unique_key', 'salesPayment_data'));
    }





    public function delete($unique_key)
    {
        $data = Customer::where('unique_key', '=', $unique_key)->first();

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('customer.index')->with('soft_destroy', 'Successfully deleted the customer !');
    }



    public function getCustomers()
    {
        $GetCustomer = Customer::orderBy('name', 'ASC')->where('soft_delete', '!=', 1)->get();
        $userData['data'] = $GetCustomer;
        echo json_encode($userData);
    }


    public function checkduplicate(Request $request)
    {
        if(request()->get('query'))
        {
            $query = request()->get('query');
            $supplierdata = Customer::where('contact_number', '=', $query)->first();
            
            $userData['data'] = $supplierdata;
            echo json_encode($userData);
        }
    }

}
