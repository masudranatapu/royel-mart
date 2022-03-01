@extends('layouts.frontend.app')

@section('title')
    {{ $title }}
@endsection
    @php
        $website = App\Models\Website::latest()->first();
    @endphp
@section('meta')

@endsection

@push('css')

@endpush

@section('content')
	<section class="breadcrumb-section">
		<div class="container-fluid">
			<div class="category-breadcrumb">
				<div class="category-wrapper">
					<h4 class="dropdown-title">categories<i class="bi bi-chevron-down"></i></h4>
					<div class="category-area checknav">
                        @php
                            $categories = App\Models\Category::where('parent_id', NULL)->where('child_id', NULL)->where('status', 1)->latest()->get();
                        @endphp
                        <ul class="category-list">
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('category', $category->slug) }}">
                                        <img src="@if($category->image) {{ asset($category->image) }} @else {{ asset('demomedia/category.png') }} @endif" alt="">
                                        <span>{{ $category->name }}</span>
                                    </a>
                                    @php
                                        $parentcategories = App\Models\Category::where('parent_id', $category->id)->where('child_id', NULL)->latest()->get();
                                    @endphp
                                    <ul>
                                        @foreach($parentcategories as $parentcategory)
                                            <li>
                                                <a href="{{ route('category', $parentcategory->slug) }}">
                                                    {{ $parentcategory->name }}
                                                </a>
                                                @php
                                                    $childcategories = App\Models\Category::where('child_id', $parentcategory->id)->latest()->get();
                                                @endphp
                                                <ul>
                                                    @foreach($childcategories as $childcategory)
                                                        <li>
                                                            <a href="{{ route('category', $childcategory->slug) }}">
                                                                {{ $childcategory->name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
					</div>
				</div>
				<div class="breadcrumb-area">
					<ul class="breadcrumb">
						<li><a href="{{ route('home') }}">Home</a></li>
						<li>{{ $title }}</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<!-- End Breadcrumb -->
	<section class="phone-verification-section">
		<div class="container">
			<div class="verification-body">
				<form method="POST" action="{{ route('customer.otp.check') }}" class="send-pin pt-0">
                    @csrf
					<div class="mini-toast">
						<span>{{ $getName }} We've sent a 5-digit one time PIN in your phone# {{ $getPhone }}, Please type PIN</span>
						<button class="close-toast" type="button">
                            <i class="bi bi-x"></i>
                        </button>
					</div>
                    <div class="single-input">
                        <input class="form-control" type="number" name="otp_code" placeholder="OPT Code">
                    </div>
					<button type="submit" class="verify-btn">submit OTP</button>
				</form>
			</div>
		</div>
	</section>
	<!-- End Phone Verification Section -->
@endsection

@push('js')

@endpush