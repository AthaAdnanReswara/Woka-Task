@extends('layout.app')

@section('content')
<div class="container py-4">
    <h3>Task Details</h3>

    <div class="card mt-3 p-3">
        <h5>{{ $task->name }}</h5>
        <p>{{ $task->description ?? 'No description' }}</p>
        <p>Project: {{ $task->project->name ?? '-' }}</p>
        <p>Status: <span class="badge bg-info text-dark">{{ ucfirst($task->status) }}</span></p>
        <p>Progress: {{ $task->progress ?? 0 }}%</p>

        <form action="{{ route('developer.task.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-2">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="todo" {{ $task->status=='todo' ? 'selected' : '' }}>To Do</option>
                    <option value="in_progress" {{ $task->status=='in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="review" {{ $task->status=='review' ? 'selected' : '' }}>Review</option>
                    <option value="done" {{ $task->status=='done' ? 'selected' : '' }}>Done</option>
                    <option value="cancelled" {{ $task->status=='cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="mb-2">
                <label>Progress (%)</label>
                <input type="number" name="progress" class="form-control" value="{{ $task->progress ?? 0 }}" min="0" max="100">
            </div>

            <button class="btn btn-primary mt-2"><i class="bi bi-save"></i> Update Task</button>
            <a href="{{ route('developer.task.index') }}" class="btn btn-secondary mt-2"><i class="bi bi-arrow-left"></i> Back</a>
        </form>
    </div>
</div>
@endsection
