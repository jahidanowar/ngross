@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{asset('/vendor/datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">{{ __('Products') }}</h1>
    <a href="{{route('order.index')}}" class="badge badge-primary mb-4">View Vendor Orders</a>

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
                        <th>Date/Time</th>
                        <th>Order Number</th>
                        <th>Total Amount</th>
                        <th>User</th>
                        <th>Address</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{$order->created_at->format('d/m/Y h:i a')}}</td>
                            <td>{{$order->order_number}}</td>
                            <td>₹{{$order->total_amount }}</td>
                            <td>{{$order->user->name}}</td>
                            <td>{{$order->user->address}}</td>
                            <td>{{$order->status}}</td>
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
{{-- @section('scripts')
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
@endsection --}}
