<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->orders()->with('products')->orderBy('id', 'DESC')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $orderData = [
            'status' => "Order Placed",
            'total_amount' => $request->total,
            'user_id' => auth()->user()->id,
        ];

        $order = Order::create($orderData);
        $order->order_number = "NGO" . $order->id;
        $order->save();

        $products = $request->cartItems;

        // Saving the Ordered Items
        foreach ($products as $product) {
            OrderProduct::create(['order_id' => $order->id, 'product_id' => $product['id'], 'quantity' => $product['quantity']]);
            //Decrease the stock
            $dbproduct = Product::find($product['id']);
            $dbproduct->stock -=  $product['quantity'];
            $dbproduct->save();
        }

        $response = [
            "message" => "Order Placed",
            "order" => $order
        ];
        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order = $order->with('products')->get();

        if (!$order) {
            $response = [
                "message" => "Orders Not found"
            ];
            return response()->json($response, 404);
        } else {
            $response = $order;
            return response()->json($response, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
