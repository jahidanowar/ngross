<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
            $data = Product::with('user')->with('categories')->latest()->get();
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
                ->addColumn('categories', function (Product $product) {
                    return $product->categories->map(function($category) {
                        return "<span class='badge badge-primary mr-2'>". $category->title;
                    })->implode('</span>');
                })
                ->rawColumns(['action', 'categories'])
                ->editColumn('price', '₹ {{$price}}')
                ->editColumn('stock', '{{$stock == 0 ? "Out of stock" : $stock}}')
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
        $categories = Category::orderBy('title')->get();
        return view('admin.product.create', ['vendors' => $vendors, 'categories' => $categories]);
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
            'image' => 'required|file|mimes:png,jpg,jpeg,webp|max:150',
            'vendor_id' => 'required|numeric|min:1',
        ]);
        $imagePath = $request->file('image')->store('public/product');
        $slug = Str::slug($request->title);

        $product = Product::create([
            'title' => $request->title,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'slug' => $slug,
            'description' => '',
            'vendor_id' => $request->vendor_id,
        ]);

        if($request->categories && !empty($request->categories)){
            $product->categories()->sync($request->categories);
        }

        return redirect()->back()->with('message', 'Product has been created');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $vendors = User::where('user_type', 'vendor')->get();
        $product = Product::where('id', $id)->with('categories')->first();
        $categoryIds = [];
        foreach($product->categories as $category){
            $categoryIds[] = $category->id;
        }
        return view('admin.product.edit', ['product' => $product, 'vendors' => $vendors, 'categories'=>$categories, 'categoryIds'=>$categoryIds]);
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
            'image' => 'required|file|mimes:png,jpg,jpeg,webp|max:150',
            'vendor_id' => 'required'
        ]);
        $imagePath = $request->file('image')->store('public/product');
        $product = Product::where('id', $id)->update(
            [
                'title' => $request->title,
                'price' => $request->price,
                'stock' => $request->stock,
                'image' => $imagePath,
                'vendor_id' => $request->vendor_id,
            ]
        );
        if($request->categories && $product){
            $product = Product::find($id);
            $product->categories()->sync($request->categories);
        }
        return redirect()->route('product.index')->with('message', 'Product has been updated');
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
