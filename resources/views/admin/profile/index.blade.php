@extends('layouts.backend.app')

@section('title')
    {{$title}}
@stop

@push('css')
    <style>
        .image-background-size {
            width: 100%;
            height: 400px;
        }
        .profile-image-size {
            width: 108px;
            height: 108px;
        }
        .profile-image-rider {
            height: 100px; width: 100px;
        }
    </style>
@endpush

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cover-profile">
                                <div class="profile-bg-img">
                                    <img class="profile-bg-img img-fluid image-background-size" src="@if(Auth::user()->cover_image) {{asset(Auth::user()->cover_image)}} @else {{asset('demomedia/demoprofile.png')}} @endif">
                                    <div class="card-block user-info">
                                        <div class="col-md-12">
                                            <div class="media-left">
                                                <a href="#" class="profile-image">
                                                    <img class="user-img img-radius profile-image-size" src="@if(Auth::user()->image) {{asset(Auth::user()->image)}} @else {{asset('demomedia/demoprofile.png')}} @endif">
                                                </a>
                                            </div>
                                            <div class="media-body row">
                                                <div class="col-lg-12">
                                                    <div class="user-title">
                                                        <h2>{{ Auth::user()->name }}</h2>
                                                        <span class="text-white">{{ Auth::user()->email }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--profile cover end-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tab-header card">
                                <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#PersonalInfo" role="tab">
                                            Personal Info
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#ProfileSetting" role="tab">
                                            Profile Setting
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#ChangePassword" role="tab">
                                            Change Password
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="PersonalInfo" role="tabpanel">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-header-text">About Me</h5>
                                        </div>
                                        <div class="card-block">
                                            <ul class="list-group">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Name
                                                    <span class="rounded-pill">{{ Auth::user()->name }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Email Address
                                                    <span class="rounded-pill">{{ Auth::user()->email }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Phone
                                                    <span class="rounded-pill">{{ Auth::user()->phone }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Address
                                                    <span class="rounded-pill">{{ Auth::user()->address }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="ProfileSetting" role="tabpanel">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-header-text">Profile Update</h5>
                                        </div>
                                        <div class="card-block">
                                            <form action="{{route('admin.profile.update', Auth::user()->id)}}" enctype="multipart/form-data" method="POST">
                                                @csrf
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="name" value="{{Auth::user()->name}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" class="form-control" name="email" value="{{Auth::user()->email}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Profile Image</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" onChange="mainTham(this)" name="image" class="custom-file-input">
                                                                <label class="custom-file-label">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label"></label>
                                                    <div class="col-sm-10">
                                                        <img class="profile-image-rider" src="@if(Auth::user()->image) {{asset(Auth::user()->image)}} @else {{asset('demomedia/demoprofile.png')}} @endif" id="showTham">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Cover Image</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" onChange="mainThamCoverImage(this)" name="cover_image" class="custom-file-input">
                                                                <label class="custom-file-label">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label"></label>
                                                    <div class="col-sm-10">
                                                        <img class="profile-image-rider" src="@if(Auth::user()->cover_image) {{asset(Auth::user()->cover_image)}} @else {{asset('demomedia/demoprofile.png')}} @endif" id="showThamCoverImage" style="">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Phone</label>
                                                    <div class="col-sm-10">
                                                        <input type="number" class="form-control" name="phone" placeholder="Phone Number" value="{{Auth::user()->phone}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Address</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" name="address" placeholder="Address">{!! Auth::user()->address !!}</textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit" class="btn btn-success">Update Profile</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="ChangePassword" role="tabpanel">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-header-text">Change Your Password</h5>
                                        </div>
                                        <div class="card-block">
                                            <form class="form-horizontal" action="{{ route('admin.password.update', Auth::user()->id) }}" method="post">
                                                @csrf
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Old Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" class="form-control" name="oldpassword" placeholder="Old Password">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">New Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" class="form-control" name="password" placeholder="New Password">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Confirm Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit" class="btn btn-info">Update Password</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function mainTham(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showTham').attr('src', e.target.result)
                }
                reader.readAsDataURL(input.files[0]);
            }
        };
        function mainThamCoverImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showThamCoverImage').attr('src', e.target.result)
                }
                reader.readAsDataURL(input.files[0]);
            }
        };
    </script>
@endpush