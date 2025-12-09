@extends('layout.app')
@section('content')
<div class="container-fluid py-4">

    <!-- HEADER + BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4"
         style="background: linear-gradient(90deg,#ff7eb9,#7ac1ff);
                border-radius:12px; padding:20px; color:white;">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-list-check"></i> Task Management
            </h3>
            <small>Kelola semua task dalam sebuah project</small>
        </div>
        <a href="{{ route('admin.task.create') }}"
           class="btn btn-light fw-semibold shadow-sm">
            <i class="bi bi-plus-circle"></i> Tambah Task
        </a>
    </div>

    <!-- ALERT -->
    @if (session('success'))
        <div class="alert alert-success small shadow-sm">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    <!-- TABLE CARD -->
    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">

        <!-- TOP HEADER + BUTTON TUTUP SEMUA -->
        <div class="card-header fw-bold d-flex justify-content-between align-items-center"
             style="background:#1e3c72; color:white;">
            <span><i class="bi bi-folder2-open"></i> Daftar Project</span>

            <button id="collapseAll" class="btn btn-sm btn-light text-primary fw-bold">
                Tutup Semua
            </button>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">

                <table id="taskTable" class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-primary small text-uppercase">
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

                    <tbody class="small">
                        @foreach ($data as $index => $item)
                        @php
                            $riwayatBase64 = base64_encode(json_encode($item['riwayat']));
                        @endphp
                        <tr class="table-row-hover"
                            data-id="{{ $item['id'] }}"
                            data-riwayat="{{ $riwayatBase64 }}">

                            <td class="details-control">▶️</td>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-semibold text-dark">{{ $item["name"] }}</td>
                            <td>{{ $item["description"] }}</td>
                            <td class="text-success fw-semibold">{{ $item["start_date"] }}</td>
                            <td class="text-danger fw-semibold">{{ $item["end_date"] }}</td>

                            <td>
                                @php
                                    $statusClass = match($item["status"] ?? '-') {
                                        'On Progress' => 'warning',
                                        'Completed'   => 'success',
                                        'Pending'     => 'secondary',
                                        default       => 'dark'
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">
                                    {{ $item["status"] }}
                                </span>
                            </td>

                            <td>{{ $item["created_by"] }}</td>
                            <td>{{ $item["jumlah_task"] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>

<!-- CUSTOM STYLE -->
<style>
.table-row-hover:hover {
    background: rgba(0,0,0,0.05);
    transform: scale(1.005);
    transition: 0.15s;
}

td.details-control {
    cursor: pointer;
    text-align: center;
    font-weight: bold;
    color: #0d6efd;
    font-size: 18px;
    width: 40px;
}

tr.shown {
    background-color: #f0f9ff !important;
}

table.dataTable td {
    white-space: nowrap;
}

div.dataTables_wrapper {
    width: 100%;
    overflow-x: auto;
}
</style>

<!-- SCRIPT COLLAPSE -->
<script>
    function base64ToJson(base64) {
        try {
            return JSON.parse(atob(base64));
        } catch (e) {
            return [];
        }
    }

    function formatRiwayat(riwayat) {
        let html = `
        <div style="overflow-x:auto">
            <table class="table table-sm table-bordered mb-0">
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
                </thead>
                <tbody>
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

        html += "</tbody></table></div>";
        return html;
    }

    $(document).ready(function() {
        let table = $('#taskTable').DataTable({
            responsive: true,
            paging: true,
            ordering: true,
            searching: false,
            lengthChange: false
        });

        function toggleRow(tr, row) {
            let td = tr.find('td.details-control');
            let isShown = row.child.isShown();
            let riwayat = base64ToJson(tr.attr('data-riwayat'));

            if (isShown) {
                $('div.slider', row.child()).slideUp(300, function() {
                    row.child.hide();
                });
                tr.removeClass('shown');
                td.text('▶️');
            } else {
                row.child('<div class="slider">'+formatRiwayat(riwayat)+'</div>', 'p-0').show();
                tr.addClass('shown');
                td.text('▼');
                $('div.slider', row.child()).slideDown(300);
            }
        }

        $('#taskTable tbody').on('click', 'td.details-control', function() {
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            toggleRow(tr, row);
        });

        $('#collapseAll').on('click', function() {
            $('#taskTable tbody tr.shown').each(function() {
                toggleRow($(this), table.row(this));
            });
        });
    });
</script>
@endsection