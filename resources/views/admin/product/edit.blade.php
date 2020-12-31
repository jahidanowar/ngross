@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">{{ __('Edit Product') }}</h1>
    <a href="{{route('product.index')}}" class="badge badge-primary mb-4">View All Products</a>

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Products</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('product.update', $product->id)}}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{$product->title}}">
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" name="price" id="price" class="form-control" value="{{$product->price}}">
                </div>
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="text" name="stock" id="stock" class="form-control" value="{{$product->stock}}">
                </div>
                <div class="form-group">
                    <label for="category">Categories</label>
                    <select multiple class="form-control" name="categories[]" required>
                        @foreach ($categories as $category)
                            @if (in_array($category->id, $categoryIds))
                                <option value="{{$category->id}}" selected>{{$category->title}}</option>
                            @else
                                <option value="{{$category->id}}">{{$category->title}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="vendor">Vendor</label>
                    <select class="form-control" name="vendor_id">
                        @foreach ($vendors as $vendor)
                            @if ($product->vendor_id == $vendor->id)
                                <option value="{{$vendor->id}}" selected>{{$vendor->name}}</option>
                            @else
                                <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Update</button>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<!-- Page level plugins -->
<script>

</script>
@endpush
