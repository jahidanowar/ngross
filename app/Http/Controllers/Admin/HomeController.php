<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth:sanctum', 'admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::count();
        $order = Order::count();

        $widget = [
            'users' => $user,
            'orders' => $order,
        ];

        return view('admin.home', compact('widget'));
    }
}
