@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-kanban text-primary"></i> Project Management
            </h3>
            <small class="text-secondary">Kelola semua proyek dalam sistem</small>
        </div>

        <a href="{{ route('PM.proyek.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Project
        </a>
    </div>

    <!-- Alert -->
    @if (session('success'))
        <div class="alert alert-success small shadow-sm">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger small shadow-sm">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Table -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-table"></i> Daftar Project
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0" id="projectTable">

                    <thead class="bg-light text-primary text-uppercase small">
                        <tr>
                            <th>No</th>
                            <th>Nama Proyek</th>
                            <th>Description</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Ditambahkan Oleh</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="small">
                        @foreach ($proyek as $project)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-semibold text-dark">
                                {{ $project->name ?? '-' }}
                            </td>

                            <td>{{ $project->description ?? '-' }}</td>

                            <td class="text-success fw-semibold">
                                {{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }}
                            </td>

                            <td class="text-danger fw-semibold">
                                {{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}
                            </td>

                            <td>{{ $project->creator->name }}</td>

                            <td>
                                @php
                                    $statusClass = [
                                        'On Progress' => 'warning',
                                        'Completed'   => 'success',
                                        'Pending'     => 'secondary'
                                    ][$project->status] ?? 'dark';
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">
                                    {{ $project->status }}
                                </span>
                            </td>

                            <td class="text-center">

                                <a href="{{ route('PM.proyek.show', $project->id) }}"
                                   class="btn btn-sm btn-outline-info rounded-pill px-3 me-1">
                                    <i class="bi bi-eye-fill me-1"></i> Detail
                                </a>

                                <a href="{{ route('PM.proyek.edit', $project->id) }}"
                                   class="btn btn-sm btn-outline-warning rounded-pill px-3 me-1">
                                    <i class="bi bi-pencil-fill me-1"></i> Edit
                                </a>

                                <form action="{{ route('PM.proyek.destroy', $project->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                        onclick="return confirm('Yakin ingin menghapus project ini?')">
                                        <i class="bi bi-trash-fill me-1"></i> Hapus
                                    </button>
                                </form>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

{{-- DataTable Script --}}
<script>
$(document).ready(function() {
    $('#projectTable').DataTable({
        ordering: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            zeroRecords: "Data proyek tidak ditemukan",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ proyek",
            paginate: {
                next: "›",
                previous: "‹"
            }
        }
    });
});
</script>
@endsection