@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-folder-plus text-primary"></i> Tambah Proyek Baru
            </h3>
            <small class="text-secondary">Isi informasi proyek dengan benar</small>
        </div>


    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-primary text-white fw-semibold">
            <i class="bi bi-pencil-square"></i> Form Input Proyek
        </div>

        <form action="{{ route('admin.project.store') }}" method="POST">
            @csrf
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Proyek</label>
                    <input type="text" name="nama_proyek" class="form-control" placeholder="Masukkan nama proyek...">
                </div>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Masukkan deskripsi proyek"></textarea>
                </div>
                @error('description')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="mb-3">
                    <label class="form-label fw-semibold">Start Date</label>
                    <input type="date" name="start_date" class="form-control">
                </div>
                @error('start_date')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="mb-3">
                    <label class="form-label fw-semibold">End Date</label>
                    <input type="date" name="end_date" class="form-control">
                </div>
                @error('end_date')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select border-primary fw-semibold" required>
                        <option value="" disabled selected class="text-muted">-- Pilih Status --</option>
                        <option value="draft" class="text-secondary fw-bold">Draft</option>
                        <option value="ongoing" class="text-primary fw-bold">Sedang Berjalan</option>
                        <option value="hold" class="text-warning fw-bold">Ditahan</option>
                        <option value="done" class="text-success fw-bold">Selesai</option>
                        <option value="cancelled" class="text-danger fw-bold">Dibatalkan</option>
                    </select>
                </div>
                @error('status')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('admin.project.index') }}" class="btn btn-danger shadow-sm">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary shadow-sm px-4">
                    <i class="bi bi-save"></i> Simpan Proyek
                </button>
            </div>

        </form>
    </div>

</div>
@endsection