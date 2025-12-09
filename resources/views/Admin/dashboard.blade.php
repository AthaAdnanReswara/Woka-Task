@extends('layout.app')

@section('content')

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="mb-4 p-4" style="background: linear-gradient(90deg, #ff7eb9, #7ac1ff); border-radius:12px; color:white;">
        <h3 class="fw-bold mb-1">Dashboard Admin</h3>
        <small>Ringkasan performa dan aktivitas terbaru</small>
    </div>

    <!-- STAT CARDS -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="p-4 text-center text-white" style="border-radius:18px; background: linear-gradient(135deg,#1e3c72,#b1bccfff); box-shadow:0 4px 14px rgba(0,0,0,0.15);">
                <h6>Total Users</h6>
                <h3 class="fw-bold">{{ $totalUser }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-4 text-center text-white" style="border-radius:18px; background: linear-gradient(135deg,#ff7eb9,#7ac1ff); box-shadow:0 4px 14px rgba(0,0,0,0.15);">
                <h6>Total Projects</h6>
                <h3 class="fw-bold">{{ $totalProject }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-4 text-center text-white" style="border-radius:18px; background: linear-gradient(135deg,#7ac1ff,#1e3c72); box-shadow:0 4px 14px rgba(0,0,0,0.15);">
                <h6>Total Tasks</h6>
                <h3 class="fw-bold">{{ $totalTask }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-4 text-center text-white" style="border-radius:18px; background: linear-gradient(135deg,#ff7eb9,#b1bccfff); box-shadow:0 4px 14px rgba(0,0,0,0.15);">
                <h6>Developers</h6>
                <h3 class="fw-bold">{{ $totalDeveloper }}</h3>
            </div>
        </div>
    </div>

    <!-- USERS TABLE -->
    <div class="card shadow-sm border-0">
        <div class="card-header" style="background:#1e3c72; color:white; border-radius:8px 8px 0 0;">
            <strong>Recent Users</strong>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="bg-gradient" style="background: linear-gradient(90deg,#ff7eb9,#7ac1ff); color:white;">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Register Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($recentUsers) && $recentUsers->count() > 0)
                            @foreach($recentUsers as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role == 'admin')
                                            <span class="badge bg-danger">Admin</span>
                                        @elseif($user->role == 'PM')
                                            <span class="badge bg-success">PM</span>
                                        @elseif($user->role == 'developer')
                                            <span class="badge bg-info">Developer</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $user->role }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center text-muted">No users found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection
