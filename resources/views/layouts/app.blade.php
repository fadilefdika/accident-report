<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- Tambahkan CSRF jika belum ada --}}

    <title>@yield('title', 'Accident Reporting')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        /* 💥 Kunci: Memberi ruang di bawah Navbar Fixed (Asumsi tinggi navbar 56px) */
        
        /* 1. CSS untuk Sidebar Fixed di Desktop (>= lg) */
        @media (min-width: 992px) {
            .sidebar-wrapper { 
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: 250px;
                z-index: 1030;
                /* PENTING: Mendorong konten di dalam sidebar ke bawah navbar */
                padding-top: 56px; 
            }

            /* Mendorong Konten Utama ke Kanan di Desktop */
            .content-wrapper {
                margin-left: 250px; /* Sesuai dengan lebar sidebar 250px */
                padding-top: 56px; /* PENTING: Mendorong seluruh konten ke bawah navbar */
            }
        }

        /* 2. CSS untuk Sidebar Mobile (< lg) */
        @media (max-width: 991.98px) {
            .sidebar-wrapper {
                position: fixed;
                left: -250px; /* Sembunyikan */
                top: 0;
                height: 100vh;
                width: 250px;
                background-color: #f8f9fa;
                transition: left 0.3s ease;
                z-index: 1045;
                box-shadow: 2px 0 5px rgba(0,0,0,0.1); 
            }

            .sidebar-wrapper.show {
                left: 0; /* Tampilkan */
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
            
            /* PENTING: Walaupun sidebar disembunyikan, konten utama di mobile tetap perlu padding atas */
            .content-wrapper {
                padding-top: 56px;
            }
        }
    </style>
</head>
<body>

{{-- 1. NAVBAR (Pastikan di partials/navbar.blade.php sudah ada kelas fixed-top) --}}
@include('partials.navbar')

{{-- 2. SIDEBAR --}}
<div class="sidebar-wrapper" id="sidebar">
    {{-- Konten sidebar harus diatur agar tidak memiliki padding-top ganda --}}
    @include('partials.sidebar') 
</div>

{{-- 3. MAIN CONTENT --}}
<div class="content-wrapper">
    <div class="p-4">
        @yield('content')
    </div>
</div>

{{-- 4. OVERLAY (untuk mode mobile) --}}
<div class="overlay" id="overlay"></div>

{{-- SCRIPTS --}}
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    // Logika Toggle sidebar di mobile
    $(document).ready(function() {
        // ... (Logika JS Anda yang sudah benar) ...
        const sidebarToggleTriggers = $('.navbar-toggler, #sidebarToggle');
        
        sidebarToggleTriggers.on('click', function() {
            $('#sidebar').toggleClass('show');
            $('#overlay').toggleClass('show');
        });

        $('#overlay').on('click', function() {
            $('#sidebar').removeClass('show');
            $(this).removeClass('show');
        });
    });
</script>

@stack('scripts')
</body>
</html>