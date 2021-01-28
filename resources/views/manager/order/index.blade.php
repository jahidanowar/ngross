@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{asset('/vendor/datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">{{ __('Orders') }}</h1>

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
            <h6 class="m-0 font-weight-bold text-primary">All Orders</h6>
        </div>
        <div class="card-body">
            <table id="dataTable" class="table table-bordered dataTable" style="width: 100%;" width="100%">
                <thead>
                    <tr>
                        <th>SL/N</th>
                        <th>Order Number</th>
                        <th>Total Amount</th>
                        <th>User</th>
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
                            <td>Rs {{$order->total_amount}}</td>
                            <td>{{$order->user->name}}</td>
                            <td>{{$order->status}}</td>
                            <td>
                                <a href="{{route('manager.order.show', $order->id)}}" class="btn btn-primary btn-sm">View Orders</a>
                            </td>
                        </tr>
                    @endforeach
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
    $('#dataTable').DataTable();
});

</script>
@endpush
