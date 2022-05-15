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
				<h2 class="title">New Password</h2>
			</div>
			<div class="verification-body">
				<form method="POST" action="{{ route('password-recovery-done') }}">
                    @csrf
					<input class="form-control" placeholder="Enter new password" type="password" name="password" required>
					<button class="verify-btn">Submit</button>
				</form>
			</div>
		</div>
	</section>

@endsection

@push('js')

@endpush
