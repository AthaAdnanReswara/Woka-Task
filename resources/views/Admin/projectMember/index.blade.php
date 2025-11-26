@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-people-fill text-primary"></i> Project Members
            </h3>
            <small class="text-secondary">Kelola anggota dari semua proyek</small>
        </div>

        <a href="{{ route('admin.projectMember.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-person-plus-fill"></i> Tambah Member
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
            <i class="bi bi-table"></i> Daftar Project Members
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0" id="memberTable">
                    <thead class="bg-light text-primary text-uppercase small">
                        <tr>
                            <th>No</th>
                            <th>Project</th>
                            <th>Nama Member</th>
                            <th>Email</th>
                            <th class="text-center" width="200">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="small">
                        @forelse($projectMembers as $m)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold text-dark">{{ $m->project->name }}</td>
                            <td>{{ $m->user->name }}</td>
                            <td>{{ $m->user->email }}</td>

                            <td class="text-center">
                                <a href="{{ route('admin.projectMember.edit',$m->id) }}"
                                    class="btn btn-sm btn-outline-warning rounded-pill px-3 me-1 text-dark">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </a>

                                <form action="{{ route('admin.projectMember.destroy',$m->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                        onclick="return confirm('Hapus member ini?')">
                                        <i class="bi bi-trash-fill"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3 fw-semibold">
                                Belum ada anggota terdaftar
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>


{{-- DataTable Script --}}
<script>
    $(document).ready(function() {
        $('#memberTable').DataTable({
            "ordering": true,
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "zeroRecords": "Tidak ada data member ditemukan",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ member",
                "paginate": {
                    "next": "›",
                    "previous": "‹"
                }
            }
        });
    });
</script>

@endsection
