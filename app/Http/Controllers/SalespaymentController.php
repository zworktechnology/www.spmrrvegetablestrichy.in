<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Sales;
use App\Models\SalesProduct;
use App\Models\Salespayment;
use App\Models\Productlist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class SalespaymentController extends Controller
{
    public function index()
    {

        $data = Salespayment::where('soft_delete', '!=', 1)->get();
        
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        $allbranch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $customer = Customer::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        
        return view('page.backend.salespayment.index', compact('data', 'today', 'allbranch', 'customer', 'timenow'));
    }


    public function branchdata($branch_id)
    {
       
        $data = Salespayment::where('branch_id', '=', $branch_id)->where('soft_delete', '!=', 1)->get();
       
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        $allbranch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $customer = Customer::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        return view('page.backend.salespayment.index', compact('data', 'today', 'allbranch', 'customer', 'timenow'));
    }


    public function datefilter(Request $request) {


        $today = $request->get('from_date');
        $data = Salespayment::where('date', '=', $today)->where('soft_delete', '!=', 1)->get();
        
        $timenow = Carbon::now()->format('H:i');

        $allbranch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $customer = Customer::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();

        return view('page.backend.salespayment.index', compact('data', 'today', 'allbranch', 'customer', 'timenow'));

    }

    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new Salespayment();

        $data->unique_key = $randomkey;
        $data->customer_id = $request->get('customer_id');
        $data->branch_id = $request->get('branch_id');
        $data->sales_id = $request->get('payment_sales_id');
        $data->date = $request->get('date');
        $data->time = $request->get('time');
        $data->oldblance = $request->get('sales_oldblance');
        $data->amount = $request->get('spayment_payableamount');
        $data->payment_pending = $request->get('spayment_pending');
        $data->save();

        $spayment_payableamount = $request->get('spayment_payableamount');
        $spayment_pending = $request->get('spayment_pending');
        $payment_sales_id = $request->get('payment_sales_id');


        DB::table('sales')->where('id', $payment_sales_id)->update([
            'sales_paymentpaidamount' => $spayment_payableamount,  'sales_paymentpending' => $spayment_pending, 'sales_payment_id' => $data->id
        ]);

        return redirect()->route('salespayment.index')->with('add', 'Payment Data added successfully!');
    }



    public function edit(Request $request, $unique_key)
    {
        $SalespaymentData = Salespayment::where('unique_key', '=', $unique_key)->first();

        return redirect()->route('salespayment.index')->with('update', 'Payment Data updated successfully!');
    }


    public function delete($unique_key)
    {
        $data = Salespayment::where('unique_key', '=', $unique_key)->first();

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('salespayment.index')->with('soft_destroy', 'Successfully deleted the Payments !');
    }

}
