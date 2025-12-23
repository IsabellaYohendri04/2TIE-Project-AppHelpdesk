@extends('layout.app')

@section('content')
<div class="pc-container">
  <div class="pc-content">

    <div class="row mb-3">
      <div class="col">
        <h3 class="mb-1">Manajemen Kategori</h3>
        <p class="text-muted mb-0">Kategori tiket dan staf (khusus Admin).</p>
      </div>
      <div class="col-auto">
        <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
          <i class="ti ti-plus me-1"></i> Tambah Kategori
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
              <th>Nama Kategori</th>
              <th>Keterangan</th>
              <th>Jumlah Staf</th>
              <th>Jumlah Tiket</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categories as $category)
              <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description ?? '-' }}</td>
                <td>
                  <button
                    type="button"
                    class="btn btn-sm btn-outline-primary btn-staff-pop"
                    data-bs-toggle="modal"
                    data-bs-target="#staffCategoryModal"
                    data-category-id="{{ $category->id }}"
                    data-category-name="{{ $category->name }}"
                    data-staff-url="{{ route('admin.category.staffs', $category) }}"
                  >
                    {{ $category->users_count }} staf
                  </button>
                </td>
                <td>
                  <span class="badge bg-secondary">{{ $category->tickets_count }} tiket</span>
                </td>
                <td class="text-end">
                  <div class="btn-group">
                    <a href="{{ route('admin.category.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                      <i class="ti ti-edit"></i>
                    </a>
                    <button
                      type="button"
                      class="btn btn-sm btn-outline-danger btn-delete-category"
                      data-bs-toggle="modal"
                      data-bs-target="#deleteCategoryModal"
                      data-category-id="{{ $category->id }}"
                      data-category-name="{{ $category->name }}"
                    >
                      <i class="ti ti-trash"></i>
                    </button>
                    <form id="delete-category-form-{{ $category->id }}" action="{{ route('admin.category.destroy', $category) }}" method="POST" class="d-none">
                      @csrf
                      @method('DELETE')
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted">Belum ada kategori.</td>
              </tr>
            @endforelse
          </tbody>
        </table>

        <div class="mt-3">
          {{ $categories->links() }}
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Modal daftar staf per kategori -->
<div class="modal fade" id="staffCategoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">
          <i class="ti ti-users me-1"></i> Staf pada Kategori: <span id="staff-cat-name"></span>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="staff-cat-list" class="list-group">
          <div class="text-center text-muted py-2">Memuat...</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi Hapus Kategori -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">
          <i class="ti ti-alert-triangle me-1"></i> Konfirmasi Hapus Kategori
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center py-4">
        <i class="ti ti-trash fs-1 text-danger mb-3"></i>
        <h5>Apakah Anda yakin ingin menghapus kategori ini?</h5>
        <p class="text-muted">
          Kategori: <span id="delete-category-name" class="fw-semibold"></span><br>
          Tindakan ini tidak dapat dibatalkan.
        </p>
      </div>

      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
          Batal
        </button>
        <button type="button" class="btn btn-danger px-4" id="delete-category-confirm-btn">
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
    if (loader) loader.style.display = 'none';

    const modal = document.getElementById('staffCategoryModal');
    const nameSpan = document.getElementById('staff-cat-name');
    const listContainer = document.getElementById('staff-cat-list');

    document.querySelectorAll('.btn-staff-pop').forEach(btn => {
      btn.addEventListener('click', function () {
        const categoryId = this.getAttribute('data-category-id');
        const categoryName = this.getAttribute('data-category-name');
        nameSpan.textContent = categoryName;
        listContainer.innerHTML = '<div class="text-center text-muted py-2">Memuat...</div>';

        const url = this.getAttribute('data-staff-url');
        fetch(url, {
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
          },
        })
          .then(res => {
            const contentType = res.headers.get('content-type') || '';
            if (!res.ok || !contentType.includes('application/json')) {
              throw new Error('Gagal memuat staf');
            }
            return res.json();
          })
          .then(data => {
            if (!data || data.length === 0) {
              listContainer.innerHTML = '<div class="text-center text-muted py-2">Belum ada staf di kategori ini.</div>';
              return;
            }
            let html = '';
            data.forEach(staff => {
              html += `
                <div class="list-group-item d-flex justify-content-between align-items-center">
                  <div>
                    <div class="fw-semibold">${staff.name}</div>
                    <small class="text-muted">${staff.email}</small>
                  </div>
                  <span class="badge bg-light text-dark">ID: ${staff.id}</span>
                </div>
              `;
            });
            listContainer.innerHTML = html;
          })
          .catch((err) => {
            console.error(err);
            listContainer.innerHTML = '<div class="text-center text-danger py-2">Gagal memuat data.</div>';
          });
      });
    });

    // JavaScript untuk modal hapus kategori
    let categoryIdToDelete = null;
    const categoryNameSpan = document.getElementById('delete-category-name');
    const confirmCategoryBtn = document.getElementById('delete-category-confirm-btn');

    document.querySelectorAll('.btn-delete-category').forEach(function (btn) {
      btn.addEventListener('click', function () {
        categoryIdToDelete = this.getAttribute('data-category-id');
        const name = this.getAttribute('data-category-name');
        if (categoryNameSpan) {
          categoryNameSpan.textContent = name;
        }
      });
    });

    if (confirmCategoryBtn) {
      confirmCategoryBtn.addEventListener('click', function () {
        if (!categoryIdToDelete) return;
        const form = document.getElementById('delete-category-form-' + categoryIdToDelete);
        if (form) {
          form.submit();
        }
      });
    }
  });
</script>
@endpush

@endsection