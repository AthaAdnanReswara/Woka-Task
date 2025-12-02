@extends('layout.app')

@section('content')

<div class="container-fluid">

    <h3 class="fw-bold mb-4">Dashboard Admin</h3>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center">
                <h6>Total Users</h6>
                <h3 class="fw-bold text-primary"></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center">
                <h6>Total Projects</h6>
                <h3 class="fw-bold text-success"></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center">
                <h6>Tasks</h6>
                <h3 class="fw-bold text-warning"></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center">
                <h6>Developers</h6>
                <h3 class="fw-bold text-info"></h3>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <strong>Recent Users</strong>
        </div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Register Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1.</td>
                        <td>Deva</td>
                        <td>deva@example.com</td>
                        <td><span class="badge bg-danger">Admin</span></td>
                        <td>2025-11-20</td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td>Rizky</td>
                        <td>rizky@example.com</td>
                        <td><span class="badge bg-success">PM</span></td>
                        <td>2025-11-18</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection