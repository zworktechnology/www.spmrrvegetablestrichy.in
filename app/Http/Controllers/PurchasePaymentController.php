<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Branch;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\PurchasePayment;
use App\Models\Productlist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class PurchasePaymentController extends Controller
{
    public function index()
    {

        $data = PurchasePayment::where('soft_delete', '!=', 1)->get();
        
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        $allbranch = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $supplier = Supplier::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        
        return view('page.backend.purchasepayment.index', compact('data', 'today', 'allbranch', 'supplier', 'timenow'));
    }


    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new PurchasePayment();

        $data->unique_key = $randomkey;
        $data->supplier_id = $request->get('supplier_id');
        $data->branch_id = $request->get('branch_id');
        $data->purchase_id = $request->get('payment_purchase_id');
        $data->date = $request->get('date');
        $data->time = $request->get('time');
        $data->oldblance = $request->get('oldblance');
        $data->amount = $request->get('payment_payableamount');
        $data->payment_pending = $request->get('payment_pending');
        $data->save();

        $payment_paid_amount = $request->get('payment_payableamount');
        $payment_pending = $request->get('payment_pending');
        $payment_purchase_id = $request->get('payment_purchase_id');


        DB::table('purchases')->where('id', $payment_purchase_id)->update([
            'payment_paid_amount' => $payment_paid_amount,  'payment_pending' => $payment_pending, 'purchase_payment_id' => $data->id
        ]);

        return redirect()->route('purchasepayment.index')->with('add', 'Payment Data added successfully!');
    }



    public function edit(Request $request, $unique_key)
    {
        $PurchasePaymentData = PurchasePayment::where('unique_key', '=', $unique_key)->first();

        return redirect()->route('purchasepayment.index')->with('update', 'Payment Data updated successfully!');
    }


    public function delete($unique_key)
    {
        $data = PurchasePayment::where('unique_key', '=', $unique_key)->first();

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('purchasepayment.index')->with('soft_destroy', 'Successfully deleted the Payments !');
    }

}
