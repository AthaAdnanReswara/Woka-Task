@extends('layout.app')
@section('title', 'Tugas saya')
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

        <a href="{{ route('PM.tugas.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Task
        </a>
    </div>

    <!-- ALERT -->
    @if (session('success'))
        <div class="alert alert-success small shadow-sm">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-kanban"></i> Daftar Project & Task
        </div>

        <div class="card-body p-0">

            <div class="p-3">
                <button id="collapseAll" class="btn btn-sm btn-secondary rounded-pill shadow-sm">
                    <i class="bi bi-arrows-collapse me-1"></i> Tutup Semua
                </button>
            </div>

            <div class="table-responsive">
                <table id="taskTable" class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-uppercase small text-primary">
                        <tr>
                            <th style="width:40px"></th>
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
                            data-riwayat="{{ $riwayatBase64 }}"
                        >
                            <td class="details-control text-primary">▶️</td>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-semibold text-dark">{{ $item["name"] }}</td>
                            <td>{{ $item["description"] }}</td>
                            <td class="text-success fw-semibold">{{ $item["start_date"] }}</td>
                            <td class="text-danger fw-semibold">{{ $item["end_date"] }}</td>
                            <td>
                                @php
                                    $statusClass = match($item["status"] ?? '-') {
                                    'rencana' => 'secondary',
                                    'sedang_dikerjakan' => 'warning',
                                    'tinjauan' => 'info',
                                    'selesai' => 'success',
                                    'dibatalkan' => 'danger',
                                    default => 'dark'
                                };
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">
                                    {{ $item["status"] }}
                                </span>
                            </td>
                            <td>{{ $item["created_by"] }}</td>
                            <td class="fw-bold text-primary">{{ $item["jumlah_task"] }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

<!-- Prevent table cutoff -->
<style>
    table.dataTable td { white-space: nowrap; }
    td.details-control {
        cursor: pointer;
        text-align: center;
        font-weight: bold;
        color: #0d6efd;
        font-size: 18px;
    }
    tr.shown { background-color: #eef7ff !important; }
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
        let html = `
            <div class="p-3">
            <div class="table-responsive">
            <table class="table table-sm table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Penanggung Jawab</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Kesulitan</th>
                        <th>Status</th>
                        <th>Tgl Mulai</th>
                        <th>Tgl Selesai</th>
                        <th>Estimasi</th>
                        <th>Progress</th>
                        <th>Pembuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead><tbody>
        `;

        riwayat.forEach(r => {
            let editUrl = `/PM/tugas/${r.id}/edit`;
            let showtUrl = `/PM/tugas/${r.id}`;
            let deleteUrl = `/PM/tugas/${r.id}`;

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
                    ${
                        !(r.status === 'selesai' && parseInt(r.progres) === 100)
                        ? `<a href="${editUrl}" class="btn btn-sm btn-warning">
                                <i class="mdi mdi-pencil"></i>
                        </a>`
                        : ''
                    }

                    <a href="${showtUrl}" class="btn btn-sm btn-secondary" target="_blank">
                        <i class="mdi mdi-eye"></i>
                    </a>

                    ${
                        !(r.status === 'selesai' && parseInt(r.progres) === 100)
                        ? `<form action="/admin/task/${r.id}" method="POST" style="display:inline;"
                                onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="mdi mdi-trash-can-outline"></i>
                                </button>
                        </form>`
                        : ''
                    }
                </td>
            </tr>
        `;
        });

        return html + `</tbody></table></div></div>`;
    }

    $(document).ready(function() {
        let table = $('#taskTable').DataTable({
            responsive: true,
            ordering: true,
            paging: true,
            searching: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Tidak ada data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: { next: "›", previous: "‹" }
            }
        });

        let expandedRows = new Set();

        function toggleRow(tr, row) {
            let td = tr.find('td.details-control');
            let isShown = row.child.isShown();
            let id = tr.data('id');

            if (isShown) {
                $('div.slider', row.child()).slideUp(200, function() {
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
                $('div.slider', row.child()).slideDown(200);
                expandedRows.add(id);
            }
        }

        $('#taskTable tbody').on('click', 'td.details-control', function() {
            let tr = $(this).closest('tr');
            toggleRow(tr, table.row(tr));
        });

        $('#collapseAll').on('click', function() {
            $('#taskTable tbody tr.shown').each(function() {
                toggleRow($(this), table.row(this));
            });
        });
    });
</script>
@endsection