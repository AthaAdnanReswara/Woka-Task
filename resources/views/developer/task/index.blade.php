@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-list-check text-primary"></i> My Tasks
            </h3>
            <small class="text-secondary">Kelola semua task yang ditugaskan kepadamu</small>
        </div>
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
            <i class="bi bi-table"></i> Daftar Task Saya
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0" id="taskTable">
                    <thead class="bg-light text-primary text-uppercase small">
                        <tr>
                            <th>No</th>
                            <th>Judul Task</th>
                            <th>Project</th>
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
                            <td class="fw-semibold text-danger">
                                {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : '-' }}
                            </td>

                            <!-- STATUS BADGE -->
                            <td>
                                @php
                                $statusColor = match($task->status) {
                                    'todo' => 'secondary',
                                    'in_progress' => 'warning',
                                    'review' => 'info',
                                    'done' => 'success',
                                    'cancelled' => 'danger',
                                    default => 'dark'
                                };
                                @endphp
                                <span class="badge bg-{{ $statusColor }}">
                                    {{ ucfirst(str_replace('_',' ', $task->status)) }}
                                </span>
                            </td>

                            <!-- ACTION BUTTON -->
                            <td class="text-center">
                                @if($task->status !== 'done')
                                <form action="{{ route('developer.task.update', $task->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="done">
                                    <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                        <i class="bi bi-check-circle"></i> Selesaikan
                                    </button>
                                </form>
                                @else
                                <span class="text-success fw-bold">Selesai</span>
                                @endif
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
