@extends('layout.app')

@section('content')
<div class="pc-container">
  <div class="pc-content">

    <div class="row mb-3">
      <div class="col">
        <h3 class="mb-1">Manajemen User Staf Helpdesk</h3>
        <p class="text-muted mb-0">Kelola akun staf yang menangani tiket helpdesk IT.</p>
      </div>
      <div class="col-auto">
        <a href="{{ route('admin.staff.create') }}" class="btn btn-primary">
          <i class="ti ti-plus me-1"></i> Tambah User Staf
        </a>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ti ti-check me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <!-- Search & Filter -->
    <form method="GET" action="{{ route('admin.staff.index') }}" class="row g-3 mb-3">
      <div class="col-md-6">
        <label class="form-label">Cari Username</label>
        <input type="text" name="search" class="form-control"
               value="{{ request('search') }}" placeholder="Masukkan username">
      </div>
      <div class="col-md-4">
        <label class="form-label">Filter Kategori</label>
        <select name="category_id" class="form-select">
          <option value="">Semua Kategori</option>
          @foreach($categories as $category)
            <option value="{{ $category->id }}"
              {{ request('category_id') == $category->id ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-primary me-2">
          <i class="ti ti-search me-1"></i> Cari
        </button>
        <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">
          <i class="ti ti-refresh me-1"></i> Reset
        </a>
      </div>
    </form>

    <div class="card">
      <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th style="width:60px">No</th>
              
              <th>Username</th>
              <th>Email</th>
              <th>Kategori</th>
              <th>Jumlah Jobdesk</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($staffUsers as $staff)
              <tr>
                <!-- NOMOR OTOMATIS LANJUT PER HALAMAN -->
                <td class="fw-semibold">
                  {{ $staffUsers->firstItem() + $loop->index }}
                </td>
                <td>{{ $staff->name }}</td>
                <td>{{ $staff->email }}</td>
                <td>
                  @forelse($staff->categories as $cat)
                    <span class="badge bg-light text-dark">{{ $cat->name }}</span>
                  @empty
                    <span class="text-muted">-</span>
                  @endforelse
                </td>
                <td>
                  <span class="badge bg-primary">
                    {{ $staff->tickets_handled_count }} tiket
                  </span>
                </td>
                <td class="text-end">
                  <div class="btn-group">
                    <a href="{{ route('admin.staff.edit', $staff) }}"
                       class="btn btn-sm btn-outline-primary">
                      <i class="ti ti-edit"></i>
                    </a>
                    <button type="button"
                            class="btn btn-sm btn-outline-danger btn-delete-staff"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteStaffModal"
                            data-staff-id="{{ $staff->id }}"
                            data-staff-name="{{ $staff->name }}">
                      <i class="ti ti-trash"></i>
                    </button>
                    <form id="delete-staff-form-{{ $staff->id }}"
                          action="{{ route('admin.staff.destroy', $staff) }}"
                          method="POST" class="d-none">
                      @csrf
                      @method('DELETE')
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center text-muted">
                  Belum ada user staf.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>

        <!-- PAGINATION KANAN BAWAH -->
        <div class="mt-3 d-flex justify-content-end">
          {{ $staffUsers->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>

      </div>
    </div>

  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteStaffModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close btn-close-white"
                data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p>Yakin ingin menghapus user <strong id="delete-staff-name"></strong>?</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-danger" id="delete-staff-confirm-btn">Hapus</button>
      </div>
    </div>
  </div>
</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', () => {
  let staffId = null;
  document.querySelectorAll('.btn-delete-staff').forEach(btn => {
    btn.onclick = () => {
      staffId = btn.dataset.staffId;
      document.getElementById('delete-staff-name').textContent =
        btn.dataset.staffName;
    };
  });
  document.getElementById('delete-staff-confirm-btn').onclick = () => {
    if (staffId) document.getElementById('delete-staff-form-' + staffId).submit();
  };
});
</script>
@endpush

@endsection
