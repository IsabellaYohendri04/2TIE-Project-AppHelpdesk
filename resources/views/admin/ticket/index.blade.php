@extends('layout.app')

@section('content')
<div class="pc-container">
  <div class="pc-content">

    <div class="row mb-3">
      <div class="col">
        <h3 class="mb-1">Daftar Tiket Helpdesk IT</h3>
        <p class="text-muted mb-0">Kelola seluruh laporan gangguan mahasiswa (SIAK, WiFi, email kampus, dll).</p>
      </div>
      <div class="col-auto">
        <a href="{{ route('admin.ticket.create') }}" class="btn btn-primary">
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

    <div class="card">
      <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Mahasiswa</th>
              <th>Kategori</th>
              <th>Judul</th>
              <th>Status</th>
              <th>Staf Helpdesk</th>
              <th>Dibuat</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($tickets as $ticket)
              <tr>
                <td>{{ $loop->iteration + ($tickets->firstItem() - 1) }}</td>
                <td>
                  <div class="d-flex flex-column">
                    <span class="fw-semibold">{{ $ticket->nama_mahasiswa ?? '-' }}</span>
                    <small class="text-muted">NIM: {{ $ticket->nim ?? '-' }}</small>
                  </div>
                </td>
                <td>
                  @php
                    $kategoriLabel = $ticket->category?->name ?? 'Tidak ada kategori';
                    $kategoriBadge = 'bg-secondary';
                  @endphp
                  <span class="badge {{ $kategoriBadge }}">{{ $kategoriLabel }}</span>
                </td>
                <td>{{ $ticket->judul }}</td>
                <td>
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
                  <span class="badge {{ $statusBadge }}">{{ $statusLabel }}</span>
                </td>
                <td>{{ $ticket->staff?->name ?? '-' }}</td>
                <td>{{ $ticket->created_at?->format('d/m/Y H:i') }}</td>
                <td class="text-end">
                  <div class="btn-group">
                    <a href="{{ route('admin.ticket.edit', $ticket) }}" class="btn btn-sm btn-outline-primary">
                      <i class="ti ti-edit"></i>
                    </a>
                    <button
                      type="button"
                      class="btn btn-sm btn-outline-danger btn-delete-ticket"
                      data-bs-toggle="modal"
                      data-bs-target="#deleteTicketModal"
                      data-ticket-id="{{ $ticket->id }}"
                      data-ticket-judul="{{ $ticket->judul }}"
                    >
                      <i class="ti ti-trash"></i>
                    </button>
                    <form id="delete-ticket-form-{{ $ticket->id }}" action="{{ route('admin.ticket.destroy', $ticket) }}" method="POST" class="d-none">
                      @csrf
                      @method('DELETE')
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center text-muted">Belum ada tiket helpdesk.</td>
              </tr>
            @endforelse
          </tbody>
        </table>

        <div class="mt-3">
          {{ $tickets->links() }}
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Modal Konfirmasi Hapus Tiket (mirip logoutModal) -->
<div class="modal fade" id="deleteTicketModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">
          <i class="ti ti-alert-triangle me-1"></i> Konfirmasi Hapus Tiket
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center py-4">
        <i class="ti ti-trash fs-1 text-danger mb-3"></i>
        <h5>Apakah Anda yakin ingin menghapus tiket ini?</h5>
        <p class="text-muted">
          Tiket: <span id="delete-ticket-judul" class="fw-semibold"></span><br>
          Tindakan ini tidak dapat dibatalkan.
        </p>
      </div>

      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
          Batal
        </button>
        <button type="button" class="btn btn-danger px-4" id="delete-ticket-confirm-btn">
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

    let ticketIdToDelete = null;
    const deleteModal = document.getElementById('deleteTicketModal');
    const judulSpan = document.getElementById('delete-ticket-judul');
    const confirmBtn = document.getElementById('delete-ticket-confirm-btn');

    document.querySelectorAll('.btn-delete-ticket').forEach(function (btn) {
      btn.addEventListener('click', function () {
        ticketIdToDelete = this.getAttribute('data-ticket-id');
        const judul = this.getAttribute('data-ticket-judul');
        if (judulSpan) {
          judulSpan.textContent = judul;
        }
      });
    });

    if (confirmBtn) {
      confirmBtn.addEventListener('click', function () {
        if (!ticketIdToDelete) return;
        const form = document.getElementById('delete-ticket-form-' + ticketIdToDelete);
        if (form) {
          form.submit();
        }
      });
    }
  });
</script>
@endpush

@endsection
