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
            <div class="mb-3">
                <button id="collapseAll" class="btn btn-sm btn-secondary">Tutup Semua</button>
            </div>
            <table id="taskTable" class="table table-hover align-middle mb-0">
                <thead class="bg-light text-uppercase small text-primary">
                    <tr>
                        <th></th>
                        <th>No</th>
                        <th>Nama Project</th>
                        <th>Deskripsi</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th>Pembuat</th>
                        <th>Jumlah Task</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data as $index => $item)
                    @php
                    $riwayatBase64 = base64_encode(json_encode($item['riwayat']));
                    @endphp
                    <tr
                        data-id="{{ $item['id'] }}"
                        data-riwayat="{{ $riwayatBase64 }}">
                        <td class="details-control">▶️</td>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item["name"] }}</td>
                        <td>{{ $item["description"] }}</td>
                        <td>{{ $item["start_date"] }}</td>
                        <td>{{ $item["end_date"] }}</td>
                        <td>{{ $item["status"] }}</td>
                        <td>{{ $item["created_by"] }}</td>
                        <td>{{ $item["jumlah_task"] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
    /* Membuat konten kolom tidak terpotong dan melebar sesuai isi */
    table.dataTable td {
        white-space: nowrap;
    }

    /* Memastikan scroll horizontal aktif */
    div.dataTables_wrapper {
        width: 100%;
        overflow-x: auto;
    }
</style>

<style>
    tr.shown {
        background-color: #f0f9ff !important;
    }

    td.details-control {
        cursor: pointer;
        text-align: center;
        font-weight: bold;
        color: #0d6efd;
        font-size: 18px;
        width: 40px;
    }
</style>

<script>
    function base64ToJson(base64) {
        try {
            return JSON.parse(atob(base64));
        } catch (e) {
            console.error("JSON Parse Error:", e);
            return [];
        }
    }

    function formatRiwayat(riwayat) {
        let html = '<div style="overflow-x:auto"><table class="table table-sm table-bordered mb-0">';
        html += `
        <thead class="table-light">
            <tr>
                <th>Penanggung Jawab</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Kesulitan</th>
                <th>Status</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Estimasi</th>
                <th>Progres</th>
                <th>Pembuat</th>
                <th>Aksi</th>
            </tr>
        </thead><tbody>
    `;

        riwayat.forEach(r => {
            let editUrl = `/admin/task/${r.id}/edit`;
            let showtUrl = `/admin/task/${r.id}`;
            let deleteUrl = `/admin/task/${r.id}`;

            html += `
            <tr>
                <td>${r.penanggung_jawab ?? '-'}</td>
                <td>${r.judul ?? '-'}</td>
                <td>${r.deskripsi ?? '-'}</td>
                <td>${r.kesulitan ?? '-'}</td>
                <td>${r.status ?? '-'}</td>
                <td>${r.tanggal_mulai ?? '-'}</td>
                <td>${r.tanggal_selesai ?? '-'}</td>
                <td>${r.estimasi ?? '-'}</td>
                <td>${r.progres ?? '-'}</td>
                <td>${r.pembuat ?? '-'}</td>
                <td class="text-center">
                    <a href="${editUrl}" class="btn btn-sm btn-warning">
                        <i class="mdi mdi-pencil"></i>
                    </a>

                    <a href="${showtUrl}" class="btn btn-sm btn-secondary" target="_blank">
                        <i class="mdi mdi-eye"></i>
                    </a>

                    <form action="/admin/task/${r.id}" method="POST" style="display:inline;" 
                        onsubmit="return confirm('Yakin ingin menghapus?')" >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="mdi mdi-trash-can-outline"></i>
                        </button>
                    </form>
                </td>
            </tr>
        `;
        });

        html += '</tbody></table></div>';
        return html;
    }

    $(document).ready(function() {
        let table = $('#taskTable').DataTable({
            responsive: true,
            ordering: true,
            paging: true,
            searching: true
        });

        let expandedRows = new Set();

        function toggleRow(tr, row) {
            let td = tr.find('td.details-control');
            let isShown = row.child.isShown();
            let id = tr.data('id');

            if (isShown) {
                $('div.slider', row.child()).slideUp(300, function() {
                    row.child.hide();
                    tr.removeClass('shown');
                    td.text('▶️');
                    expandedRows.delete(id);
                });
            } else {
                let riwayat = base64ToJson(tr.attr('data-riwayat'));
                row.child('<div class="slider">' + formatRiwayat(riwayat) + '</div>', 'p-0').show();
                tr.addClass('shown');
                td.text('▼');
                $('div.slider', row.child()).slideDown(300);
                expandedRows.add(id);
            }
        }

        $('#taskTable tbody').on('click', 'td.details-control', function() {
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            toggleRow(tr, row);
        });

        table.on('draw', function() {
            $('#taskTable tbody tr').each(function() {
                let tr = $(this);
                let id = tr.data('id');
                if (expandedRows.has(id)) {
                    toggleRow(tr, table.row(tr));
                }
            });
        });

        $('#collapseAll').on('click', function() {
            $('#taskTable tbody tr.shown').each(function() {
                toggleRow($(this), table.row(this));
            });
        });
    });
</script>
@endsection