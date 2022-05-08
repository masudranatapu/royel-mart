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
                                            <th class="text-center">Order Code</th>
                                            <th class="text-center">Order Date</th>
                                            <th>Customer</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Payment Method</th>
                                            <th class="text-center">Payment Status</th>
                                            <th class="text-center">Order Status</th>
                                            <th class="text-center" width="8%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $key => $order)
                                            <tr class="@if($order->status == 'Canceled') text-danger @endif">
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="text-center">{{ $order->order_code }}</td>
                                                <td class="text-center">{{ $order->created_at->format('d M Y h:i A') }}</td>
                                                <td>
                                                    {{ $order->customer->name }} <br>
                                                    {{ $order->customer->phone }}
                                                </td>
                                                <td class="text-center">{{ $order->total }} TK</td>
                                                <td class="text-center">{{ $order->payment_method }}</td>
                                                <td class="text-center">
                                                    @if ($order->due > 0)
                                                        Due ({{ number_format($order->due) }} ৳)
                                                    @else
                                                        Paid
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($order->status == 'Canceled')
                                                        <span class="badge bg-danger text-white">Canceled</span>
                                                    @elseif($order->status == 'Successed')
                                                        <span class="badge bg-success text-white">Successed</span>
                                                    @else
                                                        <form action="{{ route('admin.order-status-change') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                            <select name="status" id="" class="form-control select2" onchange="this.form.submit()">
                                                                <option value="">Select One</option>
                                                                <option @if($order->status == 'Pending') selected @endif disabled value="Pending">Pending</option>
                                                                <option @if($order->status == 'Confirmed') selected @endif @if($order->status == 'Confirmed' || $order->status == 'Processing' || $order->status == 'Delivered'  || $order->status == 'Successed' || $order->status == 'Canceled') disabled @endif  value="Confirmed">Confirmed</option>
                                                                <option @if($order->status == 'Processing') selected @endif @if($order->status == 'Processing' || $order->status == 'Delivered'  || $order->status == 'Successed' || $order->status == 'Canceled') disabled @endif value="Processing">Processing</option>
                                                                <option @if($order->status == 'Delivered') selected @endif @if($order->status == 'Delivered'  || $order->status == 'Successed' || $order->status == 'Canceled') disabled @endif value="Delivered">Delivered</option>
                                                                <option @if($order->status == 'Successed') selected @endif @if($order->status == 'Successed' || $order->status == 'Canceled') disabled @endif value="Delivered" value="Successed">Successed</option>
                                                                <option @if($order->status == 'Canceled') selected @endif @if($order->status == 'Confirmed' || $order->status == 'Processing' || $order->status == 'Delivered'  || $order->status == 'Successed' || $order->status == 'Canceled') disabled @endif value="Canceled">Canceled</option>
                                                            </select>
                                                        </form>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($order->status != 'Canceled')
                                                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-info" title="View Order Details">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm @if($order->status == 'Canceled') btn-danger @else btn-success @endif" title="View Order Details">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.invoice-print',$order->id) }}" target="_blank" class="btn btn-sm btn-warning" ><i class="fa fa-print"></i></a>
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
