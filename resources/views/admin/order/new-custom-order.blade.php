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
                        <form action="{{ route('admin.custom-order-store') }}" method="POST">
                            @csrf
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>
                                            Custom Order
                                        </h2>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Customer Name</label>
                                        <input type="text" class="form-control" name="customer_name" id="customer_name" value="{{ $customer_name }}" placeholder="Customer Name">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Customer Name *</label>
                                        <input type="text" class="form-control" name="customer_phone" id="customer_phone" value="{{ $customer_phone }}" required placeholder="Customer Phone">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Customer Address *</label>
                                        <textarea class="form-control" name="customer_address" id="customer_address" cols="30" rows="1" placeholder="Address">{{ $customer_address }}</textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Main Category</label>
                                        <select id="category" class="form-control select2">
                                            <option value="">Select One</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Parent Category</label>
                                        <select id="subcategory" class="form-control select2">

                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Child Category</label>
                                        <select id="subsubcategory" class="form-control select2">

                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Products</label>
                                        <select id="select_product_id" class="form-control select2">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="dt-responsive">
                                    <table id="custom-order-product" class="table table-striped table-bordered nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="8%" class="text-center">Action</th>
                                                <th width="7%" class="text-center">Image</th>
                                                <th>Title</th>
                                                <th width="10%" class="text-center">Quantity</th>
                                                <th width="10%" class="text-center">Sale Price</th>
                                                <th width="10%" class="text-right">Shipping</th>
                                                <th width="10%" class="text-right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-responsive invoice-table invoice-total">
                                            <tbody>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Sub Total :</th>
                                                    <td>
                                                        <input type="text" class="form-control text-right" readonly id="sub_total" name="sub_total" value="0">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Shipping :</th>
                                                    <td>
                                                        <input type="text" class="form-control text-right" id="total_shipping" name="total_shipping" value="0" onfocus="focusInTotalShipping()" onfocusout="focusOutTotalShipping()" onpaste="TotalShippingCng()" onkeyup="TotalShippingCng()" onchange="TotalShippingCng()">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Discount :</th>
                                                    <td>
                                                        <input type="text" class="form-control text-right" id="total_discount" name="total_discount" value="0" onfocus="focusInTotalDiscount()" onfocusout="focusOutTotalDiscount()" onpaste="TotalDiscountCng()" onkeyup="TotalDiscountCng()" onchange="TotalDiscountCng()">
                                                    </td>
                                                </tr>
                                                <tr class="text-info">
                                                    <th></th>
                                                    <th></th>
                                                    <td>
                                                        <hr>
                                                        <h5 class="text-primary">Total :</h5>
                                                    </td>
                                                    <td>
                                                        <hr>
                                                        <input type="text" class="form-control text-right" readonly id="total" name="total" value="0">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Payment Method :</th>
                                                    <td width="200px">
                                                        <select class="form-control select2" name="payment_method" id="payment_method">
                                                            <option value="Cash" selected>Cash</option>
                                                        </select>
                                                    </td>
                                                    <th>Paid :</th>
                                                    <td>
                                                        <input type="text" class="form-control text-right" id="paid" name="paid" value="0" onfocus="focusInPaid()" onfocusout="focusOutPaid()" onpaste="PaidCng()" onkeyup="PaidCng()" onchange="PaidCng()">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th>
                                                        <button type="submit" class="btn btn-success btn-lg">Submit</button>
                                                    </th>
                                                    <th>Due :</th>
                                                    <td>
                                                        <input type="text" class="form-control text-right" readonly id="due" name="due" value="0">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function mainTham(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showTham').attr('src', e.target.result)
                }
                reader.readAsDataURL(input.files[0]);
            }
        };
        function mainThamEdit(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.showThamEdit').attr('src', e.target.result)
                }
                reader.readAsDataURL(input.files[0]);
            }
        };
    </script>
    <script src="{{asset('massage/sweetalert/sweetalert.all.js')}}"></script>
    <script type="text/javascript">
        function deleteData(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    // event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }

        $('.select2').select2();

        function updateQuickSaleProduct(){
            $('#update-quick-sale-product-form').submit();
        }
    </script>


    <script type="text/javascript">
        $(document).ready(function() {

            $('#category').on('change', function(){
                var category_id = $(this).val();
                // alert(category_id);
                if(category_id) {
                    $.ajax({
                        url: "{{ route('admin.parent-category-for-product') }}",
                        type:"POST",
                        data:{
                            _token: '{{csrf_token()}}',
                            category_id: category_id,
                        },
                        success:function(data) {
                            console.log(data);
                            $('#subsubcategory').html('');
                            $('#subcategory').html(data['cat']);
                            $('#select_product_id').html(data['product']);
                        },
                    });
                } else {
                    alert('danger');
                }
            });

            $('#subcategory').on('change', function(){
                var subcategory_id = $(this).val();
                // alert(subcategory_id);
                if(subcategory_id) {
                    $.ajax({
                        url: "{{ route('admin.child-category-for-product') }}",
                        type:"POST",
                        data:{
                            _token: '{{csrf_token()}}',
                            subcategory_id: subcategory_id,
                        },
                        success:function(data) {
                            console.log(data);
                            $('#subsubcategory').html(data['cat']);
                            $('#select_product_id').html(data['product']);
                        },
                    });
                } else {
                    alert('danger');
                }
            });

            $('#subsubcategory').on('change', function(){
                var subsubcategory_id = $(this).val();
                // alert(subsubcategory_id);
                if(subsubcategory_id) {
                    $.ajax({
                        url: "{{ route('admin.get-category-product-for-qs') }}",
                        type:"POST",
                        data:{
                            _token: '{{csrf_token()}}',
                            subsubcategory_id: subsubcategory_id,
                        },
                        success:function(data) {
                            console.log(data);
                            $('#select_product_id').html(data['product']);
                        },
                    });
                } else {
                    alert('danger');
                }
            });

            $('#select_product_id').on('change', function(){
                var product_id = $(this).val();
                var quick_sale_id = $('#quick_sale_id').val();
                var tr_id = 'product_tr_'+product_id;
                if($("#"+tr_id).length == 0) {
                    $.ajax({
                        url: "{{ route('admin.add-product-custom-order-list') }}",
                        type:"POST",
                        data:{
                            _token: '{{csrf_token()}}',
                            product_id: product_id,
                        },
                        success:function(data) {
                            if(data == ''){
                                swal(
                                    'Out of stock!',
                                    '',
                                    'error'
                                )
                            }else{
                                $('#custom-order-product > tbody:last-child').prepend(data);

                                var sub_total = parseInt($('#sub_total').val());
                                var total_discount = parseInt($('#total_discount').val());
                                var total_shipping = parseInt($('#total_shipping').val());
                                var total = parseInt($('#total').val());

                                var pro_total = parseInt($('#pro_total_'+product_id).val());
                                if(sub_total > 0){
                                    var decrease_subtotal = sub_total;
                                }else{
                                    var decrease_subtotal = parseInt(0);
                                }

                                var pro_shipping = parseInt($('#pro_shipping_'+product_id).val());
                                if(total_shipping > 0){
                                    var decrease_shipping = total_shipping - pro_shipping;
                                }else{
                                    var decrease_shipping = parseInt(0);
                                }

                                var quantity = parseInt($('#pro_quantity_'+product_id).val());
                                var pro_sale_price = parseInt($('#pro_sale_price_'+product_id).val());
                                if(quantity > 0){
                                    var subtotal = (quantity * pro_sale_price);
                                }else{
                                    var subtotal = parseInt(0);
                                }
                                if(isNaN(subtotal) ){
                                    subtotal = 0;
                                }
                                $('#pro_total_'+product_id).val(subtotal);

                                if(decrease_subtotal > 0){
                                    var final_subtotal = decrease_subtotal + subtotal;
                                }else{
                                    var final_subtotal = subtotal;
                                }
                                if(isNaN(final_subtotal) || final_subtotal < 0){
                                    final_subtotal = parseInt(0);
                                }
                                $('#sub_total').val(final_subtotal);

                                var pro_shipping = parseInt($('#pro_shipping_'+product_id).val());
                                if(decrease_shipping > 0){
                                    var final_shipping = (decrease_shipping + pro_shipping);
                                }else{
                                    var final_shipping = pro_shipping;
                                }
                                if(isNaN(final_shipping) || final_subtotal < 0){
                                    final_shipping = parseInt(0);
                                }
                                $('#total_shipping').val(final_shipping);

                                var final_total = (final_subtotal + final_shipping) - total_discount;
                                if(isNaN(final_total) ){
                                    final_total = parseInt(0);
                                }
                                $('#total').val(final_total);

                                // payment----
                                var total = parseInt($('#total').val());
                                var paid = parseInt($('#paid').val());
                                var due = total - paid;

                                if(due > 0){
                                    $('#due').val(due);
                                }else{
                                    $('#due').val(0);
                                }
                            }
                        },
                    });
                }else{
                    swal(
                        'Item already added for order!',
                        '',
                        'error'
                    )
                }
            });

        });

        function removeProductTr(product_id){
            var sub_total = parseInt($('#sub_total').val());
            var total_shipping = parseInt($('#total_shipping').val());

            var pro_total = parseInt($('#pro_total_'+product_id).val());
            var pro_shipping = parseInt($('#pro_shipping_'+product_id).val());

            if(sub_total > 0){
                var final_sub_total = sub_total - pro_total;
            }else{
                var final_sub_total = parseInt(0);
            }
            $('#sub_total').val(final_sub_total);

            if(total_shipping > 0){
                var final_shipping = total_shipping - pro_shipping;
            }else{
                var final_shipping = parseInt(0);
            }
            $('#total_shipping').val(final_shipping);


            var sub_total = parseInt($('#sub_total').val());
            var total_shipping = parseInt($('#total_shipping').val());
            var total_discount = parseInt($('#total_discount').val());

            var final_total = (sub_total + total_shipping) - total_discount;
            if(isNaN(final_total) ){
                final_total = parseInt(0);
            }
            $('#total').val(final_total);

            // payment----
            var sub_total = parseInt($('#sub_total').val());
            if(sub_total <= 0){
                $('#total_shipping').val(0);
                $('#total_discount').val(0);
                $('#total').val(0);
                $('#due').val(0);
            }else{
                var total = parseInt($('#total').val());
                var paid = parseInt($('#paid').val());
                var due = total - paid;

                if(due > 0){
                    $('#due').val(due);
                }else{
                    $('#due').val(0);
                }
            }

            $('#product_tr_'+product_id).remove();
        }

        function focusInQuantity(product_id){
            var pro_quantity = parseInt($('#pro_quantity_'+product_id).val());

            if(pro_quantity <= 0){
                $('#pro_quantity_'+product_id).val('');
            }
        }

        function focusOutQuantity(product_id){
            var pro_quantity = parseInt($('#pro_quantity_'+product_id).val());

            if(isNaN(pro_quantity) || pro_quantity == '') {
                $('#pro_quantity_'+product_id).val(0);
            }
        }

        function QuantityCng(product_id){
            var pro_quantity = parseInt($('#pro_quantity_'+product_id).val());
            var pro_max_quantity = parseInt($('#pro_max_quantity_'+product_id).val());

            if(isNaN(pro_quantity) || pro_quantity == '') {
                $('#pro_quantity_'+product_id).val('');
                var quantity = parseInt(0);
            }else{
                var quantity = parseInt($('#pro_quantity_'+product_id).val());
            }

            if(quantity > pro_max_quantity){
                swal(
                        'Out of stock!',
                        '',
                        'error'
                    );

                $('#pro_quantity_'+product_id).val(pro_max_quantity);
                var quantity = parseInt($('#pro_quantity_'+product_id).val());
            }

            var sub_total = parseInt($('#sub_total').val());
            var total_discount = parseInt($('#total_discount').val());
            var total_shipping = parseInt($('#total_shipping').val());
            var total = parseInt($('#total').val());

            var pro_total = parseInt($('#pro_total_'+product_id).val());
            if(sub_total > 0){
                var decrease_subtotal = sub_total - pro_total;
            }else{
                var decrease_subtotal = parseInt(0);
            }

            var pro_shipping = parseInt($('#pro_shipping_'+product_id).val());
            if(total_shipping > 0){
                var decrease_shipping = total_shipping - pro_shipping;
            }else{
                var decrease_shipping = parseInt(0);
            }

            var pro_sale_price = parseInt($('#pro_sale_price_'+product_id).val());
            if(quantity > 0){
                var subtotal = (quantity * pro_sale_price);
            }else{
                var subtotal = parseInt(0);
            }
            if(isNaN(subtotal) ){
                subtotal = 0;
            }
            $('#pro_total_'+product_id).val(subtotal);

            var pro_total = parseInt($('#pro_total_'+product_id).val());
            if(decrease_subtotal > 0){
                var final_subtotal = decrease_subtotal + pro_total;
            }else{
                var final_subtotal = subtotal;
            }
            if(isNaN(final_subtotal) || final_subtotal < 0){
                final_subtotal = parseInt(0);
            }
            $('#sub_total').val(final_subtotal);

            var pro_shipping = parseInt($('#pro_shipping_'+product_id).val());
            if(decrease_shipping > 0){
                var final_shipping = (decrease_shipping + pro_shipping);
            }else{
                var final_shipping = pro_shipping;
            }
            if(isNaN(final_shipping) || final_subtotal < 0){
                final_shipping = parseInt(0);
            }
            $('#total_shipping').val(final_shipping);

            var final_total = (final_subtotal + final_shipping) - total_discount;
            if(isNaN(final_total) ){
                final_total = parseInt(0);
            }
            $('#total').val(final_total);

            // payment----
            var total = parseInt($('#total').val());
            var paid = parseInt($('#paid').val());
            var due = total - paid;

            if(due > 0){
                $('#due').val(due);
            }else{
                $('#due').val(0);
            }

        }

        function focusInSalePrice(product_id){
            var pro_sale_price = parseInt($('#pro_sale_price_'+product_id).val());

            if(pro_sale_price <= 0){
                $('#pro_sale_price_'+product_id).val('');
            }
        }

        function focusOutSalePrice(product_id){
            var sale_price = parseInt($('#pro_sale_price_'+product_id).val());

            if(isNaN(sale_price) || sale_price == '') {
                $('#pro_sale_price_'+product_id).val(0);
            }
        }

        function SalePriceCng(product_id){
            var pro_sale_price = parseInt($('#pro_sale_price_'+product_id).val());

            if(isNaN(pro_sale_price) || pro_sale_price == '') {
                $('#pro_sale_price_'+product_id).val('');
                var pro_sale_price = parseInt(0);
            }else{
                var pro_sale_price = parseInt($('#pro_sale_price_'+product_id).val());
            }


            var sub_total = parseInt($('#sub_total').val());
            var total_discount = parseInt($('#total_discount').val());
            var total_shipping = parseInt($('#total_shipping').val());
            var total = parseInt($('#total').val());

            var pro_total = parseInt($('#pro_total_'+product_id).val());
            if(sub_total > 0){
                var decrease_subtotal = sub_total - pro_total;
            }else{
                var decrease_subtotal = parseInt(0);
            }

            var pro_shipping = parseInt($('#pro_shipping_'+product_id).val());
            if(total_shipping > 0){
                var decrease_shipping = total_shipping - pro_shipping;
            }else{
                var decrease_shipping = parseInt(0);
            }

            var quantity = parseInt($('#pro_quantity_'+product_id).val());
            var pro_sale_price = parseInt($('#pro_sale_price_'+product_id).val());
            if(quantity > 0){
                var subtotal = (quantity * pro_sale_price);
            }else{
                var subtotal = parseInt(0);
            }
            if(isNaN(subtotal) ){
                subtotal = 0;
            }
            $('#pro_total_'+product_id).val(subtotal);

            if(decrease_subtotal > 0){
                var final_subtotal = decrease_subtotal + subtotal;
            }else{
                var final_subtotal = subtotal;
            }
            if(isNaN(final_subtotal) || final_subtotal < 0){
                final_subtotal = parseInt(0);
            }
            $('#sub_total').val(final_subtotal);

            var pro_shipping = parseInt($('#pro_shipping_'+product_id).val());
            if(decrease_shipping > 0){
                var final_shipping = (decrease_shipping + pro_shipping);
            }else{
                var final_shipping = pro_shipping;
            }
            if(isNaN(final_shipping) || final_subtotal < 0){
                final_shipping = parseInt(0);
            }
            $('#total_shipping').val(final_shipping);

            var final_total = (final_subtotal + final_shipping) - total_discount;
            if(isNaN(final_total) ){
                final_total = parseInt(0);
            }
            $('#total').val(final_total);

            // payment----
            var total = parseInt($('#total').val());
            var paid = parseInt($('#paid').val());
            var due = total - paid;

            if(due > 0){
                $('#due').val(due);
            }else{
                $('#due').val(0);
            }

        }

        $('#customer_phone').on('keyup', function(){
            var customer_phone = parseInt($('#customer_phone').val());

            if(isNaN(customer_phone)) {
                $('#customer_phone').val('');
            }
        });

        function focusInPaid(){
            var paid = parseInt($('#paid').val());
            if(paid <= 0){
                $('#paid').val('');
            }
        }

        function focusOutPaid(){
            var paid = parseInt($('#paid').val());
            if(isNaN(paid) || paid == '') {
                $('#paid').val(0);
            }
        }

        function PaidCng(){
            var paid = parseInt($('#paid').val());

            if(isNaN(paid) || paid == '') {
                $('#paid').val('');
                var paid = parseInt(0);
            }else{
                var paid = parseInt($('#paid').val());
            }

            // payment----
            var total = parseInt($('#total').val());
            var due = total - paid;

            if(due > 0){
                $('#due').val(due);
            }else{
                $('#due').val(0);
            }
        }

        function focusInTotalShipping(){
            var total_shipping = parseInt($('#total_shipping').val());
            if(total_shipping <= 0){
                $('#total_shipping').val('');
            }
        }

        function focusOutTotalShipping(){
            var total_shipping = parseInt($('#total_shipping').val());
            if(isNaN(total_shipping) || total_shipping == '') {
                $('#total_shipping').val(0);
            }
        }

        function TotalShippingCng(){
            var total_shipping = parseInt($('#total_shipping').val());

            if(isNaN(total_shipping) || total_shipping == '') {
                $('#total_shipping').val('');
                var total_shipping = parseInt(0);
            }else{
                var total_shipping = parseInt($('#total_shipping').val());
            }

            var sub_total = parseInt($('#sub_total').val());
            var total_discount = parseInt($('#total_discount').val());
            var total = parseInt($('#total').val());

            var final_total = (sub_total + total_shipping) - total_discount;
            $('#total').val(final_total);

            // payment----
            var total = parseInt($('#total').val());
            var paid = parseInt($('#paid').val());
            var due = total - paid;

            if(due > 0){
                $('#due').val(due);
            }else{
                $('#due').val(0);
            }
        }

        function focusInTotalDiscount(){
            var total_discount = parseInt($('#total_discount').val());
            if(total_discount <= 0){
                $('#total_discount').val('');
            }
        }

        function focusOutTotalDiscount(){
            var total_discount = parseInt($('#total_discount').val());
            if(isNaN(total_discount) || total_discount == '') {
                $('#total_discount').val(0);
            }
        }

        function TotalDiscountCng(){
            var total_discount = parseInt($('#total_discount').val());

            if(isNaN(total_discount) || total_discount == '') {
                $('#total_discount').val('');
                var total_discount = parseInt(0);
            }else{
                var total_discount = parseInt($('#total_discount').val());
            }

            var sub_total = parseInt($('#sub_total').val());
            var total_shipping = parseInt($('#total_shipping').val());
            var total = parseInt($('#total').val());

            var final_total = (sub_total + total_shipping) - total_discount;
            $('#total').val(final_total);

            // payment----
            var total = parseInt($('#total').val());
            var paid = parseInt($('#paid').val());
            var due = total - paid;

            if(due > 0){
                $('#due').val(due);
            }else{
                $('#due').val(0);
            }
        }

    </script>
@endpush
