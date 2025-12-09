@extends('layout.app')

@section('title', 'Dashboard')
@section('content')
<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="mb-4 p-4" style="background: linear-gradient(90deg, #ff7eb9, #7ac1ff); border-radius:12px; color:white;">
        <h3 class="fw-bold mb-1">Dashboard Developer</h3>
        <small>Ringkasan performa dan tugas developer</small>
    </div>

    <!-- STAT CARDS -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="p-4 text-center text-white" style="border-radius:18px; background: linear-gradient(135deg,#1e3c72,#b1bccfff); box-shadow:0 4px 14px rgba(0,0,0,0.15);">
                <h6>Total Users</h6>
                <h3 class="fw-bold">{{ $totalUsers }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-4 text-center text-white" style="border-radius:18px; background: linear-gradient(135deg,#7ac1ff,#ff7eb9); box-shadow:0 4px 14px rgba(0,0,0,0.15);">
                <h6>Total Developers</h6>
                <h3 class="fw-bold">{{ $totalDevelopers }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-4 text-center text-white" style="border-radius:18px; background: linear-gradient(135deg,#ff7eb9,#1e3c72); box-shadow:0 4px 14px rgba(0,0,0,0.15);">
                <h6>Total Projects</h6>
                <h3 class="fw-bold">{{ $totalProjects }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-4 text-center text-white" style="border-radius:18px; background: linear-gradient(135deg,#7ac1ff,#b1bccfff); box-shadow:0 4px 14px rgba(0,0,0,0.15);">
                <h6>Total Tasks</h6>
                <h3 class="fw-bold">{{ $totalTasks }}</h3>
            </div>
        </div>
    </div>

    <!-- DEVELOPER JOBS TABLE -->
    <div class="card shadow-sm border-0">
        <div class="card-header" style="background:#1e3c72; color:white; border-radius:8px 8px 0 0;">
            <h5 class="mb-0">Developer Jobs</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="jobsTable" class="table table-hover mb-0">
                    <thead class="bg-gradient" style="background: linear-gradient(90deg,#ff7eb9,#7ac1ff); color:white;">
                        <tr>
                            <th>Developer</th>
                            <th>Project</th>
                            <th>Task</th>
                            <th class="text-center">Progress</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tasks as $task)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="/assets/images/faces/face1.jpg" alt="" style="width:40px;height:40px;border-radius:50%;margin-right:10px;">
                                    <div>
                                        <h6 class="mb-0">{{ $task->developer->name ?? 'No Developer' }}</h6>
                                        <small>Developer</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h6 class="mb-0">{{ $task->project->name ?? 'No Project' }}</h6>
                                <small>Project</small>
                            </td>
                            <td>
                                <h6 class="mb-0">{{ $task->name }}</h6>
                                <small>Task Detail</small>
                            </td>
                            <td class="text-center">
                                <div>
                                    <div class="progress progress-md" style="height:10px; border-radius:10px;">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ $task->progress }}%; 
                                            background: linear-gradient(90deg,#ff7eb9,#7ac1ff);">
                                        </div>
                                    </div>
                                    <small>{{ $task->progress }}%</small>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($task->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($task->status == 'in_progress')
                                    <span class="badge bg-info text-white">In Progress</span>
                                @elseif($task->status == 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @else
                                    <span class="badge bg-secondary">{{ $task->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No tasks available.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $('#jobsTable').DataTable({
            paging: false,      // Hilangkan pagination
            searching: false,   // Hilangkan search
            info: false,        // Hilangkan info entries
            ordering: true
        });
    });
</script>
@endsection
