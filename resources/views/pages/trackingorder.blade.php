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
				<h2 class="title mb-4">Tracking your order now</h2>
				<form action="{{ route('trackingorder.view') }}" method="get">
                    @csrf
					<input class="form-control" placeholder="Your Order Code like 00001" name="order_code" type="text">
					<button class="verify-btn">Tracking Order</button>
				</form>
			</div>
		</div>
	</section>
	<!-- End Phone Verification Section -->
@endsection

@push('js')

@endpush