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
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-8">
                                    <h2>{{ $title }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive">
                                <table id="simpletable"class="table table-striped table-bordered nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="7%" class="text-center">Product code</th>
                                            <th width="20%">Title</th>
                                            <th width="20%" class="text-right">Purchase Qty</th>
                                            <th width="20%" class="text-right">Sale Qty</th>
                                            <th width="20%" class="text-right">Stock Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $key => $product)
                                            @if ($product->purchases->sum('quantity') > 0)
                                                @php

                                                @endphp
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $product->product_code }}
                                                    </td>
                                                    <td>{{ $product->name }}</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-8">
                                                            </div>
                                                            <div class="col-4 text-right">
                                                                {{ $product->purchases->sum('quantity') }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-8"></div>
                                                            <div class="col-4 text-right">
                                                                {{ $product->sales->sum('quantity') }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-8"></div>
                                                            <div class="col-4 text-right">
                                                                {{ $product->stocks->sum('quantity') }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                <table id="" class="table table-striped table-bordered nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="7%" class="text-center"></th>
                                            <th width="20%"></th>
                                            <th width="20%" class="text-right">Total Purchase</th>
                                            <th width="20%" class="text-right">Total Sale</th>
                                            <th width="20%" class="text-right">Total Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $t_purchase = 0;
                                            $t_sale = 0;
                                            $t_stock = 0;
                                        @endphp
                                        @foreach($products as $key => $product)
                                            @if ($product->purchases->sum('quantity') > 0)
                                                @php
                                                    $t_purchase += $product->purchases->sum('quantity');
                                                    $t_sale += $product->sales->sum('quantity');
                                                    $t_stock += $product->stocks->sum('quantity');
                                                @endphp
                                            @endif
                                        @endforeach
                                        <tr>
                                            <td class="text-center"></td>
                                            <td></td>
                                            <td class="text-right">{{ $t_purchase }}</td>
                                            <td class="text-right">{{ $t_sale }}</td>
                                            <td class="text-right">{{ $t_stock }}</td>
                                        </tr>
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
    <script>
        $("#product_id_code").on('change', function(event) {
            // alert('id');
            var product_id = $("#product_id_code").val();
            // alert(product_id);
            if(product_id){
                $.ajax({
                    type    : "POST",
                    url     : "{{ route('admin.stock.purchase') }}",
                    data    : {
                            product_id: product_id,
                            _token: '{{csrf_token()}}',
                        },
                    success : function(data) {
                        console.log(data);
                        // show all hide row
                        $("#product_code_show").show();
                        $("#name_show").show();
                        // show val on input field
                        $("#product_code_val").val(data[0]);
                        $("#name_val").val(data[1]);
                    },
                });
            }else {
                alert('Select your product');
            }
        });
        function editProductIdCode(id) {
            var product_id = $("#edit_product_id_code_"+id).val();
            // alert(product_id);
            if(product_id){
                $.ajax({
                    type    : "POST",
                    url     : "{{ route('admin.stock.purchase') }}",
                    data    : {
                            product_id: product_id,
                            _token: '{{csrf_token()}}',
                        },
                    success : function(data) {
                        console.log(data);
                        // show val on input field
                        $("#product_code_val_" + id).val(data[0]);
                        $("#name_val_" + id).val(data[1]);
                    },
                });
            }else {
                alert('Select your product');
            }
        };
    </script>
@endpush
