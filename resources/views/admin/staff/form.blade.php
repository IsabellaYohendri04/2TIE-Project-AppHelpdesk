@csrf

<div class="mb-3">
  <label class="form-label">Username</label>
  <input type="text" name="name" class="form-control" value="{{ old('name', isset($staff) ? $staff->name : '') }}" required>
</div>

<div class="mb-3">
  <label class="form-label">Email</label>
  <input type="email" name="email" class="form-control" value="{{ old('email', isset($staff) ? $staff->email : '') }}" required>
</div>

<div class="row">
  <div class="col-md-6 mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control" {{ isset($staff) ? '' : 'required' }}>
    @if(isset($staff))
      <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
    @endif
  </div>
  <div class="col-md-6 mb-3">
    <label class="form-label">Konfirmasi Password</label>
    <input type="password" name="password_confirmation" class="form-control" {{ isset($staff) ? '' : 'required' }}>
  </div>
</div>

<div class="d-flex justify-content-between mt-3">
  <a href="{{ route('admin.staff.index') }}" class="btn btn-light">
    <i class="ti ti-arrow-left me-1"></i> Kembali
  </a>
  <button type="submit" class="btn btn-primary">
    <i class="ti ti-device-floppy me-1"></i> Simpan
  </button>
</div>


