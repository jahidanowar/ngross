@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{asset('/vendor/datatables/dataTables.bootstrap4.min.css')}}">
    <style>
        @media print {

            body * {
                visibility: hidden;
            }
            #section-to-print{
                width: 100% !important;
            }
            #section-to-print, #section-to-print * {
                visibility: visible;
            }
            #section-to-print {
                position: absolute;
                left: 0;
                top: 0;
            }
            .print-button{
                visibility: hidden;
            }
        }
    </style>
@endsection

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">{{ __('Order #') }} {{$order->order_number}}</h1>

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
            <h6 class="m-0 font-weight-bold text-primary">Order Information</h6>
        </div>
        <div class="card-body px-5" id="section-to-print">
            <div class="d-flex justify-content-between">
                <div>
                    <h5 class="font-weight-bold">Billing to</h5>
                    Name: {{$user->name}} <br>
                    Email: {{$user->email}} <br>
                    Phone: <strong>{{$user->phone}}</strong> <br>
                    Address: {{$user->address}}
                </div>
                <div>
                    <h5 class="font-weight-bold">Order Information</h5>
                    Order #: <span class="font-weight-bold">{{$order->order_number}}</span> <br/>
                    Status: <span class="font-weight-bold">{{$order->status}}</span> <br/>
                    Date: <span class="font-weight-bold">{{$order->created_time}}</span>
                </div>

            </div>
            <table class="table mt-5">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{$product->title}}</td>
                        <td>{{$product->pivot->quantity}}</td>
                        <td>Rs {{$product->price}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td class="text-right"><strong>Total: </strong></td>
                        <td><strong>Rs {{$order->total_amount}}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center print-button pb-5 d-inline-flex justify-content-center">
            @if ($order->status !== "Order Completed")
                <form action="{{route('manager.order.update', $order->id)}}" method="POST">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="status" value="Order Completed">
                    <button type="submit" class="btn btn-primary">Order Complete</button>
                </form>
            @endif
            <button class="btn btn-info ml-2" onclick="window.print();">Print</button>
        </div>
    </div>

@endsection
