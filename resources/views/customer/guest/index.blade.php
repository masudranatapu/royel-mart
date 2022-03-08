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
			<div class="verification-body">
				<h2 class="title mb-4">Enter your phone number and get OTP</h2>
				<form method="POST" action="{{ route('customer.guestregister.send') }}">
                    @csrf
					<input class="form-control" placeholder="Enter Your Phone Number" type="number" name="phone">
					<button class="verify-btn">SEND PIN</button>
					<br>
					<br>
					Already have an account <a class="text-success" href="{{ route('login') }}">Log In</a>
				</form>
			</div>
		</div>
	</section>
	<!-- End Phone Verification Section -->
@endsection

@push('js')

@endpush