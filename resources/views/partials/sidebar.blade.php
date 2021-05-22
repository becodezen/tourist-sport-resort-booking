<!-- sidebar menu -->
<div class="sidebar-menu-area">
    <!-- Sidebar Menu -->
    <nav>
        <h4 class="nav-title">Navigation</h4>
        <ul class="sidebar-menu" data-widget="tree">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="javascript:void(0)"><i class="fas fa-mountain"></i> <span>Tourist Spot</span> <i class="fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('tourist.spot.create') }}">Add new</a></li>
                    <li><a href="{{ route('tourist.spot.list') }}">Tourist spot list</a></li>
                </ul>
            </li>
            <li class="menu-title">Booking Manage</li>
            <li>
                <a href="{{ route('quick.booking.create') }}">
                    <i class="fas fa-book-open"></i>
                    <span>Quick Booking</span>
                </a>
            </li>
            <li>
                <a href="{{ route('quick.booking.create') }}">
                    <i class="fas fa-book"></i>
                    <span>Booking Request</span>
                </a>
            </li>
            <li class="treeview">
                <a href="javascript:void(0)"><i class="fas fa-list-ul"></i> <span>Booking</span> <i class="fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('booking.create') }}">New Booking</a></li>
                    <li><a href="{{ route('booking.list') }}">Booking list</a></li>
                </ul>
            </li>
            @if(Auth::user()->role()->name == 'super_admin')
            <li>
                <a href="{{ route('booking.calendar.resort') }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Booking Calendar</span>
                </a>
            </li>
            @else
                <li>
                    <a href="{{ route('booking.calendar') }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Booking Calendar</span>
                    </a>
                </li>
            @endif
            <li class="menu-title">Package Manage</li>
            <li>
                <a href="{{ route('package.booking.list') }}">
                    <i class="fas fa-book"></i>
                    <span>Package Booking</span>
                </a>
            </li>
            <li class="treeview">
                <a href="javascript:void(0)"><i class="fas fa-images"></i> <span>Packages</span> <i class="fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('package.create') }}">Add New Package</a></li>
                    <li><a href="{{ route('package.list') }}">Package List</a></li>
                </ul>
            </li>
            <li class="menu-title">Resort Manage</li>
            <li class="treeview">
                <a href="javascript:void(0)"><i class="fas fa-images"></i> <span>Resort</span> <i class="fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('resort.create') }}">Add Resort</a></li>
                    <li><a href="{{ route('resort.list') }}">Resort List</a></li>
                    <li><a href="{{ route('resort.facilities') }}">Resort Facilities</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="javascript:void(0)"><i class="fas fa-boxes"></i> <span>Room Manage</span> <i class="fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('room.list') }}">Room list</a></li>
                    <li><a href="{{ route('room.create') }}">Add Room</a></li>
                    <li><a href="{{ route('room.categories') }}">Room Category</a></li>
                    <li><a href="{{ route('room.facilities') }}">Room Facility</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="javascript:void(0)"><i class="fas fa-cloud"></i> <span>Seasonal Manage</span> <i class="fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('season.create') }}">Add new</a></li>
                    <li><a href="{{ route('season.list') }}">Seasonal List</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="javascript:void(0)"><i class="fas fa-cogs"></i> <span>Settings</span> <i class="fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('weekend.list') }}">Weekend Manage</a></li>
                    <li><a href="{{ route('holiday.list') }}">Holiday Manage</a></li>
                    <li><a href="{{ route('setting.booking.list') }}">Bookiing Settings</a></li>
                </ul>
            </li>
            <li class="menu-title">Frontend Manage</li>
            <li class="treeview">
                <a href="javascript:void(0)"><i class="fas fa-images"></i> <span>Sliders</span> <i class="fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('slider.create') }}">Add new Slider</a></li>
                    <li><a href="{{ route('slider.list') }}">All Sliders</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
