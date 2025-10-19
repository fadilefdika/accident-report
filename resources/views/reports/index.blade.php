@extends('layouts.app')

@section('title', 'Daftar Laporan')

@section('content')

<h3>Daftar Laporan Accident</h3>

<div class="mb-3">
    <a href="{{ route('reports.create') }}" class="btn btn-primary">Tambah Laporan</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Bungkus table dengan div responsive --}}
<div class="table-responsive">
    <table class="table table-striped table-bordered data-table w-100">
        <thead>
            <tr>
                <th>ID</th>
                <th>Jenis Laporan</th>
                <th>Lokasi</th>
                <th>Tanggal Insiden</th>
                <th>Pelapor</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- DataTables akan load ajax --}}
        </tbody>
    </table>
</div>

{{-- Modal Konfirmasi Delete --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus laporan ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
$(function () {
    // Inisialisasi DataTables dengan responsive extension
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true, // 🔹 membuat tabel responsive
        autoWidth: false, // hindari overflow kolom
        ajax: "{{ route('reports.data') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'report_type', name: 'report_type'},
            {data: 'location', name: 'location'},
            {data: 'incident_date', name: 'incident_date'},
            {data: 'reported_by', name: 'reported_by'},
            {data: 'description', name: 'description'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
            { targets: -1, className: 'text-center' } // kolom aksi rata tengah
        ],
        language: {
            emptyTable: "Belum ada laporan.",
            search: "Cari:",
            paginate: {
                previous: "Sebelumnya",
                next: "Berikutnya"
            }
        }
    });

    // ===============================
    // Logika Delete (AJAX)
    // ===============================
    var deleteId;

    $('body').on('click', '.delete-btn', function () {
        deleteId = $(this).data('id');
        $('#deleteModal').modal('show');
    });

    $('#confirmDelete').click(function (e) {
        e.preventDefault();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content'); 
        
        $.ajax({
            type: "POST",
            url: "{{ route('reports.destroy', ['id' => ':id']) }}".replace(':id', deleteId),
            data: {
                '_token': CSRF_TOKEN,
                '_method': 'DELETE',
            },
            success: function (data) {
                $('#deleteModal').modal('hide');
                table.draw(); 
                alert(data.message);
            },
            error: function (data) {
                console.log('Error:', data);
                alert('Gagal menghapus laporan.');
            }
        });
    });

});
</script>
@endpush
