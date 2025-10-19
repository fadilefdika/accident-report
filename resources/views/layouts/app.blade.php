<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Accident Reporting')</title>
    {{-- ✅ BIARKAN VITE MENGURUS BOOTSTRAP CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body>

<div class="d-flex">
    @include('partials.sidebar')
    
    <div class="flex-grow-1">
        @include('partials.navbar')
        <div class="p-4">
            <p>cek</p>
            @yield('content')
        </div>
    </div>
</div>

{{-- JQuery dan DataTables dimuat terakhir --}}
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

{{-- ❌ Hapus baris ini: Bootstrap JS (seharusnya sudah diurus oleh @vite) --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}

@stack('scripts')
</body>
</html>