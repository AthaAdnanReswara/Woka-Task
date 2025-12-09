@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- HEADER + BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4"
         style="background: linear-gradient(90deg,#7ac1ff,#ff7eb9);
                border-radius:12px; padding:20px; color:white;">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-person-badge-fill"></i> Developer
            </h3>
            <small>Kelola akun Developer pada sistem proyek</small>
        </div>

        <a href="{{ route('PM.pengembang.create') }}"
           class="btn btn-light fw-semibold shadow-sm">
            <i class="bi bi-person-plus me-1"></i> Tambah Developer
        </a>
    </div>

    <!-- ALERT -->
    @if (session('success'))
        <div class="alert alert-success small shadow-sm">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger small shadow-sm">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        </div>
    @endif

    <!-- CARD TABLE -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        
        <div class="card-header fw-bold d-flex align-items-center"
             style="background:#1e3c72; color:white;">
            <i class="bi bi-people me-2"></i> Daftar Developer
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0" id="pembimbing">
                    <thead class="bg-light text-primary text-uppercase small">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Ditambahkan Oleh</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="small">
                        @foreach ($pengembang as $data)
                        <tr class="table-row-hover">
                            <td class="fw-semibold">{{ $loop->iteration }}</td>

                            <td class="fw-semibold text-dark">
                                <i class="bi bi-person-circle text-primary me-1"></i>
                                {{ $data->name }}
                            </td>

                            <td>{{ $data->email }}</td>

                            <td>
                                <i class="bi bi-person-badge text-secondary me-1"></i>
                                {{ $data->creator->name ?? '-' }}
                            </td>

                            <td class="text-center">
                                <span class="badge bg-secondary">
                                    {{ $data->created_at->format('d M Y') }}
                                </span>
                            </td>

                            <td class="text-center">

                                <a href="{{ route('PM.pengembang.edit', $data->id) }}" 
                                   class="btn btn-sm btn-warning shadow-sm me-1">
                                   <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('PM.pengembang.destroy', $data->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf 
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('Yakin hapus developer ini?')"
                                        class="btn btn-sm btn-danger shadow-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>

<!-- HOVER ANIMATION -->
<style>
.table-row-hover:hover {
    background: rgba(0,0,0,0.05);
    transform: scale(1.005);
    transition: .15s;
    cursor: pointer;
}
</style>

<!-- DATATABLE -->
<script>
$(document).ready(function() {
    $('#pembimbing').DataTable({
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data",
            "zeroRecords": "Data tidak ditemukan",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "paginate": { "next": "›", "previous": "‹" }
        }
    });
});
</script>

@endsection
