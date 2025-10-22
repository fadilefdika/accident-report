<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Carbon\Carbon; // Digunakan untuk perhitungan tanggal

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data tahun ini
        $startOfYear = Carbon::now()->startOfYear();
        $endOfYear = Carbon::now()->endOfYear();

        $reportsThisYear = Report::whereBetween('incident_date', [$startOfYear, $endOfYear])->get();

        // 2. Hitung KPI Kritis
        $totalReports = $reportsThisYear->count();
        $minorAccidents = $reportsThisYear->where('report_type', 'minor')->count();
        $seriousAccidents = $reportsThisYear->where('report_type', 'serious')->count();
        $nearMisses = $reportsThisYear->where('report_type', 'nearmiss')->count();

        // 3. Menghitung Days Since Last Incident (Asumsi incident_date sudah ada)
        $lastIncident = Report::latest('incident_date')->first();
        $daysSinceLastIncident = 0;
        if ($lastIncident) {
            $daysSinceLastIncident = Carbon::parse($lastIncident->incident_date)->diffInDays(Carbon::now());
        }

        // 4. Data untuk Chart (Contoh: Laporan per Bulan)
        $monthlyReports = Report::selectRaw('MONTH(incident_date) as month, report_type, count(*) as count')
            ->whereYear('incident_date', Carbon::now()->year)
            ->groupByRaw('MONTH(incident_date), report_type') // Menggunakan groupByRaw dan ekspresi fungsi penuh
            ->orderByRaw('MONTH(incident_date) asc')         // Menggunakan orderByRaw dan ekspresi fungsi penuh
            ->get();
            
        // Siapkan data untuk view
        $data = [
            'totalReports' => $totalReports,
            'minorAccidents' => $minorAccidents,
            'seriousAccidents' => $seriousAccidents,
            'nearMisses' => $nearMisses,
            'daysSinceLastIncident' => $daysSinceLastIncident,
            'monthlyReports' => $monthlyReports,
        ];

        return view('dashboard.index', compact('data'));
    }
}