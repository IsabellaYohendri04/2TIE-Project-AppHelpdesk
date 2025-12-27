<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">
          <i class="ti ti-alert-triangle me-1"></i> Konfirmasi Logout
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center py-4">
        <i class="ti ti-logout fs-1 text-danger mb-3"></i>
        <h5>Apakah Anda yakin ingin logout?</h5>
        <p class="text-muted">
          Anda harus login kembali untuk mengakses sistem.
        </p>
      </div>

      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
          Batal
        </button>
        <button type="button" class="btn btn-danger px-4"
            onclick="document.getElementById('logout-form').submit();">
          Ya, Logout
        </button>
      </div>

    </div>
  </div>
</div>
