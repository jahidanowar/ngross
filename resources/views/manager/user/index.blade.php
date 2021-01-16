@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{asset('/vendor/datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">{{ __('Users') }}</h1>
    <a href="{{route('manager.user.create')}}" class="badge badge-primary mb-4">Add New Vendor</a>

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
            <h6 class="m-0 font-weight-bold text-primary">All Vendors</h6>
        </div>
        <div class="card-body">
            <table id="dataTable" class="table table-bordered dataTable" style="width: 100%;" width="100%">
                <thead>
                    <tr>
                        <th>SL/N</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $id = 0;
                    @endphp
                    @foreach ($vendors as $vendor)
                        <tr>
                            <td>{{++$id}}</td>
                            <td>{{$vendor->name}}</td>
                            <td>{{$vendor->phone}}</td>
                            <td>{{$vendor->address}}</td>
                            <td>
                                <a href="{{route('manager.user.show', $vendor->id)}}" class="btn btn-primary btn-sm">View Orders</a>
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
