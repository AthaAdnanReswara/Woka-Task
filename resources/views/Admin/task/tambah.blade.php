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
                <!-- Judul Task -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Judul Task</label>
                    <input type="text" name="judul_task" class="form-control shadow-sm" placeholder="Masukkan judul task" value="{{ old('judul_task') }}">
                    @error('judul_task')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Project -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Project</label>
                    <select name="project_id" class="form-select shadow-sm">
                        <option selected disabled>-- Pilih Project --</option>
                        @foreach ($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('project_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Developer -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Assigned To (Developer)</label>
                    <select name="assigned_to" class="form-select shadow-sm">
                        <option selected disabled>-- Pilih Developer --</option>
                        @foreach ($developers as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('assigned_to')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Mulai -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control shadow-sm" value="{{ old('tanggal_mulai') }}">
                </div>
                @error('tanggal_mulai')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <!-- Deadline -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tanggal Tenggat</label>
                    <input type="date" name="tanggal_tenggat" class="form-control shadow-sm @error('tanggal_tenggat') is-invalid @enderror" value="{{ old('tanggal_tenggat') }}">
                    @error('tanggal_tenggat')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kesulitan -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tingkat Kesulitan</label>
                    <select name="kesulitan" class="form-select shadow-sm">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                        <option value="critical">Critical</option>
                    </select>
                    @error('kesulitan')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select shadow-sm">
                        <option value="rencana" selected>Rencana</option>
                        <option value="sedang_dikerjakan">Sedang Dikerjakan</option>
                        <option value="tinjauan">Tinjauan</option>
                        <option value="selesai">Selesai</option>
                        <option value="dibatalkan">Dibatalkan</option>
                    </select>
                </div>
                @error('status')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <!-- Estimasi Jam -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Estimasi Waktu (jam)</label>
                    <input type="number" step="0.1" name="estimasi" class="form-control shadow-sm" placeholder="Masukkan estimasi waktu" value="{{ old('estimasi') }}">
                    @error('estimasi')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Progress -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Progress (%)</label>
                    <input type="number" name="progress" max="100" min="0" class="form-control shadow-sm" value="{{ old('progress', 0) }}">
                    @error('progress')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" class="form-control shadow-sm" placeholder="Tambahkan deskripsi task">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
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