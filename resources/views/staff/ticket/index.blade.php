@extends('layout.app')

@section('content')
<div class="pc-container">
  <div class="pc-content">

    <div class="row mb-3">
      <div class="col">
        @if(!empty($isAssignedView))
          <h3 class="mb-1">Tiket Ditugaskan ke Saya</h3>
          <p class="text-muted mb-0">Hanya tiket dengan penugasan langsung kepada Anda, diurutkan dengan prioritas status diproses.</p>
        @else
          <h3 class="mb-1">Tiket Keseluruhan</h3>
          <p class="text-muted mb-0">Semua tiket helpdesk. Edit hanya diperbolehkan jika kategori sesuai dengan kategori Anda.</p>
        @endif
      </div>
      <div class="col-auto">
        <a href="{{ route('staff.ticket.create') }}" class="btn btn-primary">
          <i class="ti ti-plus me-1"></i> Tambah Tiket
        </a>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ti ti-check me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="ti ti-alert-circle me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ !empty($isAssignedView) ? route('staff.ticket.assigned') : route('staff.ticket.index') }}" class="row g-3 mb-3">
      <div class="col-md-4">
        <label for="search" class="form-label">Cari Kata Kunci</label>
        <input type="text" class="form-control" id="search" name="search" value="{{ old('search', request('search')) }}" placeholder="Nama Mahasiswa, Judul, dll.">
      </div>
      <div class="col-md-3">
        <label for="category_id" class="form-label">Kategori</label>
        <select class="form-select" id="category_id" name="category_id">
          <option value="">Semua Kategori</option>
          @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', request('category_id')) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status">
          <option value="">Semua Status</option>
          @foreach($statusList as $key => $label)
            <option value="{{ $key }}" {{ old('status', request('status')) == $key ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary me-2">
          <i class="ti ti-search me-1"></i> Cari
        </button>
        <a href="{{ !empty($isAssignedView) ? route('staff.ticket.assigned') : route('staff.ticket.index') }}" class="btn btn-secondary">
          <i class="ti ti-refresh me-1"></i> Reset
        </a>
      </div>
    </form>

    <!-- Card Layout -->
    @if($tickets->count() > 0)
      <div class="row">
        @foreach($tickets as $ticket)
          <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                  <div>
                    @php
                      $statusBadge = match($ticket->status) {
                        \App\Models\Ticket::STATUS_BARU => 'bg-primary',
                        \App\Models\Ticket::STATUS_PROSES => 'bg-warning text-dark',
                        \App\Models\Ticket::STATUS_SELESAI => 'bg-success',
                        \App\Models\Ticket::STATUS_DITOLAK => 'bg-danger',
                        default => 'bg-secondary',
                      };
                      $statusLabel = \App\Models\Ticket::daftarStatus()[$ticket->status] ?? ucfirst($ticket->status);
                    @endphp
                    <span class="badge {{ $statusBadge }} mb-2">{{ $statusLabel }}</span>
                    @if($ticket->category)
                      <span class="badge bg-secondary">{{ $ticket->category->name }}</span>
                    @endif
                  </div>
                  <small class="text-muted">{{ $ticket->created_at?->format('d/m/Y') }}</small>
                </div>

                <h5 class="card-title mb-3">{{ $ticket->judul }}</h5>
                
                @if($ticket->nama_mahasiswa || $ticket->nim)
                  <div class="mb-2">
                    <small class="text-muted d-block">Mahasiswa:</small>
                    <span class="fw-semibold">{{ $ticket->nama_mahasiswa ?? '-' }}</span>
                    @if($ticket->nim)
                      <small class="text-muted d-block">NIM: {{ $ticket->nim }}</small>
                    @endif
                  </div>
                @endif

                @if($ticket->deskripsi)
                  <p class="card-text text-muted small mb-3" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                    {{ $ticket->deskripsi }}
                  </p>
                @endif

                @php
                  $canEdit = in_array($ticket->category_id, $staffCategoryIds ?? []);
                  $editClasses = $canEdit ? 'btn btn-sm btn-primary flex-fill' : 'btn btn-sm btn flex-fill disabled';
                @endphp
                <div class="d-flex gap-2 mt-auto">
                  <a href="{{ $canEdit ? route('staff.ticket.edit', $ticket) : '#' }}" class="{{ $editClasses }}" @unless($canEdit) aria-disabled="true" title="Kategori tidak sesuai dengan kategori Anda" @endunless>
                    <i class="ti ti-edit me-1"></i> Edit
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="mt-3 d-flex justify-content-end">
        {{ $tickets->onEachSide(1)->links('pagination::bootstrap-5') }}
      </div>
    @else
      <div class="card">
        <div class="card-body text-center py-5">
          <i class="ti ti-inbox fs-1 text-muted mb-3"></i>
          <h5 class="text-muted">Belum ada tiket</h5>
          <p class="text-muted mb-0">Tidak ada tiket yang sesuai dengan kategori Anda saat ini.</p>
        </div>
      </div>
    @endif

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
  });
</script>
@endpush

