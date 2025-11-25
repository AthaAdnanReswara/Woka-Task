@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-plus-circle text-primary"></i> Tambah Task
            </h3>
            <small class="text-secondary">Isi form berikut untuk menambahkan task baru</small>
        </div>


    </div>

    <!-- Card Form -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-list-task"></i> Form Tambah Task
        </div>

        <div class="card-body">
            <form action="{{ route('admin.task.store') }}" method="POST">
                @csrf
                <!-- Nama Task -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Task</label>
                    <input type="text" name="title" class="form-control shadow-sm"placeholder="Masukkan nama task" value="{{ old('title') }}">
                    @error('title')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <!-- Project -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Project</label>
                    <select name="project_id"
                        class="form-select shadow-sm">
                        <option selected disabled>-- Pilih Project --</option>
                        @foreach ($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('project_id')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <!-- Developer -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Developer</label>
                    <select name="developer_id"
                        class="form-select shadow-sm ">
                        <option selected disabled>-- Pilih Developer --</option>
                        @foreach ($developers as $user)
                        <option value="{{ $user->id }}" {{ old('developer_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('developer_id')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Deadline -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Deadline</label>
                    <input type="date" name="deadline"
                        class="form-control shadow-sm @error('deadline') is-invalid @enderror"
                        value="{{ old('deadline') }}">
                    @error('deadline')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <!-- Status -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select shadow-sm">
                        <option value="todo" selected>Todo</option>
                        <option value="in-progress">In Progress</option>
                        <option value="review">Review</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <!-- Deskripsi -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="description" rows="4" class="form-control shadow-sm"placeholder="Tambahkan deskripsi task">{{ old('description') }}</textarea>
                </div>
                <div class="text-end">
                    <a href="{{ route('admin.task.index') }}" class="btn btn-secondary shadow-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary shadow-sm px-4">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection