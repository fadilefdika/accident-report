@extends('layouts.app')

@section('title', 'Tambah Laporan Accident')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <h3 class="mb-4">Buat Laporan Accident Baru</h3>

        {{-- Menampilkan pesan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form untuk Membuat Laporan Baru --}}
        {{-- WAJIB: enctype="multipart/form-data" untuk upload file --}}
        <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Jenis Laporan --}}
            <div class="mb-3">
                <label for="report_type" class="form-label">Jenis Laporan</label>
                <select class="form-select @error('report_type') is-invalid @enderror" id="report_type" name="report_type" required>
                    <option value="">-- Pilih Jenis Laporan --</option>
                    <option value="minor" {{ old('report_type') == 'minor' ? 'selected' : '' }}>Minor Accident</option>
                    <option value="serious" {{ old('report_type') == 'serious' ? 'selected' : '' }}>Serious Accident</option>
                    <option value="nearmiss" {{ old('report_type') == 'nearmiss' ? 'selected' : '' }}>Near Miss</option>
                </select>
                @error('report_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Lokasi --}}
            <div class="mb-3">
                <label for="location" class="form-label">Lokasi Kejadian</label>
                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" required>
                @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tanggal Insiden --}}
            <div class="mb-3">
                <label for="incident_date" class="form-label">Tanggal Insiden</label>
                <input type="date" class="form-control @error('incident_date') is-invalid @enderror" id="incident_date" name="incident_date" value="{{ old('incident_date', date('Y-m-d')) }}" required>
                @error('incident_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Pelapor --}}
            <div class="mb-3">
                <label for="reported_by" class="form-label">Nama Pelapor</label>
                {{-- Mengisi otomatis dengan nama user yang sedang login (opsional) --}}
                <input type="text" class="form-control @error('reported_by') is-invalid @enderror" id="reported_by" name="reported_by" value="{{ old('reported_by', Auth::user()->name ?? '') }}" required>
                @error('reported_by')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi Lengkap Kejadian</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Lampiran (Attachment) --}}
            <div class="mb-4">
                <label for="attachment" class="form-label">Lampiran (Foto/Dokumen)</label>
                <input class="form-control @error('attachment') is-invalid @enderror" type="file" id="attachment" name="attachment">
                <small class="form-text text-muted">Max 2MB. Format: JPG, PNG, PDF.</small>
                @error('attachment')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary me-2">Simpan Laporan</button>
            <a href="{{ route('reports.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection