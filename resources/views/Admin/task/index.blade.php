@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-list-check text-primary"></i> Task Management
            </h3>
            <small class="text-secondary">Kelola semua task dalam sebuah proyek</small>
        </div>

        <a href="{{ route('admin.task.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle"></i> Tambah Task
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
            <i class="bi bi-table"></i> Daftar Task
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0" id="taskTable">
                    <thead class="bg-light text-primary text-uppercase small">
                        <tr>
                            <th>No</th>
                            <th>Nama Task</th>
                            <th>Project</th>
                            <th>Developer</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="small">
                        @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold text-dark">{{ $task->title }}</td>
                            <td>{{ $task->project->name ?? '-' }}</td>
                            <td>{{ $task->developer->name ?? '-' }}</td>

                            <td class="fw-semibold text-danger">
                                {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}
                            </td>

                            <td>
                                @php
                                $statusColor = match($task->status) {
                                    'todo' => 'secondary',
                                    'in-progress' => 'warning',
                                    'review' => 'info',
                                    'completed' => 'success',
                                    'cancelled' => 'danger',
                                    default => 'dark'
                                };
                                @endphp

                                <span class="badge bg-{{ $statusColor }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>

                            <td class="text-center">

                                <a href="{{ route('admin.task.show', $task->id) }}"
                                    class="btn btn-sm btn-outline-info rounded-pill px-3 me-1">
                                    <i class="bi bi-eye-fill"></i> Detail
                                </a>

                                <a href="{{ route('admin.task.edit', $task->id) }}"
                                    class="btn btn-sm btn-outline-warning rounded-pill px-3 me-1 text-dark">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </a>

                                <form action="{{ route('admin.task.destroy', $task->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                        onclick="return confirm('Hapus task ini?')">
                                        <i class="bi bi-trash-fill"></i> Hapus
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

{{-- DataTable --}}
<script>
    $(document).ready(function() {
        $('#taskTable').DataTable({
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "zeroRecords": "Data task tidak ditemukan",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ task",
                "paginate": {
                    "next": "›",
                    "previous": "‹"
                }
            }
        });
    });
</script>

@endsection
