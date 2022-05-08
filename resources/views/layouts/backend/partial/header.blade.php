<div class="navbar-wrapper">
    <div class="navbar-logo">
        <a class="mobile-menu" id="mobile-collapse" href="javascript:;">
            <i class="feather icon-menu"></i>
        </a>
        <a href="{{ route('admin.dashboard') }}">
            <img class="img-fluid" src="{{ asset('demomedia/projanmoit.png') }}" alt="Theme-Logo" />
        </a>
        <a class="mobile-options">
            <i class="feather icon-more-horizontal"></i>
        </a>
    </div>
    <div class="navbar-container">
        <ul class="nav-left">
            <li>
                <a href="javascript:;" onclick="javascript:toggleFullScreen()">
                    <i class="feather icon-maximize full-screen"></i>
                </a>
            </li>
        </ul>
        <ul class="nav-right">
            <li class="user-profile header-notification">
                <div class="dropdown-primary dropdown">
                    <div class="dropdown-toggle" data-toggle="dropdown">
                        <img src="@if(Auth::user()->image) {{asset(Auth::user()->image)}} @else {{asset('demomedia/demoprofile.png')}} @endif" class="img-radius"
                            alt="User-Profile-Image">
                        <span>{{ Auth::user()->name }}</span>
                        <i class="feather icon-chevron-down"></i>
                    </div>
                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                        <li>
                            <a href="{{ route('admin.profile') }}">
                                <i class="feather icon-user"></i>
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="feather icon-log-out"></i>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="" style="padding-left: 0px;">
                <a href="{{ route('home') }}" target="_blank">
                    <i class="feather icon-globe"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
