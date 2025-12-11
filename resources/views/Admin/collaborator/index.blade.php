@extends('layout.app')
@section('title', 'collaborator')
@section('content')
<div class="container-fluid py-4">

    <!-- HEADER + BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4" 
         style="background: linear-gradient(90deg,#ff7eb9,#7ac1ff); 
                border-radius:12px; padding:20px; color:white;">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-people-fill"></i> Task Collaborators
            </h3>
            <small>Kelola user yang berkolaborasi dalam setiap task proyek</small>
        </div>
        <a href="{{ route('admin.collaborator.create') }}" 
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

    <!-- TABLE CARD -->
    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        <div class="card-header fw-bold" 
             style="background:#1e3c72; color:white; border-radius:8px 8px 0 0;">
            <i class="bi bi-people"></i> Daftar Task Collaborator
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-primary small text-uppercase">
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
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold text-dark">{{ $c->task->judul_task ?? '-' }}</td>
                            <td>{{ $c->user->name ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary">
                                    {{ $c->created_at->format('d M Y') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.collaborator.edit', $c->id) }}" 
                                   class="btn btn-sm btn-outline-warning me-1">
                                    <i class="bi bi-pencil-square"></i> Update
                                </a>
                                <form action="{{ route('admin.collaborator.destroy', $c->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Yakin hapus collaborator ini?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Tidak ada collaborator.
                            </td>
                        </tr>
                        @endforelse
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
