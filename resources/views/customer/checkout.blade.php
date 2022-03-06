@extends('layouts.frontend.app')

@section('title')
    {{$title}}
@endsection

@section('meta')

@endsection

@push('css')

@endpush

@section('content')

    @include('layouts.frontend.partial.breadcrumbcategory')

	<section class="shipping-summary-section pt-20 pb-60">
        <form action="">
            <div class="container">
                <div class="shipping-summary-wrapper">
                    <div class="shipping-area">
                        <div class="single-wrapper">
                            <h3 class="area-title">Shipping Address
                                <span class="d-block">(Please Fill Out Your Information)</span>
                            </h3>
                            <div class="address-area">
                                <div class="addresses">
                                    @foreach($shippingaddress as $shippaddress)
                                        @php
                                            $orders = App\Models\Order::where('id', $shippaddress->order_id)->latest()->first();
                                        @endphp
                                        <div class="single-address">
                                            <div class="address-head">
                                                <div class="label-area">
                                                    <input type="radio" id="address{{$shippaddress->id}}" name="address" value="{{$shippaddress->id}}">
                                                    <label for="address{{$shippaddress->id}}">address one</label>
                                                </div>
                                                <div class="edit-area">
                                                    <button type="button" class="edit-trigger" data-bs-toggle="modal" data-bs-target="#edit-form{{$shippaddress->id}}">
                                                        <i class="bi bi-pencil-square"></i>
                                                        edit
                                                    </button>
                                                    <a href="{{ route('customer.deleteshipping.address', $shippaddress->id) }}" onclick="return confirm('Are you sure, you want delete this shipping address ? ')" class="remove-trigger" >
                                                        <i class="bi bi-trash"></i>
                                                        delete
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="address-body">
                                                <div class="address-wrapper">
                                                    <p><label for="">Shipping To : </label><span>Home</span></p>
                                                    <p><label for="">name : </label><span>{{  $shippaddress->shipping_name }}</span></p>
                                                    <p><label for="">Phone : </label><span>{{  $shippaddress->shipping_phone }}</span></p>
                                                    <p><label for="">Mail : </label><span>{{  $shippaddress->shipping_email }}</span></p>
                                                    <p><label for="">Address : </label><span>{{  $shippaddress->shipping_address }}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="edit-form{{$shippaddress->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    <div class="edit-form">
                                                        <form action="{{ route('customer.shippingaddress.update', $shippaddress->id) }}" class="address">
                                                            @csrf
                                                            <div class="delivery-types">
                                                                <label for="">Shipping your product to</label>
                                                                <div class="type-wrapper">
                                                                    <span class="single-type">
                                                                        <input type="radio" id="home{{$shippaddress->id}}" name="shippingto" @if($orders->shippingto == 'home') checked @endif>
                                                                        <label for="home{{$shippaddress->id}}">home</label>
                                                                    </span>
                                                                    <span class="single-type">
                                                                        <input type="radio" id="office{{$shippaddress->id}}" name="shippingto" @if($orders->shippingto == 'office') checked @endif>
                                                                        <label for="office{{$shippaddress->id}}">Office</label>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="address-wrapper">
                                                                <div class="single-input">
                                                                    <label for="name">Name </label>
                                                                    <input id="name" class="form-control" type="text" name="shipping_name" value="{{ $shippaddress->shipping_name }}">
                                                                </div>
                                                                <div class="single-input">
                                                                    <label for="phone">Email Address </label>
                                                                    <input id="phone" class="form-control" type="text" name="shipping_email" value="{{ $shippaddress->shipping_email }}">
                                                                </div>
                                                                <div class="single-input">
                                                                    <label for="phone">Phone Number </label>
                                                                    <input id="phone" class="form-control" type="text" name="shipping_phone" value="{{ $shippaddress->shipping_phone }}">
                                                                </div>
                                                                <div class="single-input">
                                                                    <div class="row mx-0">
                                                                        <div class="col-6 px-3 ps-0">
                                                                            <select name="shipping_division_id" class="form-select" id="billing_div_id_{{ $shippaddress->id }}" onChange="editDivision('{{ $shippaddress->id }}')">
                                                                                <option value="" selected>Select One</option>
                                                                                @foreach($divisions as $division)
                                                                                    <option @if($division->id == $shippaddress->shipping_division_id) selected @endif value="{{ $division->id }}">{{ $division->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-6 px-3 pe-0">
                                                                            <select name="shipping_district_id" class="form-select" id="billing_dis_id_{{ $shippaddress->id }}">
                                                                                @foreach($districts as $district)
                                                                                    <option @if($district->id == $shippaddress->shipping_district_id) selected @endif value="{{ $district->id }}">{{ $district->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="single-input">
                                                                    <textarea class="form-control" name="shipping_address" id="" placeholder="Address" cols="30" rows="10">{{  $shippaddress->shipping_address }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="text-center">
                                                                <button type="submit" class="save-address">save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="address-footer">
                                    <button type="button" class="address-trigger">
                                        <i class="bi bi-plus"></i>
                                        add new address
                                    </button>
                                </div>
                            </div>
                            <div class="toggle-form">
                                <form action="" class="address">
                                    <div class="delivery-types">
                                        <label for="">Pick up your product from : </label>
                                        <div class="type-wrapper">
                                            <span class="single-type">
                                                <input type="radio" id="home" name="pickup">
                                                <label for="home">home</label>
                                            </span>
                                            <span class="single-type">
                                                <input type="radio" id="office" name="pickup">
                                                <label for="office">Office</label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="address-wrapper">
                                        <div class="single-input">
                                            <label for="name">Name: </label>
                                            <input id="name" class="form-control" type="text">
                                        </div>
                                        <div class="single-input">
                                            <label for="phone">Phone Number: </label>
                                            <input id="phone" class="form-control" type="text">
                                        </div>
                                        <div class="single-input">
                                            <div class="row mx-0">
                                                <div class="col-6 px-3 ps-0">
                                                    <label for="phone">Division</label>
                                                    <select name="" id="billing_div_id" class="form-control">
                                                        <option value="" disabled selected>Select One</option>
                                                        @foreach($divisions as $division)
                                                            <option value="{{ $division->id }}">{{ $division->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-6 px-3 pe-0">
                                                    <label for="phone">District</label>
                                                    <select name="" id="billing_dis_id" class="form-control">
                                                        <option disabled selected>First select division</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="single-input">
                                            <textarea class="form-control" name="" id="" placeholder="Address" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="summary-area">
                        @php 
                            $total = 0;
                        @endphp
                        @if(session('cart'))
                            @foreach(session('cart') as $key => $checkoutDetails)
                                @php
                                    $total += $checkoutDetails['price'] * $checkoutDetails['quantity'];
                                @endphp
                                <input type="hidden" name="product_id[]" value="{{ $key }}">
                                <input type="hidden" name="quantity[]" value="{{ $checkoutDetails['quantity'] }}">
                                <input type="hidden" name="size_id[]" value="{{ $checkoutDetails['size_id'] }}">
                                <input type="hidden" name="color_id[]" value="{{ $checkoutDetails['color_id'] }}">
                            @endforeach
                        @endif
                        <h3 class="area-title">Checkout Summary</h3>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Subtotal </td>
                                    <input type="hidden" name="sub_total" id="sub_total" value="{{ $total }}">
                                    <td>{{ $total }} TK</td>
                                </tr>
                                <tr>
                                    <td>Shipping </td>
                                    <input type="hidden" name="shipping_amount" id="shipping_amount" value="">
                                    <td> <span id="delivery_amount"> </span> TK</td>
                                </tr>
                                <tr>
                                    <td>Payable Total</td>
                                    <td><span id="grand_total">{{ $total }} </span> TK</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="accordion" id="promo">
                            <div class="accordion-item">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Add Promo code or Gift voucher
                                </button>
                                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#promo">
                                    <div class="accordion-body">
                                        <form action="">
                                            <input class="form-control" type="text">
                                            <button class="promo-btn" type="submit">apply</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="shipping-summary-wrapper mt-30">
                    <div class="shipping-area">
                        <div class="single-wrapper">
                            <h3 class="area-title">Payment Method
                                <span class="d-block">(Please Fill Out Your Information)</span>
                            </h3>
                            <div class="payment-types">
                                <div class="single-type">
                                    <div class="inner-type">
                                        <input id="cash" type="radio" name="payment_method" value="Cash">
                                        <label for="cash">Cash on Delivery</label>
                                    </div>
                                </div>
                                <div class="single-type">
                                    <div class="inner-type">
                                        <input id="cards" type="radio" name="payment_method" value="Payment Cards">
                                        <label for="cards">
                                            <ul>
                                                <li><img src="{{asset('frontend/images/payments/1.jpg')}}" alt=""></li>
                                                <li><img src="{{asset('frontend/images/payments/2.jpg')}}" alt=""></li>
                                                <li><img src="{{asset('frontend/images/payments/3.jpg')}}" alt=""></li>
                                                <li><img src="{{asset('frontend/images/payments/4.jpg')}}" alt=""></li>
                                            </ul>
                                        </label>
                                    </div>
                                </div>
                                <div class="single-type">
                                    <div class="inner-type">
                                        <input id="bkash" type="radio" name="payment_method" value="Bkash">
                                        <label for="bkash">
                                            <ul>
                                                <li><img src="{{asset('frontend/images/payments/bkash.png')}}" alt=""></li>
                                            </ul>
                                        </label>
                                    </div>
                                </div>
                                <div class="single-type">
                                    <div class="inner-type">
                                        <input id="nagad" type="radio" name="payment_method" value="Nagad">
                                        <label for="nagad">
                                            <ul>
                                                <li><img src="{{asset('frontend/images/payments/nagad.png')}}" alt=""></li>
                                            </ul>
                                        </label>
                                    </div>
                                </div>
                                <div class="single-type">
                                    <div class="inner-type">
                                        <input id="rocket" type="radio" name="payment_method" value="Rocket">
                                        <label for="rocket">
                                            <ul>
                                                <li><img src="{{asset('frontend/images/payments/rocket.png')}}" alt=""></li>
                                            </ul>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="shipping-area mt-20 bg-transparent border-0 p-0">
                        <div class="order-note">
                            <p>Note: In some cases, the price of your peace book / product may change from the supplier / supplier for various reasons. You may not get it from your family book / product publisher / supplier. We apologize for any inconvenience this person may have caused</p>
                        </div>
                        <div class="text-center mt-20">
                            <button class="navigation-btn" type="submit">Confirm Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
	</section>
	<!-- End Shipping Summary Section -->
@endsection

@push('js')
    <script>
        // informaiton division
        $("#billing_div_id").on('change', function() {
            var billing_div_id = $("#billing_div_id").val();
            // alert(billing_div_id);
            var sub_total = $("#sub_total").val();
            // alert(sub_total);
            var grand_total = $("#grand_total").text();
            // alert(grand_total);
            if(billing_div_id){
                $.ajax({
                    url         : "{{ url('customer/division-distric/ajax') }}/" + billing_div_id ,
                    type        : 'GET',
                    dataType    : 'json',
                    success     : function(data) {
                        // console.log(data);
                        $("#billing_dis_id").empty();
                        $('#billing_dis_id').append('<option value=""> Select One </option>');
                        $("#vatDisplay").show();
                        $.each(data[0], function(key, value){
                            $('#billing_dis_id').append('<option value="'+ value.id +'">' + value.name + '</option>');
                        });
                        $("#delivery_amount").text(data[1]);
                        $("#shipping_amount").val(data[1]);
                        $("#grand_total").text(parseInt(data[1]) + parseInt(sub_total));
                    },
                });
            }else {
                alert("Select your division");
            };
        });
        // informaiton distric
        $("#billing_dis_id").on('change', function() {
            var billing_dis_id = $("#billing_dis_id").val();
            // alert(billing_dis_id);
            var sub_total = $("#sub_total").val();
            // alert(sub_total);
            var grand_total = $("#grand_total").text();
            // alert(grand_total);
            if(billing_dis_id){
                $.ajax({
                    url         : "{{ url('customer/distric-division/ajax') }}/" + billing_dis_id ,
                    type        : 'GET',
                    dataType    : 'json',
                    success     : function(data) {
                        console.log(data);
                        $("#delivery_amount").text(data[0]);
                        $("#shipping_amount").val(data[0]);
                        $("#grand_total").text(parseInt(data[0]) + parseInt(sub_total));
                    },
                });
            }else {
                alert("Select your distric");
            };
        });
        // edit billing
        function editDivision(id) {

            var billing_div_id = $("#billing_div_id_" + id).val();
            alert(billing_div_id);

            if(billing_div_id){
                $.ajax({
                    url         : "{{ url('customer/division-distric/ajax') }}/" + billing_div_id ,
                    type        : 'GET',
                    dataType    : 'json',
                    success     : function(data) {
                        // console.log(data);
                        $("#billing_dis_id_" + id).empty();
                        $("#billing_dis_id_" + id).append('<option value=""> Select One </option>');
                        $("#vatDisplay").show();
                        $.each(data[0], function(key, value){
                            $("#billing_dis_id_" + id).append('<option value="'+ value.id +'">' + value.name + '</option>');
                        });
                    },
                });
            }else {
                alert("Select your division");
            };
        };
    </script>
@endpush