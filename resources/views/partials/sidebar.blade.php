<div class="bg-light border-end vh-100 position-fixed top-0 d-none d-lg-block" 
     style="width: 220px; z-index: 1030;" 
     id="sidebarWrapper">
    <div class="p-3">
        <h5>Menu</h5>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/reports') }}">Reports</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}">Logout</a>
            </li>
        </ul>
    </div>
</div>
