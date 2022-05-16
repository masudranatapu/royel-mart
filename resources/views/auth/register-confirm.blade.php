@extends('layouts.frontend.app')

@section('title')
    {{$title}}
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
                        <ul class="category-list">
                            @include('layouts.frontend.partial.breadcrumb_category')
                        </ul>
					</div>
				</div>
				<div class="breadcrumb-area">
					<ul class="breadcrumb">
						<li><a href="{{ route('home') }}">Home</a></li>
						<li>{{$title}}</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<!-- End Breadcrumb -->
	<section class="login-register-section">
		<div class="container">
			<div class="login-reg-box">
				<div class="inner-box">
					<form method="POST" action="{{ route('customer.info.save') }}">
                        @csrf
						<div class="title-box">
							<h3 class="title">Create an account</h3>
						</div>
						<div class="single-input">
							<input class="form-control" readonly type="text" name="name" value="{{ $getName }}">
						</div>
						<div class="single-input">
							<input class="form-control" readonly type="email" name="email" value="{{ $getEmail }}">
						</div>
						<div class="single-input">
							<input class="form-control" readonly type="number" name="phone" value="{{ $getPhone }}">
						</div>

                        <div class="form-group mb-3">
                            <select name="division_id" id="division_id" required class="form-control select2">
                                <option value="" disabled selected>Select One</option>
                                @foreach($divisions as $division)
                                    <option value="{{$division->id}}" @if($division->id == $division_id) selected @endif>{{$division->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <select name="district_id" id="district_id" required class="form-control select2">
                                <option value="">Select One</option>
                                @foreach($districts as $district)
                                    <option value="{{$district->id}}" @if($district->id == $district_id) selected @endif>{{$district->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <select name="area_id" id="area_id" required class="form-control select2">
                                <option value="">Select One</option>
                                @foreach($areas as $area)
                                    <option value="{{$area->id}}" @if($area->id == $area_id) selected @endif>{{$area->name}}</option>
                                @endforeach
                            </select>
                        </div>

						<div class="single-input">
							<input class="form-control" readonly type="text" name="address" value="{{ $getAddress }}">
						</div>
						<div class="single-input">
							<input class="form-control" type="password" name="password" placeholder="Password">
						</div>
						<div class="single-input">
							<input class="form-control" type="password" name="password_confirmation" placeholder="Password Confirmation">
						</div>
						<button type="submit" class="submit-btn">Register</button>
						<label for="" class="alter">Or</label>
						<div class="login-options">
							<div class="single-option">
								<a href="#">
									<span class="icon"><img src="{{asset('frontend/images/icons/facebook.png')}}" alt=""></span>
									<span>SignIn With Facebook</span>
								</a>
							</div>
							<div class="single-option">
								<a href="#">
									<span class="icon"><img src="{{asset('frontend/images/icons/google.png')}}" alt=""></span>
									<span>SignIn With Google</span>
								</a>
							</div>
						</div>
						<div class="signup-option">
							<label for="">Already have an account? <a href="{{ route('login') }}">Login</a></label>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	<!-- End Login Register Section -->
@endsection

@push('js')
    <script>
        $('#division_id').on('change', function(){
            var division_id = $(this).val();

            $('#district_id').html('<option value="">Select One</option>');
            $('#area_id').html('<option value="">Select One</option>');

            $.ajax({
                url: "{{ route('get-customer-district-by-division') }}",
                type:"POST",
                data:{
                    _token: '{{csrf_token()}}',
                    division_id: division_id,
                },
                success:function(data) {
                    $('#district_id').html(data);
                },
            });

        });

        $('#district_id').on('change', function(){
            var district_id = $(this).val();

            $('#area_id').html('<option value="">Select One</option>');

            $.ajax({
                url: "{{ route('get-customer-area-by-district') }}",
                type:"POST",
                data:{
                    _token: '{{csrf_token()}}',
                    district_id: district_id,
                },
                success:function(data) {
                    $('#area_id').html(data);
                },
            });

        });
    </script>
@endpush
