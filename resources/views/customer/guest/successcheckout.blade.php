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
				<div class="greeting-box">
					<div class="greeting-icon">
						<img src="{{asset('frontend/images/icons/bags.png')}}" alt="">
					</div>
					<h2 class="greeting-title">Success!</h2>
					<p class="greeting-desc">
                        Your Product successfully checkouted. Please check your sms for order code.
                    </p>
					<a href="{{ route('home') }}" class="navigation-btn">Continue Shopping</a>
				</div>
			</div>
		</div>
	</section>
	<!-- End Phone Verification Section -->
@endsection

@push('js')

@endpush