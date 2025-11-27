@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-pencil-square text-warning"></i> Edit Task
            </h3>
            <small class="text-secondary">Perbarui informasi task</small>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-secondary text-white fw-bold">
            <i class="bi bi-kanban"></i> Form Edit Task
        </div>

        <div class="card-body">
            <form action="{{ route('admin.task.update',$task->id) }}" method="POST">
                @csrf
                @method("PUT")

                <!-- PROJECT -->
                <div class="mb-3">
                    <label class="fw-semibold">Project</label>
                    <select name="project_id" class="form-select" required>
                        @foreach($projects as $p)
                            <option value="{{ $p->id }}" {{ $task->project_id == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- DEVELOPER -->
                <div class="mb-3">
                    <label class="fw-semibold">Assign Ke</label>
                    <select name="assigned_to" id="selectUser" class="form-select" required>
                        @foreach($developers as $d)
                            <option value="{{ $d->id }}" {{ $task->assigned_to == $d->id ? 'selected' : '' }}>
                                {{ $d->name }} - {{ $d->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- JUDUL -->
                <div class="mb-3">
                    <label class="fw-semibold">Judul Task</label>
                    <input type="text" class="form-control" name="judul_task"
                           value="{{ old('judul_task',$task->judul_task) }}" required>
                </div>

                <!-- DESKRIPSI -->
                <div class="mb-3">
                    <label class="fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="form-control">{{ old('deskripsi',$task->deskripsi) }}</textarea>
                </div>

                <!-- KESULITAN -->
                <div class="mb-3">
                    <label class="fw-semibold">Tingkat Kesulitan</label>
                    <select name="kesulitan" class="form-select">
                        @foreach (['low'=>'Low','medium'=>'Medium','high'=>'High','critical'=>'Critical'] as $key=>$label)
                            <option value="{{ $key }}" {{ $key == $task->kesulitan ? 'selected':'' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- STATUS -->
                <div class="mb-3">
                    <label class="fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        @foreach ([
                            'rencana'=>'Rencana','sedang_dikerjakan'=>'Sedang Dikerjakan',
                            'tinjauan'=>'Tinjauan','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'
                        ] as $key=>$label)
                            <option value="{{ $key }}" {{ $key == $task->status ? 'selected':'' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="tanggal_mulai"
                               value="{{ $task->tanggal_mulai }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Tanggal Tenggat</label>
                        <input type="date" class="form-control" name="tanggal_tenggat"
                               value="{{ $task->tanggal_tenggat }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Estimasi (Jam)</label>
                        <input type="number" name="estimasi" class="form-control"
                               value="{{ $task->estimasi }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Progress (%)</label>
                        <input type="number" name="progress" min="0" max="100" class="form-control"
                               value="{{ $task->progress }}">
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.task.index') }}" class="btn btn-outline-dark rounded-pill px-3">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- SELECT2 --}}
@push('scripts')
<script>
    $(document).ready(function(){
        $('#selectUser').select2();
    });
</script>
@endpush

@endsection
