@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{asset('/vendor/datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">{{ __('Products') }}</h1>
    <a href="{{route('product.create')}}" class="badge badge-primary mb-4">Add New Product</a>

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
            <table id="dataTable" class="table table-bordered dataTable" style="width: 100%;" width="100%">
                <thead>
                    <tr>
                        <th>SL/N</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Categories</th>
                        <th>Vendor</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
<!-- Page level plugins -->
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script>

$(document).ready(function() {
    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('product.list') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'title', name: 'title'},
            {data: 'price', name: 'price'},
            {data: 'stock', name: 'stock'},
            {data: 'categories', name: 'categories.title'},
            {data: 'user.name', name: 'vendor'},
            {
                data: 'action',
                name: 'action',
            },
        ]
    });

});

</script>
@endpush
{{-- @section('scripts')
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
@endsection --}}
