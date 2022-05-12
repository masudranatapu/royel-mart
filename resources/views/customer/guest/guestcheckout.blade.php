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
    <form action="{{ route('customer.guest-checkout.store') }}" method="POST">
        @csrf
        <section class="shipping-summary-section pt-20 pb-60">
            <div class="container">
                <div class="shipping-summary-wrapper">
                    <div class="shipping-area">
                        <div class="single-wrapper">
                            <h3 class="area-title">Shipping Address
                                <span class="d-block">(Please Fill Out Your Information)</span>
                            </h3>
                            <div class="address">
                                <div class="delivery-types">
                                    <label for="">Shipping to</label>
                                    <div class="type-wrapper">
                                        <span class="single-type">
                                            <input type="radio" id="home" checked name="shipping_to" value="home">
                                            <label for="home">home</label>
                                        </span>
                                        <span class="single-type">
                                            <input type="radio" id="office" name="shipping_to" value="office">
                                            <label for="office">Office</label>
                                        </span>
                                    </div>
                                </div>
                                <div class="address-wrapper row">
                                    <div class="single-input col-md-4">
                                        <label for="name">Name: </label>
                                        <input id="name" name="shipping_name" required class="form-control" type="text" placeholder="Full Name">
                                    </div>
                                    <div class="single-input col-md-4">
                                        <label for="email">Email Address: </label>
                                        <input id="email" name="shipping_email" required class="form-control" type="text" placeholder="Email Address">
                                    </div>
                                    <div class="single-input col-md-4">
                                        <label for="phone">Phone Number: </label>
                                        <input id="shipping_phone" name="shipping_phone" readonly class="form-control" type="text" value="{{ $getPhone }}" placeholder="Phone">
                                    </div>

                                    <div class="single-input col-md-4">
                                        <label for="phone">Division</label>
                                        <select name="division_id" id="division_id" class="form-control" required>
                                            <option  disabled selected>Select One</option>
                                            @foreach($divisions as $division)
                                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="single-input col-md-4">
                                        <label for="phone">Division</label>
                                        <select name="district_id" id="district_id" class="form-control" required>
                                            <option disabled selected>select district</option>
                                        </select>
                                    </div>
                                    <div class="single-input col-md-4">
                                        <label for="phone">Area</label>
                                        <select name="area_id" id="area_id" class="form-control" required>
                                            <option disabled selected>select area</option>
                                        </select>
                                    </div>

                                    <div class="single-input col-md-12">
                                        <label for="phone">Address</label>
                                        <textarea class="form-control" name="shipping_address" placeholder="Your Address" cols="30" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="summary-area">
                        @php
                            $sub_total = 0;
                            $total = 0;
                            $discount = 0;
                            $shipping_charge = 0;
                        @endphp
                        @if(session('cart'))
                            @foreach(session('cart') as $key => $checkoutDetails)
                                @php
                                    $sub_total += ($checkoutDetails['regular_price'] * $checkoutDetails['quantity']);
                                    $shipping_charge += $checkoutDetails['shipping_charge'];
                                    $discount += $checkoutDetails['discount'];
                                @endphp
                                <input type="hidden" name="product_id[]" value="{{ $key }}">
                                <input type="hidden" name="sale_price[]" value="{{ $checkoutDetails['price'] }}">
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
                                    <input type="hidden" name="sub_total" id="sub_total" value="{{ $sub_total }}">
                                    <td>{{ $sub_total }} ৳</td>
                                </tr>
                                <tr>
                                    @php
                                        $total = ($sub_total + $shipping_charge) - $discount;
                                    @endphp
                                    <td>Shipping </td>
                                    <input type="hidden" name="shipping_amount" id="shipping_amount" value="{{ $shipping_charge }}">
                                    <td> <span id="delivery_amount">{{ $shipping_charge }}</span> ৳</td>
                                </tr>
                                <tr>
                                    <td>Discount </td>
                                    <input type="hidden" name="discount" id="discount" value="{{ $discount }}">
                                    <td> <span id="discount_amount">{{ $discount }}</span> ৳</td>
                                </tr>
                                <tr>
                                    <td>Payable Total</td>
                                    <input type="hidden" name="total" id="total" value="{{ $total }}">
                                    <td><span id="grand_total">{{ $total }} </span> ৳</td>
                                </tr>
                            </tbody>
                        </table>
                        {{-- @if ($discount <= 0) --}}
                            <div class="accordion" id="promo">
                                <div class="accordion-item">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Add Promo code or Gift voucher
                                    </button>
                                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#promo">
                                        <div class="accordion-body">
                                            <input class="form-control" name="voucher_code" id="voucher_code" type="text">
                                            <input class="form-control" id="voucher_code_apply" type="hidden" value="0">
                                            <button class="promo-btn" type="button" id="applyVoucherBtn" onclick="applyVoucher()">apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {{-- @endif --}}
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
                                        <label for="cash">
                                            <ul>
                                                <li><img src="{{asset('image/cod.png')}}" alt=""></li>
                                            </ul>
                                        </label>
                                    </div>
                                </div>
                                <div class="single-type">
                                    <div class="inner-type">
                                        <input id="cards" type="radio" name="payment_method" value="Payment Cards">
                                        <label for="cards">
                                            <ul>
                                                <li><img src="{{asset('image/ssl.png')}}" alt=""></li>
                                            </ul>
                                        </label>
                                    </div>
                                </div>
                                {{-- <div class="single-type">
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
                                </div> --}}
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
        </section>
    </form>
    <!-- End Shipping Summary Section -->
@endsection

@push('js')
    <script src="{{asset('massage/sweetalert/sweetalert.all.js')}}"></script>
    <script>

        function applyVoucher() {
            var shipping_phone = $('#shipping_phone').val();
            var voucher_code = $('#voucher_code').val();
            var voucher_code_apply = parseInt($('#voucher_code_apply').val());

            var discount_amount = parseInt($('#discount').val());
            var total = parseInt($('#total').val());

            if (voucher_code == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please enter voucher code!',
                })
            }else if (voucher_code_apply == 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Already used this code!',
                })
            } else {
                $.ajax({
                    url: "{{ route('customer.voucher-check-with-guest') }}",
                    type: 'GET',
                    data: {
                        shipping_phone: shipping_phone,
                        voucher_code: voucher_code,
                        discount_amount: discount_amount,
                        total: total,
                        _token: '{{csrf_token()}}',
                    },
                    success: function(data) {
                        if (data['real_code'] <= 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'You entered invalid code!',
                            })

                            $('#voucher_code_apply').val(0);
                            $('#voucher_code').val('');
                        } else if (data['code_applicable'] <= 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'This code applicable for minimum purchase '+data['min_p_amount']+' ৳',
                            })

                            $('#voucher_code_apply').val(0);
                            $('#voucher_code').val('');
                        } else if (data['use_time'] <= 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Already used this code and crossed the limit!',
                            })

                            $('#voucher_code_apply').val(0);
                            $('#voucher_code').val('');
                        } else {
                            $('#discount').val(data['discount_amount']);
                            $('#discount_amount').html(data['discount_amount']);
                            $('#total').val(data['total']);
                            $('#grand_total').html(data['total']);
                            $('#voucher_code_apply').val(1);
                        }
                    },
                });
            }
        }

        $('#division_id').on('change', function(){
            var division_id = $(this).val();

            $('#district_id').html('<option value="">Select One</option>');
            $('#area_id').html('<option value="">Select One</option>');

            $.ajax({
                url: "{{ route('get-customer-district-by-division') }}",
                type:"POST",
                data:{
                    _token: '{{csrf_token()}}',
                    division_id: division_id,
                },
                success:function(data) {
                    $('#district_id').html(data);
                },
            });

        });

        $('#district_id').on('change', function(){
            var district_id = $(this).val();

            $('#area_id').html('<option value="">Select One</option>');

            $.ajax({
                url: "{{ route('get-customer-area-by-district') }}",
                type:"POST",
                data:{
                    _token: '{{csrf_token()}}',
                    district_id: district_id,
                },
                success:function(data) {
                    $('#area_id').html(data);
                },
            });

        });

        $('#area_id').on('change', function(){
            var area_id = $(this).val();

            $.ajax({
                url: "{{ route('get-customer-area-by-district') }}",
                type:"POST",
                data:{
                    _token: '{{csrf_token()}}',
                    area_id: area_id,
                },
                success:function(data) {
                    console.log(data);
                },
            });

        });

    </script>

@endpush
