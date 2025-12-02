@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-people-fill text-primary"></i> Task Collaborators
            </h3>
            <small class="text-secondary">Kelola user yang berkolaborasi dalam setiap task proyek</small>
        </div>

        <a href="{{ route('PM.kelompok.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle"></i> Tambah Collaborator
        </a>
    </div>

    <!-- Notifikasi -->
    @if (session('success'))
        <div class="alert alert-success small shadow-sm">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger small shadow-sm">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Card Table -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-people"></i> Daftar Task Collaborator
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
                            <td class="text-dark fw-semibold">{{ $c->task->judul_task ?? '-' }}</td>
                            <td>{{ $c->user->name ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary">
                                    {{ $c->created_at->format('d M Y') }}
                                </span>
                            </td>

                            <td class="text-center">
                                <a href="{{ route('PM.kelompok.edit', $c->id) }}" 
                                   class="btn btn-sm btn-outline-warning me-1">
                                   <i class="bi bi-pencil-square"></i> Edit
                                </a>

                                <form action="{{ route('PM.kelompok.destroy', $c->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf 
                                    @method('DELETE')

                                    <button onclick="return confirm('Hapus collaborator ini?')" 
                                            class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-3 text-muted">
                                Belum ada data collaborator.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<!-- Hover & Scale Animasi -->
<style>
.table-row-hover:hover {
    background: rgba(0, 0, 0, 0.05) !important;
    transform: scale(1.005);
    transition: .15s;
    cursor: pointer;
}
</style>

<!-- Javascript DataTable -->
<script>
$(document).ready(function() {
    $('#collaboratorTable').DataTable({
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data",
            "zeroRecords": "Tidak ditemukan data",
            "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            "paginate": {
                "next": "›",
                "previous": "‹"
            }
        }
    });
});
</script>

@endsection
