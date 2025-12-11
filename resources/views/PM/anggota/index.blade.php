@extends('layout.app')
@section('title', 'anggota project')
@section('content')
<div class="container-fluid py-4">

    <!-- HEADER + BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4" 
         style="background: linear-gradient(90deg,#ff7eb9,#7ac1ff); 
                border-radius:12px; padding:20px; color:white;">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-people-fill"></i> Project Members
            </h3>
            <small>Kelola anggota dari setiap project</small>
        </div>

        <a href="{{ route('PM.anggota.create') }}" 
           class="btn btn-light fw-semibold shadow-sm">
            <i class="bi bi-person-plus-fill"></i> Tambah Member
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

    <!-- TABLE CARD -->
    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        <div class="card-header fw-bold" 
             style="background:#1e3c72; color:white; border-radius:8px 8px 0 0;">
            <i class="bi bi-table"></i> Daftar Project Members
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="memberTable">

                    <!-- HEADER TABEL -->
                    <thead class="text-white small text-uppercase" 
                           style="background: linear-gradient(135deg,#1e3c72,#7ac1ff);">
                        <tr>
                            <th>No</th>
                            <th>Project</th>
                            <th>Nama Member</th>
                            <th>Email</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="small">
                        @forelse($members as $m)
                        <tr class="table-row-hover">
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold text-dark">{{ $m->project->name }}</td>
                            <td>{{ $m->user->name }}</td>
                            <td>{{ $m->user->email }}</td>

                            <td class="text-center">
                                <a href="{{ route('PM.anggota.edit',$m->id) }}"
                                   class="btn btn-sm btn-outline-warning me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>

                                <form action="{{ route('PM.anggota.destroy',$m->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Hapus member ini?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3 fw-semibold">
                                Belum ada anggota terdaftar
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<!-- STYLE -->
<style>
.table-row-hover:hover {
    background: rgba(0,0,0,0.04);
    transform: scale(1.005);
    transition: .15s;
    cursor: pointer;
}
.btn-outline-warning:hover {
    background-color: #ffc107;
    color: white;
}
.btn-outline-danger:hover {
    background-color: #dc3545;
    color: white;
}
</style>

<!-- DATATABLE -->
<script>
$(document).ready(function() {
    $('#memberTable').DataTable({
        ordering: true,
        paging: false,          // hilangkan pagination
        searching: false,       // hilangkan search bar
        info: false,            // hilangkan info jumlah data
        lengthChange: false,    // hilangkan "Tampilkan _MENU_"
        language: {
            zeroRecords: "Tidak ada data member ditemukan"
        }
    });
});
</script>

@endsection
