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
	<section class="page-title-section">
		<div class="container">
			<h1 class="page-title">Contact Us</h1>
		</div>
	</section>
	<!-- End Page Title Section -->
	<section class="contact-section pt-40 pb-60">
		<div class="container">
			<div class="contact-info-area mb-40">
				<div class="row">
					<div class="col-sm-4 mb-3">
						<div class="single-info">
							<div class="icon-box">
								<div class="icon">
									<img src="{{asset('frontend/images/icons/phone.png')}}" alt="">
								</div>
							</div>
							<div class="info">
								<span>Phone</span>
								<span>+ {{ $website->phone }}</span>
							</div>
						</div>
					</div>
					<div class="col-sm-4 mb-3">
						<div class="single-info">
							<div class="icon-box">
								<div class="icon">
									<img src="{{asset('frontend/images/icons/location.png')}}" alt="">
								</div>
							</div>
							<div class="info">
								<span>Address</span>
								<span>{{ $website->address }}</span>
							</div>
						</div>
					</div>
					<div class="col-sm-4 mb-3">
						<div class="single-info">
							<div class="icon-box">
								<div class="icon">
									<img src="{{asset('frontend/images/icons/mail.png')}}" alt="">
								</div>
							</div>
							<div class="info">
								<span>Email</span>
								<span>{{ $website->email }}</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="location-area mb-40">
				<div class="map-wrapper">
                    <div class="mapouter">
                        <div class="gmap_canvas">
                            <iframe width="100%" height="100%" id="gmap_canvas" src="https://maps.google.com/maps?q=Mohammadpur,%20dhaka&t=k&z=19&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0">

                            </iframe>
                            <a href="https://www.embedgooglemap.net/blog/divi-discount-code-elegant-themes-coupon/"></a>
                            <br>
                            <style>
                                .mapouter{position:relative;text-align:right;height:100%;width:100%;}
                            </style>
                            <a href="https://www.embedgooglemap.net">
                                google map html
                            </a>
                            <style>
                                .gmap_canvas {overflow:hidden;background:none!important;height:100%;width:100%;}
                            </style>
                        </div>
                    </div>
                </div>
			</div>
			<div class="contact-form-area">
				<div class="form-wrapper">
					<h2 class="form-title">Contact Form</h2>
					<form action="{{ route('contact.store') }}" method="POST">
                        @csrf
						<div class="row">
							<div class="col-sm-4 px-2 mb-sm-3 mb-2">
								<input class="form-control" name="name" type="text" placeholder="Name ">
							</div>
							<div class="col-sm-4 px-2 mb-sm-3 mb-2">
								<input class="form-control" name="email" type="email" placeholder="Email ">
							</div>
							<div class="col-sm-4 px-2 mb-sm-3 mb-2">
								<input class="form-control" name="phone" type="number" placeholder="Phone:">
							</div>
							<div class="col-12 px-2 mb-sm-3 mb-2">
								<textarea class="form-control" name="message" placeholder="Message" id="" cols="30" rows="6"></textarea>
							</div>
							<div class="col-12">
								<button type="submit" class="submit-contact">Contact Us</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	<!-- End Contact Section -->
@endsection

@push('js')

@endpush