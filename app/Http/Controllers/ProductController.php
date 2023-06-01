<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::where('soft_delete', '!=', 1)->get();

        return view('page.backend.product.index', compact('data'));
    }

    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new Product();

        $data->unique_key = $randomkey;
        $data->name = $request->get('name');
        $data->description = $request->get('description');
        $data->available_stockin_bag = $request->get('available_stockin_bag');
        $data->available_stockin_kilograms = $request->get('available_stockin_kilograms');
        
        $data->save();


        return redirect()->route('product.index')->with('add', 'Product Data added successfully!');
    }


    public function edit(Request $request, $unique_key)
    {
        $ProductData = Product::where('unique_key', '=', $unique_key)->first();

        $ProductData->name = $request->get('name');
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
