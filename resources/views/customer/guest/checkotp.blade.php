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
                <form action="">
                    <input class="form-control" placeholder="Enter Your Phone Number" type="text">
                    <button class="verify-btn">Resend PIN</button>
                </form>
                <form action="#" class="send-pin">
                    <div class="mini-toast">
                        <span>We've sent a 4-digit one time PIN in your phone# 01791005945, Please type PIN</span>
                        <button class="close-toast" type="button"><i class="bi bi-x"></i></button>
                    </div>
                    <div class="verify-codes">
                        <input type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                        <input type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                        <input type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                        <input type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                    </div>	
                    <button class="verify-btn">submit pin</button>
                    <div class="alter">
                        <label for="">If you fail to get OTP. Try logging in</label>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- End Phone Verification Section -->
@endsection

@push('js')

@endpush