@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-kanban text-primary"></i> Project Management
            </h3>
            <small class="text-secondary">Kelola semua proyek dalam sistem</small>
        </div>
    
        <a href="{{ route('admin.project.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle"></i> Tambah Project
        </a>
    </div>

    <!-- Alert -->
    @if (session('success'))
        <div class="alert alert-success small shadow-sm">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger small shadow-sm">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        </div>
    @endif
    

    <!-- Table -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-table"></i> Daftar Project
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0" id="projectTable">
                    <thead class="bg-light text-primary text-uppercase small">
                        <tr>
                            <th>No</th>
                            <th>Nama Proyek</th>
                            <th>Description</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="small">
                        @foreach ($projects as $project)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold text-dark">{{ $project->nama_proyek }}</td>
                            <td>{{ $project->pm->name ?? '-' }}</td>
                            <td class="text-danger fw-semibold">
                                {{ \Carbon\Carbon::parse($project->pm->start_date)->format('d M Y') }}
                            </td>
                            <td class="text-danger fw-semibold">
                                {{ \Carbon\Carbon::parse($project->pm->end_date)->format('d M Y') }}
                            <td>
                                @php
                                    $statusClass = match($project->status) {
                                        'On Progress' => 'warning',
                                        'Completed' => 'success',
                                        'Pending' => 'secondary',
                                        default => 'dark'
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">{{ $project->status }}</span>
                            </td>

                            <td class="text-center">

                                <a href="{{ route('admin.project.show', $project->id) }}" 
                                   class="btn btn-sm btn-info text-white me-1">
                                   <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('admin.project.edit', $project->id) }}" 
                                   class="btn btn-sm btn-warning text-white me-1">
                                   <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('admin.project.destroy', $project->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus project ini?')">
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


{{-- DataTable Script --}}
<script>
$(document).ready(function() {
    $('#projectTable').DataTable({
        "ordering": true,
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data",
            "zeroRecords": "Data proyek tidak ditemukan",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ proyek",
            "paginate": {
                "next": "›",
                "previous": "‹"
            }
        }
    });
});
</script>

@endsection
