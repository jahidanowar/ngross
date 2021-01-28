@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{asset('/vendor/datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">{{ __('Users') }}</h1>
    <a href="{{route('user.create')}}" class="badge badge-primary mb-4">Add New User</a>

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
        <div class="col-md-7">
            <!-- Vendor Products -->
            @if ($user->user_type == "vendor")
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Vendor Orders</h6>
                    </div>
                    <div class="card-body">
                        <table id="dataTable" class="table table-bordered dataTable" style="width: 100%;" width="100%">
                            <thead>
                                <tr>
                                    <th>SL/N</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $id = 0;
                                @endphp
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{++$id}}</td>
                                        <td>{{$order['product_name']}}</td>
                                        <td>{{$order['quantity']}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">User Orders</h6>
                    </div>
                    <div class="card-body">
                        <table id="dataTable" class="table table-bordered dataTable" style="width: 100%;" width="100%">
                            <thead>
                                <tr>
                                    <th>SL/N</th>
                                    <th>Orders No</th>
                                    <th>Products</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $id = 0;
                                @endphp
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{++$id}}</td>
                                        <td>{{$order->order_number}}</td>
                                        <td>
                                            @foreach ($order->products as $product)
                                                <span class="badge">{{$product->title}}</span><br>
                                            @endforeach
                                        </td>
                                        <td>₹{{$order->total_amount}}</td>
                                        <td>{{$order->status}}</td>
                                        <td>Action</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Info</h6>
                </div>
                <div class="card-body">
                    <form action="{{route('user.update', $user->id)}}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="Name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{$user->name}}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" class="form-control" value="{{$user->email}}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{$user->phone}}">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{$user->address}}">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<!-- Page level plugins -->
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script>
</script>
@endpush
