@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-pencil-square"></i> Edit Developer
            </h5>
        </div>

        <form action="{{ route('PM.pengembang.update', $pengembang->id) }}" method="POST" class="p-4">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $pengembang->name) }}" class="form-control " placeholder="Masukkan nama lengkap...">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" value="{{ old('email', $pengembang->email) }}" class="form-control " placeholder="Masukkan email...">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password Baru (Opsional) -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Password (Opsional)</label>
                <input type="password" name="password" class="form-control"placeholder="Isi jika ingin mengganti password">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                @error('password')
                    <small class="text-danger d-block">{{ $message }}</small>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('PM.pengembang.index') }}" class="btn btn-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-warning text-white">
                    <i class="bi bi-save"></i> Update
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
