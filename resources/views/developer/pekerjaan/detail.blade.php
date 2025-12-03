@extends('layout.app')

@section('content')
<div class="container py-4">

    <h3 class="fw-bold mb-3">
        <i class="bi bi-eye text-primary"></i> Detail Task
    </h3>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <h4 class="fw-bold">{{ $task->judul_task }}</h4>
            <p class="text-muted">{{ $task->deskripsi }}</p>

            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Status:</strong> {{ $task->status }}
                </div>
                <div class="col-md-4">
                    <strong>Progress:</strong> {{ $task->progress }}%
                    <div class="progress mt-1">
                        <div class="progress-bar bg-success"
                            role="progressbar"
                            style="width: {{ $task->progress }}%;"
                            aria-valuenow="{{ $task->progress }}"
                            aria-valuemin="0"
                            aria-valuemax="100">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <strong>Kesulitan:</strong> {{ $task->kesulitan ?? '-' }}
                </div>
            </div>

            <hr>

            <h5 class="fw-bold">Informasi Lainnya</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Penanggung Jawab:</strong> {{ $task->user->name ?? '-' }}
                </div>
                <div class="col-md-4">
                    <strong>Pembuat Task:</strong> {{ $task->creator->name ?? '-' }}
                </div>
                <div class="col-md-4">
                    <strong>Project:</strong> {{ $task->project->name ?? '-' }}
                </div>
            </div>

            <hr>

            <h5 class="fw-bold">Lampiran</h5>

            @if($task->lampiran->count() == 0)
            <p class="text-muted">Tidak ada lampiran.</p>
            @else
            <ul class="list-group">
                @foreach($task->lampiran as $file)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-file-earmark"></i>
                        {{ $file->file_name }}
                    </div>
                    <a href="{{ asset('storage/' . $file->file_path) }}"
                        target="_blank"
                        class="btn btn-sm btn-primary">
                        <i class="bi bi-download"></i> Lihat
                    </a>
                </li>
                @endforeach
            </ul>
            @endif

            <hr>

            <a href="{{ route('developer.pekerjaan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

        </div>
    </div>

</div>
@endsection