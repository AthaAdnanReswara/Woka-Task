@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Header Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-person-plus-fill text-primary"></i> Tambah Member Proyek
            </h3>
            <small class="text-secondary">Pilih proyek & user untuk ditambahkan sebagai anggota</small>
        </div>


    </div>

    <!-- Alert -->
    @if(session('error'))
    <div class="alert alert-danger small shadow-sm"><i class="bi bi-exclamation-circle"></i> {{ session('error') }}</div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger small shadow-sm">
        <strong><i class="bi bi-x-circle"></i> Terdapat kesalahan!</strong>
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form Container -->
    <div class="card border-0 shadow-sm rounded-3" style="max-width:650px; margin:auto;">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-people-fill"></i> Form Tambah Member Proyek
        </div>

        <div class="card-body p-4">

            <form action="{{ route('PM.anggota.store') }}" method="POST">
                @csrf

                <!-- Project -->
                <div class="mb-3">
                    <label class="fw-semibold mb-1">Pilih Proyek</label>
                    <select name="project_id" class="form-select text-black" >
                        <option value="">-- Pilih Project --</option>
                        @foreach($projects as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('project_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <!-- User -->
                <div class="mb-4">
                    <label class="fw-semibold mb-1">Pilih Member/User</label>
                    <select name="user_id" class="form-select text-black" >
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                        @endforeach
                    </select>
                </div>
                @error('user_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <a href="{{ route('PM.anggota.index') }}" class="btn btn-secondary shadow-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">
                    <i class="bi bi-check-circle-fill"></i> Simpan Member
                </button>
            </form>

        </div>
    </div>

</div>
@endsection