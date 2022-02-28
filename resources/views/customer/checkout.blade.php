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
        <div class="container">
            <div class="shipping-summary-wrapper">
                <div class="shipping-area">
                    <div class="single-wrapper">
                        <h3 class="area-title">Shipping Address
                            <span class="d-block">(Please Fill Out Your Information)</span>
                        </h3>
                        <form action="" class="address">
                            <div class="delivery-types">
                                <label for="">Pick Up Your Parcel From:</label>
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
                                            <select name="billing_division_id" id="billing_div_id" class="form-control">
                                                <option value="" disabled selected>Select One</option>
                                                @foreach($divisions as $division)
                                                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 px-3 pe-0">
                                            <select name="billing_district_id" id="billing_dis_id" class="form-control">
                                                <option disabled selected> First Select Area/ District / City</option>
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
                                <td>{{ $total }} TK</td>
                            </tr>
                            <tr>
                                <td>Shipping </td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td>Payable Total </td>
                                <td>{{ $total }} TK</td>
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
                                    <input id="cash" type="radio" name="payment">
                                    <label for="cash">Cash on Delivery</label>
                                </div>
                            </div>
                            <div class="single-type">
                                <div class="inner-type">
                                    <input id="cards" type="radio" name="payment">
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
                                    <input id="bkash" type="radio" name="payment">
                                    <label for="bkash">
                                        <ul>
                                            <li><img src="{{asset('frontend/images/payments/bkash.png')}}" alt=""></li>
                                        </ul>
                                    </label>
                                </div>
                            </div>
                            <div class="single-type">
                                <div class="inner-type">
                                    <input id="nagad" type="radio" name="payment">
                                    <label for="nagad">
                                        <ul>
                                            <li><img src="{{asset('frontend/images/payments/nagad.png')}}" alt=""></li>
                                        </ul>
                                    </label>
                                </div>
                            </div>
                            <div class="single-type">
                                <div class="inner-type">
                                    <input id="rocket" type="radio" name="payment">
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
    </section>
    <!-- End Shipping Summary Section -->
@endsection

@push('js')

@endpush