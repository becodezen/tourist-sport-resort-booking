<!-- Header Section -->
<div class="header-top-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-6 hidden-sm">
                <div class="header-top-items">
                    <div class="header-top-item">
                        <span>
                            <i class="fas fa-map-marker-alt"></i>
                            Address will be here...
                        </span>
                    </div>
                    <div class="header-top-item">
                        <span>
                            <i class="fas fa-phone-alt"></i>
                            +88 01798 673 163
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="header-top-items">
                    <div class="header-top-menus">
                        <ul>
                            <li>
                                <a href="{{ route('fr.uc') }}">
                                    <i class="fas fa-lock"></i>
                                    <span>How to Booking?</span>
                                </a>
                            </li>
                            @if(!Auth::guard('customer')->check())
                            <li>
                                <a href="{{ route('fr.login') }}">
                                    <i class="fas fa-lock"></i>
                                    <span>Login</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('fr.register') }}">
                                    <i class="fas fa-plus"></i>
                                    <span>Create Account</span>
                                </a>
                            </li>
                            @else
                            <li>
                                <a href="{{ route('fr.dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i>
                                    <span>My Dashboard</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<header class="header-area" id="stickyHeader">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="header-logo">
                    <div class="logo">
                        <h1>
                            <a href="{{ route('fr.home') }}">Vromon Bilash</a>
                        </h1>
                    </div>
                    <div class="responsive-menu-bar">
                        <i class="fas fa-bars"></i>
                    </div>
                    <div class="responsive-menu">
                        <h3>Vromon Bilash</h3>
                        <ul>
                            <li><a href="{{ route('fr.home') }}">Home</a></li>
                            <li><a href="{{ route('fr.uc') }}">About Us</a></li>
                            <li><a href="{{ route('fr.resorts') }}">Reosrts</a></li>
                            <li><a href="{{ route('fr.tourist.spots') }}">Tourist Spots</a></li>
                            <li><a href="{{ route('fr.package.list') }}">Packages</a></li>
                            <li><a href="{{ route('fr.tourist.spots') }}">Contact Us</a></li>
                            <li><a href="{{ route('fr.uc') }}">How to booking?</a></li>
                            <hr>
                            @if(Auth::guard('customer')->check())
                                <li>
                                    <a href="{{ route('fr.dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i>
                                        <span>Dashboard</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('fr.recent.booking.history') }}">
                                        <i class="fas fa-history"></i>
                                        <span>Recent Booking History</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('fr.booking.history') }}">
                                        <i class="fas fa-columns"></i>
                                        <span>Booking History</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('fr.package.booking.history') }}">
                                        <i class="fas fa-columns"></i>
                                        <span>Package Booking History</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('fr.update.profile') }}">
                                        <i class="fas fa-user"></i>
                                        <span>Update Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('fr.change.password') }}">
                                        <i class="fas fa-lock"></i>
                                        <span>Change Password</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('fr.customer.logout') }}">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Logout</span>
                                    </a>
                                </li>
                                @else
                                <li><a href="{{ route('fr.login') }}">Login</a></li>
                                <li><a href="{{ route('fr.register') }}">Registration</a></li>
                            @endif
                        </ul>
                        <div id="close_menu">
                            <i class="fas fa-times"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-9">
                <div class="mainmenu">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarText"
                            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarText">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('fr.home') }}">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('fr.uc') }}">About Us</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('fr.resorts') }}">Resorts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('fr.tourist.spots') }}">Tourist Spots</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('fr.package.list') }}">Packages</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('fr.uc') }}">Contact Us</a>
                                </li>
                                {{-- @if(Auth::guard('customer')->check())
                                    <li class="nav-item has-children">
                                        <a class="nav-link" href="#">{{ Auth::guard('customer')->user()->name }}</a>
                                        <ul class="children user-children">
                                            <li><a href="{{ route('fr.dashboard') }}">My Dashboard</a></li>
                                            <li><a href="{{ route('fr.customer.logout') }}">Logout</a></li>
                                        </ul>
                                    </li>
                                @endif --}}
                            </ul>
                            {{-- @if(!Auth::guard('customer')->check())
                                <span class="user-account">
                                    <a href="{{ route('fr.login') }}" class="btn btn-primary">Login/Register</a>
                                </span>
                            @endif --}}
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
