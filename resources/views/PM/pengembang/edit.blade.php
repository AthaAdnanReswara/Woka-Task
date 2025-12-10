@extends('layout.app')
@section('title', 'edit developer')
@section('content')
<div class="container-fluid py-4">

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-pencil-square"></i> Edit Developer
            </h5>
        </div>

        <form action="{{ route('PM.pengembang.update', $pengembang->id) }}" method="POST" class="p-4" enctype="multipart/form-data">
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

            <!-- Foto Profil -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Foto Profil</label>
                <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewImage(event)">
                @error('foto')
                <small class="text-danger">{{ $message }}</small>
                @enderror

                <!-- Foto lama -->
                <div class="mt-3">
                    @if($pengembang->profile && $pengembang->profile->foto)
                    <img src="{{ asset('storage/' . $pengembang->profile->foto) }}"alt="Foto Lama" width="120"
                        class="rounded shadow-sm mb-2" id="fotoLama">
                    @else
                    <p class="text-muted">Tidak ada foto sebelumnya.</p>
                    @endif

                    <!-- Preview foto baru -->
                    <img id="preview" src="#" class="rounded shadow-sm d-none" width="120">
                </div>
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

<!-- Script Preview Foto -->
<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        let preview = document.getElementById('preview');
        let oldPhoto = document.getElementById('fotoLama');

        preview.src = reader.result;
        preview.classList.remove('d-none');

        if (oldPhoto) {
            oldPhoto.classList.add('d-none');
        }
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
