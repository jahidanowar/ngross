@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{asset('/vendor/datatables/dataTables.bootstrap4.min.css')}}">
    <style>
        #viewOrder:focus, #viewOrder:hover{
            cursor: pointer;
        }
    </style>
@endsection

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">{{ __('Orders of ') }} {{$user->name}}</h1>

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
            @foreach ($vendorOrders as $vendorOrder)
                <div id="viewOrder" data-orders="{{$vendorOrder['orders']}}" class="shadow p-3 mb-3 rounded border">
                    <h4>{{$vendorOrder['product_name']}}</h4>
                    <p>Quanity: {{$vendorOrder['quantity']}}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="orderModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="orderModalLabel">Orders</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    $(".card-body").on('click', '#viewOrder', function(){
        console.log($(this).data('orders'))
        $("#orderModal").modal('show')
    })
</script>
@endpush
