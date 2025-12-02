@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-pencil-square text-warning"></i> Edit Project Member
            </h3>
            <small class="text-secondary">Perbarui anggota yang terdaftar dalam project</small>
        </div>
    </div>

    <!-- Card Form -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-secondary text-white fw-bold">
            <i class="bi bi-people"></i> Form Edit Member
        </div>
        @if (session('error'))
        <h3 class="text-danger">{{ session('error') }}</h3>
        @endif
        <div class="card-body">
            <form action="{{ route('PM.anggota.update', $member->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Project Name (Readonly) -->
                <div class="mb-3">
                    <label class="fw-semibold">Nama Project</label>
                    <input type="text" class="form-control" value="{{ $member->project->name }}" readonly>
                </div>

                <!-- Select User -->
                <div class="mb-3">
                    <label class="fw-semibold">User/Member</label>
                    <select name="user_id" id="userSelect" class="form-select text-black" required>
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $u)
                        <option value="{{ $u->id }}"
                            {{ $u->id == $member->user_id ? 'selected' : '' }}>
                            {{ $u->name }} ({{ $u->email }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Button -->
                <div class="text-end mt-4">

                    <a href="{{ route('PM.anggota.index') }}"
                        class="btn btn-outline-secondary rounded-pill px-3 shadow-sm">
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



@endsection