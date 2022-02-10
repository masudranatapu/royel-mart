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
            <li class="header-notification">
                <div class="dropdown-primary dropdown">
                    <div class="dropdown-toggle" data-toggle="dropdown">
                        <i class="feather icon-bell"></i>
                        <span class="badge bg-c-pink">5</span>
                    </div>
                    <ul class="show-notification notification-view dropdown-menu"
                        data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                        <li>
                            <h6>Notifications</h6>
                            <label class="label label-danger">New</label>
                        </li>
                        <li>
                            <div class="media">
                                <img class="d-flex align-self-center img-radius"
                                    src="../files/assets/images/avatar-4.jpg"
                                    alt="Generic placeholder image">
                                <div class="media-body">
                                    <h5 class="notification-user">{{ Auth::user()->name }}</h5>
                                    <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer
                                        elit.</p>
                                    <span class="notification-time">30 minutes ago</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="media">
                                <img class="d-flex align-self-center img-radius"
                                    src="../files/assets/images/avatar-3.jpg"
                                    alt="Generic placeholder image">
                                <div class="media-body">
                                    <h5 class="notification-user">Joseph William</h5>
                                    <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer
                                        elit.</p>
                                    <span class="notification-time">30 minutes ago</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="media">
                                <img class="d-flex align-self-center img-radius"
                                    src="../files/assets/images/avatar-4.jpg"
                                    alt="Generic placeholder image">
                                <div class="media-body">
                                    <h5 class="notification-user">Sara Soudein</h5>
                                    <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer
                                        elit.</p>
                                    <span class="notification-time">30 minutes ago</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="user-profile header-notification">
                <div class="dropdown-primary dropdown">
                    <div class="dropdown-toggle" data-toggle="dropdown">
                        <img src="../files/assets/images/avatar-4.jpg" class="img-radius"
                            alt="User-Profile-Image">
                        <span>{{ Auth::user()->name }}</span>
                        <i class="feather icon-chevron-down"></i>
                    </div>
                    <ul class="show-notification profile-notification dropdown-menu"
                        data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                        <li>
                            <a href="#!">
                                <i class="feather icon-settings"></i> Settings
                            </a>
                        </li>
                        <li>
                            <a href="user-profile.html">
                                <i class="feather icon-user"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a href="email-inbox.html">
                                <i class="feather icon-mail"></i> My Messages
                            </a>
                        </li>
                        <li>
                            <a href="auth-lock-screen.html">
                                <i class="feather icon-lock"></i> Lock Screen
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="feather icon-log-out"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>