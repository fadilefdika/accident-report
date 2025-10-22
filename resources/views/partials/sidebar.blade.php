<div class="bg-white border-end vh-100 position-fixed top-0 d-none d-lg-block shadow-sm"
     style="width: 220px; z-index: 1030; transition: all 0.3s ease;"
     id="sidebarWrapper">

    <div class="p-3">
        <h6 class="fw-bold text-primary mb-3 text-uppercase" style="font-size: 12px;">Menu Utama</h6>
        <ul class="nav flex-column sidebar-menu">
            <li class="nav-item mb-1">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                   href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-1">
                <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" 
                   href="{{ route('reports.index') }}">
                    <i class="bi bi-clipboard-data me-2"></i> Reports
                </a>
            </li>
            <li class="nav-item mt-2 pt-2 border-top">
                <a class="nav-link text-danger" href="#">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</div>

<style>
    /* ===== Smooth Sidebar Styling ===== */
    .sidebar-menu .nav-link {
        color: #555;
        font-size: 12px;
        padding: 8px 12px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        transition: all 0.25s ease-in-out;
    }

    .sidebar-menu .nav-link i {
        font-size: 14px;
        opacity: 0.8;
        transition: all 0.25s ease;
    }

    .sidebar-menu .nav-link:hover {
        background-color: #f1f5ff;
        color: #0d6efd;
        transform: translateX(3px);
    }

    .sidebar-menu .nav-link:hover i {
        opacity: 1;
    }

    /* ===== Active Menu Style ===== */
    .sidebar-menu .nav-link.active {
        background-color: #e7f1ff;
        color: #0d6efd;
        font-weight: 600;
        position: relative;
    }

    .sidebar-menu .nav-link.active::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background-color: #0d6efd;
        border-radius: 0 3px 3px 0;
    }

    /* Responsiveness */
    @media (max-width: 992px) {
        #sidebarWrapper {
            display: none !important;
        }
    }
</style>
