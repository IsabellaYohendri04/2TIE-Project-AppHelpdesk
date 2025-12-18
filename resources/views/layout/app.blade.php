<!doctype html>
<html lang="en">
<head>
    <title>Helpdesk</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Meta -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Berry Bootstrap Admin Dashboard" />
    <meta name="author" content="codedthemes" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/phosphor/duotone/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}" />

    <!-- Berry CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/themes/dark.css') }}" />

    @stack('css')
</head>

<body>

    <!-- Preloader -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <!-- Sidebar -->
    @include('layout.sidebar')

    <!-- Wrapper -->
<div class="pc-wrapper">

    <!-- Header / Topbar -->
    @include('layout.headertopbar')

    <!-- CONTENT WAJIB ADA -->
    <div class="pc-content">
        @yield('content')
    </div>

    <!-- Footer -->
    @include('layout.footer')

</div>

    <!-- Required JS -->
    @include('layout.requiredjs')

    <!-- Page Specific JS -->
    @include('layout.pagespesificjs')

    @stack('js')

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
        <button type="button" class="btn btn-danger px-4" onclick="submitLogout()">
          Ya, Logout
        </button>
      </div>

    </div>
  </div>
</div>





<script>
function submitLogout() {
    document.getElementById('logout-form').submit();
}
</script>

</body>
</html>
