<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Accident Reporting')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        /* Sidebar responsive */
        @media (max-width: 992px) {
            .sidebar {
                position: fixed;
                left: -250px; /* sembunyikan */
                top: 0;
                height: 100%;
                width: 250px;
                background-color: #f8f9fa;
                transition: left 0.3s ease;
                z-index: 1045;
            }

            .sidebar.show {
                left: 0;
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
            }

            .overlay.show {
                display: block;
            }
        }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar" id="sidebar">
        @include('partials.sidebar')
    </div>

    <div class="flex-grow-1">
        @include('partials.navbar')

        <div class="p-4">
            <p>cek</p>
            @yield('content')
        </div>
    </div>
</div>

<div class="overlay" id="overlay"></div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    // Toggle sidebar di mobile
    $(document).ready(function() {
        $('.navbar-toggler').on('click', function() {
            $('#sidebar').toggleClass('show');
            $('#overlay').toggleClass('show');
        });

        $('#overlay').on('click', function() {
            $('#sidebar').removeClass('show');
            $(this).removeClass('show');
        });
        $('#sidebarToggle').on('click', function() {
            $('#sidebar').toggleClass('show');
            $('#overlay').toggleClass('show');
        });
    });
</script>


@stack('scripts')
</body>
</html>
