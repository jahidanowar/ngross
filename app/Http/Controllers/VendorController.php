<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    // Return All the Products Related to vendor
    public function products()
    {
        return auth()->user()->products()->orderBy('id', 'DESC')->get();
    }
    //Return All the orders that related to vendor
    public function orders(Request $request)
    {
        if($request->query('byhour')){
            return auth()->user()->vendorOrders($request->query('byhour'));
        }
        return auth()->user()->vendorOrders();
    }

    //Update Product
    public function productUpdate(Request $request)
    {
        $product = Product::find($request->id);
        if ($product) {
            $product->stock = $request->stock;
            $product->price = $request->price;
            $product->title = $request->title;
            $product->save();
            $response = [
                "message" => "Product Updated"
            ];
            return response()->json($response, 201);
        }
    }
}
