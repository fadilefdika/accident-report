<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables; // Tambahkan ini
use Illuminate\Support\Facades\Validator; // Tambahkan ini

class ReportController extends Controller
{
    // ===================================
    // R (Read) - Tampilan Index dengan Yajra DataTables
    // ===================================
    public function index()
    {
        // View index akan kosong, data akan diambil via AJAX oleh DataTables
        return view('reports.index');
    }

    // Method untuk menyajikan data ke Yajra DataTables
    public function data()
    {
        $reports = Report::select(['id', 'report_type', 'location', 'incident_date', 'reported_by', 'description']);

        return DataTables::of($reports)
            ->editColumn('description', function ($report) {
                // Batasi deskripsi di tampilan tabel
                return Str::limit($report->description, 50);
            })
            ->addColumn('action', function($report){
                // Tombol Aksi Lengkap: View, Edit, Delete
                $btn = '<a href="'.route('reports.show', $report->id).'" class="btn btn-sm btn-info me-1">View</a>';
                $btn .= '<a href="'.route('reports.edit', $report->id).'" class="btn btn-sm btn-warning me-1">Edit</a>';
                $btn .= '<a href="'.route('reports.pdf', $report->id).'" class="btn btn-sm btn-success me-1">PDF</a>';
                $btn .= '<button type="button" data-id="'.$report->id.'" class="btn btn-sm btn-danger delete-btn">Delete</button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // ===================================
    // C (Create) - Menampilkan Form
    // ===================================
    public function create()
    {
        return view('reports.create');
    }

    // ===================================
    // C (Create) - Menyimpan Data Baru
    // ===================================
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'report_type'   => 'required|string|max:50',
            'location'      => 'required|string|max:255',
            'incident_date' => 'required|date',
            'reported_by'   => 'required|string|max:100',
            'description'   => 'required|string',
            'attachment'    => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $fileName = null;
        if ($request->hasFile('attachment')) {
            $fileName = time().'_'.$request->attachment->getClientOriginalName();
            $request->attachment->move(public_path('uploads'), $fileName);
        }

        Report::create($request->except('attachment') + ['attachment' => $fileName]);

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil disimpan!');
    }
    
    // ===================================
    // R (Read) - Menampilkan Detail
    // ===================================
    public function show($id)
    {
        $report = Report::findOrFail($id);
        return view('reports.show', compact('report'));
    }

    // ===================================
    // U (Update) - Menampilkan Form Edit
    // ===================================
    public function edit($id)
    {
        $report = Report::findOrFail($id);
        return view('reports.edit', compact('report'));
    }

    // ===================================
    // U (Update) - Memperbarui Data
    // ===================================
    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'report_type'   => 'required|string|max:50',
            'location'      => 'required|string|max:255',
            'incident_date' => 'required|date',
            'reported_by'   => 'required|string|max:100',
            'description'   => 'required|string',
            'attachment'    => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $fileName = $report->attachment; // Ambil nama file lama

        if ($request->hasFile('attachment')) {
            // Hapus file lama jika ada
            if ($report->attachment && file_exists(public_path('uploads/' . $report->attachment))) {
                unlink(public_path('uploads/' . $report->attachment));
            }
            // Upload file baru
            $fileName = time().'_'.$request->attachment->getClientOriginalName();
            $request->attachment->move(public_path('uploads'), $fileName);
        }

        $report->update($request->except('attachment') + ['attachment' => $fileName]);

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil diperbarui!');
    }

    // ===================================
    // D (Delete) - Menghapus Data
    // ===================================
    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        
        // Hapus file lampiran (attachment) jika ada
        if ($report->attachment && file_exists(public_path('uploads/' . $report->attachment))) {
            unlink(public_path('uploads/' . $report->attachment));
        }
        
        $report->delete();

        // Menggunakan respons JSON karena ini dipanggil via AJAX dari DataTables
        return response()->json(['success' => true, 'message' => 'Laporan berhasil dihapus!']);
    }

    // ===================================
    // Fitur Tambahan: Export PDF
    // ===================================
    public function exportPDF($id)
    {
        $report = Report::findOrFail($id);
        // Pastikan Anda telah membuat view di resources/views/reports/pdf.blade.php
        $pdf = PDF::loadView('reports.pdf', compact('report')); 
        return $pdf->download('report-'.$id.'.pdf');
    }
}