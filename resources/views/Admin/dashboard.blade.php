@extends('layout.app')

@section('title', 'Dashboard')
@section('content')

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="mb-4 p-4" style="background: linear-gradient(90deg, #ff7eb9, #7ac1ff); border-radius:12px; color:white;">
        <h3 class="fw-bold mb-1">Dashboard Admin</h3>
        <small>Ringkasan performa dan aktivitas terbaru</small>
    </div>

    <!-- STAT CARDS -->
    <div class="row mb-4">
        @php
            $stats = [
                ['label' => 'Total Users', 'value' => $totalUser, 'color' => 'linear-gradient(135deg,#1e3c72,#b1bccfff)'],
                ['label' => 'Total Projects', 'value' => $totalProject, 'color' => 'linear-gradient(135deg,#ff7eb9,#7ac1ff)'],
                ['label' => 'Total Tasks', 'value' => $totalTask, 'color' => 'linear-gradient(135deg,#7ac1ff,#1e3c72)'],
                ['label' => 'Developers', 'value' => $totalDeveloper, 'color' => 'linear-gradient(135deg,#ff7eb9,#b1bccfff)'],
            ];
        @endphp

        @foreach ($stats as $stat)
        <div class="col-md-3 mb-3">
            <div class="p-4 text-center text-white" style="border-radius:18px; background: {{ $stat['color'] }}; box-shadow:0 4px 14px rgba(0,0,0,0.15);">
                <h6>{{ $stat['label'] }}</h6>
                <h3 class="fw-bold">{{ $stat['value'] }}</h3>
            </div>
        </div>
        @endforeach
    </div>

    <!-- RECENT USERS TABLE -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header" style="background:#1e3c72; color:white; border-radius:8px 8px 0 0;">
            <strong>Recent Users</strong>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead style="background: linear-gradient(90deg,#ff7eb9,#7ac1ff); color:white;">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Register Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentUsers as $index => $user)
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
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No users found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="grid-margin stretch-card mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header" style="background:#1e3c72; color:white; border-radius:8px 8px 0 0;">
                <h5 class="mb-0">Developer Jobs</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: linear-gradient(90deg,#ff7eb9,#7ac1ff); color:white;">
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
                                        <img src="{{ $task->user->profile?->foto ? asset('storage/' . $task->user->profile->foto) : '/assets/images/faces/face1.jpg' }}"
                                            alt="" style="width:40px;height:40px;border-radius:50%;margin-right:10px;">
                                        <div>
                                            <h6 class="mb-0">{{ $task->user->name ?? 'No Developer' }}</h6>
                                            <small>Developer</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-0">{{ $task->project->name ?? 'No Project' }}</h6>
                                    <small>Project</small>
                                </td>
                                <td>
                                    <h6 class="mb-0">{{ $task->judul_task }}</h6>
                                    <small>Task Detail</small>
                                </td>
                                <td class="text-center">
                                    <div class="progress progress-md" style="height:10px; border-radius:10px;">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $task->progress }}%; background: linear-gradient(90deg,#ff7eb9,#7ac1ff);"></div>
                                    </div>
                                    <small>{{ $task->progress }}%</small>
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

    <!-- PROJECT & TOTAL BY ROLE -->
    <div class="row mb-4">
        <!-- PROJECT LIST -->
<div class="col-lg-8">
    <div class="card card-rounded mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h4 class="card-title card-title-dash">Projects</h4>
                    <p class="card-subtitle card-subtitle-dash">Daftar project aktif</p>
                </div>
            </div>

            <div class="row">
                @foreach($totalll as $project)
                <div class="col-md-6 mb-3">
                    <div class="card p-3 h-100" style="border-radius: 12px; background: rgba(122,193,255,0.1);">
                        <h6 class="fw-bold mb-2">{{ $project->name }}</h6>
                        @if($project->description)
                        <p class="mb-2 text-muted" style="font-size: 0.875rem;">{{ Str::limit($project->description, 60) }}</p>
                        @endif
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-info text-white">Project</span>
                            <small class="text-muted">{{ $project->created_at->format('d M Y') }}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</div>


        <!-- Total by Role Chart -->
        <div class="col-lg-4">
            <div class="card card-rounded mb-4">
                <div class="card-body">
                    <h4 class="card-title card-title-dash mb-3">Total by Role & Data</h4>
                    <canvas id="totalChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- CHART.JS SCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = ['Admin', 'Developer', 'Users', 'Projects', 'Tasks'];

        const data = {
            labels: labels,
            datasets: [{
                label: 'Jumlah',
                data: [
                    {{ $totalAdmin ?? 0 }},
                    {{ $totalDeveloper ?? 0 }},
                    {{ $totalUser ?? 0 }},
                    {{ $totalProject ?? 0 }},
                    {{ $totalTask ?? 0 }}
                ],
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF'
                ],
                hoverOffset: 10
            }]
        };

        const config = {
            type: 'doughnut',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.raw;
                            }
                        }
                    }
                }
            }
        };

        new Chart(document.getElementById('totalChart'), config);
    </script>
<!-- LIST TASK -->
<div class="card shadow-sm border-0 rounded-3 overflow-hidden mb-4">
    <div class="card-header fw-bold" 
         style="background:#1e3c72; color:white; border-radius:8px 8px 0 0;">
        <i class="bi bi-kanban"></i> Daftar Task Developer
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-primary small text-uppercase">
                    <tr>
                        <th>No</th>
                        <th>Developer</th>
                        <th>Project</th>
                        <th>Task</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Deadline</th>
                    </tr>
                </thead>

                <tbody class="small">
                    @forelse ($tasks as $index => $task)
                    <tr class="table-row-hover">

                        <!-- No -->
                        <td>{{ $index + 1 }}</td>

                        <!-- Developer -->
                        <td class="fw-semibold text-dark">
                            {{ $task->developer->name ?? 'Belum ada developer' }}
                        </td>

                        <!-- Project -->
                        <td>
                            {{ $task->project->nama_project ?? 'Tanpa Project' }}
                        </td>

                        <!-- Task Title -->
                        <td>
                            {{ $task->judul_task }}
                        </td>

                        <!-- Status -->
                        <td class="text-center">
                            <span class="badge 
                                @if($task->status == 'ongoing') bg-warning text-dark
                                @elseif($task->status == 'completed') bg-success
                                @elseif($task->status == 'revisi') bg-danger
                                @else bg-secondary
                                @endif
                            ">
                                {{ strtoupper($task->status) }}
                            </span>
                        </td>

                        <!-- Deadline -->
                        <td class="text-center">
                            @if ($task->tanggal_tenggat)
                                <span class="badge bg-secondary">
                                    {{ \Carbon\Carbon::parse($task->tanggal_tenggat)->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                    </tr>
                    @empty

                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Tidak ada task.
                        </td>
                    </tr>

                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

@endsection