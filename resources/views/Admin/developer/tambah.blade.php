@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-person-plus"></i> Tambah Developer
            </h5>
        </div>

        @if (session('success'))
        <div class="alert alert-success small shadow-sm">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
        @elseif (session('error'))
        <div class="alert alert-danger small shadow-sm">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('admin.developer.store') }}" method="POST" class="p-4">
            @csrf

            <!-- Nama -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap...">
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email...">
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password...">
                
            </div>

            <!-- Submit -->
            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('admin.developer.index') }}" class="btn btn-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection