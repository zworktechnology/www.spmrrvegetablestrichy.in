<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Productlist;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::where('soft_delete', '!=', 1)->get();
        $branch_data = Branch::where('soft_delete', '!=', 1)->where('status', '!=', 1)->get();
        $productlistdata = Productlist::where('soft_delete', '!=', 1)->get();
        $product_data = [];
        foreach ($data as $key => $datas) {
            $branch = Branch::findOrFail($datas->branchtable_id);
            $productlist = Productlist::findOrFail($datas->productlist_id);
            $product_data[] = array(
                'unique_key' => $datas->unique_key,
                'product' => $datas->name,
                'available_stockin_bag' => $datas->available_stockin_bag,
                'available_stockin_kilograms' => $datas->available_stockin_kilograms,
                'branch' => $branch->name,
                'status' => $datas->status,
                'branchtable_id' => $datas->branchtable_id,
                'description' => $datas->description,
                'productlist_id' => $datas->productlist_id,
                'productlist' => $productlist->name,
            );
        }

        

        return view('page.backend.product.index', compact('branch_data', 'product_data', 'productlistdata'));
    }

    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new Product();

        $data->unique_key = $randomkey;
        $data->productlist_id = $request->get('productlist_id');
        $data->branchtable_id = $request->get('branchid');
        $data->description = $request->get('description');
        $data->available_stockin_bag = $request->get('available_stockin_bag');
        $data->available_stockin_kilograms = $request->get('available_stockin_kilograms');
        
        $data->save();


        return redirect()->route('product.index')->with('add', 'Product Data added successfully!');
    }


    public function edit(Request $request, $unique_key)
    {
        $ProductData = Product::where('unique_key', '=', $unique_key)->first();

        $ProductData->productlist_id = $request->get('productlist_id');
        $ProductData->branchtable_id = $request->get('branchid');
        $ProductData->description = $request->get('description');
        $ProductData->available_stockin_bag = $request->get('available_stockin_bag');
        $ProductData->available_stockin_kilograms = $request->get('available_stockin_kilograms');
        $ProductData->status = $request->get('status');

        $ProductData->update();

        return redirect()->route('product.index')->with('update', 'Product Data updated successfully!');
    }


    public function delete($unique_key)
    {
        $data = Product::where('unique_key', '=', $unique_key)->first();

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('product.index')->with('soft_destroy', 'Successfully deleted the product !');
    }


    

}
