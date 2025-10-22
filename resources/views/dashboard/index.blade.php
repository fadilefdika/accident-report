@extends('layouts.app')

@section('title', 'HSE Dashboard')

@section('content')
<h3 class="mb-4">HSE Accident Summary (Tahun Ini)</h3>

{{-- 1. KPI Cards --}}
<div class="row mb-5">
    {{-- Card 1: Total Laporan --}}
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Laporan</h5>
                <p class="card-text fs-2">{{ $data['totalReports'] }}</p>
            </div>
        </div>
    </div>

    {{-- Card 2: Serious Accident --}}
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h5 class="card-title">Serious Accidents</h5>
                <p class="card-text fs-2">{{ $data['seriousAccidents'] }}</p>
            </div>
        </div>
    </div>

    {{-- Card 3: Minor Accident --}}
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Minor Accidents</h5>
                <p class="card-text fs-2">{{ $data['minorAccidents'] }}</p>
            </div>
        </div>
    </div>

    {{-- Card 4: Near Miss --}}
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Near Misses</h5>
                <p class="card-text fs-2">{{ $data['nearMisses'] }}</p>
            </div>
        </div>
    </div>
</div>

{{-- 2. Days Since Last Incident --}}
<div class="alert alert-success text-center mb-5">
    <h4 class="mb-0">Hari Sejak Insiden Terakhir: <strong class="fs-1">{{ $data['daysSinceLastIncident'] }}</strong> Hari</h4>
</div>

{{-- 3. Visualisasi Data (Chart) --}}
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Laporan Bulanan Berdasarkan Jenis</div>
            <div class="card-body">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
{{-- Include Chart.js (atau library chart lainnya) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Data dari Controller Laravel (dikonversi ke JSON)
    const monthlyData = @json($data['monthlyReports']);
    
    // Siapkan data untuk Chart.js
    const seriousData = Array(12).fill(0);
    const minorData = Array(12).fill(0);
    const nearMissData = Array(12).fill(0);

    monthlyData.forEach(item => {
        const monthIndex = item.month - 1; // Bulan 1 = index 0
        if (item.report_type === 'serious') {
            seriousData[monthIndex] = item.count;
        } else if (item.report_type === 'minor') {
            minorData[monthIndex] = item.count;
        } else if (item.report_type === 'nearmiss') {
            nearMissData[monthIndex] = item.count;
        }
    });

    const ctx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar', // Bisa diganti 'line' atau 'doughnut'
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Serious Accident',
                data: seriousData,
                backgroundColor: 'rgba(220, 53, 69, 0.7)', // Merah
                stack: 'Stack 0',
            }, {
                label: 'Minor Accident',
                data: minorData,
                backgroundColor: 'rgba(255, 193, 7, 0.7)', // Kuning
                stack: 'Stack 0',
            }, {
                label: 'Near Miss',
                data: nearMissData,
                backgroundColor: 'rgba(23, 162, 184, 0.7)', // Biru Muda
                stack: 'Stack 0',
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: { stacked: true },
                y: { stacked: true, beginAtZero: true }
            }
        }
    });
</script>
@endpush