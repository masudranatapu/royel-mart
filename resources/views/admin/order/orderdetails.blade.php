@extends('layouts.backend.app')

@section('title')
    {{$title}}
@stop

@push('css')
    <link rel="stylesheet" href="{{asset('backend/select2/css/select2.css')}}">
    <link rel="stylesheet" href="{{asset('backend/invoice-print.css')}}">
@endpush

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper" id="invoce-area">
                <div class="page-body">
                    <div class="card">
                        <div class="row invoice-contact">
                            <div class="col-md-10">
                                <div class="invoice-box row">
                                    <div class="col-sm-12">
                                        <table class="table table-responsive invoice-table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <img src="{{ URL::to($website->logo) }}" width="260" class="m-b-10" alt="">
                                                        <a href="{{ route('admin.invoice-print',$order->id) }}" target="_blank" class="btn btn-sm btn-success ml-4" ><i class="fa fa-print"></i> Print</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $website->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{$website->address}}</td>
                                                </tr>
                                                <tr>
                                                    <td><a href="mailto:{{ $website->email }}" target="_top">{{ $website->email }}</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $website->phone }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 pr-4">
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
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="row invoive-info">
                                <div class="col-md-4   invoice-client-info">
                                    <h6>Shipping Information:</h6>
                                    <h6 class="m-0">{{ $order->shipping_name }}</h6>
                                    <p class="m-0 m-t-10">{{ $order->shipping_address }}</p>
                                    <p class="m-0">{{ $order->shipping_phone }}</p>
                                    <p>{{ $order->shipping_email }}</p>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <h6>Order Information :</h6>
                                    <table class="table table-responsive invoice-table invoice-order table-borderless">
                                        <tbody>
                                            <tr>
                                                <th>Date :</th>
                                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y')}}</td>
                                            </tr>
                                            <tr>
                                                <th>Status :</th>
                                                <td>
                                                    <span class="label label-warning">{{ $order->status }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Id :</th>
                                                <td>
                                                    #{{ $order->id }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Adjust Shipping Charge : </th>
                                                <td>
                                                    <span class="ml-2"><button class="btn btn-sm btn-success" data-toggle="modal" data-target="#adjust-shipping-charge">Adjust</button></span>
                                                </td>
                                                <div class="modal fade" id="adjust-shipping-charge" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Adjust Charge</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true"> &times; </span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.adjust-order-shipping-charge', $order->id) }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="form-group row">
                                                                        <label class="col-md-2"><strong>Shipping Charge</strong></label>
                                                                        <div class="col-md-8">
                                                                            <input type="number" class="form-control" name="shipping_amount" value="{{ $order->shipping_amount }}" required placeholder="Adjust Charge">
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <input type="submit" class="btn btn-success" value="Submit">
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <h6 class="m-b-20">Invoice Number
                                        <span>#{{ $order->order_code }}</span></h6>
                                    <h6 class="text-uppercase">Payment Method :
                                        <span>{{ $order->payment_method }}</span>
                                    </h6>
                                    <h6 class="text-uppercase text-success">Total Paid :
                                        <span>
                                            {{ number_format($order->paid) }} ৳
                                        </span>
                                    </h6>
                                    <h6 class="text-uppercase text-danger">Total Due :
                                        <span>
                                            {{ number_format($order->due) }} ৳
                                            @if($order->due <= 0) <span cllass="text-success">Paid</span> @endif
                                            @if($order->due > 0 && $order->status != 'Pending') <span cllass=""><button class="btn btn-sm btn-success" data-toggle="modal" data-target="#due-payment-modal">Pay</button></span> @endif
                                        </span>
                                    </h6>
                                    <div class="modal fade" id="due-payment-modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Due Payment</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true"> &times; </span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.order-due-payment', $order->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group row">
                                                            <label class="col-md-2"><strong>Due Amount</strong></label>
                                                            <div class="col-md-8">
                                                                <input type="number" class="form-control" name="paid" value="{{ $order->due }}" required placeholder="Due payment">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="submit" class="btn btn-success" value="Paid">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table  invoice-detail-table">
                                            <thead>
                                                <tr class="thead-default">
                                                    <th>Description</th>
                                                    <th class="text-right">Quantity</th>
                                                    <th class="text-right">Amount</th>
                                                    <th class="text-right">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->products as $key => $o_product)
                                                    @php
                                                        $product = App\Models\Product::findOrFail($o_product->product_id);
                                                        $p_color = App\Models\ProductOrderColor::where('order_code', $order->order_code)->where('product_id', $o_product->product_id)->first();
                                                    @endphp
                                                    <tr>
                                                        <td class="d-flex">
                                                            <span>
                                                                <img width="100" height="100" src="{{ asset($product->thumbnail) }}" alt="">
                                                            </span>
                                                            <span class="ml-2">
                                                                <h6>{{ $product->name }}</h6>
                                                                <p>
                                                                    @if ($p_color)
                                                                        @php
                                                                            $color = App\Models\Color::findOrFail($p_color->color_id);
                                                                            $p_size = App\Models\ProductOrderColorSize::where('order_code', $order->order_code)->where('product_id', $o_product->product_id)->where('color_id', $color->id)->first();
                                                                        @endphp
                                                                        Color: {{ $color->name }}
                                                                        @if ($p_size)
                                                                            @php
                                                                                $size = App\Models\Size::findOrFail($p_size->size_id);
                                                                            @endphp
                                                                            ,Size: {{ $size->name }}
                                                                        @endif
                                                                    @endif
                                                                </p>
                                                            </span>
                                                        </td>
                                                        <td class="text-right">{{ $o_product->quantity }}</td>
                                                        <td class="text-right">{{ number_format($o_product->sale_price) }} ৳</td>
                                                        <td class="text-right">{{ number_format($o_product->sale_price * $o_product->quantity) }} ৳</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-responsive invoice-table invoice-total">
                                        <tbody>
                                            <tr>
                                                <th class="text-right">Sub Total :</th>
                                                <td class="text-right">{{ number_format($order->sub_total) }} ৳</td>
                                            </tr>
                                            <tr>
                                                <th class="text-right">Shipping :</th>
                                                <td class="text-right">{{ number_format($order->shipping_amount) }} ৳</td>
                                            </tr>
                                            <tr>
                                                <th class="text-right">Discount :</th>
                                                <td class="text-right">{{ number_format($order->discount) }} ৳</td>
                                            </tr>
                                            <tr class="text-info">
                                                <td class="text-right">
                                                    <hr>
                                                    <h5 class="text-primary">Total :</h5>
                                                </td>
                                                <td class="text-right">
                                                    <hr>
                                                    <h5 class="text-primary">{{ number_format($order->total) }} ৳</h5>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h6>Terms And Condition :</h6>
                                    <p></p>
                                </div>
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
