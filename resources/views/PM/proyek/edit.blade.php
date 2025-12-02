@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-pencil-fill text-warning"></i> Edit Project
            </h3>
            <small class="text-secondary">Perbarui data project</small>
        </div>


    </div>

    <!-- Card Form -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-secondary text-white fw-bold">
            <i class="bi bi-kanban"></i> Form Edit Project
        </div>
        <div class="card-body">
            <form action="{{ route('PM.proyek.update', $proyek->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-3">
                    <label class="fw-semibold">Nama Proyek</label>
                    <input type="text" name="name" required
                        class="form-control"
                        value="{{ old('name', $proyek->name) }}">
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label class="fw-semibold">Deskripsi</label>
                    <textarea name="description" rows="3"
                        class="form-control">{{ old('description', $proyek->description) }}</textarea>
                </div>

                <!-- Dates -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Tanggal Mulai</label>
                        <input type="date" name="start_date"
                            class="form-control"
                            value="{{ old('start_date', $proyek->start_date) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Tanggal Selesai</label>
                        <input type="date" name="end_date"
                            class="form-control"
                            value="{{ old('end_date', $proyek->end_date) }}">
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label class="fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        @foreach (['draft'=>'Draft','ongoing'=>'On Going','hold'=>'Hold','done'=>'Done','cancelled'=>'Cancelled'] as $key => $label)
                        <option value="{{ $key }}" {{ $key == $proyek->status ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Created by -->
                <!--  -->

                <!-- Submit Button -->
                <div class="text-end">
                    <a href="{{ route('PM.proyek.index') }}" class="btn btn-outline-secondary shadow-sm rounded-pill px-3">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection