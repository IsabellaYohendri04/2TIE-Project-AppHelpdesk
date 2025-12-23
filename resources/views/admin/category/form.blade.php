@csrf

<div class="mb-3">
  <label class="form-label">Nama Kategori</label>
  <input type="text" name="name" class="form-control" value="{{ old('name', isset($category) ? $category->name : '') }}" required>
</div>

<div class="mb-3">
  <label class="form-label">Keterangan</label>
  <textarea name="description" class="form-control" rows="3" placeholder="Opsional">{{ old('description', isset($category) ? $category->description : '') }}</textarea>
</div>

<div class="d-flex justify-content-between mt-3">
  <a href="{{ route('admin.category.index') }}" class="btn btn-light">
    <i class="ti ti-arrow-left me-1"></i> Kembali
  </a>
  <button type="submit" class="btn btn-primary">
    <i class="ti ti-device-floppy me-1"></i> Simpan
  </button>
</div>


