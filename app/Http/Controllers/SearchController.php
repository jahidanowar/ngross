<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request,
            [
                'key' => 'required',
            ],
        );

        $products = Product::where('title', 'LIKE', "%{$request->key}%")->get();

        return $products;
    }
}
