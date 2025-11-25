@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-person-badge-fill text-primary"></i> Developer
            </h3>
            <small class="text-secondary">Kelola akun Developer pada sistem proyek</small>
        </div>

        <a href="{{ route('admin.developer.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-person-plus">Tambah Developer</i> 
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
    
    <!-- Table Card -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-people"></i> Daftar Developer
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="pembimbing">
                    <thead class="bg-light text-primary text-uppercase small">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th class="text-center">Ditambahkan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="small">
                        @foreach ($developer as $data)
                        <tr class="table-row-hover">
                            <td class="fw-semibold">{{ $loop->iteration }}</td>
                            <td class="fw-semibold text-dark">{{ $data->name }}</td>
                            <td>{{ $data->email }}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary">
                                    {{ $data->created_at->format('d M Y') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.developer.edit', $data->id) }}" 
                                   class="btn btn-sm btn-outline-warning me-1">
                                   <i class="bi bi-pencil-square text-dark">Update</i>
                                </a>

                                <form action="{{ route('admin.developer.destroy', $data->id) }}" method="POST" class="d-inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger shadow-none"
                                            onclick="return confirm('Yakin hapus PM ini?')">
                                        <i class="bi bi-trash text-dark">Delete</i>
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

<!-- Animasi Row Hover + Styling -->
<style>
.table-row-hover:hover {
    background: rgba(0, 0, 0, 0.05) !important;
    transform: scale(1.005);
    transition: .15s;
    cursor: pointer;
}
</style>

{{-- DataTable Script --}}
<script>
$(document).ready(function() {
    $('#pembimbing').DataTable({
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data",
            "zeroRecords": "Data tidak ditemukan",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "paginate": {
                "next": "›",
                "previous": "‹"
            }
        }
    });
});
</script>
@endsection
