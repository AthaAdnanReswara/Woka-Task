@extends('layout.app')

@section('content')
<div class="container-fluid py-4" style="background:#f0f4ff; border-radius:12px;">

    <!-- Header -->
    <div class="mb-4 p-4" style="background: linear-gradient(90deg, #ff7eb9, #7ac1ff); border-radius:12px; color:white;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-list-check"></i> Task Saya
                </h3>
                <small>Kelola task yang menjadi tanggung jawab Anda</small>
            </div>
        </div>
    </div>

    <!-- ALERT -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Daftar Project Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:#1e3c72; color:white; border-radius:8px 8px 0 0;">
            <span><i class="bi bi-folder4-open"></i> Daftar Project</span>
            <button id="collapseAll" class="btn btn-sm" style="background:#ff7eb9; color:white;">Tutup Semua</button>
        </div>

        <div class="card-body p-0">
            <div class="mb-3 mt-3 px-3">
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
                    <tr data-id="{{ $item['id'] }}" data-riwayat="{{ $riwayatBase64 }}">
                        <td class="details-control">▶️</td>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item["name"] }}</td>
                        <td>{{ $item["description"] }}</td>
                        <td>{{ \Carbon\Carbon::parse($item["start_date"])->format('d M Y')}}</td>
                        <td>{{ \Carbon\Carbon::parse($item["end_date"])->format('d M Y')}}</td>
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

    /* Tabel lebih modern */
    #taskTable th, #taskTable td { vertical-align: middle; }

    td.details-control {
        cursor: pointer;
        text-align: center;
        font-weight: bold;
        color: #11356c;
        font-size: 18px;
        width: 40px;
    }

    tr.shown { background-color: #e0f0ff !important; }

    .badge { font-size: 0.8rem; }

    .card-header button:hover { opacity: 0.85; }

    div.dataTables_wrapper { width: 100%; overflow-x: auto; }
</style>

<script>
    function base64ToJson(base64) {
        try { return JSON.parse(atob(base64)); } 
        catch(e) { console.error("JSON Parse Error:", e); return []; }
    }

    function formatTanggal(dateString) {
        if (!dateString) return "-";
        const d = new Date(dateString);

        return d.toLocaleDateString("id-ID", {
            day: "2-digit",
            month: "long",
            year: "numeric"
        });
    }


    function formatRiwayat(riwayat) {
        let html = '<div style="overflow-x:auto"><table class="table table-sm table-bordered mb-0">';
        html += `
            <thead class="table-light">
                <tr>
                    <th>Penanggung Jawab</th>
                    <th>Judul</th>
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
            let editUrl = `/developer/pekerjaan/${r.id}/edit`;
            let detailUrl = `/developer/pekerjaan/${r.id}show`;

            html += `
            <tr>
                <td>${r.penanggung_jawab ?? '-'}</td>
                <td>${r.judul ?? '-'}</td>
                <td>${r.kesulitan ?? '-'}</td>
                <td>${r.status ?? '-'}</td>
                <td>${formatTanggal(r.tanggal_mulai)}</td>
                <td>${formatTanggal(r.tanggal_selesai)}</td>
                <td>${r.estimasi ?? '-'}</td>
                <td>${r.progres ?? '-'}</td>
                <td>${r.pembuat ?? '-'}</td>

                <td class="text-center">
                    <a href="${editUrl}" class="btn btn-sm btn-warning"><i class="mdi mdi-pencil"></i></a>

                    <a href="${detailUrl}" class="btn btn-sm btn-secondary" target="_blank">
                        <i class="mdi mdi-eye"></i>
                    </a>
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
            paging: false,          // Hilangkan pagination
            searching: false,       // Hilangkan search
            info: false,            // Hilangkan info entries
            ordering: true
        });

        let expandedRows = new Set();

        function toggleRow(tr, row) {
            let td = tr.find('td.details-control');
            let isShown = row.child.isShown();
            let id = tr.data('id');

            if(isShown) {
                $('div.slider', row.child()).slideUp(300,function(){ 
                    row.child.hide(); 
                    tr.removeClass('shown'); 
                    td.text('▶️'); 
                    expandedRows.delete(id); 
                });
            } else {
                let riwayat = base64ToJson(tr.attr('data-riwayat'));
                row.child('<div class="slider">'+formatRiwayat(riwayat)+'</div>', 'p-0').show();
                tr.addClass('shown'); td.text('▼'); $('div.slider', row.child()).slideDown(300); expandedRows.add(id);
            }
        }

        $('#taskTable tbody').on('click','td.details-control',function(){
            let tr = $(this).closest('tr'); 
            let row = table.row(tr); 
            toggleRow(tr,row);
        });

        $('#collapseAll').on('click',function(){
            $('#taskTable tbody tr.shown').each(function(){ toggleRow($(this), table.row(this)); });
        });
    });
</script>
@endsection