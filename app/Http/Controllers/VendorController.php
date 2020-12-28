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
    public function orders(){
        return auth()->user()->vendorOrders();
    }

    //Update Product
    public function productUpdate(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->stock = $request->stock;
            $product->save();
            $response = [
                "message" => "Product Updated"
            ];
            return response()->json($response, 201);
        }
    }
}
