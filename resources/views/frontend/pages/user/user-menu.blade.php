<ul class="navbar-nav ac-navbar">
    <li class="nav-item">
        <a href="{{ route('user.dashboard') }}" class="nav-link">
            <span class="material-icons arrow-icons">arrow_back</span> Back to Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('user.orders') }}" class="nav-link {{ request()->routeIs('user.orders') ? 'activeTab' : '' }} ">
            <span class="material-icons">chrome_reader_mode</span>Orders
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('user.edit.profile') }}" class="nav-link {{ request()->routeIs('user.edit.profile') ? 'activeTab' : '' }} ">
            <span class="material-icons">person</span>Edit
            Account
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('user.edit.password') }}" class="nav-link {{ request()->routeIs('user.edit.password') ? 'activeTab' : '' }} ">
            <span class="material-icons">lock</span>Password
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('user.wishlist') }}" class="nav-link {{ request()->routeIs('user.wishlist') ? 'activeTab' : '' }}">
            <span class="material-icons">favorite_border</span>
        Saved List</a>
    </li>

</ul>
