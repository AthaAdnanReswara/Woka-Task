@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-list-check text-primary"></i> Task Management
            </h3>
            <small class="text-secondary">Kelola semua task dalam sebuah proyek</small>
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
            <i class="bi bi-table"></i> Daftar Task
        </div>
        <div class="card-body p-0">

<table id="taskTable" class="table table-hover align-middle mb-0">
    <thead class="bg-light text-uppercase small text-primary">
        <tr>
            <th></th>
            <th>#</th>
            <th>Judul</th>
            <th>Project</th>
            <th>PIC</th>
            <th>Deadline</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($tasks as $t)
        @php
        $encode = base64_encode(json_encode($t)); // untuk kirim data detail
        @endphp
        <tr 
            data-info="{{ $encode }}"
            data-id="{{ $t->id }}"
            class="cursor-pointer">

            <td class="details-control">▶</td>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $t->judul_task }}</td>
            <td>{{ $t->project->name ?? '-' }}</td>
            <td>{{ $t->user->name ?? '-' }}</td>
            <td><span class="text-danger fw-bold">{{ $t->tanggal_tenggat }}</span></td>

            <td>
                @php
                $color = [
                    'rencana'=>'secondary','sedang_dikerjakan'=>'warning',
                    'tinjauan'=>'info','selesai'=>'success','dibatalkan'=>'danger'
                ][$t->status] ?? 'dark';
                @endphp
                <span class="badge bg-{{ $color }}">{{ ucfirst(str_replace('_',' ',$t->status)) }}</span>
            </td>
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
        cursor:pointer;
        font-size:18px;
        width:35px;
        text-align:center;
        font-weight:bold;
        color:#0d6efd;
    }
    tr.shown { background:#f0f9ff !important; }
</style>

{{-- SCRIPT DROPDOWN --}}
<script>
function decode(row){ return JSON.parse(atob(row)); }

function format(d){
    return `
    <div class="p-3 bg-light border">
        <table class="table table-sm mb-0">
            <tr><th width="180px">Judul</th><td>${d.judul_task}</td></tr>
            <tr><th>Deskripsi</th><td>${d.deskripsi ?? '-'}</td></tr>
            <tr><th>Project</th><td>${d.project?.name ?? '-'}</td></tr>
            <tr><th>PIC / User</th><td>${d.user?.name ?? '-'}</td></tr>
            <tr><th>Deadline</th><td>${d.tanggal_tenggat ?? '-'}</td></tr>
            <tr><th>Status</th><td>${d.status}</td></tr>
            <tr>
                <th>Aksi</th>
                <td>
                    <a href="/admin/task/${d.id}/edit" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Edit</a>
                    <form action="/admin/task/${d.id}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
        </table>
    </div>`;
}

$(document).ready(function(){

    let table = $('#taskTable').DataTable(); 
    let open = new Set();

    $('#taskTable tbody').on('click','td.details-control',function(){
        let tr = $(this).closest('tr');
        let row = table.row(tr);
        let id = tr.data('id');

        if(row.child.isShown()){
            row.child.hide();
            tr.removeClass('shown');
            $(this).text('▶');
            open.delete(id);
        } else {
            let d = decode(tr.attr('data-info'));
            row.child(format(d)).show();
            tr.addClass('shown');
            $(this).text('▼');
            open.add(id);
        }
    });
});
</script>

@endsection
