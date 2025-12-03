@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-pencil-square"></i> Edit Task Collaborator
            </h5>
        </div>

        <form action="{{ route('PM.kelompok.update', $kelompok->id) }}" method="POST" class="p-4">
            @csrf
            @method('PUT')

            <!-- Pilih Task -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Pilih Task</label>
                <select name="task_id" class="form-select" required>
                    <option value="">-- pilih task --</option>
                    @foreach($tasks as $t)
                    <option value="{{ $t->id }}" {{ $kelompok->task_id == $t->id ? 'selected' : '' }}>
                        {{ $t->title ?? $t->judul_task }}
                    </option>
                    @endforeach
                </select>
                @error('task_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- Pilih User -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Pilih User (Collaborator)</label>
                <select name="user_id" class="form-select" required>
                    <option value="">-- pilih user --</option>
                    @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ $kelompok->user_id == $u->id ? 'selected' : '' }}>
                        {{ $u->name }}
                    </option>
                    @endforeach
                </select>
                @error('user_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- Tombol -->
            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('PM.kelompok.index') }}" class="btn btn-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-warning text-white">
                    <i class="bi bi-save2"></i> Update
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
