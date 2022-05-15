@extends('layouts.frontend.app')

@section('title')
    Reset Password
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
				<form method="POST" action="{{ route('otp-send-for-password-reset') }}">
                    @csrf
					<input class="form-control" placeholder="Enter Your Phone Number" type="number" name="phone">
					<button class="verify-btn">SEND PIN</button>
				</form>
			</div>
		</div>
	</section>

@endsection

@push('js')

@endpush
