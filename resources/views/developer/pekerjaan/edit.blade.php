@extends('layout.app')

@section('content')
<div class="container-fluid py-4">
    <h3 class="fw-bold mb-4"><i class="bi bi-pencil-square text-primary"></i> Edit Task</h3>

    <form action="{{ route('developer.pekerjaan.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Judul Task</label>
            <input type="text" class="form-control" value="{{ $task->judul_task }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $task->deskripsi) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                @foreach(['rencana','sedang_dikerjakan','tinjauan','selesai','dibatalkan'] as $status)
                    <option value="{{ $status }}" @selected($task->status == $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Progress (%)</label>
            <input type="number" name="progress" class="form-control" min="0" max="100" value="{{ old('progress', $task->progress) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Task</button>
        <a href="{{ route('developer.pekerjaan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
