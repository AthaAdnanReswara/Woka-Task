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

        <!-- Tambahkan enctype untuk upload foto -->
        <form action="{{ route('admin.developer.store') }}" method="POST" enctype="multipart/form-data" class="p-4">
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

            <!-- Foto Profil -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Foto Profil</label>

                <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewImage(event)">

                @error('foto')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <!-- Preview gambar -->
                <div class="mt-3">
                    <img id="preview" src="#" alt="Preview Foto" class="rounded shadow-sm d-none" width="120">
                </div>
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

<!-- Script Preview Foto -->
<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('preview');
        output.src = reader.result;
        output.classList.remove('d-none');
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection
