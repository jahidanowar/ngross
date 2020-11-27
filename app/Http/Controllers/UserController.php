<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct() {
        // $this->middleware('auth');
    }
    
    public function index()
    {
        dd(Auth::user()->name);
    }
}
