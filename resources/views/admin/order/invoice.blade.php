
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/fontawesome.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <!-- BEGIN INVOICE -->
            <div class="col-xs-12">
                <div class="grid invoice">
                    <div class="grid-body">
                        <div class="invoice-title">
                            <div class="row">
                                <div class="col-xs-12">
                                    <img src="{{ URL::to($website->logo) }}" alt="" height="35">
                                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-info pull-right mr-2 order-list-btn">Order List</a>
                                    <a href="{{ route('admin.invoice-print',$order->id) }}" class="btn btn-sm btn-info pull-right mr-2 order-list-btn"><i class="fa-solid fa-print"></i> Print</a>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-12">
                                    <h2>invoice<br>
                                    <span class="small">order #{{ $order->id }}</span></h2>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-6">
                                <address>
                                    <strong>Shipping Information:</strong><br>
                                    {{ $order->shipping_name }},<br>
                                    {{ $order->shipping_address }},<br>
                                    <abbr title="Phone">P:</abbr> {{ $order->shipping_phone }}
                                </address>
                            </div>
                            <div class="col-xs-6 text-right">
                                <address>
                                    <strong>Company Information :</strong><br>
                                    {{ $website->name }}<br>
                                    {{ $website->address }},<br>
                                    <abbr title="Phone">P:</abbr> {{ $website->phone }}
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <address>
                                    <strong>Payment Method:</strong><br>
                                    {{ $order->payment_method }}<br>
                                </address>
                            </div>
                            <div class="col-xs-6 text-right">
                                <address>
                                    <strong>Order Date:</strong><br>
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y')}}
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h3>ORDER SUMMARY</h3>
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="line">
                                            <td><strong>#</strong></td>
                                            <td class="text-start"><strong>Product</strong></td>
                                            <td class="text-right"><strong>Qty</strong></td>
                                            <td class="text-right"><strong>Price</strong></td>
                                            <td class="text-right"><strong>Total</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->products as $key => $o_product)
                                            @php
                                                $product = App\Models\Product::findOrFail($o_product->product_id);
                                                $p_color = App\Models\ProductOrderColor::where('order_code', $order->order_code)->where('product_id', $o_product->product_id)->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>
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
                                                </td>
                                                <td class="text-right">{{ $o_product->quantity }}</td>
                                                <td class="text-right">{{ number_format($o_product->sale_price) }} ৳</td>
                                                <td class="text-right">{{ number_format($o_product->sale_price * $o_product->quantity) }} ৳</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="text-right"><strong>Sub Total</strong></td>
                                            <td class="text-right"><strong>{{ number_format($order->sub_total) }} ৳</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                            </td><td class="text-right"><strong>Shipping</strong></td>
                                            <td class="text-right"><strong>{{ number_format($order->shipping_amount) }} ৳</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                            </td><td class="text-right"><strong>Discount</strong></td>
                                            <td class="text-right"><strong>{{ number_format($order->discount) }} ৳</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                            </td><td class="text-right"><strong>Total</strong></td>
                                            <td class="text-right"><strong>{{ number_format($order->total) }} ৳</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 identity">
                                <h6>Terms And Condition :</h6>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END INVOICE -->
        </div>
    </div>

    <style type="text/css">
        @media print {
            .order-list-btn{
                display: none;
            }
        }
        .mr-2{
            margin-right: 10px;
        }
        body{margin-top:20px;
            background:#eee;
        }

        .invoice {
            padding: 30px;
        }

        .invoice h2 {
            margin-top: 0px;
            line-height: 0.8em;
        }

        .invoice .small {
            font-weight: 300;
        }

        .invoice hr {
            margin-top: 10px;
            border-color: #ddd;
        }

        .invoice .table tr.line {
            border-bottom: 1px solid #ccc;
        }

        .invoice .table td {
            border: none;
        }

        .invoice .identity {
            margin-top: 10px;
            font-size: 1.1em;
            font-weight: 300;
        }

        .invoice .identity strong {
            font-weight: 600;
        }


        .grid {
            position: relative;
            width: 100%;
            background: #fff;
            color: #666666;
            border-radius: 2px;
            margin-bottom: 25px;
            box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.1);
        }

    </style>

    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>
