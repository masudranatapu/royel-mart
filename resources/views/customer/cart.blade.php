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
    <section class="cart-section pt-20 pb-60">
        <div class="container">
            <div class="cart-summary-wrapper">
                <div class="cart-area">
                    <h3 class="area-title">Shopping Cart</h3>
                    <div class="cart-products">
                        @php
                            $total = 0;
                            $i = 1;
                        @endphp
                        @if(session('cart'))
                            @foreach(session('cart') as $key => $cartdetails)
                                @php
                                    $total += $cartdetails['price'] * $cartdetails['quantity'] ;
                                @endphp
                                <div class="single-item">
                                    <figure>
                                        <a href="#">
                                            <img src="{{ asset($cartdetails['image']) }}">
                                        </a>
                                    </figure>
                                    <div class="contents">
                                        <h4 class="product-name">
                                            {{ $cartdetails['name'] }}
                                        </h4>
                                        <div class="product-info">
                                            @if($cartdetails['color_id'])
                                                @php
                                                    $color = App\Models\Unit::findOrFail($cartdetails['color_id']);
                                                @endphp
                                                <div class="single-info">
                                                    <label for="">Color:</label>
                                                    <span>{{ $color->name }}</span>
                                                </div>
                                            @endif
                                            @if($cartdetails['size_id'])
                                                @php
                                                    $size = App\Models\SubUnit::findOrFail($cartdetails['size_id']);
                                                @endphp
                                                <div class="single-info">
                                                    <label for="">Size:</label>
                                                    <span>{{ $size->name }}</span>
                                                </div>
                                            @endif
                                            <div class="single-info mobile">
                                                <label for="">Price: </label>
                                                <span class="price">{{ $cartdetails['price'] }} ৳</span>
                                            </div>
                                        </div>
                                        <div class="product-qty">
                                            <div class="quantity-wrapper">
                                                <button class="qty btn-number button_plus_minus btn-minus-qty_{{ $key }} update-cart" @if ($cartdetails['quantity'] <= 1) disabled="disabled" @endif data-id="{{ $key }}" data-type="minus" data-field="quant_{{ $key }}[1]">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <div class="input-wrapper">
                                                    <input type="number" name="quant_{{ $key }}[1]" class="form-control input-number" value="{{ $cartdetails['quantity'] }}" min="1" max="100">
                                                </div>
                                                <button class="qty btn-number button_plus_minus btn-plus-qty_{{ $key }} update-cart" data-id="{{ $key }}" data-type="plus" data-field="quant_{{ $key }}[1]">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>								
                                        </div>
                                    </div>
                                    <div class="product-price">
                                        <span class="price">{{ $cartdetails['price'] }} ৳</span>
                                    </div>
                                    <button class="option-btn" title="Product remove form cart" onclick="removeFormCart({{ $key }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $key }}" action="{{ route('cart.remove', $key) }}" method="get" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            @endforeach
                        @endif
                    </div>				
                </div>
                <div class="summary-area">
                    <h3 class="area-title">Checkout Summary</h3>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Subtotal</td>
                                <td>{{ $total }} ৳</td>
                            </tr>
                            <tr>
                                <td>Total amount</td>
                                <td>{{ $total }} ৳</td>
                            </tr>
                            <tr>
                                <td>Payable Total</td>
                                <td>{{ $total }} ৳</td>
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
            <div class="text-center mt-40">
                @auth
                    <a href="{{ route('customer.checkout.index') }}" class="navigation-btn" type="submit">Goto Checkout Page</a>
                @else
                    <a href="{{ route('customer.guest-checkout.index') }}" class="navigation-btn" type="submit">Goto Checkout Page</a>
                @endauth
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="{{ asset('massage/sweetalert/sweetalert.all.js') }}"></script>
    <script type="text/javascript">
        function removeFormCart(id) {
            swal({
                title: 'Are you sure?',
                text: "Your want to remove product from cart ?",
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
                        'Your cart product save. Please checkout :-)',
                        'error'
                    )
                }
            })
        }
    </script>
    <script>
        $('.btn-number').click(function(e){
            e.preventDefault();
            var ele = $(this);
            var id = ele.attr("data-id");
            fieldName = $(this).attr('data-field');
            type      = $(this).attr('data-type');
            var input = $("input[name='"+fieldName+"']");
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if(type == 'minus') {
                    if(currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                        $.ajax({
                            url: '{{ url('update-cart') }}',
                            method: "patch",
                            data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: currentVal - 1},
                            success: function (data) {
                                window.location.reload();
                            }
                        });
                    }
                    if(parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }
                } else if(type == 'plus') {
                    if(currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                        $('.btn-minus-qty_'.id).attr('disabled', false);
                        $.ajax({
                            url: '{{ url('update-cart') }}',
                            method: "patch",
                            data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: currentVal + 1},
                            success: function (data) {
                                window.location.reload();
                            }
                        });
                    }
                    if(parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }
                }
            } else {
                input.val(0);
            }
        });
    </script>
@endpush