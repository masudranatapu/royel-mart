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

    <section class="phone-verification-section">
        <div class="container">
            <div class="title-area">
                <h2 class="title">Enter your phone number</h2>
            </div>
            <div class="verification-body">
                <form method="POST" action="{{ route('customer.guestotp.resend') }}">
                    @csrf
                    <input class="form-control" placeholder="Enter Your Phone Number" value="{{ $getPhone }}" readonly type="number" name="phone">
                    <button class="verify-btn">Resend PIN</button>
                </form>
                <form method="POST" action="{{ route('customer.guestotp.check') }}" class="send-pin">
                    @csrf
                    <div class="mini-toast">
                        <span>We've sent a 5-digit one time PIN in your phone# {{ $getPhone }}, Please type PIN</span>
                        <button class="close-toast" type="button"><i class="bi bi-x"></i></button>
                    </div>
                    <div class="verify-codes">
						<input type="number" name="code_one" maxlength="1" size="1" min="0" max="9" autofocus pattern="[0-9]{1}">
						<input type="number" name="code_tow" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}">
						<input type="number" name="code_three" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}">
						<input type="number" name="code_four" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}">
						<input type="number" name="code_five" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}">
                    </div>
                    <button class="verify-btn">submit pin</button>
                </form>
            </div>
        </div>
    </section>
    <!-- End Phone Verification Section -->
@endsection

@push('js')

@endpush
