<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::all();
        return view('reports.index', compact('reports'));
    }
    public function store(Request $request)
    {
        $fileName = null;

        if ($request->hasFile('attachment')) {
            $fileName = time().'_'.$request->attachment->getClientOriginalName();
            $request->attachment->move(public_path('uploads'), $fileName);
        }

        Report::create([
            'report_type'   => $request->report_type,
            'location'      => $request->location,
            'incident_date' => $request->incident_date,
            'reported_by'   => $request->reported_by,
            'description'   => $request->description,
            'attachment'    => $fileName
        ]);

        return back()->with('success', 'Report saved!');
    }

    public function exportPDF($id)
    {
        $report = Report::findOrFail($id);
        $pdf = PDF::loadView('report.pdf', compact('report'));
        return $pdf->download('report-'.$id.'.pdf');
    }
}
