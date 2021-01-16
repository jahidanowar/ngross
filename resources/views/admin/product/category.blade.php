@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">{{ __('Manage Categories') }}</h1>
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

<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add New Category</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('category.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control" value="{{ old('image') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Create</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Categories</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered" width="100%" style="width: 100%">
                    <thead>
                        <tr>
                            <th>SL/NO</th>
                            <th>Title</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $id=0
                        @endphp
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{++$id}}</td>
                                <td>{{$category->title}}</td>
                                <td>
                                    <a href="{{route('category.edit', $category->id)}}" class="btn btn-warning">Edit</a>
                                    <form action="{{route('category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display: inline-block;">
                                        @method('DELETE')
                                        @csrf
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- Page level plugins -->
<script>

</script>
@endpush
