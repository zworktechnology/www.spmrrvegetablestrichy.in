<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Purchase;
use App\Models\Sales;
use App\Models\Expence;
use App\Models\Branch;
use App\Models\SalesProduct;
use App\Models\PurchaseProduct;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');

        $total_purchase_amt_billing = Purchase::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('gross_amount');
            if($total_purchase_amt_billing != ""){
                $tot_purchaseAmount = $total_purchase_amt_billing;
            }else {
                $tot_purchaseAmount = '0';
            }

        $total_purchase_amt_payment = Purchase::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('paid_amount');
            if($total_purchase_amt_payment != ""){
                $total_purchase_payment = $total_purchase_amt_payment;
            }else {
                $total_purchase_payment = '0';
            }


        

        $total_sale_amt_billing = Sales::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('gross_amount');
            if($total_sale_amt_billing != ""){
                $tot_saleAmount = $total_sale_amt_billing;
            }else {
                $tot_saleAmount = '0';
            }

        $total_sale_amt_payment = Sales::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('paid_amount');
            if($total_sale_amt_payment != ""){
                $total_sale_payment = $total_sale_amt_payment;
            }else {
                $total_sale_payment = '0';
            }



        $total_expense_amt_billing = Expence::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('amount');
            if($total_expense_amt_billing != ""){
                $tot_expenseAmount = $total_expense_amt_billing;
            }else {
                $tot_expenseAmount = '0';
            }




            $dashbord_table = [];

            $allbranch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
            foreach ($allbranch as $key => $allbranchs) {

                $totalpurchaseamt_billing = Purchase::where('soft_delete', '!=', 1)->where('branch_id', '=', $allbranchs->id)->where('date', '=', $today)->sum('gross_amount');
                if($totalpurchaseamt_billing != 0){
                    $totpurchaseAmount = $totalpurchaseamt_billing;
                }else {
                    $totpurchaseAmount = '';
                }


                $totalpurchaseamt_payment = Purchase::where('soft_delete', '!=', 1)->where('branch_id', '=', $allbranchs->id)->where('date', '=', $today)->sum('paid_amount');
                if($totalpurchaseamt_payment != 0){
                    $totalpurchase_payment = $totalpurchaseamt_payment;
                }else {
                    $totalpurchase_payment = '';
                }


                $totalsaleamt_billing = Sales::where('soft_delete', '!=', 1)->where('branch_id', '=', $allbranchs->id)->where('date', '=', $today)->sum('gross_amount');
                if($totalsaleamt_billing != 0){
                    $totsaleAmount = $totalsaleamt_billing;
                }else {
                    $totsaleAmount = '';
                }

                $totalsaleamt_payment = Sales::where('soft_delete', '!=', 1)->where('branch_id', '=', $allbranchs->id)->where('date', '=', $today)->sum('paid_amount');
                if($totalsaleamt_payment != 0){
                    $totalsale_payment = $totalsaleamt_payment;
                }else {
                    $totalsale_payment = '';
                }



                $totalexpenseamt_billing = Expence::where('soft_delete', '!=', 1)->where('branch_id', '=', $allbranchs->id)->where('date', '=', $today)->sum('amount');
                if($totalexpenseamt_billing != 0){
                    $totexpenseAmount = $totalexpenseamt_billing;
                }else {
                    $totexpenseAmount = '';
                }

                $dashbord_table[] = array(
                    'branch' => $allbranchs->shop_name,
                    'today' => $today,
                    'totpurchaseAmount' => $totpurchaseAmount,
                    'totalpurchase_payment' => $totalpurchase_payment,
                    'totsaleAmount' => $totsaleAmount,
                    'totalsale_payment' => $totalsale_payment,
                    'totexpenseAmount' => $totexpenseAmount,

                );
                
            }



        return view('home', compact('today', 'tot_purchaseAmount', 'total_purchase_payment', 'tot_saleAmount', 'total_sale_payment', 'tot_expenseAmount', 'dashbord_table'));
    }


    public function datefilter(Request $request) {
        $today = $request->get('from_date');



        $total_purchase_amt_billing = Purchase::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('gross_amount');
            if($total_purchase_amt_billing != ""){
                $tot_purchaseAmount = $total_purchase_amt_billing;
            }else {
                $tot_purchaseAmount = '0';
            }

        $total_purchase_amt_payment = Purchase::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('paid_amount');
            if($total_purchase_amt_payment != ""){
                $total_purchase_payment = $total_purchase_amt_payment;
            }else {
                $total_purchase_payment = '0';
            }


        

        $total_sale_amt_billing = Sales::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('gross_amount');
            if($total_sale_amt_billing != ""){
                $tot_saleAmount = $total_sale_amt_billing;
            }else {
                $tot_saleAmount = '0';
            }

        $total_sale_amt_payment = Sales::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('paid_amount');
            if($total_sale_amt_payment != ""){
                $total_sale_payment = $total_sale_amt_payment;
            }else {
                $total_sale_payment = '0';
            }



        $total_expense_amt_billing = Expence::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('amount');
            if($total_expense_amt_billing != ""){
                $tot_expenseAmount = $total_expense_amt_billing;
            }else {
                $tot_expenseAmount = '0';
            }




            $dashbord_table = [];

            $allbranch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
            foreach ($allbranch as $key => $allbranchs) {

                $totalpurchaseamt_billing = Purchase::where('soft_delete', '!=', 1)->where('branch_id', '=', $allbranchs->id)->where('date', '=', $today)->sum('gross_amount');
                if($totalpurchaseamt_billing != 0){
                    $totpurchaseAmount = $totalpurchaseamt_billing;
                }else {
                    $totpurchaseAmount = '';
                }


                $totalpurchaseamt_payment = Purchase::where('soft_delete', '!=', 1)->where('branch_id', '=', $allbranchs->id)->where('date', '=', $today)->sum('paid_amount');
                if($totalpurchaseamt_payment != 0){
                    $totalpurchase_payment = $totalpurchaseamt_payment;
                }else {
                    $totalpurchase_payment = '';
                }


                $totalsaleamt_billing = Sales::where('soft_delete', '!=', 1)->where('branch_id', '=', $allbranchs->id)->where('date', '=', $today)->sum('gross_amount');
                if($totalsaleamt_billing != 0){
                    $totsaleAmount = $totalsaleamt_billing;
                }else {
                    $totsaleAmount = '';
                }

                $totalsaleamt_payment = Sales::where('soft_delete', '!=', 1)->where('branch_id', '=', $allbranchs->id)->where('date', '=', $today)->sum('paid_amount');
                if($totalsaleamt_payment != 0){
                    $totalsale_payment = $totalsaleamt_payment;
                }else {
                    $totalsale_payment = '';
                }



                $totalexpenseamt_billing = Expence::where('soft_delete', '!=', 1)->where('branch_id', '=', $allbranchs->id)->where('date', '=', $today)->sum('amount');
                if($totalexpenseamt_billing != 0){
                    $totexpenseAmount = $totalexpenseamt_billing;
                }else {
                    $totexpenseAmount = '';
                }

                $dashbord_table[] = array(
                    'branch' => $allbranchs->shop_name,
                    'today' => $today,
                    'totpurchaseAmount' => $totpurchaseAmount,
                    'totalpurchase_payment' => $totalpurchase_payment,
                    'totsaleAmount' => $totsaleAmount,
                    'totalsale_payment' => $totalsale_payment,
                    'totexpenseAmount' => $totexpenseAmount,

                );
                
            }



        return view('home', compact('today', 'tot_purchaseAmount', 'total_purchase_payment', 'tot_saleAmount', 'total_sale_payment', 'tot_expenseAmount', 'dashbord_table'));

    }
}
