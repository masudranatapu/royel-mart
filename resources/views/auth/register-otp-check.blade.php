@extends('layouts.frontend.app')

@section('title')
    {{ $title }}
@endsection
    @php
        $website = App\Models\Website::latest()->first();
        $search = '';
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
								@if($category->id == 1)
								@else
                                    <li>
                                        <a href="{{ route('category', $category->slug) }}">
                                            <img src="@if($category->image) {{ asset($category->image) }} @else {{ asset('demomedia/category.png') }} @endif" alt="">
                                            <span>{{ $category->name }}</span>
                                        </a>
                                        @php
                                            $parentcategories = App\Models\Category::where('parent_id', $category->id)->where('child_id', NULL)->latest()->get();
                                        @endphp
                                        @if($parentcategories->count() > 0)
                                            <ul>
                                                @foreach($parentcategories as $parentcategory)
                                                    <li>
                                                        <a href="{{ route('category', $parentcategory->slug) }}">
                                                            {{ $parentcategory->name }}
                                                        </a>
                                                        @php
                                                            $childcategories = App\Models\Category::where('child_id', $parentcategory->id)->latest()->get();
                                                        @endphp
                                                        @if($childcategories->count() > 0)
                                                            <ul>
                                                                @foreach($childcategories as $childcategory)
                                                                    <li>
                                                                        <a href="{{ route('category', $childcategory->slug) }}">
                                                                            {{ $childcategory->name }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endif
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
						<span>{{ $getName }} , We sent one time OTP in your phone number {{ $getPhone }} Please type OTP</span>
						<button class="close-toast" type="button">
                            <i class="bi bi-x"></i>
                        </button>
					</div>
					<div class="verify-codes">
						<input type="text" name="code_one" maxlength="1" size="1" min="0" max="9" autofocus pattern="[0-9]{1}">
						<input type="text" name="code_tow" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}">
						<input type="text" name="code_three" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}">
						<input type="text" name="code_four" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}">
						<input type="text" name="code_five" maxlength="1" size="1" min="0" max="9" pattern="[0-9]{1}">
					</div>
					<button class="verify-btn">Submit OTP</button>
                    <br>
                    <br>
					<a href="{{ route('customer.otp.resend') }}" title="Resend OTP on your phone number">Resend OTP</a>
				</form>
			</div>
		</div>
	</section>
@endsection

@push('js')

@endpush
