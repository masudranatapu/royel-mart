@extends('layouts.backend.app')

@section('title')
    {{$title}}
@stop

@push('css')
    <link rel="stylesheet" href="{{asset('backend/select2/css/select2.css')}}">
@endpush

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2>{{ $title }} <small class="badge bg-success text-white">{{ $orders->count() }}</small></h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive">
                                <table id="simpletable" class="table table-striped table-bordered nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">SL No</th>
                                            <th width="10%">Name</th>
                                            <th width="10%">Email</th>
                                            <th width="10%">Phone</th>
                                            <th width="25%">Address</th>
                                            <th width="10%" class="text-center">Image</th>
                                            <th width="8%" class="text-center">Date</th>
                                            <th width="8%" class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $key => $order)
                                            <tr class="@if($order->status == 'Canceled') text-danger @endif">
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>{{ $order->name }}</td>
                                                <td>{{ $order->phone }}</td>
                                                <td>{{ $order->email }}</td>
                                                <td>{{ $order->address }}</td>
                                                <td>
                                                    <a href="{{ URL::to($order->image) }}" target="_blank">
                                                        <img src="{{ URL::to($order->image) }}" width="100%" height="100px" alt="">
                                                    </a>
                                                </td>
                                                <td class="text-center">{{ $order->created_at->format('d M Y h:i A') }}</td>
                                                <td class="text-center">
                                                    @if($order->status == 'Canceled')
                                                        <span class="badge bg-danger text-white">Canceled</span>
                                                    @else
                                                        @if($order->status == 'Approved')
                                                            <span class="badge bg-success text-white">Approved</span>
                                                        @else
                                                            <form action="{{ route('admin.custom-order-status-change') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                                <select name="status" id="" class="form-control select2" onchange="this.form.submit()">
                                                                    <option value="">Select One</option>
                                                                    <option @if($order->status == 'Pending') selected @endif disabled value="Pending">Pending</option>
                                                                    <option @if($order->status == 'Approved') selected @endif @if($order->status == 'Approved'|| $order->status == 'Canceled') disabled @endif  value="Approved">Approved</option>
                                                                    <option @if($order->status == 'Canceled') selected @endif @if($order->status == 'Approved'|| $order->status == 'Canceled') disabled @endif value="Canceled">Canceled</option>
                                                                </select>
                                                            </form>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('backend/select2/js/select2.full.min.js')}}"></script>
    <script>
        $('.select2').select2();
    </script>
@endpush
