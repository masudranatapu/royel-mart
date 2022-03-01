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
	<section class="about-section pt-40 pb-40 bg-lite">
		<div class="container">
			<div class="about-box">
				<h2 class="about-title">{{$about->name}}</h2>
				<div class="about-contents overflow-hidden">
                    <p>
                        {!! $about->details !!}
                    </p>
                </div>
			</div>
		</div>
	</section>
	<!-- End About Section -->
@endsection

@push('js')

@endpush