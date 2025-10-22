<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;

Route::redirect('/', '/login', 301);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
// Route Khusus untuk DataTables (Mengambil Data via AJAX)
Route::get('reports/data', [ReportController::class, 'data'])->name('reports.data');
Route::get('reports/{id}/pdf', [ReportController::class, 'exportPDF'])->name('reports.pdf');
Route::get('reports/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
Route::post('reports/{id}/update', [ReportController::class, 'update'])->name('reports.update');
Route::delete('reports/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');
Route::get('reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('reports', [ReportController::class, 'store'])->name('reports.store');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');