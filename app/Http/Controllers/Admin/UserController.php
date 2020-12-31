<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
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
        //
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

        $products = [];

        if($user && $user->user_type == "vendor"){
            $products = $user->products;
        }

        return view('admin.user.details', compact(['user', 'products']));

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

    //Return User List
    public function getusers(Request $request){

        if ($request->ajax()) {
            $data = User::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                    <a href="' . route('user.show', $row->id) . '" class="edit btn btn-primary">View</a>
                    <a href="' . route('user.edit', $row->id) . '" class="edit btn btn-info">Edit</a>

                    <form action="' . route('user.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\' Are you sure? \')" style="display: inline-block;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                    </form>

                    ';
                    return $actionBtn;
                })
                ->addColumn('status', function (User $user) {
                    switch($user->user_type){
                        case "vendor":
                            return "Vendor";
                            break;
                        case "user":
                            return "User";
                            break;
                        default:
                            return "Admin";
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
