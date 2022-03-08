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
                                                    <th width="25%">Name</th>
                                                    <th width="10%">Color qty</th>
                                                    <th width="10%">Total qty</th>
                                                    <th width="15%">B. Price</th>
                                                    <th width="15%">S. Price</th>
                                                    <th width="15%">Total</th>
                                                    <th width="5%">Action</th>
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
                                        <div class="row mb-2">
                                            <div class="col-md-12">
                                                <label for="">Remark</label>
                                                <textarea class="form-control" name="remark" id="remark" cols="30" rows="2" placeholder="Remark"></textarea>
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
            // alert(productPurchaseId);
            if($("#remove_tr_" + productPurchaseId).length == 0){
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
    <script>
        function removeProductFromTable(obj){
            var id = obj.id;
            // set grand sub total-------------
            var product_total_cost = $('#product_total_cost_'+id).val();
            var grand_sub_total = $('#grand_sub_total').val();
            $('#grand_sub_total').val(parseInt(grand_sub_total) - parseInt(product_total_cost));
            $('#total_table_product_cost').html(parseInt(grand_sub_total) - parseInt(product_total_cost));

            // main billing calculation--------------------
            var grand_sub_total = $('#grand_sub_total').val();
            $('#grand_total').val(parseInt(grand_sub_total));
            $('#discount_tk').val(0);
            $('#discount_per').val(0);

            var grand_total = parseInt($('#grand_total').val());
            var paid = parseInt($('#paid').val());

            var discount_tk = $('#discount_tk').val();
            $('#grand_total').val(parseInt(grand_total) - parseInt(discount_tk));

            var grand_total = parseInt($('#grand_total').val());

            if(parseInt(grand_total) > 0){
                if (parseInt(grand_total) > parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }

                if(parseInt(paid) > parseInt(grand_total) ){
                    $('#change').val(parseInt(paid) - parseInt(grand_total));
                }

                if (parseInt(grand_total) == parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }
            }else{
                $('#due').val(0);
                $('#change').val(0);
            }


            $('#remove_tr_'+id).remove();
        }

        function productColorQtyPstChange(color_id, product_id){
            var color_qty_data = $('#product_color_qty_'+color_id+'_'+product_id).val();
            if(color_qty_data == '' || !$.isNumeric(color_qty_data)){
                color_qty_data = parseInt('0');
            }

            var color_qty_data_check = $('#product_color_qty_for_check_'+color_id+'_'+product_id).val();

            // for product qty--------------
            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            $('#product_total_qty_'+product_id).val(parseInt(total_qty) - parseInt(color_qty_data_check));

            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            $('#product_total_qty_'+product_id).val(parseInt(total_qty) + parseInt(color_qty_data));

            // for unit qty--------------
            var total_unit_qty = parseInt($('#product_unit_qty_'+product_id).val());
            $('#product_unit_qty_'+product_id).val(parseInt(total_unit_qty) - parseInt(color_qty_data_check));

            var total_unit_qty = parseInt($('#product_unit_qty_'+product_id).val());
            $('#product_unit_qty_'+product_id).val(parseInt(total_unit_qty) + parseInt(color_qty_data));

            // for self color qty--------------
            $('#product_color_qty_for_check_'+color_id+'_'+product_id).val(parseInt(color_qty_data));

            // for pur total warehouse qty cost--------------
            var ws_qty = parseInt($('#product_purchase_showroom_qty_'+color_id+'_'+product_id).val());

            if(ws_qty == '' || !$.isNumeric(ws_qty)){
                ws_qty = parseInt('0');
            }

            $('#product_purchase_warehouse_qty_'+color_id+'_'+product_id).val(parseInt(color_qty_data) - parseInt(ws_qty));

            // pevious cost reduce from gtotal---------------
            var product_total_cost = $('#product_total_cost_'+product_id).val();
            var grand_sub_total = $('#grand_sub_total').val();
            $('#grand_sub_total').val(parseInt(grand_sub_total) - parseInt(product_total_cost));

            // for pur total purchase cost--------------
            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            var product_purchase_cost = $('#product_purchase_cost_'+product_id).val();

            $('#product_total_cost_'+product_id).val(parseInt(total_qty) * parseInt(product_purchase_cost));
            $('#product_purchase_cost_for_check_'+product_id).val(parseInt(product_purchase_cost));

            // for sale price---------------
            var product_total_cost = $('#product_total_cost_'+product_id).val();
            var product_margin_profit = $('#product_margin_profit_'+product_id).val();

            var total_margin_profit = Math.ceil((parseInt(product_total_cost) * parseInt(product_margin_profit))/100);

            var total_cost = parseInt(product_total_cost) + parseInt(total_margin_profit);
            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            var sale_price = Math.ceil(parseInt(total_cost)/parseInt(total_qty));
            $('#product_sale_price_'+product_id).val(sale_price);

            // set grand sub total-------------
            var product_total_cost = $('#product_total_cost_'+product_id).val();
            var grand_sub_total = $('#grand_sub_total').val();
            $('#grand_sub_total').val(parseInt(grand_sub_total) + parseInt(product_total_cost));
            $('#total_table_product_cost').html(parseInt(grand_sub_total) + parseInt(product_total_cost));

            // main billing calculation--------------------
            var grand_sub_total = $('#grand_sub_total').val();
            $('#grand_total').val(parseInt(grand_sub_total));
            $('#discount_tk').val(0);
            $('#discount_per').val(0);

            var grand_total = parseInt($('#grand_total').val());
            var paid = parseInt($('#paid').val());

            var discount_tk = $('#discount_tk').val();
            $('#grand_total').val(parseInt(grand_total) - parseInt(discount_tk));

            var grand_total = parseInt($('#grand_total').val());

            if(parseInt(grand_total) > 0){
                if (parseInt(grand_total) > parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }

                if(parseInt(paid) > parseInt(grand_total) ){
                    $('#change').val(parseInt(paid) - parseInt(grand_total));
                }

                if (parseInt(grand_total) == parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }
            }else{
                $('#due').val(0);
                $('#change').val(0);
            }
        }

        function productColorQtyChange(color_id, product_id){
            var color_qty_data = $('#product_color_qty_'+color_id+'_'+product_id).val();
            if(color_qty_data == '' || !$.isNumeric(color_qty_data)){
                color_qty_data = parseInt('0');
            }

            var color_qty_data_check = $('#product_color_qty_for_check_'+color_id+'_'+product_id).val();

            // for product qty--------------
            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            $('#product_total_qty_'+product_id).val(parseInt(total_qty) - parseInt(color_qty_data_check));

            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            $('#product_total_qty_'+product_id).val(parseInt(total_qty) + parseInt(color_qty_data));

            // for unit qty--------------
            var total_unit_qty = parseInt($('#product_unit_qty_'+product_id).val());
            $('#product_unit_qty_'+product_id).val(parseInt(total_unit_qty) - parseInt(color_qty_data_check));

            var total_unit_qty = parseInt($('#product_unit_qty_'+product_id).val());
            $('#product_unit_qty_'+product_id).val(parseInt(total_unit_qty) + parseInt(color_qty_data));

            // for self color qty--------------
            $('#product_color_qty_for_check_'+color_id+'_'+product_id).val(parseInt(color_qty_data));

            // for pur total warehouse qty cost--------------
            var ws_qty = parseInt($('#product_purchase_showroom_qty_'+color_id+'_'+product_id).val());

            if(ws_qty == '' || !$.isNumeric(ws_qty)){
                ws_qty = parseInt('0');
            }

            $('#product_purchase_warehouse_qty_'+color_id+'_'+product_id).val(parseInt(color_qty_data) - parseInt(ws_qty));

            // pevious cost reduce from gtotal---------------
            var product_total_cost = $('#product_total_cost_'+product_id).val();
            var grand_sub_total = $('#grand_sub_total').val();
            $('#grand_sub_total').val(parseInt(grand_sub_total) - parseInt(product_total_cost));

            // for pur total purchase cost--------------
            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            var product_purchase_cost = $('#product_purchase_cost_'+product_id).val();

            $('#product_total_cost_'+product_id).val(parseInt(total_qty) * parseInt(product_purchase_cost));
            $('#product_purchase_cost_for_check_'+product_id).val(parseInt(product_purchase_cost));

            // for sale price---------------
            var product_total_cost = $('#product_total_cost_'+product_id).val();
            var product_margin_profit = $('#product_margin_profit_'+product_id).val();

            var total_margin_profit = Math.ceil((parseInt(product_total_cost) * parseInt(product_margin_profit))/100);

            var total_cost = parseInt(product_total_cost) + parseInt(total_margin_profit);
            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            var sale_price = Math.ceil(parseInt(total_cost)/parseInt(total_qty));
            $('#product_sale_price_'+product_id).val(sale_price);

            // set grand sub total-------------
            var product_total_cost = $('#product_total_cost_'+product_id).val();
            var grand_sub_total = $('#grand_sub_total').val();
            $('#grand_sub_total').val(parseInt(grand_sub_total) + parseInt(product_total_cost));
            $('#total_table_product_cost').html(parseInt(grand_sub_total) + parseInt(product_total_cost));

            // main billing calculation--------------------
            var grand_sub_total = $('#grand_sub_total').val();
            $('#grand_total').val(parseInt(grand_sub_total));
            $('#discount_tk').val(0);
            $('#discount_per').val(0);

            var grand_total = parseInt($('#grand_total').val());
            var paid = parseInt($('#paid').val());

            var discount_tk = $('#discount_tk').val();
            $('#grand_total').val(parseInt(grand_total) - parseInt(discount_tk));

            var grand_total = parseInt($('#grand_total').val());

            if(parseInt(grand_total) > 0){
                if (parseInt(grand_total) > parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }

                if(parseInt(paid) > parseInt(grand_total) ){
                    $('#change').val(parseInt(paid) - parseInt(grand_total));
                }

                if (parseInt(grand_total) == parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }
            }else{
                $('#due').val(0);
                $('#change').val(0);
            }
        }

        function productQtyPstChange(product_id){
            // for pur total purchase cost--------------
            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            if(total_qty == '' || !$.isNumeric(total_qty)){
                total_qty = parseInt('0');
            }

            $('#product_purchase_warehouse_qty_'+product_id).val(parseInt(total_qty) - parseInt($('#product_purchase_showroom_qty_'+product_id).val()));

            var product_purchase_cost = $('#product_purchase_cost_'+product_id).val();

            $('#product_total_cost_'+product_id).val(parseInt(total_qty) * parseInt(product_purchase_cost));
            $('#product_purchase_cost_for_check_'+product_id).val(parseInt(product_purchase_cost));

            // pevious cost reduce from gtotal---------------
            var product_total_cost = $('#product_total_cost_'+product_id).val();
            var grand_sub_total = $('#grand_sub_total').val();

            $('#grand_sub_total').val(parseInt(grand_sub_total) - parseInt(product_total_cost));

            // for sale price---------------
            var product_total_cost = $('#product_total_cost_'+product_id).val();
            var product_margin_profit = $('#product_margin_profit_'+product_id).val();

            var total_margin_profit = Math.ceil((parseInt(product_total_cost) * parseInt(product_margin_profit))/100);

            var total_cost = parseInt(product_total_cost) + parseInt(total_margin_profit);
            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            var sale_price = Math.ceil(parseInt(total_cost)/parseInt(total_qty));
            $('#product_sale_price_'+product_id).val(sale_price);

            // set grand sub total-------------
            var product_total_cost = $('#product_total_cost_'+product_id).val();
            var grand_sub_total = $('#grand_sub_total').val();
            $('#grand_sub_total').val(parseInt(grand_sub_total) + parseInt(product_total_cost));
            $('#total_table_product_cost').html(parseInt(grand_sub_total) + parseInt(product_total_cost));

            // main billing calculation--------------------
            var grand_sub_total = $('#grand_sub_total').val();
            $('#grand_total').val(parseInt(grand_sub_total));
            $('#discount_tk').val(0);
            $('#discount_per').val(0);

            var grand_total = parseInt($('#grand_total').val());
            var paid = parseInt($('#paid').val());

            var discount_tk = $('#discount_tk').val();
            $('#grand_total').val(parseInt(grand_total) - parseInt(discount_tk));

            var grand_total = parseInt($('#grand_total').val());

            if(parseInt(grand_total) > 0){
                if (parseInt(grand_total) > parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }

                if(parseInt(paid) > parseInt(grand_total) ){
                    $('#change').val(parseInt(paid) - parseInt(grand_total));
                }

                if (parseInt(grand_total) == parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }
            }else{
                $('#due').val(0);
                $('#change').val(0);
            }

        }

        function productQtyChange(product_id){
            // for pur total purchase cost--------------
            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            if(total_qty == '' || !$.isNumeric(total_qty)){
                total_qty = parseInt('0');
            }

            $('#product_purchase_warehouse_qty_'+product_id).val(parseInt(total_qty) - parseInt($('#product_purchase_showroom_qty_'+product_id).val()));

            var product_purchase_cost = $('#product_purchase_cost_'+product_id).val();

            $('#product_total_cost_'+product_id).val(parseInt(total_qty) * parseInt(product_purchase_cost));
            $('#product_purchase_cost_for_check_'+product_id).val(parseInt(product_purchase_cost));

            // pevious cost reduce from gtotal---------------
            var product_total_cost = $('#product_total_cost_'+product_id).val();
            var grand_sub_total = $('#grand_sub_total').val();

            $('#grand_sub_total').val(parseInt(grand_sub_total) - parseInt(product_total_cost));

            // for sale price---------------
            var product_total_cost = $('#product_total_cost_'+product_id).val();
            var product_margin_profit = $('#product_margin_profit_'+product_id).val();

            var total_margin_profit = Math.ceil((parseInt(product_total_cost) * parseInt(product_margin_profit))/100);

            var total_cost = parseInt(product_total_cost) + parseInt(total_margin_profit);
            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            var sale_price = Math.ceil(parseInt(total_cost)/parseInt(total_qty));
            $('#product_sale_price_'+product_id).val(sale_price);

            // set grand sub total-------------
            var product_total_cost = $('#product_total_cost_'+product_id).val();
            var grand_sub_total = $('#grand_sub_total').val();
            $('#grand_sub_total').val(parseInt(grand_sub_total) + parseInt(product_total_cost));
            $('#total_table_product_cost').html(parseInt(grand_sub_total) + parseInt(product_total_cost));

            // main billing calculation--------------------
            var grand_sub_total = $('#grand_sub_total').val();
            $('#grand_total').val(parseInt(grand_sub_total));
            $('#discount_tk').val(0);
            $('#discount_per').val(0);

            var grand_total = parseInt($('#grand_total').val());
            var paid = parseInt($('#paid').val());

            var discount_tk = $('#discount_tk').val();
            $('#grand_total').val(parseInt(grand_total) - parseInt(discount_tk));

            var grand_total = parseInt($('#grand_total').val());

            if(parseInt(grand_total) > 0){
                if (parseInt(grand_total) > parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }

                if(parseInt(paid) > parseInt(grand_total) ){
                    $('#change').val(parseInt(paid) - parseInt(grand_total));
                }

                if (parseInt(grand_total) == parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }
            }else{
                $('#due').val(0);
                $('#change').val(0);
            }

        }

        function productPurchaseColorShowroomPstQtyChange(color_id, product_id){
            // for pur total warehouse qty cost--------------
            var color_qty_data = $('#product_color_qty_'+color_id+'_'+product_id).val();
            if(color_qty_data == '' || !$.isNumeric(color_qty_data)){
                color_qty_data = parseInt('0');
            }
            var ws_qty = parseInt($('#product_purchase_showroom_qty_'+color_id+'_'+product_id).val());
            if(ws_qty == '' || !$.isNumeric(ws_qty)){
                ws_qty = parseInt('0');
            }

            $('#product_purchase_warehouse_qty_'+color_id+'_'+product_id).val(parseInt(color_qty_data) - parseInt(ws_qty));
        }

        function productPurchaseColorShowroomQtyChange(color_id, product_id){
            // for pur total warehouse qty cost--------------
            var color_qty_data = $('#product_color_qty_'+color_id+'_'+product_id).val();
            if(color_qty_data == '' || !$.isNumeric(color_qty_data)){
                color_qty_data = parseInt('0');
            }
            var ws_qty = parseInt($('#product_purchase_showroom_qty_'+color_id+'_'+product_id).val());
            if(ws_qty == '' || !$.isNumeric(ws_qty)){
                ws_qty = parseInt('0');
            }

            $('#product_purchase_warehouse_qty_'+color_id+'_'+product_id).val(parseInt(color_qty_data) - parseInt(ws_qty));
        }

        function productPurchaseShowroomPstQtyChange(product_id){
            // for pur total warehouse qty cost--------------
            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            var ws_qty = parseInt($('#product_purchase_showroom_qty_'+product_id).val());

            if(ws_qty == '' || !$.isNumeric(ws_qty)){
                ws_qty = parseInt('0');
            }
            $('#product_purchase_warehouse_qty_'+product_id).val(parseInt(total_qty) - parseInt(ws_qty));
        }

        function productPurchaseShowroomQtyChange(product_id){
            // for pur total warehouse qty cost--------------
            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            var ws_qty = parseInt($('#product_purchase_showroom_qty_'+product_id).val());

            if(ws_qty == '' || !$.isNumeric(ws_qty)){
                ws_qty = parseInt('0');
            }
            $('#product_purchase_warehouse_qty_'+product_id).val(parseInt(total_qty) - parseInt(ws_qty));
        }

        function productPurchaseCostPstChange(product_id){
            // for pur total purchase cost--------------
            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            var product_purchase_cost = $('#product_purchase_cost_'+product_id).val();
            if(product_purchase_cost == '' || !$.isNumeric(product_purchase_cost)){
                product_purchase_cost = parseInt('0');
            }

            $('#product_total_cost_'+product_id).val(parseInt(total_qty) * parseInt(product_purchase_cost));

            // pevious cost reduce from gtotal---------------
            var product_purchase_cost_for_check = $('#product_purchase_cost_for_check_'+product_id).val();
            var grand_sub_total = $('#grand_sub_total').val();
            var old_cost = parseInt(total_qty) * parseInt(product_purchase_cost_for_check);
            $('#grand_sub_total').val(parseInt(grand_sub_total) - parseInt(old_cost));

            $('#product_purchase_cost_for_check_'+product_id).val(parseInt(product_purchase_cost));

            // for sale price---------------
            var product_total_cost = $('#product_total_cost_'+product_id).val();
            var product_margin_profit = $('#product_margin_profit_'+product_id).val();

            var total_margin_profit = Math.ceil((parseInt(product_total_cost) * parseInt(product_margin_profit))/100);

            var total_cost = parseInt(product_total_cost) + parseInt(total_margin_profit);
            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            var sale_price = Math.ceil(parseInt(total_cost)/parseInt(total_qty));
            $('#product_sale_price_'+product_id).val(sale_price);

            // set grand sub total-------------
            var product_total_cost = $('#product_total_cost_'+product_id).val();
            var grand_sub_total = $('#grand_sub_total').val();
            $('#grand_sub_total').val(parseInt(grand_sub_total) + parseInt(product_total_cost));
            $('#total_table_product_cost').html(parseInt(grand_sub_total) + parseInt(product_total_cost));


            // main billing calculation--------------------
            var grand_sub_total = $('#grand_sub_total').val();
            $('#grand_total').val(parseInt(grand_sub_total));
            $('#discount_tk').val(0);
            $('#discount_per').val(0);

            var grand_total = parseInt($('#grand_total').val());
            var paid = parseInt($('#paid').val());

            var discount_tk = $('#discount_tk').val();
            $('#grand_total').val(parseInt(grand_total) - parseInt(discount_tk));

            var grand_total = parseInt($('#grand_total').val());

            if(parseInt(grand_total) > 0){
                if (parseInt(grand_total) > parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }

                if(parseInt(paid) > parseInt(grand_total) ){
                    $('#change').val(parseInt(paid) - parseInt(grand_total));
                }

                if (parseInt(grand_total) == parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }
            }else{
                $('#due').val(0);
                $('#change').val(0);
            }
        }

        function productPurchaseCostChange(product_id){
            // for pur total purchase cost--------------
            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            var product_purchase_cost = $('#product_purchase_cost_'+product_id).val();
            if(product_purchase_cost == '' || !$.isNumeric(product_purchase_cost)){
                product_purchase_cost = parseInt('0');
            }

            $('#product_total_cost_'+product_id).val(parseInt(total_qty) * parseInt(product_purchase_cost));

            // pevious cost reduce from gtotal---------------
            var product_purchase_cost_for_check = $('#product_purchase_cost_for_check_'+product_id).val();
            var grand_sub_total = $('#grand_sub_total').val();
            var old_cost = parseInt(total_qty) * parseInt(product_purchase_cost_for_check);
            $('#grand_sub_total').val(parseInt(grand_sub_total) - parseInt(old_cost));

            $('#product_purchase_cost_for_check_'+product_id).val(parseInt(product_purchase_cost));

            // for sale price---------------
            var product_total_cost = $('#product_total_cost_'+product_id).val();
            var product_margin_profit = $('#product_margin_profit_'+product_id).val();

            var total_margin_profit = Math.ceil((parseInt(product_total_cost) * parseInt(product_margin_profit))/100);

            var total_cost = parseInt(product_total_cost) + parseInt(total_margin_profit);
            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            var sale_price = Math.ceil(parseInt(total_cost)/parseInt(total_qty));
            $('#product_sale_price_'+product_id).val(sale_price);

            // set grand sub total-------------
            var product_total_cost = $('#product_total_cost_'+product_id).val();
            var grand_sub_total = $('#grand_sub_total').val();
            $('#grand_sub_total').val(parseInt(grand_sub_total) + parseInt(product_total_cost));
            $('#total_table_product_cost').html(parseInt(grand_sub_total) + parseInt(product_total_cost));

            // main billing calculation--------------------
            var grand_sub_total = $('#grand_sub_total').val();
            $('#grand_total').val(parseInt(grand_sub_total));
            $('#discount_tk').val(0);
            $('#discount_per').val(0);

            var grand_total = parseInt($('#grand_total').val());
            var paid = parseInt($('#paid').val());

            var discount_tk = $('#discount_tk').val();
            $('#grand_total').val(parseInt(grand_total) - parseInt(discount_tk));

            var grand_total = parseInt($('#grand_total').val());

            if(parseInt(grand_total) > 0){
                if (parseInt(grand_total) > parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }

                if(parseInt(paid) > parseInt(grand_total) ){
                    $('#change').val(parseInt(paid) - parseInt(grand_total));
                }

                if (parseInt(grand_total) == parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }
            }else{
                $('#due').val(0);
                $('#change').val(0);
            }
        }

        function productProfitMarginPstChange(product_id){
            // for sale price---------------
            var product_total_cost = $('#product_total_cost_'+product_id).val();
            var product_margin_profit = $('#product_margin_profit_'+product_id).val();
            if(product_margin_profit == '' || !$.isNumeric(product_margin_profit)){
                product_margin_profit = parseInt('0');
            }

            var total_margin_profit = Math.ceil((parseInt(product_total_cost) * parseInt(product_margin_profit))/100);

            // sale price----------------------
            var total_cost = parseInt(product_total_cost) + parseInt(total_margin_profit);
            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            var sale_price = Math.ceil(parseInt(total_cost)/parseInt(total_qty));
            $('#product_sale_price_'+product_id).val(sale_price);
        }

        function productProfitMarginChange(product_id){
            // for sale price---------------
            var product_total_cost = $('#product_total_cost_'+product_id).val();
            var product_margin_profit = $('#product_margin_profit_'+product_id).val();
            if(product_margin_profit == '' || !$.isNumeric(product_margin_profit)){
                product_margin_profit = parseInt('0');
            }

            var total_margin_profit = Math.ceil((parseInt(product_total_cost) * parseInt(product_margin_profit))/100);

            // sale price----------------------
            var total_cost = parseInt(product_total_cost) + parseInt(total_margin_profit);
            var total_qty = parseInt($('#product_total_qty_'+product_id).val());
            var sale_price = Math.ceil(parseInt(total_cost)/parseInt(total_qty));
            $('#product_sale_price_'+product_id).val(sale_price);
        }

        function productSalePricePstChange(product_id){
            // for sale price---------------
            var product_purchase_cost = $('#product_purchase_cost_'+product_id).val();
            var product_sale_price = $('#product_sale_price_'+product_id).val();
            var profit = parseInt(product_sale_price) - parseInt(product_purchase_cost);

            var total_margin_profit = Math.ceil((parseInt(profit) * 100)/parseInt(product_purchase_cost));

            $('#product_margin_profit_'+product_id).val(total_margin_profit);
        }

        function productSalePriceChange(product_id){
            // for sale price---------------
            var product_purchase_cost = $('#product_purchase_cost_'+product_id).val();
            var product_sale_price = $('#product_sale_price_'+product_id).val();
            var profit = parseInt(product_sale_price) - parseInt(product_purchase_cost);

            var total_margin_profit = Math.ceil((parseInt(profit) * 100)/parseInt(product_purchase_cost));

            $('#product_margin_profit_'+product_id).val(total_margin_profit);
        }

        function dicountTkPstChange(){
            var grand_sub_total = parseInt($('#grand_sub_total').val());
            var discount_tk = $('#discount_tk').val();

            if(discount_tk == '' || !$.isNumeric(discount_tk)){
                discount_tk = parseInt('0');
            }

            $('#grand_total').val(parseInt(grand_sub_total));

            var discount_per = Math.ceil((parseInt(discount_tk) * 100)/parseInt(grand_sub_total));
            $('#discount_per').val(parseInt(discount_per));

            var grand_total = parseInt($('#grand_total').val());
            var paid = parseInt($('#paid').val());
            $('#grand_total').val(parseInt(grand_total) - parseInt(discount_tk));

            var grand_total = parseInt($('#grand_total').val());

            if(parseInt(grand_total) > 0){
                if (parseInt(grand_total) > parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }

                if(parseInt(paid) > parseInt(grand_total) ){
                    $('#change').val(parseInt(paid) - parseInt(grand_total));
                }

                if (parseInt(grand_total) == parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }
            }else{
                $('#due').val(0);
                $('#change').val(0);
            }
        }

        function dicountTkChange(){
            var grand_sub_total = parseInt($('#grand_sub_total').val());
            var discount_tk = $('#discount_tk').val();

            if(discount_tk == '' || !$.isNumeric(discount_tk)){
                discount_tk = parseInt('0');
            }

            $('#grand_total').val(parseInt(grand_sub_total));

            var discount_per = Math.ceil((parseInt(discount_tk) * 100)/parseInt(grand_sub_total));
            $('#discount_per').val(parseInt(discount_per));

            var grand_total = parseInt($('#grand_total').val());
            var paid = parseInt($('#paid').val());
            $('#grand_total').val(parseInt(grand_total) - parseInt(discount_tk));

            var grand_total = parseInt($('#grand_total').val());

            if(parseInt(grand_total) > 0){
                if (parseInt(grand_total) > parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }

                if(parseInt(paid) > parseInt(grand_total) ){
                    $('#change').val(parseInt(paid) - parseInt(grand_total));
                }

                if (parseInt(grand_total) == parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }
            }else{
                $('#due').val(0);
                $('#change').val(0);
            }
        }

        function dicountPerChange(){
            var grand_sub_total = parseInt($('#grand_sub_total').val());
            var discount_per = $('#discount_per').val();

            if(discount_per == '' || !$.isNumeric(discount_per)){
                discount_per = parseInt('0');
            }

            $('#grand_total').val(parseInt(grand_sub_total));

            var discount_tk = Math.ceil((parseInt(discount_per) * parseInt(grand_sub_total))/100);
            $('#discount_tk').val(parseInt(discount_tk));

            var grand_total = parseInt($('#grand_total').val());
            var paid = parseInt($('#paid').val());

            var discount_tk = $('#discount_tk').val();
            $('#grand_total').val(parseInt(grand_total) - parseInt(discount_tk));

            var grand_total = parseInt($('#grand_total').val());

            if(parseInt(grand_total) > 0){
                if (parseInt(grand_total) > parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }

                if(parseInt(paid) > parseInt(grand_total) ){
                    $('#change').val(parseInt(paid) - parseInt(grand_total));
                }

                if (parseInt(grand_total) == parseInt(paid)) {
                    $('#due').val(0);
                    $('#change').val(0);
                }
            }else{
                $('#due').val(0);
                $('#change').val(0);
            }
        }

        function dicountPerPstChange(){
            var grand_sub_total = parseInt($('#grand_sub_total').val());
            var discount_per = $('#discount_per').val();

            if(discount_per == '' || !$.isNumeric(discount_per)){
                discount_per = parseInt('0');
            }

            $('#grand_total').val(parseInt(grand_sub_total));

            var discount_tk = Math.ceil((parseInt(discount_per) * parseInt(grand_sub_total))/100);
            $('#discount_tk').val(parseInt(discount_tk));

            var grand_total = parseInt($('#grand_total').val());
            var paid = parseInt($('#paid').val());

            var discount_tk = $('#discount_tk').val();
            $('#grand_total').val(parseInt(grand_total) - parseInt(discount_tk));

            var grand_total = parseInt($('#grand_total').val());

            if(parseInt(grand_total) > 0){
                if (parseInt(grand_total) > parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }

                if(parseInt(paid) > parseInt(grand_total) ){
                    $('#change').val(parseInt(paid) - parseInt(grand_total));
                }

                if (parseInt(grand_total) == parseInt(paid)) {
                    $('#due').val(0);
                    $('#change').val(0);
                }
            }else{
                $('#due').val(0);
                $('#change').val(0);
            }
        }

        function PaidChange(){
            var paid = $('#paid').val();

            if(paid == '' || !$.isNumeric(paid)){
                paid = parseInt('0');
            }

            var grand_total = parseInt($('#grand_total').val());

            if (parseInt(grand_total) > parseInt(paid)) {
                $('#due').val(parseInt(grand_total) - parseInt(paid));
                $('#change').val(0);
            }

            if(parseInt(paid) > parseInt(grand_total) ){
                $('#change').val(parseInt(paid) - parseInt(grand_total));
                $('#due').val(0);
            }

            if (parseInt(grand_total) == parseInt(paid)) {
                $('#due').val(0);
                $('#change').val(0);
            }
        }
        function cashPaidPstChange(){
            var cash_paid = $('#cash_paid').val();
            if(cash_paid == '' || !$.isNumeric(cash_paid)){
                cash_paid = parseInt('0');
            }

            var bank_paid = parseInt($('#bank_paid').val());
            if(bank_paid == '' || !$.isNumeric(bank_paid)){
                bank_paid = parseInt('0');
                $('#bank_paid').val('0');
            }

            $('#paid').val(parseInt(cash_paid) + parseInt(bank_paid));

            var grand_total = parseInt($('#grand_total').val());
            var paid = parseInt($('#paid').val());

            if (parseInt(grand_total) > parseInt(paid)) {
                $('#due').val(parseInt(grand_total) - parseInt(paid));
                $('#change').val(0);
            }

            if(parseInt(paid) > parseInt(grand_total) ){
                $('#change').val(parseInt(paid) - parseInt(grand_total));
                $('#due').val(0);
            }

            if (parseInt(grand_total) == parseInt(paid)) {
                $('#due').val(0);
                $('#change').val(0);
            }
        }

        function cashPaidChange(){
            var cash_paid = $('#cash_paid').val();
            if(cash_paid == '' || !$.isNumeric(cash_paid)){
                cash_paid = parseInt('0');
            }

            var bank_paid = parseInt($('#bank_paid').val());
            if(bank_paid == '' || !$.isNumeric(bank_paid)){
                bank_paid = parseInt('0');
                $('#bank_paid').val('0');
            }

            $('#paid').val(parseInt(cash_paid) + parseInt(bank_paid));

            var grand_total = parseInt($('#grand_total').val());
            var paid = parseInt($('#paid').val());

            if (parseInt(grand_total) > parseInt(paid)) {
                $('#due').val(parseInt(grand_total) - parseInt(paid));
                $('#change').val(0);
            }

            if(parseInt(paid) > parseInt(grand_total) ){
                $('#change').val(parseInt(paid) - parseInt(grand_total));
                $('#due').val(0);
            }

            if (parseInt(grand_total) == parseInt(paid)) {
                $('#due').val(0);
                $('#change').val(0);
            }
        }
        function bankPaidChange(){
            var bank_paid = $('#bank_paid').val();
            if(bank_paid == '' || !$.isNumeric(bank_paid)){
                bank_paid = parseInt('0');
            }

            var cash_paid = parseInt($('#cash_paid').val());
            if(cash_paid == '' || !$.isNumeric(cash_paid)){
                cash_paid = parseInt('0');
                $('#cash_paid').val('0');
            }

            $('#paid').val(parseInt(bank_paid) + parseInt(cash_paid));

            var grand_total = parseInt($('#grand_total').val());
            var paid = parseInt($('#paid').val());

            if (parseInt(grand_total) > parseInt(paid)) {
                $('#due').val(parseInt(grand_total) - parseInt(paid));
                $('#change').val(0);
            }

            if(parseInt(paid) > parseInt(grand_total) ){
                $('#change').val(parseInt(paid) - parseInt(grand_total));
                $('#due').val(0);
            }

            if (parseInt(grand_total) == parseInt(paid)) {
                $('#due').val(0);
                $('#change').val(0);
            }
        }

        function bankPaidPstChange(){
            var bank_paid = $('#bank_paid').val();
            if(bank_paid == '' || !$.isNumeric(bank_paid)){
                bank_paid = parseInt('0');
            }

            var cash_paid = parseInt($('#cash_paid').val());
            if(cash_paid == '' || !$.isNumeric(cash_paid)){
                cash_paid = parseInt('0');
                $('#cash_paid').val('0');
            }

            $('#paid').val(parseInt(bank_paid) + parseInt(cash_paid));

            var grand_total = parseInt($('#grand_total').val());
            var paid = parseInt($('#paid').val());

            if (parseInt(grand_total) > parseInt(paid)) {
                $('#due').val(parseInt(grand_total) - parseInt(paid));
                $('#change').val(0);
            }

            if(parseInt(paid) > parseInt(grand_total) ){
                $('#change').val(parseInt(paid) - parseInt(grand_total));
                $('#due').val(0);
            }

            if (parseInt(grand_total) == parseInt(paid)) {
                $('#due').val(0);
                $('#change').val(0);
            }
        }

        $('#account_id').on('change', function(){
            var account = $('#account_id').val();
            if(account == ''){
                $("#bank_paid").val('0');
                $("#bank_paid").attr("readonly", true);

                var bank_paid = parseInt($('#bank_paid').val());
                var cash_paid = parseInt($('#cash_paid').val());

                $('#paid').val(parseInt(bank_paid) + parseInt(cash_paid));

                var grand_total = parseInt($('#grand_total').val());
                var paid = parseInt($('#paid').val());

                if (parseInt(grand_total) > parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                    $('#change').val(0);
                }

                if(parseInt(paid) > parseInt(grand_total) ){
                    $('#change').val(parseInt(paid) - parseInt(grand_total));
                    $('#due').val(0);
                }

                if (parseInt(grand_total) == parseInt(paid)) {
                    $('#due').val(parseInt(grand_total) - parseInt(paid));
                }
            }else{
                $("#bank_paid").attr("readonly", false);
            }
        });

    </script>
@endpush