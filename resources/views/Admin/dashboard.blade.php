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
    <div class="row">
        <div class="col-sm-12">
            <div class="home-tab">
                <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                        <div class="row">
                            <div class="col-lg-8 d-flex flex-column">
                                <div class="row flex-grow">
                                    <div class="col-12 grid-margin stretch-card">
                                        <div class="card card-rounded">
                                            <div class="card-body">
                                                <div class="d-sm-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h4 class="card-title card-title-dash">Project </h4>
                                                        <p class="card-subtitle card-subtitle-dash">Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                                                    </div>
                                                    <div>
                                                        <div class="dropdown">
                                                            <button class="btn btn-light dropdown-toggle toggle-dark btn-lg mb-0 me-0" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> This month </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                                <h6 class="dropdown-header">Settings</h6>
                                                                <a class="dropdown-item" href="#">Action</a>
                                                                <a class="dropdown-item" href="#">Another action</a>
                                                                <a class="dropdown-item" href="#">Something else here</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" href="#">Separated link</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                                    <div class="d-sm-flex align-items-center mt-4 justify-content-between">
                                                        <h2 class="me-2 fw-bold">$36,2531.00</h2>
                                                        <h4 class="me-2">USD</h4>
                                                        <h4 class="text-success">(+1.37%)</h4>
                                                    </div>
                                                    <div class="me-3">
                                                        <div id="marketingOverview-legend"></div>
                                                    </div>
                                                </div>
                                                <div class="chartjs-bar-wrapper mt-3">
                                                    <canvas id="marketingOverview"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row flex-grow">
                                    <div class="col-12 grid-margin stretch-card">
                                        <div class="card card-rounded">
                                            <div class="card-body">
                                                <div class="d-sm-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h4 class="card-title card-title-dash">Developer</h4>
                                                        <p class="card-subtitle card-subtitle-dash">You have 50+ new requests</p>
                                                    </div>
                                                    <div>
                                                        <button class="btn btn-primary btn-lg text-white mb-0 me-0" type="button"><i class="mdi mdi-account-plus"></i>Add new member</button>
                                                    </div>
                                                </div>
                                                <div class="table-responsive  mt-1">
                                                    <table class="table select-table">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <div class="form-check form-check-flat mt-0">
                                                                        <label class="form-check-label">
                                                                            <input type="checkbox" class="form-check-input" aria-checked="false" id="check-all"><i class="input-helper"></i></label>
                                                                    </div>
                                                                </th>
                                                                <th>Developer</th>
                                                                <th>Company</th>
                                                                <th>Progress</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ( $developers as $dev )

                                                            <tr>
                                                                <td>
                                                                    <div class="form-check form-check-flat mt-0">
                                                                        <label class="form-check-label">
                                                                            <input type="checkbox" class="form-check-input" aria-checked="false"><i class="input-helper"></i></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex ">
                                                                        <img src="{{ $dev->profile?->foto ? asset('storage/' . $dev->profile->foto) : '' }}" alt="">
                                                                        <div>
                                                                            <h6>{{ $dev->name }}</h6>
                                                                            <p>{{ $dev->email }}</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <h6>Company name 1</h6>
                                                                    <p>company type</p>
                                                                </td>
                                                                <td>
                                                                    <div>
                                                                        <div class="d-flex justify-content-between align-items-center mb-1 max-width-progress-wrap">
                                                                            <p class="text-success">79%</p>
                                                                            <p>85/162</p>
                                                                        </div>
                                                                        <div class="progress progress-md">
                                                                            <div class="progress-bar bg-success" role="progressbar" style="width: 85%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="badge badge-opacity-warning">In progress</div>
                                                                </td>
                                                            </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 d-flex flex-column">
                                <div class="row flex-grow">
                                    <div class="col-12 grid-margin stretch-card">
                                        <div class="card card-rounded">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h4 class="card-title card-title-dash">Todo list</h4>
                                                            <div class="add-items d-flex mb-0">
                                                                <!-- <input type="text" class="form-control todo-list-input" placeholder="What do you need to do today?"> -->
                                                                <button class="add btn btn-icons btn-rounded btn-primary todo-list-add-btn text-white me-0 pl-12p"><i class="mdi mdi-plus"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="list-wrapper">
                                                            <ul class="todo-list todo-list-rounded">
                                                                <li class="d-block">
                                                                    <div class="form-check w-100">
                                                                        <label class="form-check-label">
                                                                            <input class="checkbox" type="checkbox"> Lorem Ipsum is simply dummy text of the printing <i class="input-helper rounded"></i>
                                                                        </label>
                                                                        <div class="d-flex mt-2">
                                                                            <div class="ps-4 text-small me-3">24 June 2020</div>
                                                                            <div class="badge badge-opacity-warning me-3">Due tomorrow</div>
                                                                            <i class="mdi mdi-flag ms-2 flag-color"></i>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="d-block">
                                                                    <div class="form-check w-100">
                                                                        <label class="form-check-label">
                                                                            <input class="checkbox" type="checkbox"> Lorem Ipsum is simply dummy text of the printing <i class="input-helper rounded"></i>
                                                                        </label>
                                                                        <div class="d-flex mt-2">
                                                                            <div class="ps-4 text-small me-3">23 June 2020</div>
                                                                            <div class="badge badge-opacity-success me-3">Done</div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="form-check w-100">
                                                                        <label class="form-check-label">
                                                                            <input class="checkbox" type="checkbox"> Lorem Ipsum is simply dummy text of the printing <i class="input-helper rounded"></i>
                                                                        </label>
                                                                        <div class="d-flex mt-2">
                                                                            <div class="ps-4 text-small me-3">24 June 2020</div>
                                                                            <div class="badge badge-opacity-success me-3">Done</div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="border-bottom-0">
                                                                    <div class="form-check w-100">
                                                                        <label class="form-check-label">
                                                                            <input class="checkbox" type="checkbox"> Lorem Ipsum is simply dummy text of the printing <i class="input-helper rounded"></i>
                                                                        </label>
                                                                        <div class="d-flex mt-2">
                                                                            <div class="ps-4 text-small me-3">24 June 2020</div>
                                                                            <div class="badge badge-opacity-danger me-3">Expired</div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row flex-grow">
                                    <div class="col-12 grid-margin stretch-card">
                                        <div class="card card-rounded">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <h4 class="card-title card-title-dash">Type By Amount</h4>
                                                        </div>
                                                        <div>
                                                            <canvas class="my-auto" id="doughnutChart"></canvas>
                                                        </div>
                                                        <div id="doughnutChart-legend" class="mt-5 text-center"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row flex-grow">
                                    <div class="col-12 grid-margin stretch-card">
                                        <div class="card card-rounded">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <div>
                                                                <h4 class="card-title card-title-dash">Leave Report</h4>
                                                            </div>
                                                            <div>
                                                                <div class="dropdown">
                                                                    <button class="btn btn-light dropdown-toggle toggle-dark btn-lg mb-0 me-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Month Wise </button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                                        <h6 class="dropdown-header">week Wise</h6>
                                                                        <a class="dropdown-item" href="#">Year Wise</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <canvas id="leaveReport"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row flex-grow">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection