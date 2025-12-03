@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-person-plus text-primary"></i> Tambah Task Collaborator
            </h3>
            <small class="text-secondary">Pilih task & user yang akan berkolaborasi</small>
        </div>
    </div>

    <!-- Card Form -->
    <div class="card border-0 shadow-sm rounded-3">
        
        <!-- Card Header -->
        <div class="card-header bg-primary text-white fw-semibold">
            <i class="bi bi-pencil-square"></i> Form Input Collaborator
        </div>

        <form action="{{ route('PM.kelompok.store') }}" method="POST">
            @csrf

            <div class="card-body">

                <!-- Pilih Task -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Pilih Task</label>
                    <select name="task_id" class="form-select border-primary" required>
                        <option value="" disabled selected>-- pilih task --</option>
                        @foreach($tasks as $t)
                            <option value="{{ $t->id }}">{{ $t->title ?? $t->judul_task }}</option>
                        @endforeach
                    </select>
                    @error('task_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pilih User -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Pilih User (Collaborator)</label>
                    <select name="user_id" class="form-select border-primary" required>
                        <option value="" disabled selected>-- pilih user --</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <!-- Footer Form -->
            <div class="card-footer text-end">
                <a href="{{ route('PM.kelompok.index') }}" class="btn btn-danger shadow-sm">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary shadow-sm px-4">
                    <i class="bi bi-save"></i> Simpan Collaborator
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
