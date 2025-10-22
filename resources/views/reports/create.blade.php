@extends('layouts.app')

@section('title', 'Tambah Laporan Accident')

@section('content')
<style>
    /* ===== Custom Style untuk Tampilan Landscape ===== */
    .form-landscape {
        font-size: 10px !important;
    }

    .form-landscape label {
        font-weight: 600;
        font-size: 10px !important;
        color: #333;
    }

    .form-landscape input,
    .form-landscape select,
    .form-landscape textarea {
        font-size: 10px !important;
        padding: 4px 8px;
    }

    .form-landscape h5 {
        font-size: 13px !important;
        font-weight: 700;
        color: #0d6efd;
        border-bottom: 1px solid #ccc;
    }

    .form-landscape .card {
        border-radius: 10px;
    }

    .form-landscape .btn {
        font-size: 11px;
        padding: 6px 16px;
    }

    /* Buat tampilan landscape-like: 2 kolom besar */
    .form-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 992px) {
        .form-section {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container-fluid form-landscape">
    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold text-primary mb-0">📝 Buat Laporan Accident Baru</h4>
            </div>

            {{-- Pesan Error --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>⚠️ Terdapat kesalahan input:</strong>
                    <ul class="mb-0 mt-2 list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li><small>{{ $error }}</small></li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-section">
                    <div>
                        <h5 class="mb-3">1. Detail Insiden</h5>

                        {{-- Jenis Laporan --}}
                        <div class="mb-3">
                            <label for="report_type">Jenis Laporan <span class="text-danger">*</span></label>
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
                            <label for="location">Lokasi Kejadian <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" required placeholder="Contoh: Area Gudang B, Mesin Press 4">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Insiden --}}
                        <div class="mb-3">
                            <label for="incident_date">Tanggal Insiden <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('incident_date') is-invalid @enderror" id="incident_date" name="incident_date" value="{{ old('incident_date', date('Y-m-d')) }}" required>
                            @error('incident_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <h5 class="mb-3">2. Deskripsi & Pelapor</h5>

                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label for="description">Deskripsi Kejadian <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6" required placeholder="Jelaskan kronologi kejadian, siapa yang terluka, dan tindakan awal.">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Pelapor --}}
                        <div class="mb-3">
                            <label for="reported_by">Nama Pelapor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('reported_by') is-invalid @enderror" id="reported_by" name="reported_by" value="{{ old('reported_by', Auth::user()->name ?? '') }}" required placeholder="Nama Anda">
                            @error('reported_by')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5 class="mb-3 mt-4">3. Lampiran (Opsional)</h5>
                        <div class="mb-3">
                            <label for="attachment">Lampiran (Foto/Dokumen)</label>
                            <input class="form-control @error('attachment') is-invalid @enderror" type="file" id="attachment" name="attachment">
                            <div class="form-text text-muted">
                                <i class="bi bi-info-circle me-1"></i> Maks 2MB — Format: JPG, PNG, PDF.
                            </div>
                            @error('attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="mt-3 mb-3">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-cloud-arrow-up-fill me-1"></i> Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
