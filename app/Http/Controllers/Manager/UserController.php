<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    function __construct()
    {
        $this->middleware(['auth:sanctum', 'manager']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orderBy = $request->order_by;

        $vendors = User::where('manager_id', auth()->user()->id)->where('user_type', 'vendor')->get();
        return view('manager.user.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('manager.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|confirmed|min:6',
            'address' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->manager_id = auth()->user()->id;

        switch($request->user_type){
            case "vendor":
                $user->user_type = "vendor";
                break;
            case "user":
                $user->user_type = "user";
                break;
        }
        $user->password = bcrypt($request->password);

        if($user->save()){
            return redirect()->back()->with('message', 'User has been added!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if($user->manager_id !== auth()->user()->id){
            return redirect()->back()->with('message', 'You have no permission to manage this vendor');
        }

        $vendorOrders = $user->products()->with('orders')->get();

        // $vendorOrders->each(function($vendorOrder){
        //     $vendorOrder->orders()->filter(function($order){
        //         return $order->status == "Order Completed";
        //     })
        // });

        foreach ($vendorOrders as $vendorOrder) {
            $quantity = 0;
            $orders = collect([]);

            foreach ($vendorOrder->orders as $order){
                if($order->status !== "Order Delivered"){
                    $quantity +=  $order->pivot->quantity;
                    $orders->push($order);
                }
            }
            $vendorOrder->quantity = $quantity;
            $vendorOrder->orders = $orders;
        }

        // dd($vendorOrders);
        return view('manager.user.show', compact('vendorOrders', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
