@extends('layout.app')
@section('title', 'lihat semua project saya')
@section('content')
<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-file-earmark-text text-primary"></i> Detail Task
            </h3>
            <small class="text-secondary">Informasi lengkap task Anda</small>
        </div>

        <a href="{{ route('developer.pekerjaan.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- CARD UTAMA -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-info-circle"></i> Informasi Task
        </div>

        <div class="card-body">

            <!-- INFORMASI TASK -->
            <div class="row mb-4">

                <div class="col-md-6">
                    <h5 class="fw-bold text-dark">Judul Task</h5>
                    <p>{{ $task->judul_task }}</p>

                    <h6 class="fw-bold text-dark mt-3">Deskripsi</h6>
                    <p>{{ $task->deskripsi ?? '-' }}</p>

                    <h6 class="fw-bold text-dark mt-3">Kesulitan</h6>
                    <span class="badge bg-info text-dark text-uppercase px-3">
                        {{ $task->kesulitan }}
                    </span>
                </div>

                <div class="col-md-6">
                    <h6 class="fw-bold text-dark">Status</h6>
                    <span class="badge bg-success text-light text-uppercase px-3">
                        {{ $task->status }}
                    </span>

                    <h6 class="fw-bold text-dark mt-3">Penanggung Jawab</h6>
                    <p>{{ $task->user->name }}</p>

                    <h6 class="fw-bold text-dark mt-3">Tanggal Mulai</h6>
                    <p>{{ \Carbon\Carbon::parse($task->tanggal_mulai)->format('d M Y') }}</p>

                    <h6 class="fw-bold text-dark mt-3">Tanggal Selesai</h6>
                    <p>{{ \Carbon\Carbon::parse($task->tanggal_tenggat)->format('d M Y') }}</p>
                </div>
            </div>

            <!-- PROGRESS BAR -->
            <div class="mb-4">
                <h5 class="fw-bold text-dark">Progress</h5>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar bg-success fw-bold"
                        role="progressbar"
                        style="width: {{ $task->progress }}%;">
                        {{ $task->progress }}%
                    </div>
                </div>
            </div>

            <!-- INFORMASI PROJECT -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-secondary text-white fw-bold">
                    <i class="bi bi-folder2-open"></i> Informasi Project
                </div>

                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th>Nama Project</th>
                            <td>{{ $task->project->name }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi Project</th>
                            <td>{{ $task->project->description }}</td>
                        </tr>
                        <tr>
                            <th>Project Manager</th>
                            <td>{{ $task->creator->name }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- LAMPIRAN -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning fw-bold">
                    <i class="bi bi-paperclip"></i> Lampiran Task
                </div>

                <div class="card-body p-0">
                    @if ($task->lampirans->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Ukuran</th>
                                    <th>Uploader</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($task->lampirans as $file)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $file->file_name }}</td>
                                    <td>{{ number_format($file->file_size / 1024, 2) }} KB</td>
                                    <td>{{ $file->uploader->name }}</td>
                                    <td class="text-center">
                                        <!-- PREVIEW -->
                                        <a href="{{ asset('storage/' . $file->file_path) }}"
                                            target="_blank"
                                            class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>

                                        <!-- DOWNLOAD -->
                                        <a href="{{ asset('storage/' . $file->file_path) }}"
                                            class="btn btn-sm btn-primary"
                                            download>
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                    @else
                    <div class="p-3 text-center text-muted">
                        <i class="bi bi-folder-x"></i> Tidak ada lampiran
                    </div>
                    @endif

                </div>
            </div>

        </div>
    </div>

</div>
@endsection