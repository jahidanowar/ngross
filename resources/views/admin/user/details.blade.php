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
        <div class="col-md-6">
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
                                    <th>Orders No</th>
                                    <th>Products</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

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

                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Info</h6>
                </div>
                <div class="card-body">

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
