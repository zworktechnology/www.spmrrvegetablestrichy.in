<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Branch;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Bank;
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
            $branch = Branch::findOrFail($datas->branch_id);
            $supplier = Supplier::findOrFail($datas->supplier_id);

            $purchase_data[] = array(
                'branch' => $branch->name,
                'supplier' => $supplier->name,
                'bill_no' => $datas->bill_no,
                'date' => $datas->date,
                'time' => $datas->time,
                'grand_total' => $datas->grand_total,
                'status' => $datas->status,
                'unique_key' => $datas->unique_key,
            );
        }

        return view('page.backend.purchase.index', compact('purchase_data'));
    }


    public function create()
    {
        $product = Product::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
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
        return view('page.backend.purchase.create', compact('product', 'branch', 'supplier', 'today', 'timenow', 'bank', 'billno'));
    }



    public function store(Request $request)
    {

        // Purchase Table
        $randomkey = Str::random(5);
        $branch_id = $request->get('branch_id');
        $supplier_id = $request->get('supplier_id');


        
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
            $PurchaseProduct->product_id = $product_id;
            $PurchaseProduct->bag = $request->bag[$key];
            $PurchaseProduct->kgs = $request->kgs[$key];
            $PurchaseProduct->price_per_kg = $request->price_per_kg[$key];
            $PurchaseProduct->total_price = $request->total_price[$key];
            $PurchaseProduct->save();
        }
        


        return redirect()->route('purchase.index')->with('add', 'Purchase Data added successfully!');
    }



    public function getProducts()
    {
        $GetProduct = Product::where('soft_delete', '!=', 1)->get();
        $userData['data'] = $GetProduct;
        echo json_encode($userData);
    }
}
