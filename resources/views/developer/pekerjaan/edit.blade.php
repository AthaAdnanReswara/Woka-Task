@extends('layout.app')

@section('title', 'Edit Tugas')

@section('content')

<div class="container-fluid py-4">

    {{-- Alert sukses --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-pencil-square"></i> Edit Tugas
            </h5>
        </div>

        <div class="card-body">

            <form action="{{ route('developer.pekerjaan.update', $task->id) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $task->deskripsi) }}</textarea>
                </div>
                @error('deskripsi')
                <div class="text-danger mb-3">{{ $message }}</div>
                @enderror

                {{-- Kesulitan --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Tingkat Kesulitan</label>
                    <select name="kesulitan" class="form-select" required>
                        <option value="low" {{ $task->kesulitan == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ $task->kesulitan == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ $task->kesulitan == 'high' ? 'selected' : '' }}>High</option>
                        <option value="critical" {{ $task->kesulitan == 'critical' ? 'selected' : '' }}>Critical</option>
                    </select>
                </div>
                @error('kesulitan')
                <div class="text-danger mb-3">{{ $message }}</div>
                @enderror

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="rencana" {{ $task->status == 'rencana' ? 'selected' : '' }}>Rencana</option>
                        <option value="sedang_dikerjakan" {{ $task->status == 'sedang_dikerjakan' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                        <option value="selesai" {{ $task->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="tunda" {{ $task->status == 'tunda' ? 'selected' : '' }}>Tunda</option>
                    </select>
                </div>
                @error('status')
                <div class="text-danger mb-3">{{ $message }}</div>
                @enderror

                {{-- Progress --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Progress (%)</label>
                    <input type="number" name="progress" class="form-control" min="0" max="100"
                        value="{{ old('progress', $task->progress) }}" required>
                </div>
                @error('progress')
                <div class="text-danger mb-3">{{ $message }}</div>
                @enderror

                {{-- Upload Lampiran --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Lampiran (Foto / File / Video)</label>
                    <input type="file" name="lampiran[]" class="form-control" multiple>
                    <small class="text-muted">Bisa upload lebih dari satu file (jpg, png, mp4, pdf, doc, zip)</small>
                </div>
                @error('lampiran.*')
                <div class="text-danger mb-3">{{ $message }}</div>
                @enderror

                {{-- Daftar Lampiran Sebelumnya --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Lampiran Sebelumnya</label>

                    @if($task->lampirans->count() == 0)
                    <p class="text-muted">Belum ada lampiran.</p>
                    @else
                    <ul class="list-group">
                        @foreach ($task->lampirans as $file)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                <i class="bi bi-paperclip"></i>
                                {{ $file->file_name }} ({{ number_format($file->file_size / 1024, 1) }} KB)
                            </a>

                            {{-- Tombol Hapus Lampiran (opsional) --}}
                            <form action="{{ route('developer.pekerjaan.destroy', $file->id) }}"
                                method="POST" onsubmit="return confirm('Hapus lampiran ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('developer.pekerjaan.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection