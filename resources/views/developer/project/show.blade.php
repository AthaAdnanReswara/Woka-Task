@extends('developer.layouts.app')

@section('title', 'Project Details')

@section('content')
<div class="container mt-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Project Details</h3>
        <a href="{{ route('developer.projects.index') }}" class="btn btn-secondary">
            &larr; Back to My Projects
        </a>
    </div>

    {{-- Card Project --}}
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ $project->name }}</h5>
        </div>

        <div class="card-body">
            {{-- Row Info --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Project Manager:</strong><br>
                    {{ $project->manager->name ?? 'N/A' }}
                </div>
                <div class="col-md-6">
                    <strong>Deadline:</strong><br>
                    {{ $project->deadline ? $project->deadline->format('d M Y') : '-' }}
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <strong>Description:</strong>
                <p class="mt-1">{{ $project->description ?? 'No description available.' }}</p>
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <strong>Status:</strong><br>
                <span class="badge bg-info text-dark">
                    {{ ucfirst($project->status) }}
                </span>
            </div>

            {{-- Created & Updated --}}
            <div class="text-muted small">
                Created at: {{ $project->created_at->format('d M Y H:i') }} <br>
                Last update: {{ $project->updated_at->format('d M Y H:i') }}
            </div>
        </div>
    </div>

</div>
@endsection
