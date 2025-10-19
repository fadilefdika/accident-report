<nav class="navbar navbar-expand navbar-dark bg-primary fixed-top">
    <div class="container-fluid">

        <!-- Hamburger toggler untuk mobile/tablet -->
        <button class="btn btn-primary d-lg-none me-2" id="sidebarToggle">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand" href="#">Accident Reporting</a>

        <!-- Memindahkan Dropdown keluar dari .collapse untuk memastikan selalu terlihat -->
        <ul class="navbar-nav ms-auto">
            @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser"
                       role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                        <li class="dropdown-item-text text-wrap">
                            <span class="d-block text-truncate fw-bold">{{ Auth::user()->name }}</span>
                            <small class="d-block text-truncate text-muted">{{ Auth::user()->email }}</small>
                        </li>
                        
                        <li><hr class="dropdown-divider"></li>
                        
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            @endauth
        </ul>

    </div>
</nav>