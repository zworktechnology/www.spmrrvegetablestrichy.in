<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Branch;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Productlist;
use App\Models\PurchasePayment;
use App\Models\BranchwiseBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use PDF;

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

            $total_discount = PurchasePayment::where('soft_delete', '!=', 1)->where('supplier_id', '=', $datas->id)->sum('purchasepayment_discount');
            if($total_discount != ""){
                $total_discount_amont = $total_discount;
            }else {
                $total_discount_amont = '0';
            }

            $total_amount_paid = $total_paid_Amount + $total_payment_paid + $total_discount_amont;
            


            // Total Balance
            $total_balance = $tot_purchaseAmount - $total_amount_paid;
            
            $LastPattityal = Purchase::where('supplier_id', '=', $datas->id)->where('gross_amount', '=', NULL)->where('purchase_order', '=', NULL)->orderBy('date', 'asc')->where('soft_delete', '!=', 1)->first();
            if($LastPattityal){
                $last_date = $LastPattityal->date;
            }else {
                $last_date = '';
            }


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
                'total_discount_amont' => $total_discount_amont,
                'LastPattityal' => $last_date,
            );


            $price = array();
            foreach ($supplierarr_data as $key => $row)
            {
                $price[$key] = $row['total_purchase_amt'];
            }
            array_multisort($price, SORT_DESC, $supplierarr_data);

        }


        $alldata_branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $tot_balance_Arr = [];

        foreach ($alldata_branch as $key => $alldata_branchs) {
            $Supplier_array = Supplier::where('soft_delete', '!=', 1)->get();
            foreach ($Supplier_array as $key => $Supplier_arra) {

        $last_idrow = BranchwiseBalance::where('supplier_id', '=', $Supplier_arra->id)->where('branch_id', '=', $alldata_branchs->id)->first();


        

        if($last_idrow != ""){
            if($last_idrow->purchase_balance != NULL){
                $tot_balace = $last_idrow->purchase_balance;

            }else {

                $tot_balace = 0;
                
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


        $allbranch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();

        $total_purchase_amount = Purchase::where('soft_delete', '!=', 1)->sum('gross_amount');
        if($total_purchase_amount != ""){
            $total_purchaseAmount = $total_purchase_amount;
        }else {
            $total_purchaseAmount = '0';
        }


        $total_amuntpaid = Purchase::where('soft_delete', '!=', 1)->sum('paid_amount');
        if($total_amuntpaid != ""){
            $totalpaid_Amount = $total_amuntpaid;
        }else {
            $totalpaid_Amount = '0';
        }
        $paymenttotal_paid = PurchasePayment::where('soft_delete', '!=', 1)->sum('amount');
        if($paymenttotal_paid != ""){
            $totalpayment_paid = $paymenttotal_paid;
        }else {
            $totalpayment_paid = '0';
        }


        $discountpaid = PurchasePayment::where('soft_delete', '!=', 1)->sum('purchasepayment_discount');
        if($discountpaid != ""){
            $discount_paid = $discountpaid;
        }else {
            $discount_paid = '0';
        }

        $totalamount_paid = $totalpaid_Amount + $totalpayment_paid + $discount_paid;
        


        // Total Balance
        $totalbalance = $total_purchaseAmount - $totalamount_paid;

        return view('page.backend.supplier.index', compact('supplierarr_data', 'tot_balance_Arr', 'allbranch', 'total_purchaseAmount', 'totalamount_paid', 'totalbalance'));
    }


    public function branchdata($branch_id) 
    {

        $data = Supplier::where('soft_delete', '!=', 1)->get();
        $supplierarr_data = [];
        foreach ($data as $key => $datas) {

            $supplier_name = Supplier::findOrFail($datas->id);
            // Grand total
            $total_purchase_amt = Purchase::where('soft_delete', '!=', 1)->where('supplier_id', '=', $datas->id)->where('branch_id', '=', $branch_id)->sum('gross_amount');
            if($total_purchase_amt != ""){
                $tot_purchaseAmount = $total_purchase_amt;
            }else {
                $tot_purchaseAmount = '0';
            }

            // Total Paid
            $total_paid = Purchase::where('soft_delete', '!=', 1)->where('supplier_id', '=', $datas->id)->where('branch_id', '=', $branch_id)->sum('paid_amount');
            if($total_paid != ""){
                $total_paid_Amount = $total_paid;
            }else {
                $total_paid_Amount = '0';
            }
            $payment_total_paid = PurchasePayment::where('soft_delete', '!=', 1)->where('supplier_id', '=', $datas->id)->where('branch_id', '=', $branch_id)->sum('amount');
            if($payment_total_paid != ""){
                $total_payment_paid = $payment_total_paid;
            }else {
                $total_payment_paid = '0';
            }

            $total_discount = PurchasePayment::where('soft_delete', '!=', 1)->where('supplier_id', '=', $datas->id)->where('branch_id', '=', $branch_id)->sum('purchasepayment_discount');
            if($total_discount != ""){
                $total_discount_amont = $total_discount;
            }else {
                $total_discount_amont = '0';
            }

            $total_amount_paid = $total_paid_Amount + $total_payment_paid + $total_discount_amont;
            


            // Total Balance
            $total_balance = $tot_purchaseAmount - $total_amount_paid;
            
            $LastPattityal = Purchase::where('supplier_id', '=', $datas->id)->where('gross_amount', '=', NULL)->where('purchase_order', '=', NULL)->orderBy('date', 'asc')->where('soft_delete', '!=', 1)->first();
            if($LastPattityal){
                $last_date = $LastPattityal->date;
            }else {
                $last_date = '';
            }


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
                'total_discount_amont' => $total_discount_amont,
                'LastPattityal' => $last_date,
            );


            $price = array();
            foreach ($supplierarr_data as $key => $row)
            {
                $price[$key] = $row['total_purchase_amt'];
            }
            array_multisort($price, SORT_DESC, $supplierarr_data);

        }



        $alldata_branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $tot_balance_Arr = [];
       

        foreach ($alldata_branch as $key => $alldata_branchs) {
            $Supplier_array = Supplier::where('soft_delete', '!=', 1)->get();
            foreach ($Supplier_array as $key => $Supplier_arra) {

            $last_idrow = BranchwiseBalance::where('supplier_id', '=', $Supplier_arra->id)->where('branch_id', '=', $alldata_branchs->id)->first();
        
            if($last_idrow != ""){
                if($last_idrow->purchase_balance != NULL){
                    $tot_balace = $last_idrow->purchase_balance;

                }else {

                    $tot_balace = 0;
                    
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
            $total_purchase_amount = Purchase::where('soft_delete', '!=', 1)->where('branch_id', '=', $branch_id)->sum('gross_amount');
            if($total_purchase_amount != ""){
                $total_purchaseAmount = $total_purchase_amount;
            }else {
                $total_purchaseAmount = '0';
            }


            $total_amuntpaid = Purchase::where('soft_delete', '!=', 1)->where('branch_id', '=', $branch_id)->sum('paid_amount');
            if($total_amuntpaid != ""){
                $totalpaid_Amount = $total_amuntpaid;
            }else {
                $totalpaid_Amount = '0';
            }
            $paymenttotal_paid = PurchasePayment::where('soft_delete', '!=', 1)->where('branch_id', '=', $branch_id)->sum('amount');
            if($paymenttotal_paid != ""){
                $totalpayment_paid = $paymenttotal_paid;
            }else {
                $totalpayment_paid = '0';
            }


            $discountpaid = PurchasePayment::where('soft_delete', '!=', 1)->where('branch_id', '=', $branch_id)->sum('purchasepayment_discount');
            if($discountpaid != ""){
                $discount_paid = $discountpaid;
            }else {
                $discount_paid = '0';
            }

            $totalamount_paid = $totalpaid_Amount + $totalpayment_paid + $discount_paid;
            


            // Total Balance
            $totalbalance = $total_purchaseAmount - $totalamount_paid;


        $allbranch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();

        return view('page.backend.supplier.index', compact('supplierarr_data', 'tot_balance_Arr', 'allbranch', 'total_purchaseAmount', 'totalamount_paid', 'totalbalance'));
    }  


    public function allpdf_export() {
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

            $total_discount = PurchasePayment::where('soft_delete', '!=', 1)->where('supplier_id', '=', $datas->id)->sum('purchasepayment_discount');
            if($total_discount != ""){
                $total_discount_amont = $total_discount;
            }else {
                $total_discount_amont = '0';
            }

            $total_amount_paid = $total_paid_Amount + $total_payment_paid + $total_discount_amont;
            


            // Total Balance
            $total_balance = $tot_purchaseAmount - $total_amount_paid;
            


            $supplierarr_data[] = array(
                'unique_key' => $datas->unique_key,
                'name' => $supplier_name->name,
                'contact_number' => $datas->contact_number,
                'shop_name' => $datas->shop_name,
                'total_purchase_amt' => $tot_purchaseAmount,
                'total_paid' => $total_amount_paid,
                'balance_amount' => $total_balance,
                'total_discount_amont' => $total_discount_amont,
            );


            $price = array();
            foreach ($supplierarr_data as $key => $row)
            {
                $price[$key] = $row['balance_amount'];
            }
            array_multisort($price, SORT_DESC, $supplierarr_data);
            
        }

        $total_purchase_amount = Purchase::where('soft_delete', '!=', 1)->sum('gross_amount');
        if($total_purchase_amount != ""){
            $total_purchaseAmount = $total_purchase_amount;
        }else {
            $total_purchaseAmount = '0';
        }


        $total_amuntpaid = Purchase::where('soft_delete', '!=', 1)->sum('paid_amount');
        if($total_amuntpaid != ""){
            $totalpaid_Amount = $total_amuntpaid;
        }else {
            $totalpaid_Amount = '0';
        }
        $paymenttotal_paid = PurchasePayment::where('soft_delete', '!=', 1)->sum('amount');
        if($paymenttotal_paid != ""){
            $totalpayment_paid = $paymenttotal_paid;
        }else {
            $totalpayment_paid = '0';
        }


        $discountpaid = PurchasePayment::where('soft_delete', '!=', 1)->sum('purchasepayment_discount');
        if($discountpaid != ""){
            $discount_paid = $discountpaid;
        }else {
            $discount_paid = '0';
        }

        $totalamount_paid = $totalpaid_Amount + $totalpayment_paid + $discount_paid;
        


        // Total Balance
        $totalbalance = $total_purchaseAmount - $totalamount_paid;
        $pdf = Pdf::loadView('page.backend.supplier.pdfexport_view', [
            'supplierarr_data' => $supplierarr_data,
            'total_purchaseAmount' => $total_purchaseAmount,
            'totalamount_paid' => $totalamount_paid,
            'totalbalance' => $totalbalance,
            'branch_name' => 'All Branches',

        ]);

        $name = 'Suppliers.' . 'pdf';

        return $pdf->stream($name);

    }



    public function pdf_export($last_word) {
        $data = Supplier::where('soft_delete', '!=', 1)->get();
        $supplierarr_data = [];
        foreach ($data as $key => $datas) {

            $supplier_name = Supplier::findOrFail($datas->id);
            // Grand total
            $total_purchase_amt = Purchase::where('soft_delete', '!=', 1)->where('supplier_id', '=', $datas->id)->where('branch_id', '=', $last_word)->sum('gross_amount');
            if($total_purchase_amt != ""){
                $tot_purchaseAmount = $total_purchase_amt;
            }else {
                $tot_purchaseAmount = '0';
            }

            // Total Paid
            $total_paid = Purchase::where('soft_delete', '!=', 1)->where('supplier_id', '=', $datas->id)->where('branch_id', '=', $last_word)->sum('paid_amount');
            if($total_paid != ""){
                $total_paid_Amount = $total_paid;
            }else {
                $total_paid_Amount = '0';
            }
            $payment_total_paid = PurchasePayment::where('soft_delete', '!=', 1)->where('supplier_id', '=', $datas->id)->where('branch_id', '=', $last_word)->sum('amount');
            if($payment_total_paid != ""){
                $total_payment_paid = $payment_total_paid;
            }else {
                $total_payment_paid = '0';
            }

            $total_discount = PurchasePayment::where('soft_delete', '!=', 1)->where('supplier_id', '=', $datas->id)->where('branch_id', '=', $last_word)->sum('purchasepayment_discount');
            if($total_discount != ""){
                $total_discount_amont = $total_discount;
            }else {
                $total_discount_amont = '0';
            }

            $total_amount_paid = $total_paid_Amount + $total_payment_paid + $total_discount_amont;
            


            // Total Balance
            $total_balance = $tot_purchaseAmount - $total_amount_paid;
            


            $supplierarr_data[] = array(
                'unique_key' => $datas->unique_key,
                'name' => $supplier_name->name,
                'contact_number' => $datas->contact_number,
                'shop_name' => $datas->shop_name,
                'total_purchase_amt' => $tot_purchaseAmount,
                'total_paid' => $total_amount_paid,
                'balance_amount' => $total_balance,
                'total_discount_amont' => $total_discount_amont,
            );

            $price = array();
            foreach ($supplierarr_data as $key => $row)
            {
                $price[$key] = $row['balance_amount'];
            }
            array_multisort($price, SORT_DESC, $supplierarr_data);

        }


        $total_purchase_amount = Purchase::where('soft_delete', '!=', 1)->where('branch_id', '=', $last_word)->sum('gross_amount');
        if($total_purchase_amount != ""){
            $total_purchaseAmount = $total_purchase_amount;
        }else {
            $total_purchaseAmount = '0';
        }


        $total_amuntpaid = Purchase::where('soft_delete', '!=', 1)->where('branch_id', '=', $last_word)->sum('paid_amount');
        if($total_amuntpaid != ""){
            $totalpaid_Amount = $total_amuntpaid;
        }else {
            $totalpaid_Amount = '0';
        }
        $paymenttotal_paid = PurchasePayment::where('soft_delete', '!=', 1)->where('branch_id', '=', $last_word)->sum('amount');
        if($paymenttotal_paid != ""){
            $totalpayment_paid = $paymenttotal_paid;
        }else {
            $totalpayment_paid = '0';
        }


        $discountpaid = PurchasePayment::where('soft_delete', '!=', 1)->where('branch_id', '=', $last_word)->sum('purchasepayment_discount');
        if($discountpaid != ""){
            $discount_paid = $discountpaid;
        }else {
            $discount_paid = '0';
        }

        $totalamount_paid = $totalpaid_Amount + $totalpayment_paid + $discount_paid;
        


        // Total Balance
        $totalbalance = $total_purchaseAmount - $totalamount_paid;

        $branch_name = Branch::findOrFail($last_word);
        $pdf = Pdf::loadView('page.backend.supplier.pdfexport_view', [
            'supplierarr_data' => $supplierarr_data,
            'total_purchaseAmount' => $total_purchaseAmount,
            'totalamount_paid' => $totalamount_paid,
            'totalbalance' => $totalbalance,
            'branch_name' => $branch_name->shop_name,

        ]);

        $name = 'Suppliers.' . 'pdf';

        return $pdf->stream($name);

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



    public function supplierview($unique_key, $last_word)
    {

        if($last_word != 'supplier'){

            $SupplierData = Supplier::where('unique_key', '=', $unique_key)->first();

            $today = Carbon::now()->format('Y-m-d');
            $data = Purchase::where('supplier_id', '=', $SupplierData->id)->where('branch_id', '=', $last_word)->where('soft_delete', '!=', 1)->get();
            $purchase_data = [];
            foreach ($data as $key => $datas) {
    
                $branch_name = Branch::findOrFail($datas->branch_id);
                $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $datas->id)->where('branch_id', '=', $last_word)->get();
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
                    'branch_name' => $branch_name->shop_name,
                    'supplier_name' => $SupplierData->name,
                    'date' => $datas->date,
                    'gross_amount' => $datas->gross_amount,
                    'paid_amount' => $datas->paid_amount,
                    'purchase_order' => $datas->purchase_order,
                    'bill_no' => $datas->bill_no,
                    'id' => $datas->id,
                    'terms' => $terms,
                );
            }
    
            $branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
            $supplier = Supplier::where('soft_delete', '!=', 1)->get();
    
    
            $suppliername = $SupplierData->name;
            $supplier_id = $SupplierData->id;
            $unique_key = $SupplierData->unique_key;
    
    
    
    
            $PurchasePayment = PurchasePayment::where('supplier_id', '=', $SupplierData->id)->where('branch_id', '=', $last_word)->where('soft_delete', '!=', 1)->get();
            $PurchasePayment_data = [];
    
            foreach ($PurchasePayment as $key => $PurchasePayments) {
                $branch_name = Branch::findOrFail($PurchasePayments->branch_id);
    
    
                $PurchasePayment_data[] = array(
                    'unique_key' => $PurchasePayments->unique_key,
                    'branch_name' => $branch_name->shop_name,
                    'supplier_name' => $SupplierData->name,
                    'date' => $PurchasePayments->date,
                    'paid_amount' => $PurchasePayments->amount,
                    'purchasepayment_discount' => $PurchasePayments->purchasepayment_discount,
                );
            }
    
    
            $fromdate = '';
            $todate = '';
            $branchid = '';
            $supplierid = $SupplierData->id;




            $total_purchase_amt = Purchase::where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->where('branch_id', '=', $last_word)->sum('gross_amount');
            if($total_purchase_amt != ""){
                $tot_purchaseAmount = $total_purchase_amt;
            }else {
                $tot_purchaseAmount = '0';
            }

            // Total Paid
            $total_paid = Purchase::where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->where('branch_id', '=', $last_word)->sum('paid_amount');
            if($total_paid != ""){
                $total_paid_Amount = $total_paid;
            }else {
                $total_paid_Amount = '0';
            }
            $payment_total_paid = PurchasePayment::where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->where('branch_id', '=', $last_word)->sum('amount');
            if($payment_total_paid != ""){
                $total_payment_paid = $payment_total_paid;
            }else {
                $total_payment_paid = '0';
            }

            $total_discount = PurchasePayment::where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->where('branch_id', '=', $last_word)->sum('purchasepayment_discount');
            if($total_discount != ""){
                $total_discount_amont = $total_discount;
            }else {
                $total_discount_amont = '0';
            }

            $total_amount_paid = $total_paid_Amount + $total_payment_paid + $total_discount_amont;
            


            // Total Balance
            $total_balance = $tot_purchaseAmount - $total_amount_paid;
            $GETbranch = Branch::findOrFail($last_word);
            $GETBranchname = $GETbranch->shop_name;
    
            return view('page.backend.supplier.view', compact('SupplierData', 'purchase_data', 'branch', 'supplier', 'suppliername', 'supplier_id', 'unique_key', 'today',
                         'fromdate','todate', 'branchid', 'supplierid', 'PurchasePayment_data', 'tot_purchaseAmount', 'total_amount_paid', 'total_balance', 'GETBranchname'));



        }else if($last_word == 'supplier'){


            $SupplierData = Supplier::where('unique_key', '=', $unique_key)->first();

            $today = Carbon::now()->format('Y-m-d');
            $data = Purchase::where('supplier_id', '=', $SupplierData->id)->where('soft_delete', '!=', 1)->get();
            $purchase_data = [];
            foreach ($data as $key => $datas) {
    
                $branch_name = Branch::findOrFail($datas->branch_id);
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
                    'branch_name' => $branch_name->shop_name,
                    'supplier_name' => $SupplierData->name,
                    'date' => $datas->date,
                    'gross_amount' => $datas->gross_amount,
                    'paid_amount' => $datas->paid_amount,
                    'purchase_order' => $datas->purchase_order,
                    'bill_no' => $datas->bill_no,
                    'id' => $datas->id,
                    'terms' => $terms,
                );
            }
    
            $branch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
            $supplier = Supplier::where('soft_delete', '!=', 1)->get();
    
    
            $suppliername = $SupplierData->name;
            $supplier_id = $SupplierData->id;
            $unique_key = $SupplierData->unique_key;
    
    
    
    
            $PurchasePayment = PurchasePayment::where('supplier_id', '=', $SupplierData->id)->where('soft_delete', '!=', 1)->get();
            $PurchasePayment_data = [];
    
            foreach ($PurchasePayment as $key => $PurchasePayments) {
                $branch_name = Branch::findOrFail($PurchasePayments->branch_id);
    
    
                $PurchasePayment_data[] = array(
                    'unique_key' => $PurchasePayments->unique_key,
                    'branch_name' => $branch_name->shop_name,
                    'supplier_name' => $SupplierData->name,
                    'date' => $PurchasePayments->date,
                    'paid_amount' => $PurchasePayments->amount,
                    'purchasepayment_discount' => $PurchasePayments->purchasepayment_discount,
                );
            }
    
    
            $fromdate = '';
            $todate = '';
            $branchid = '';
            $supplierid = $SupplierData->id;


            $total_purchase_amt = Purchase::where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->sum('gross_amount');
            if($total_purchase_amt != ""){
                $tot_purchaseAmount = $total_purchase_amt;
            }else {
                $tot_purchaseAmount = '0';
            }

            // Total Paid
            $total_paid = Purchase::where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->sum('paid_amount');
            if($total_paid != ""){
                $total_paid_Amount = $total_paid;
            }else {
                $total_paid_Amount = '0';
            }
            $payment_total_paid = PurchasePayment::where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->sum('amount');
            if($payment_total_paid != ""){
                $total_payment_paid = $payment_total_paid;
            }else {
                $total_payment_paid = '0';
            }

            $total_discount = PurchasePayment::where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->sum('purchasepayment_discount');
            if($total_discount != ""){
                $total_discount_amont = $total_discount;
            }else {
                $total_discount_amont = '0';
            }

            $total_amount_paid = $total_paid_Amount + $total_payment_paid + $total_discount_amont;
            


            // Total Balance
            $total_balance = $tot_purchaseAmount - $total_amount_paid;
            $GETBranchname = 'ALL';
    
            return view('page.backend.supplier.view', compact('SupplierData', 'purchase_data', 'branch', 'supplier', 'suppliername', 'supplier_id', 'unique_key', 'today',
                         'fromdate','todate', 'branchid', 'supplierid', 'PurchasePayment_data', 'tot_purchaseAmount', 'total_amount_paid', 'total_balance', 'GETBranchname'));



        }
      
    }



    public function viewfilter(Request $request, $unique_key, $last_word)
   {
        
        $branchid = $request->get('branchid');
        $unique_key = $request->get('uniquekey');
        $SupplierData = Supplier::where('unique_key', '=', $unique_key)->first();


        $supplier = Supplier::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();

        $fromdate = $request->get('fromdate');
        $todate = $request->get('todate');


        if($last_word != 'supplier'){

            if($fromdate){
                $GetBranch = Branch::findOrFail($branchid);


                $data = Purchase::where('date', '=', $fromdate)->where('branch_id', '=', $branchid)->where('supplier_id', '=', $SupplierData->id)->where('soft_delete', '!=', 1)->get();
                $purchase_data = [];
                foreach ($data as $key => $datas) {

                    $branch_name = Branch::findOrFail($datas->branch_id);
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
                        'branch_name' => $branch_name->shop_name,
                        'supplier_name' => $SupplierData->name,
                        'date' => $datas->date,
                        'gross_amount' => $datas->gross_amount,
                        'paid_amount' => $datas->paid_amount,
                        'bill_no' => $datas->bill_no,
                        'purchase_order' => $datas->purchase_order,
                        'id' => $datas->id,
                        'terms' => $terms,
                    );
                }

                $suppliername = $SupplierData->name;
                $supplier_id = $SupplierData->id;
                $unique_key = $SupplierData->unique_key;


                $PurchasePayment_data = [];

                $PurchasePayment = PurchasePayment::where('date', '=', $fromdate)->where('branch_id', '=', $branchid)->where('supplier_id', '=', $SupplierData->id)->where('soft_delete', '!=', 1)->get();
                if($PurchasePayment != ''){
                    
                    foreach ($PurchasePayment as $key => $PurchasePayments) {
                        $branch_name = Branch::findOrFail($PurchasePayments->branch_id);


                        $PurchasePayment_data[] = array(
                            'unique_key' => $PurchasePayments->unique_key,
                            'branch_name' => $branch_name->shop_name,
                            'supplier_name' => $SupplierData->name,
                            'date' => $PurchasePayments->date,
                            'paid_amount' => $PurchasePayments->amount,
                            'purchasepayment_discount' => $PurchasePayments->purchasepayment_discount,
                        );
                    }
                }

                $supplierid = $SupplierData->id;

                $total_purchase_amt = Purchase::where('date', '=', $fromdate)->where('branch_id', '=', $branchid)->where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->sum('gross_amount');
                if($total_purchase_amt != ""){
                    $tot_purchaseAmount = $total_purchase_amt;
                }else {
                    $tot_purchaseAmount = '0';
                }

                // Total Paid
                $total_paid = Purchase::where('date', '=', $fromdate)->where('soft_delete', '!=', 1)->where('branch_id', '=', $branchid)->where('supplier_id', '=', $SupplierData->id)->sum('paid_amount');
                if($total_paid != ""){
                    $total_paid_Amount = $total_paid;
                }else {
                    $total_paid_Amount = '0';
                }
                $payment_total_paid = PurchasePayment::where('date', '=', $fromdate)->where('soft_delete', '!=', 1)->where('branch_id', '=', $branchid)->where('supplier_id', '=', $SupplierData->id)->sum('amount');
                if($payment_total_paid != ""){
                    $total_payment_paid = $payment_total_paid;
                }else {
                    $total_payment_paid = '0';
                }

                $total_discount = PurchasePayment::where('date', '=', $fromdate)->where('soft_delete', '!=', 1)->where('branch_id', '=', $branchid)->where('supplier_id', '=', $SupplierData->id)->sum('purchasepayment_discount');
                if($total_discount != ""){
                    $total_discount_amont = $total_discount;
                }else {
                    $total_discount_amont = '0';
                }

                $total_amount_paid = $total_paid_Amount + $total_payment_paid + $total_discount_amont;
                $total_balance = $tot_purchaseAmount - $total_amount_paid;
                $GETBranchname = $GetBranch->shop_name;
            }

            if($todate){


                $GetBranch = Branch::findOrFail($branchid);


                $data = Purchase::where('date', '=', $todate)->where('branch_id', '=', $branchid)->where('supplier_id', '=', $SupplierData->id)->where('soft_delete', '!=', 1)->get();
                $purchase_data = [];
                foreach ($data as $key => $datas) {

                    $branch_name = Branch::findOrFail($datas->branch_id);
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
                        'branch_name' => $branch_name->shop_name,
                        'supplier_name' => $SupplierData->name,
                        'date' => $datas->date,
                        'gross_amount' => $datas->gross_amount,
                        'paid_amount' => $datas->paid_amount,
                        'bill_no' => $datas->bill_no,
                        'purchase_order' => $datas->purchase_order,
                        'id' => $datas->id,
                        'terms' => $terms,
                    );
                }

                $suppliername = $SupplierData->name;
                $supplier_id = $SupplierData->id;
                $unique_key = $SupplierData->unique_key;


                $PurchasePayment_data = [];

                $PurchasePayment = PurchasePayment::where('date', '=', $todate)->where('branch_id', '=', $branchid)->where('supplier_id', '=', $SupplierData->id)->where('soft_delete', '!=', 1)->get();
                if($PurchasePayment != ''){
                    
                    foreach ($PurchasePayment as $key => $PurchasePayments) {
                        $branch_name = Branch::findOrFail($PurchasePayments->branch_id);


                        $PurchasePayment_data[] = array(
                            'unique_key' => $PurchasePayments->unique_key,
                            'branch_name' => $branch_name->shop_name,
                            'supplier_name' => $SupplierData->name,
                            'date' => $PurchasePayments->date,
                            'paid_amount' => $PurchasePayments->amount,
                            'purchasepayment_discount' => $PurchasePayments->purchasepayment_discount,
                        );
                    }
                }

                $supplierid = $SupplierData->id;

                $total_purchase_amt = Purchase::where('date', '=', $todate)->where('branch_id', '=', $branchid)->where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->sum('gross_amount');
                if($total_purchase_amt != ""){
                    $tot_purchaseAmount = $total_purchase_amt;
                }else {
                    $tot_purchaseAmount = '0';
                }

                // Total Paid
                $total_paid = Purchase::where('date', '=', $todate)->where('soft_delete', '!=', 1)->where('branch_id', '=', $branchid)->where('supplier_id', '=', $SupplierData->id)->sum('paid_amount');
                if($total_paid != ""){
                    $total_paid_Amount = $total_paid;
                }else {
                    $total_paid_Amount = '0';
                }
                $payment_total_paid = PurchasePayment::where('date', '=', $todate)->where('soft_delete', '!=', 1)->where('branch_id', '=', $branchid)->where('supplier_id', '=', $SupplierData->id)->sum('amount');
                if($payment_total_paid != ""){
                    $total_payment_paid = $payment_total_paid;
                }else {
                    $total_payment_paid = '0';
                }

                $total_discount = PurchasePayment::where('date', '=', $todate)->where('soft_delete', '!=', 1)->where('branch_id', '=', $branchid)->where('supplier_id', '=', $SupplierData->id)->sum('purchasepayment_discount');
                if($total_discount != ""){
                    $total_discount_amont = $total_discount;
                }else {
                    $total_discount_amont = '0';
                }

                $total_amount_paid = $total_paid_Amount + $total_payment_paid + $total_discount_amont;
                $total_balance = $tot_purchaseAmount - $total_amount_paid;
                $GETBranchname = $GetBranch->shop_name;


            }


            if($fromdate && $todate){


                $GetBranch = Branch::findOrFail($branchid);


                $data = Purchase::whereBetween('date', [$fromdate, $todate])->where('branch_id', '=', $branchid)->where('supplier_id', '=', $SupplierData->id)->where('soft_delete', '!=', 1)->get();
                $purchase_data = [];
                foreach ($data as $key => $datas) {

                    $branch_name = Branch::findOrFail($datas->branch_id);
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
                        'branch_name' => $branch_name->shop_name,
                        'supplier_name' => $SupplierData->name,
                        'date' => $datas->date,
                        'gross_amount' => $datas->gross_amount,
                        'paid_amount' => $datas->paid_amount,
                        'bill_no' => $datas->bill_no,
                        'purchase_order' => $datas->purchase_order,
                        'id' => $datas->id,
                        'terms' => $terms,
                    );
                }

                $suppliername = $SupplierData->name;
                $supplier_id = $SupplierData->id;
                $unique_key = $SupplierData->unique_key;


                $PurchasePayment_data = [];

                $PurchasePayment = PurchasePayment::whereBetween('date', [$fromdate, $todate])->where('branch_id', '=', $branchid)->where('supplier_id', '=', $SupplierData->id)->where('soft_delete', '!=', 1)->get();
                if($PurchasePayment != ''){
                    
                    foreach ($PurchasePayment as $key => $PurchasePayments) {
                        $branch_name = Branch::findOrFail($PurchasePayments->branch_id);


                        $PurchasePayment_data[] = array(
                            'unique_key' => $PurchasePayments->unique_key,
                            'branch_name' => $branch_name->shop_name,
                            'supplier_name' => $SupplierData->name,
                            'date' => $PurchasePayments->date,
                            'paid_amount' => $PurchasePayments->amount,
                            'purchasepayment_discount' => $PurchasePayments->purchasepayment_discount,
                        );
                    }
                }

                $supplierid = $SupplierData->id;

                $total_purchase_amt = Purchase::whereBetween('date', [$fromdate, $todate])->where('branch_id', '=', $branchid)->where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->sum('gross_amount');
                if($total_purchase_amt != ""){
                    $tot_purchaseAmount = $total_purchase_amt;
                }else {
                    $tot_purchaseAmount = '0';
                }

                // Total Paid
                $total_paid = Purchase::whereBetween('date', [$fromdate, $todate])->where('soft_delete', '!=', 1)->where('branch_id', '=', $branchid)->where('supplier_id', '=', $SupplierData->id)->sum('paid_amount');
                if($total_paid != ""){
                    $total_paid_Amount = $total_paid;
                }else {
                    $total_paid_Amount = '0';
                }
                $payment_total_paid = PurchasePayment::whereBetween('date', [$fromdate, $todate])->where('soft_delete', '!=', 1)->where('branch_id', '=', $branchid)->where('supplier_id', '=', $SupplierData->id)->sum('amount');
                if($payment_total_paid != ""){
                    $total_payment_paid = $payment_total_paid;
                }else {
                    $total_payment_paid = '0';
                }

                $total_discount = PurchasePayment::whereBetween('date', [$fromdate, $todate])->where('soft_delete', '!=', 1)->where('branch_id', '=', $branchid)->where('supplier_id', '=', $SupplierData->id)->sum('purchasepayment_discount');
                if($total_discount != ""){
                    $total_discount_amont = $total_discount;
                }else {
                    $total_discount_amont = '0';
                }

                $total_amount_paid = $total_paid_Amount + $total_payment_paid + $total_discount_amont;
                $total_balance = $tot_purchaseAmount - $total_amount_paid;
                $GETBranchname = $GetBranch->shop_name;



            }

        }else if($last_word == 'supplier'){

            if($fromdate){


                $data = Purchase::where('date', '=', $fromdate)->where('supplier_id', '=', $SupplierData->id)->where('soft_delete', '!=', 1)->get();
                $purchase_data = [];
                foreach ($data as $key => $datas) {

                    $branch_name = Branch::findOrFail($datas->branch_id);
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
                        'branch_name' => $branch_name->shop_name,
                        'supplier_name' => $SupplierData->name,
                        'date' => $datas->date,
                        'gross_amount' => $datas->gross_amount,
                        'paid_amount' => $datas->paid_amount,
                        'bill_no' => $datas->bill_no,
                        'purchase_order' => $datas->purchase_order,
                        'id' => $datas->id,
                        'terms' => $terms,
                    );
                }

                $suppliername = $SupplierData->name;
                $supplier_id = $SupplierData->id;
                $unique_key = $SupplierData->unique_key;


                $PurchasePayment_data = [];

                $PurchasePayment = PurchasePayment::where('date', '=', $fromdate)->where('supplier_id', '=', $SupplierData->id)->where('soft_delete', '!=', 1)->get();
                if($PurchasePayment != ''){
                    
                    foreach ($PurchasePayment as $key => $PurchasePayments) {
                        $branch_name = Branch::findOrFail($PurchasePayments->branch_id);


                        $PurchasePayment_data[] = array(
                            'unique_key' => $PurchasePayments->unique_key,
                            'branch_name' => $branch_name->shop_name,
                            'supplier_name' => $SupplierData->name,
                            'date' => $PurchasePayments->date,
                            'paid_amount' => $PurchasePayments->amount,
                            'purchasepayment_discount' => $PurchasePayments->purchasepayment_discount,
                        );
                    }
                }

                $supplierid = $SupplierData->id;

                $total_purchase_amt = Purchase::where('date', '=', $fromdate)->where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->sum('gross_amount');
                if($total_purchase_amt != ""){
                    $tot_purchaseAmount = $total_purchase_amt;
                }else {
                    $tot_purchaseAmount = '0';
                }

                // Total Paid
                $total_paid = Purchase::where('date', '=', $fromdate)->where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->sum('paid_amount');
                if($total_paid != ""){
                    $total_paid_Amount = $total_paid;
                }else {
                    $total_paid_Amount = '0';
                }
                $payment_total_paid = PurchasePayment::where('date', '=', $fromdate)->where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->sum('amount');
                if($payment_total_paid != ""){
                    $total_payment_paid = $payment_total_paid;
                }else {
                    $total_payment_paid = '0';
                }

                $total_discount = PurchasePayment::where('date', '=', $fromdate)->where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->sum('purchasepayment_discount');
                if($total_discount != ""){
                    $total_discount_amont = $total_discount;
                }else {
                    $total_discount_amont = '0';
                }

                $total_amount_paid = $total_paid_Amount + $total_payment_paid + $total_discount_amont;
                $total_balance = $tot_purchaseAmount - $total_amount_paid;
                $GETBranchname = 'All Branch';
            }

            if($todate){


                $data = Purchase::where('date', '=', $todate)->where('supplier_id', '=', $SupplierData->id)->where('soft_delete', '!=', 1)->get();
                $purchase_data = [];
                foreach ($data as $key => $datas) {

                    $branch_name = Branch::findOrFail($datas->branch_id);
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
                        'branch_name' => $branch_name->shop_name,
                        'supplier_name' => $SupplierData->name,
                        'date' => $datas->date,
                        'gross_amount' => $datas->gross_amount,
                        'paid_amount' => $datas->paid_amount,
                        'bill_no' => $datas->bill_no,
                        'purchase_order' => $datas->purchase_order,
                        'id' => $datas->id,
                        'terms' => $terms,
                    );
                }

                $suppliername = $SupplierData->name;
                $supplier_id = $SupplierData->id;
                $unique_key = $SupplierData->unique_key;


                $PurchasePayment_data = [];

                $PurchasePayment = PurchasePayment::where('date', '=', $todate)->where('supplier_id', '=', $SupplierData->id)->where('soft_delete', '!=', 1)->get();
                if($PurchasePayment != ''){
                    
                    foreach ($PurchasePayment as $key => $PurchasePayments) {
                        $branch_name = Branch::findOrFail($PurchasePayments->branch_id);


                        $PurchasePayment_data[] = array(
                            'unique_key' => $PurchasePayments->unique_key,
                            'branch_name' => $branch_name->shop_name,
                            'supplier_name' => $SupplierData->name,
                            'date' => $PurchasePayments->date,
                            'paid_amount' => $PurchasePayments->amount,
                            'purchasepayment_discount' => $PurchasePayments->purchasepayment_discount,
                        );
                    }
                }

                $supplierid = $SupplierData->id;

                $total_purchase_amt = Purchase::where('date', '=', $todate)->where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->sum('gross_amount');
                if($total_purchase_amt != ""){
                    $tot_purchaseAmount = $total_purchase_amt;
                }else {
                    $tot_purchaseAmount = '0';
                }

                // Total Paid
                $total_paid = Purchase::where('date', '=', $todate)->where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->sum('paid_amount');
                if($total_paid != ""){
                    $total_paid_Amount = $total_paid;
                }else {
                    $total_paid_Amount = '0';
                }
                $payment_total_paid = PurchasePayment::where('date', '=', $todate)->where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->sum('amount');
                if($payment_total_paid != ""){
                    $total_payment_paid = $payment_total_paid;
                }else {
                    $total_payment_paid = '0';
                }

                $total_discount = PurchasePayment::where('date', '=', $todate)->where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->sum('purchasepayment_discount');
                if($total_discount != ""){
                    $total_discount_amont = $total_discount;
                }else {
                    $total_discount_amont = '0';
                }

                $total_amount_paid = $total_paid_Amount + $total_payment_paid + $total_discount_amont;
                $total_balance = $tot_purchaseAmount - $total_amount_paid;
                $GETBranchname = 'All Branch';


            }


            if($fromdate && $todate){


                $data = Purchase::whereBetween('date', [$fromdate, $todate])->where('supplier_id', '=', $SupplierData->id)->where('soft_delete', '!=', 1)->get();
                $purchase_data = [];
                foreach ($data as $key => $datas) {

                    $branch_name = Branch::findOrFail($datas->branch_id);
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
                        'branch_name' => $branch_name->shop_name,
                        'supplier_name' => $SupplierData->name,
                        'date' => $datas->date,
                        'gross_amount' => $datas->gross_amount,
                        'paid_amount' => $datas->paid_amount,
                        'bill_no' => $datas->bill_no,
                        'purchase_order' => $datas->purchase_order,
                        'id' => $datas->id,
                        'terms' => $terms,
                    );
                }

                $suppliername = $SupplierData->name;
                $supplier_id = $SupplierData->id;
                $unique_key = $SupplierData->unique_key;


                $PurchasePayment_data = [];

                $PurchasePayment = PurchasePayment::whereBetween('date', [$fromdate, $todate])->where('supplier_id', '=', $SupplierData->id)->where('soft_delete', '!=', 1)->get();
                if($PurchasePayment != ''){
                    
                    foreach ($PurchasePayment as $key => $PurchasePayments) {
                        $branch_name = Branch::findOrFail($PurchasePayments->branch_id);


                        $PurchasePayment_data[] = array(
                            'unique_key' => $PurchasePayments->unique_key,
                            'branch_name' => $branch_name->shop_name,
                            'supplier_name' => $SupplierData->name,
                            'date' => $PurchasePayments->date,
                            'paid_amount' => $PurchasePayments->amount,
                            'purchasepayment_discount' => $PurchasePayments->purchasepayment_discount,
                        );
                    }
                }

                $supplierid = $SupplierData->id;

                $total_purchase_amt = Purchase::whereBetween('date', [$fromdate, $todate])->where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->sum('gross_amount');
                if($total_purchase_amt != ""){
                    $tot_purchaseAmount = $total_purchase_amt;
                }else {
                    $tot_purchaseAmount = '0';
                }

                // Total Paid
                $total_paid = Purchase::whereBetween('date', [$fromdate, $todate])->where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->sum('paid_amount');
                if($total_paid != ""){
                    $total_paid_Amount = $total_paid;
                }else {
                    $total_paid_Amount = '0';
                }
                $payment_total_paid = PurchasePayment::whereBetween('date', [$fromdate, $todate])->where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->sum('amount');
                if($payment_total_paid != ""){
                    $total_payment_paid = $payment_total_paid;
                }else {
                    $total_payment_paid = '0';
                }

                $total_discount = PurchasePayment::whereBetween('date', [$fromdate, $todate])->where('soft_delete', '!=', 1)->where('supplier_id', '=', $SupplierData->id)->sum('purchasepayment_discount');
                if($total_discount != ""){
                    $total_discount_amont = $total_discount;
                }else {
                    $total_discount_amont = '0';
                }

                $total_amount_paid = $total_paid_Amount + $total_payment_paid + $total_discount_amont;
                $total_balance = $tot_purchaseAmount - $total_amount_paid;
                $GETBranchname = 'All Branch';



            }
            
        }
        $today = Carbon::now()->format('Y-m-d');

        return view('page.backend.supplier.view', compact('SupplierData', 'purchase_data', 'suppliername', 'supplier_id', 'unique_key', 'today',
                         'fromdate','todate', 'branchid', 'supplierid', 'PurchasePayment_data', 'tot_purchaseAmount', 'total_amount_paid', 'total_balance', 'GETBranchname'));
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



    public function checkduplicate(Request $request)
    {
        if(request()->get('query'))
        {
            $query = request()->get('query');
            $supplierdata = Supplier::where('contact_number', '=', $query)->first();
            
            $userData['data'] = $supplierdata;
            echo json_encode($userData);
        }
    }

}
