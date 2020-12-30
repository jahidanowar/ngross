<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;

class ProductController extends Controller
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
        $products = [];
        return view('admin.product.index', compact('products'));
    }

    public function getProducts(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::with('user')->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('product.edit', $row->id) . '" class="edit btn btn-info">Edit</a>

                    <form action="' . route('product.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\' Are you sure? \')" style="display: inline-block;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                    </form>

                    ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('price', '₹ {{$price}}')
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendors = User::where('user_type', 'vendor')->get();
        return view('admin.product.create', compact('vendors'));
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
            'title' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'required|file|max:150',
            'vendor_id' => 'required',
        ]);


        $imagePath = $request->file('image')->store('product/'. Str::random(10).$request->image->extension());
        $slug = Str::slug($request->title);

        $product = Product::create([
            'title' => $request->title,
            'price' => $request->price,
            'stock' => $request->stock,
            'vedor_id' => $request->vedor_id,
            'image' => $imagePath,
            'slug' => $slug,
        ]);
        return redirect()->back()->with('message', 'Product has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $vendors = User::where('user_type', 'vendor')->get();
        return view('admin.product.edit', ['product' => $product, 'vendors' => $vendors]);
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
        $request->validate([
            'title' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'vendor_id' => 'required'
        ]);

        Product::where('id', $id)->update($request->only(['title', 'price', 'stock', 'vendor_id']));

        return redirect()->back()->with('message', 'Product has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->back()->with('message', 'Product has been deleted');

    }
}
