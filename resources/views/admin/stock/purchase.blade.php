@extends('layouts.backend.app')

@section('title')
    {{$title}}
@stop

@push('css')

@endpush

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <form action="">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <label for="">Select Product For Purchase</label>
                                        <select id="productPurchaseId" class="form-control">
                                            <option value="">Select One</option>
                                            @foreach($products as $key => $product)
                                                <option value="{{ $product->id }}">{{$product->name}} - {{$product->product_code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped table-bordered nowrap" style="width:100%" id="purchase_product_add_table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Color qty</th>
                                                    <th>Total qty</th>
                                                    <th>B. Price</th>
                                                    <th>S. Price</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>More Info</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Subtotal</label>
                                                <input class="form-control" type="number" id="grand_sub_total" name="grand_sub_total" value="0">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Discount TK</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"> ৳ </span>
                                                    </div>
                                                    <input class="form-control" type="number" id="discount_tk" name="discount_tk" onpaste="dicountTkPstChange()" onkeyup="dicountTkChange()" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Discount % </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"> % </span>
                                                    </div>
                                                    <input class="form-control" type="number" id="discount_per" name="discount_per" onpaste="dicountPerPstChange()" onkeyup="dicountPerChange()" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Previous Due</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"> ৳ </span>
                                                    </div>
                                                    <input class="form-control" type="number" readonly id="previous_due" name="previous_due" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Total</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"> ৳ </span>
                                                    </div>
                                                    <input class="form-control" type="number" readonly id="grand_total" name="grand_total" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Cash Paid</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"> ৳ </span>
                                                    </div>
                                                    <input class="form-control" type="number" id="cash_paid" name="cash_paid" onpaste="cashPaidPstChange()" onkeyup="cashPaidChange()" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Total Paid</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"> ৳ </span>
                                                    </div>
                                                    <input class="form-control" type="number" id="paid" name="paid" readonly onkeyup="PaidChange()" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Due</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"> ৳ </span>
                                                    </div>
                                                    <input class="form-control" type="number" readonly id="due" name="due" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Change</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"> ৳ </span>
                                                    </div>
                                                    <input class="form-control" type="number" readonly id="change" name="change" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="submit" class="btn btn-info" value="Purchase Now">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('massage/sweetalert/sweetalert.all.js')}}"></script>
    <script>
        $("#productPurchaseId").on('change', function() {
            var productPurchaseId = $("#productPurchaseId").val();

            if($("#remove_productpurchase_row_" + productPurchaseId).length == 0){
                $.ajax({
                    type    : "POST",
                    url     : "{{ route('admin.productpurchase.ajax') }}",
                    data    : {
                            id      : productPurchaseId,
                            _token  : '{{csrf_token()}}'
                        },
                    success:function(data) {
                        console.log(data);
                        $("#purchase_product_add_table tbody:last-child").append(data);
                    }
                });
            }else {
                swal(
                    'Product already added for purchase!',
                    '',
                    'error'
                )
            }

        });

    </script>
@endpush