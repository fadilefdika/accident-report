@extends('layouts.app')

@section('title', 'Daftar Laporan')

@section('content')
<h3>Daftar Laporan Accident</h3>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Jenis Laporan</th>
            <th>Lokasi</th>
            <th>Tanggal</th>
            <th>Pelapor</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reports as $report)
        <tr>
            <td>{{ $report->id }}</td>
            <td>{{ ucfirst($report->report_type) }}</td>
            <td>{{ $report->location }}</td>
            <td>{{ $report->incident_date }}</td>
            <td>{{ $report->reported_by }}</td>
            <td>{{ Str::limit($report->description, 50) }}</td>
            <td>
                <a href="/reports/{{ $report->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                <a href="/reports/{{ $report->id }}/pdf" class="btn btn-sm btn-success">PDF</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
