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
            <li class="menu-title">Booking Manage</li>
            <li class="treeview">
                <a href="javascript:void(0)"><i class="icon_drive"></i> <span>Booking</span> <i class="fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('booking.create') }}">New Booking</a></li>
                    <li><a href="{{ route('booking.list') }}">Booking list</a></li>
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
