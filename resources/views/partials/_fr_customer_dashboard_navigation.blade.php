<div class="dashboard-sidebar" id="dashboardSidebar">
    <ul class="sidebar-nav">
        <li class="treeview">
            <a href="{{ route('fr.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="treeview">
            <a href="{{ route('fr.recent.booking.history') }}">
                <i class="fas fa-history"></i>
                <span>Recent Booking History</span>
            </a>
        </li>
        <li class="treeview">
            <a href="{{ route('fr.booking.history') }}">
                <i class="fas fa-columns"></i>
                <span>Booking History</span>
            </a>
        </li>
        <li class="treeview">
            <a href="{{ route('fr.package.booking.history') }}">
                <i class="fas fa-columns"></i>
                <span>Package Booking History</span>
            </a>
        </li>
        <li class="treeview">
            <a href="{{ route('fr.update.profile') }}">
                <i class="fas fa-user"></i>
                <span>Update Profile</span>
            </a>
        </li>
        <li class="treeview">
            <a href="{{ route('fr.change.password') }}">
                <i class="fas fa-lock"></i>
                <span>Change Password</span>
            </a>
        </li>
        <li class="treeview">
            <a href="{{ route('fr.customer.logout') }}">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</div>
