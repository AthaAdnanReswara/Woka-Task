@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- HEADER + BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4" 
         style="background: linear-gradient(90deg,#ff7eb9,#7ac1ff);
                border-radius:12px; padding:20px; color:white;">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-kanban"></i> Project Management
            </h3>
            <small>Kelola semua proyek dalam sistem</small>
        </div>

        <a href="{{ route('PM.proyek.create') }}" 
           class="btn btn-light fw-semibold shadow-sm">
            <i class="bi bi-plus-circle"></i> Tambah Project
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
            <i class="bi bi-table"></i> Daftar Project
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0" id="projectTable">

                    <thead class="bg-light text-primary small text-uppercase">
                        <tr>
                            <th>No</th>
                            <th>Nama Proyek</th>
                            <th>Description</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Ditambahkan Oleh</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="small">
                        @forelse ($proyek as $project)
                        <tr class="table-row-hover">
                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-semibold text-dark">
                                {{ $project->name ?? '-' }}
                            </td>

                            <td>{{ $project->description ?? '-' }}</td>

                            <td class="text-success fw-semibold">
                                {{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }}
                            </td>

                            <td class="text-danger fw-semibold">
                                {{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}
                            </td>

                            <td>{{ $project->creator->name }}</td>

                            <td>
                                @php
                                    $statusClass = [
                                        'On Progress' => 'warning',
                                        'Completed'   => 'success',
                                        'Pending'     => 'secondary'
                                    ][$project->status] ?? 'dark';
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">
                                    {{ $project->status }}
                                </span>
                            </td>

                            <td class="text-center">
                                <a href="{{ route('PM.proyek.edit', $project->id) }}"
                                   class="btn btn-sm btn-outline-warning rounded-pill px-3 me-1">
                                    <i class="bi bi-pencil-fill me-1"></i> Edit
                                </a>

                                <form action="{{ route('PM.proyek.destroy', $project->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                        onclick="return confirm('Yakin ingin menghapus project ini?')">
                                        <i class="bi bi-trash-fill me-1"></i> Hapus
                                    </button>
                                </form>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Tidak ada Project.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>

<!-- HOVER EFFECT -->
<style>
.table-row-hover:hover {
    background: rgba(0,0,0,0.05);
    transform: scale(1.005);
    transition: 0.15s;
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

<!-- DATATABLE (Tanpa Search & Tanpa Length Menu) -->
<script>
$(document).ready(function() {
    $('#projectTable').DataTable({
        ordering: true,
        dom: 't<"d-flex justify-content-between mt-3"ip>', // Hapus search & length menu
        language: {
            zeroRecords: "Data proyek tidak ditemukan",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ proyek",
            paginate: {
                next: "›",
                previous: "‹"
            }
        }
    });
});
</script>

@endsection
