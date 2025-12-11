@extends('layout.app')
@section('title', 'project')
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
        <a href="{{ route('admin.project.create') }}" 
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
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-primary small text-uppercase">
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
                        <tr class="table-row-hover">
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold text-dark">{{ $project->name ?? '-'}}</td>
                            <td>{{ $project->description ?? '-' }}</td>
                            <td class="text-success fw-semibold">
                                {{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }}
                            </td>
                            <td class="text-danger fw-semibold">
                                {{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}
                            </td>
                            <td>
                                @php
                                $statusClass = match($project->status ?? '-') {
                                    'On Progress' => 'warning',
                                    'Completed' => 'success',
                                    'Pending' => 'secondary',
                                    default => 'dark'
                                };
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">{{ $project->status }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.project.edit', $project->id) }}"
                                    class="btn btn-sm btn-outline-warning me-1">
                                    <i class="bi bi-pencil-square"></i> Update
                                </a>

                                <form action="{{ route('admin.project.destroy', $project->id) }}" method="POST" class="d-inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Yakin ingin menghapus project ini?')">
                                        <i class="bi bi-trash"></i> Delete
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

<!-- HOVER + STYLING -->
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

@endsection
