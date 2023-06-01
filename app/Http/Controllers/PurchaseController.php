<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Branch;
use App\Models\Supplier;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    public function index()
    {
        $data = Purchase::where('soft_delete', '!=', 1)->get();

        return view('page.backend.purchase.index', compact('data'));
    }


    public function create()
    {
        $product = Product::where('soft_delete', '!=', 1)->get();
        $branch = Branch::where('soft_delete', '!=', 1)->get();
        $supplier = Supplier::where('soft_delete', '!=', 1)->get();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');
        return view('page.backend.purchase.create', compact('product', 'branch', 'supplier', 'today', 'timenow'));
    }
}
