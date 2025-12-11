@extends('layout.app')
@section('title', 'collaborator task')
@section('content')
<div class="container-fluid py-4">

    <!-- HEADER + BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4"
         style="background: linear-gradient(90deg,#7ac1ff,#ff7eb9);
                border-radius:12px; padding:20px; color:white;">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-people-fill"></i> Task Collaborators
            </h3>
            <small>Kelola user yang berkolaborasi dalam setiap task</small>
        </div>

        <a href="{{ route('PM.kelompok.create') }}"
           class="btn btn-light fw-semibold shadow-sm">
            <i class="bi bi-plus-circle"></i> Tambah Collaborator
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
            <i class="bi bi-people me-2"></i> Daftar Task Collaborator
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0" id="collaboratorTable">
                    <thead class="bg-light text-primary text-uppercase small">
                        <tr>
                            <th>No</th>
                            <th>Task</th>
                            <th>Collaborator</th>
                            <th class="text-center">Ditambahkan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="small">
                        @forelse ($collabs as $c)
                        <tr class="table-row-hover">
                            <td class="fw-semibold">{{ $loop->iteration }}</td>

                            <td class="fw-semibold text-dark">
                                <i class="bi bi-list-task text-primary"></i>
                                {{ $c->task->judul_task ?? '-' }}
                            </td>

                            <td>
                                <i class="bi bi-person-circle text-secondary"></i>
                                {{ $c->user->name ?? '-' }}
                            </td>

                            <td class="text-center">
                                <span class="badge bg-secondary">
                                    {{ $c->created_at->format('d M Y') }}
                                </span>
                            </td>

                            <td class="text-center">
                                <a href="{{ route('PM.kelompok.edit', $c->id) }}" 
                                   class="btn btn-sm btn-warning shadow-sm me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('PM.kelompok.destroy', $c->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf 
                                    @method('DELETE')

                                    <button onclick="return confirm('Hapus collaborator ini?')" 
                                            class="btn btn-sm btn-danger shadow-sm">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-info-circle"></i> Belum ada data collaborator.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<!-- CUSTOM STYLE -->
<style>
.table-row-hover:hover {
    background: rgba(0,0,0,0.04);
    transform: scale(1.005);
    transition: .15s;
    cursor: pointer;
}
</style>

<!-- DATATABLE TANPA PENCARIAN & LENGTH -->
<script>
$(document).ready(function() {
    $('#collaboratorTable').DataTable({
        pageLength: 10,
        ordering: true,
        dom: 't<"d-flex justify-content-between mt-3"ip>',
        language: {
            zeroRecords: "Tidak ditemukan data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: {
                next: "›",
                previous: "‹"
            }
        }
    });
});
</script>

@endsection
