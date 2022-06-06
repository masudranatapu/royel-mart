@extends('layouts.backend.app')

@section('title')
    {{$title}}
@stop

@push('css')

@endpush

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-pink text-white">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Product</p>
                                            <h4 class="m-b-0">{{ total_product() }}</h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <i class="feather icon-book f-50 text-c-pink"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-green text-white">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Total Sale</p>
                                            <h4 class="m-b-0">৳ {{ total_sale() }}</h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <i
                                                class="feather icon-credit-card f-50 text-c-green"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-blue text-white">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Orders</p>
                                            <h4 class="m-b-0">{{ total_order() }}</h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <i
                                                class="feather icon-shopping-cart f-50 text-c-blue"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-c-yellow text-white">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Total Customer</p>
                                            <h4 class="m-b-0">{{ total_customer() }}</h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <i class="feather icon-user f-50 text-c-yellow"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2>Today's Order <small class="badge bg-success text-white">{{ $today_order->count() }}</small></h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
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
                                        @foreach($today_order as $key => $order)
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
                                                    {{ $order->status }}
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

@endpush
