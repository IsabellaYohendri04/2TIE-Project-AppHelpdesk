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
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="card">
      <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Email</th>
              <th>Jumlah Jobdesk</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($staffUsers as $staff)
              <tr>
                <td>{{ $staff->id }}</td>
                <td>{{ $staff->name }}</td>
                <td>{{ $staff->email }}</td>
                <td>
                  <span class="badge bg-primary">
                    {{ $staff->tickets_handled_count }} tiket
                  </span>
                </td>
                <td class="text-end">
                  <div class="btn-group">
                    <a href="{{ route('admin.staff.edit', $staff) }}" class="btn btn-sm btn-outline-primary">
                      <i class="ti ti-edit"></i>
                    </a>
                    <button
                      type="button"
                      class="btn btn-sm btn-outline-danger btn-delete-staff"
                      data-bs-toggle="modal"
                      data-bs-target="#deleteStaffModal"
                      data-staff-id="{{ $staff->id }}"
                      data-staff-name="{{ $staff->name }}"
                    >
                      <i class="ti ti-trash"></i>
                    </button>
                    <form id="delete-staff-form-{{ $staff->id }}" action="{{ route('admin.staff.destroy', $staff) }}" method="POST" class="d-none">
                      @csrf
                      @method('DELETE')
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted">Belum ada user staf.</td>
              </tr>
            @endforelse
          </tbody>
        </table>

        <div class="mt-3">
          {{ $staffUsers->links() }}
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Modal Konfirmasi Hapus User Staf -->
<div class="modal fade" id="deleteStaffModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">
          <i class="ti ti-alert-triangle me-1"></i> Konfirmasi Hapus User Staf
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center py-4">
        <i class="ti ti-trash fs-1 text-danger mb-3"></i>
        <h5>Apakah Anda yakin ingin menghapus user staf ini?</h5>
        <p class="text-muted">
          User: <span id="delete-staff-name" class="fw-semibold"></span><br>
          Tindakan ini tidak dapat dibatalkan.
        </p>
      </div>

      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
          Batal
        </button>
        <button type="button" class="btn btn-danger px-4" id="delete-staff-confirm-btn">
          Ya, Hapus
        </button>
      </div>

    </div>
  </div>
</div>

@push('js')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const loader = document.querySelector('.loader-bg');
    if (loader) {
      loader.style.display = 'none';
    }

    let staffIdToDelete = null;
    const nameSpan = document.getElementById('delete-staff-name');
    const confirmBtn = document.getElementById('delete-staff-confirm-btn');

    document.querySelectorAll('.btn-delete-staff').forEach(function (btn) {
      btn.addEventListener('click', function () {
        staffIdToDelete = this.getAttribute('data-staff-id');
        const name = this.getAttribute('data-staff-name');
        if (nameSpan) {
          nameSpan.textContent = name;
        }
      });
    });

    if (confirmBtn) {
      confirmBtn.addEventListener('click', function () {
        if (!staffIdToDelete) return;
        const form = document.getElementById('delete-staff-form-' + staffIdToDelete);
        if (form) {
          form.submit();
        }
      });
    }
  });
</script>
@endpush

@endsection


