@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-list-check text-primary"></i> Task Management
            </h3>
            <small class="text-secondary">Kelola semua task dalam sebuah project</small>
        </div>

        <a href="{{ route('admin.task.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle"></i> Tambah Task
        </a>
    </div>

    <!-- ALERT -->
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-folder2-open"></i> Daftar Project
        </div>

        <div class="card-body p-0">
            <table id="taskTable" class="table table-hover align-middle mb-0">
                <thead class="bg-light text-uppercase small text-primary">
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>Nama Project</th>
                        <th>Total Task</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($projects as $p)
                    @php
                    $encode = base64_encode(json_encode($p->toArray()));
                    @endphp

                    <tr
                        data-info="{{ $encode }}"
                        data-id="{{ $p->id }}"
                        class="cursor-pointer">

                        <td class="details-control">▶</td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->tasks->count() }} Task</td>
                        <td><span class="badge bg-info">Project</span></td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- STYLE --}}
<style>
    td.details-control {
        cursor: pointer;
        font-size: 18px;
        width: 35px;
        text-align: center;
        font-weight: bold;
        color: #0d6efd;
    }

    tr.shown {
        background: #f0f9ff !important;
    }

    .btn-edit {
        background: #D4A017 !important;
        border: 0 !important;
        color: white !important;
    }

    .btn-delete {
        background: #E74C3C !important;
        border: 0 !important;
        color: white !important;
    }
</style>

{{-- SCRIPT --}}
<script>
    function decode(row) {
        return JSON.parse(atob(row));
    }

    function format(d) {
        let tasks = d.tasks ?? [];
        let tableId = "tbl_child_" + d.id;

        if (tasks.length === 0) {
            return `<div class="p-3 bg-light"><em>Belum ada task pada project ini.</em></div>`;
        }

        let rows = "";
        tasks.forEach((t, i) => {
            rows += `
        <tr>
            <td>${i+1}</td>
            <td>${t.judul_task}</td>
            <td>${t.user?.name ?? '-'}</td>
            <td>${t.tanggal_tenggat ?? '-'}</td>
            <td>${t.status}</td>
            <td>
                <a href="/admin/task/${t.id}/edit" class="btn btn-sm btn-edit me-1">
                    <i class="bi bi-pencil"></i>
                </a>

                <form action="/admin/task/${t.id}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-delete">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>`;
        });

        return `
    <div class="p-3 bg-light border">
        <h6 class="fw-bold mb-3">Task Pada Project: ${d.name}</h6>

        <table id="${tableId}" class="table table-bordered table-striped table-sm">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Judul Task</th>
                    <th>PIC</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th width="130px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                ${rows}
            </tbody>
        </table>
    </div>`;
    }

    $(document).ready(function() {

        let table = $('#taskTable').DataTable();

        $('#taskTable tbody').on('click', 'td.details-control', function() {

            let tr = $(this).closest('tr');
            let row = table.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
                $(this).text('▶');
            } else {
                let d = decode(tr.attr('data-info'));

                row.child(format(d)).show();
                tr.addClass('shown');
                $(this).text('▼');

                let childId = "#tbl_child_" + d.id;

                $(childId).DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    autoWidth: false,
                    responsive: true,
                    pageLength: 5
                });
            }
        });

    });
</script>

@endsection