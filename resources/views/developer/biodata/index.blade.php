@extends('layout.app')

@section('content')
<div class="container py-4">

    <div class="card shadow-sm border-0">
        <div class="card-body text-center">

            {{-- ALERT --}}
            @if (session('success'))
            <div class="alert alert-success small shadow-sm">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
            </div>
            @elseif (session('error'))
            <div class="alert alert-danger small shadow-sm">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            </div>
            @endif

            {{-- FOTO --}}
            <img src="{{ $profile->foto ? asset('storage/'.$profile->foto) : 'https://via.placeholder.com/150' }}"
                style="width:150px; height:150px; object-fit:cover; object-position:top; border-radius:50%;"class="mb-3"alt="Foto Profil">

            <h4>{{ $user->name }}</h4>
            <p class="text-muted">{{ $user->email }}</p>

            <hr>

            <div class="text-start px-5">
                <p><strong>Nama:</strong> {{ $profile->user->name ?? '-' }}</p>
                <p><strong>Alamat:</strong> {{ $profile->alamat ?? '-' }}</p>
                <p><strong>Bio:</strong> {{ $profile->bio ?? '-' }}</p>
                <p><strong>Tempat Lahir:</strong> {{ $profile->tempat_lahir ?? '-' }}</p>
                <p><strong>Tanggal Lahir:</strong> {{ $profile->tanggal_lahir ?? '-' }}</p>
                <p><strong>Gender:</strong> {{ ucfirst($profile->gender ?? '-') }}</p>
                <p><strong>No HP:</strong> {{ $profile->no_hp ?? '-' }}</p>
            </div>

            <button class="btn btn-dark mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                Edit Profile
            </button>

        </div>
    </div>

</div>

{{-- ========================= MODAL EDIT ========================= --}}
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('developer.biodata.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    <div class="row">

                        {{-- FOTO --}}
                        <div class="col-md-4 text-center mb-3">
                            <img
                                src="{{ $profile->foto ? asset('storage/'.$profile->foto) : 'https://via.placeholder.com/120' }}"
                                class="rounded mb-3"
                                width="120">
                            <input type="file" name="foto" class="form-control">
                        </div>

                        <div class="col-md-8">

                            {{-- USER DATA --}}
                            <h5 class="mb-3">Akun User</h5>

                            <div class="mb-3">
                                <label>Nama</label>
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Password Baru (opsional)</label>
                                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diganti">
                            </div>

                            <hr>

                            {{-- PROFILE DATA --}}
                            <h5 class="mt-4 mb-3">Detail Profil</h5>

                            <div class="mb-3">
                                <label>No HP</label>
                                <input type="text" name="no_hp" class="form-control" value="{{ $profile->no_hp }}">
                            </div>

                            <div class="mb-3">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control">{{ $profile->alamat }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label>Bio</label>
                                <textarea name="bio" class="form-control">{{ $profile->bio }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label>Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control"
                                    value="{{ $profile->tempat_lahir }}">
                            </div>

                            <div class="mb-3">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control"
                                    value="{{ $profile->tanggal_lahir }}">
                            </div>

                            <div class="mb-3">
                                <label>Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="laki-laki" {{ $profile->gender == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="perempuan" {{ $profile->gender == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    <option value="tidak diketahui" {{ $profile->gender == 'tidak diketahui' ? 'selected' : '' }}>Tidak Diketahui</option>
                                </select>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-dark">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>


@endsection