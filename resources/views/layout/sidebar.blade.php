<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="{{ route('dashboard') }}" class="b-brand text-primary">
        <!-- ========   Change your logo from here   ============ -->
       {{-- <img src="{{ asset('logo/logo1.png') }}" alt="Logo Helpdesk" class="logo logo-lg" /> --}}
<a href="{{ route('dashboard') }}" class="b-brand text-primary">
    <img src="{{ asset('assets/logo/logo1.png') }}"
         class="logo logo-lg"
         alt="Logo Helpdesk">

    <img src="{{ asset('assets/logo/logo1.png') }}"
         class="logo logo-sm"
         alt="Logo Helpdesk">
</a>


      </a>
    </div>
    <div class="navbar-content">
      <ul class="pc-navbar">
        <li class="pc-item pc-caption">
          <label>Dashboard</label>
          <i class="ti ti-dashboard"></i>
        </li>
        <li class="pc-item">
          <a href="{{ route('dashboard') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
            <span class="pc-mtext">Dashboard</span>
          </a>
        </li>

        @role('admin')
        <li class="pc-item pc-caption">
          <label>Admin Helpdesk</label>
          <i class="ti ti-headset"></i>
        </li>
        <li class="pc-item">
          <a href="{{ route('admin.ticket.index') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-ticket"></i></span>
            <span class="pc-mtext">Tiket Helpdesk</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="{{ route('admin.staff.index') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-users"></i></span>
            <span class="pc-mtext">User Staf</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="{{ route('admin.category.index') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-package"></i></span>
            <span class="pc-mtext">Kategori</span>
          </a>
        </li>
        @endrole

        @role('staff')
        <li class="pc-item pc-caption">
          <label>Staff Helpdesk</label>
          <i class="ti ti-headset"></i>
        </li>
        <li class="pc-item">
          <a href="{{ route('staff.ticket.index') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-ticket"></i></span>
            <span class="pc-mtext">Tiket Keseluruhan</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="{{ route('staff.ticket.assigned') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-list-check"></i></span>
            <span class="pc-mtext">Tiket Ditugaskan</span>
          </a>
        </li>
        @endrole

        <li class="pc-item pc-caption">
          <label>Other</label>
          <i class="ti ti-brand-chrome"></i>
        </li>
       

      </ul>
      <div class="pc-navbar-card bg-primary rounded">
        <h4 class="text-white">Lapor</h4>
        <p class="text-white opacity-75">Penasaran dengan lapor mahasiswa ? klik button di bawah!</p>
        <a href="{{ route('logout') }}" target="_blank"
          class="btn btn-light text-primary">
          Beranda Lapor
        </a>
      </div>
      <div class="w-100 text-center">
        <div class="badge theme-version badge rounded-pill bg-light text-dark f-12"></div>
      </div>
    </div>
  </div>
</nav>