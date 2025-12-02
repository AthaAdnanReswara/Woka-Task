@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <h3 class="fw-bold text-dark mb-3">
        <i class="bi bi-folder2-open text-primary"></i>
        {{ $project->name }}
    </h3>

    <p class="text-muted">{{ $project->description }}</p>

    <hr>

    <h5 class="fw-bold text-dark mt-4 mb-3">
        <i class="bi bi-list-task text-success"></i> Task pada Project Ini
    </h5>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Task</th>
                        <th>Status</th>
                        <th>Deadline</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($project->tasks as $task)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $task->title }}</td>

                        <td>
                            @php
                                $color = [
                                    'todo' => 'secondary',
                                    'in_progress' => 'warning',
                                    'review' => 'info',
                                    'done' => 'success'
                                ][$task->status] ?? 'dark';
                            @endphp
                            <span class="badge bg-{{ $color }}">
                                {{ ucfirst(str_replace('_',' ', $task->status)) }}
                            </span>
                        </td>

                        <td class="text-danger">
                            {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : '-' }}
                        </td>

                        <td>
                            <a href="{{ route('developer.tasks.show', $task->id) }}"
                                class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-eye"></i> Lihat
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection
