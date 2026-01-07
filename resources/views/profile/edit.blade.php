@extends('layout.app')

@section('content')
<div class="pc-container">
  <div class="pc-content">

    <div class="row mb-3">
      <div class="col">
        <h3 class="mb-1">Profile Settings</h3>
        <p class="text-muted mb-0">Kelola informasi profile dan foto Anda.</p>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ti ti-check me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body text-center">
            <div class="mb-3">
              @php
                $profilePicture = $user->profile_picture 
                  ? \Illuminate\Support\Facades\Storage::url($user->profile_picture) 
                  : asset('assets/images/user/avatar-2.jpg');
              @endphp
              <img src="{{ $profilePicture }}" alt="Profile Picture" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #e9ecef;">
            </div>
            <h5 class="mb-1">{{ $user->name }}</h5>
            <p class="text-muted mb-2">{{ $user->email }}</p>
            <span class="badge bg-primary">
              @if($user->hasRole('admin'))
                Admin
              @elseif($user->hasRole('staff'))
                Staff
              @else
                User
              @endif
            </span>
            @if($user->profile_picture)
              <form action="{{ route('profile.picture.destroy') }}" method="POST" class="mt-3">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus foto profile?')">
                  <i class="ti ti-trash me-1"></i> Hapus Foto
                </button>
              </form>
            @endif
          </div>
        </div>
      </div>

      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <div class="mb-3">
                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Foto Profile</label>
                <input type="file" name="profile_picture" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif">
                <small class="text-muted">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB</small>
              </div>

              <hr class="my-4">

              <h5 class="mb-3">Ubah Password</h5>
              <p class="text-muted small">Kosongkan jika tidak ingin mengubah password</p>

              <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control" autocomplete="new-password">
                <small class="text-muted">Minimal 6 karakter</small>
              </div>

              <div class="mb-3">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
              </div>

              <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary">
                  <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@push('js')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const loader = document.querySelector('.loader-bg');
    if (loader) {
      loader.style.display = 'none';
    }

    // Preview image sebelum upload
    const fileInput = document.querySelector('input[name="profile_picture"]');
    if (fileInput) {
      fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            const img = document.querySelector('.card-body.text-center img');
            if (img) {
              img.src = e.target.result;
            }
          };
          reader.readAsDataURL(file);
        }
      });
    }
  });
</script>
@endpush
