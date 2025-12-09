@extends('layout.app')

@section('content')

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4"
         style="background: linear-gradient(90deg,#ff7eb9,#7ac1ff);
                border-radius:12px; padding:20px; color:white;">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-speedometer2"></i> Dashboard Admin
            </h3>
            <small>Ringkasan data keseluruhan sistem</small>
        </div>
    </div>

<!-- STAT CARDS -->
<div class="row mb-4">

    <!-- Total Users -->
    <div class="col-md-3 mb-3">
        <div class="p-4 text-center text-white"
             style="border-radius:18px; 
                    background: linear-gradient(135deg,#1e3c72,#b1bccf); 
                    box-shadow:0 4px 14px rgba(0,0,0,0.15);">
            <h6>Total Users</h6>
            <h3 class="fw-bold">{{ $totalUser }}</h3>
        </div>
    </div>

    <!-- Total Developers -->
    <div class="col-md-3 mb-3">
        <div class="p-4 text-center text-white"
             style="border-radius:18px; 
                    background: linear-gradient(135deg,#7ac1ff,#ff7eb9); 
                    box-shadow:0 4px 14px rgba(0,0,0,0.15);">
            <h6>Total Developers</h6>
            <h3 class="fw-bold">{{ $totalDevelopers }}</h3>
        </div>
    </div>

    <!-- Total Projects -->
    <div class="col-md-3 mb-3">
        <div class="p-4 text-center text-white"
             style="border-radius:18px; 
                    background: linear-gradient(135deg,#ff7eb9,#1e3c72); 
                    box-shadow:0 4px 14px rgba(0,0,0,0.15);">
            <h6>Total Projects</h6>
            <h3 class="fw-bold">{{ $totalProjects }}</h3>
        </div>
    </div>

    <!-- Total Tasks -->
    <div class="col-md-3 mb-3">
        <div class="p-4 text-center text-white"
             style="border-radius:18px; 
                    background: linear-gradient(135deg,#7ac1ff,#b1bccf); 
                    box-shadow:0 4px 14px rgba(0,0,0,0.15);">
            <h6>Total Tasks</h6>
            <h3 class="fw-bold">{{ $totalTasks }}</h3>
        </div>
    </div>

</div>

    <!-- RECENT USERS TABLE -->
    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        <div class="card-header fw-bold"
             style="background:#1e3c72; color:white; border-radius:8px 8px 0 0;">
            <i class="bi bi-people"></i> Recent Users
        </div>

        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light small text-primary text-uppercase">
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Register Date</th>
                    </tr>
                </thead>
                <tbody class="small">

                    <tr class="table-row-hover">
                        <td>1.</td>
                        <td class="fw-semibold text-dark">Deva</td>
                        <td>deva@example.com</td>
                        <td><span class="badge bg-danger">Admin</span></td>
                        <td>2025-11-20</td>
                    </tr>

                    <tr class="table-row-hover">
                        <td>2.</td>
                        <td class="fw-semibold text-dark">Rizky</td>
                        <td>rizky@example.com</td>
                        <td><span class="badge bg-success">PM</span></td>
                        <td>2025-11-18</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- HOVER + STYLE -->
<style>
.table-row-hover:hover {
    background: rgba(0,0,0,0.05);
    transform: scale(1.005);
    transition: 0.15s;
}
</style>

@endsection
