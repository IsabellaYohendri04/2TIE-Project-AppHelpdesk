<header class="pc-header fixed-top">
  <div class="header-wrapper">
<div class="me-auto pc-mob-drp">
  
  <ul class="list-unstyled">
    {{-- <li class="pc-h-item header-mobile-collapse">
  <a href="#" class="pc-head-link head-link-secondary ms-0" id="sidebar-hide">
    <i class="ti ti-menu-2"></i>
  </a>
</li> --}}

 <li class="pc-h-item pc-sidebar-popup">
      <a href="#" class="pc-head-link head-link-secondary ms-0" id="mobile-collapse">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>

    
  </ul>
</div>
<!-- [Mobile Media Block end] -->
<div class="ms-auto">
  @php
    $user = auth()->user();
    $notificationsQuery = \App\Models\Ticket::with(['category', 'staff'])->latest();

    if ($user && $user->hasRole('staff')) {
        $categoryIds = $user->categories->pluck('id');
        $notificationsQuery->whereIn('category_id', $categoryIds);
    }

    $notifications = $notificationsQuery->take(5)->get();
    $notifCount = $notifications->count();
  @endphp
  <ul class="list-unstyled">
    <li class="dropdown pc-h-item">
      <a
        class="pc-head-link head-link-secondary dropdown-toggle arrow-none me-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        aria-expanded="false"
      >
        <i class="ti ti-bell"></i>
        @if($notifCount > 0)
          <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle p-1">{{ $notifCount }}</span>
        @endif
      </a>
      <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header">
          <h5>
            Notifikasi
            <span class="badge bg-warning rounded-pill ms-1">{{ $notifCount }}</span>
          </h5>
        </div>
        <div class="dropdown-header px-0 text-wrap header-notification-scroll position-relative" style="max-height: calc(100vh - 215px)">
          <div class="list-group list-group-flush w-100">
            @forelse($notifications as $ticket)
              @php
                $statusBadge = match($ticket->status) {
                  \App\Models\Ticket::STATUS_BARU => 'badge bg-primary',
                  \App\Models\Ticket::STATUS_PROSES => 'badge bg-warning text-dark',
                  \App\Models\Ticket::STATUS_SELESAI => 'badge bg-success',
                  \App\Models\Ticket::STATUS_DITOLAK => 'badge bg-danger',
                  default => 'badge bg-secondary',
                };
                $statusLabel = \App\Models\Ticket::daftarStatus()[$ticket->status] ?? ucfirst($ticket->status);
              @endphp
              <div class="list-group-item list-group-item-action">
                <div class="d-flex">
                  <div class="flex-shrink-0">
                    <div class="user-avtar bg-light-primary text-primary">
                      <i class="ti ti-ticket"></i>
                    </div>
                  </div>
                  <div class="flex-grow-1 ms-1">
                    <span class="float-end text-muted">{{ $ticket->created_at?->diffForHumans() }}</span>
                    <h5 class="mb-1">{{ $ticket->judul }}</h5>
                    <p class="text-body fs-6 mb-1">
                      {{ \Illuminate\Support\Str::limit($ticket->deskripsi, 80) ?? 'Tanpa deskripsi' }}
                    </p>
                    <div class="d-flex gap-2 align-items-center flex-wrap">
                      <span class="{{ $statusBadge }}">{{ $statusLabel }}</span>
                      @if($ticket->category)
                        <span class="badge bg-light text-dark">{{ $ticket->category->name }}</span>
                      @endif
                      @if($ticket->staff)
                        <span class="badge bg-light text-dark"><i class="ti ti-user"></i> {{ $ticket->staff->name }}</span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div class="list-group-item">
                <p class="mb-0 text-muted text-center">Tidak ada notifikasi.</p>
              </div>
            @endforelse
          </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="text-center py-2">
          <span class="text-muted small">Menampilkan {{ $notifCount }} notifikasi terbaru</span>
        </div>
      </div>
    </li>
    <li class="dropdown pc-h-item header-user-profile">
      <a
        class="pc-head-link head-link-primary dropdown-toggle arrow-none me-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        aria-expanded="false"
      >
        @php
          $user = auth()->user();
          $profilePicture = $user->profile_picture 
            ? \Illuminate\Support\Facades\Storage::url($user->profile_picture) 
            : asset('assets/images/user/avatar-2.jpg');
        @endphp
        <img src="{{ $profilePicture }}" alt="user-image" class="user-avtar" />
        <span>
          <i class="ti ti-settings"></i>
        </span>
      </a>
      <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header">
          <div class="d-flex align-items-center mb-2">
            <img src="{{ $profilePicture }}" alt="user-image" class="user-avtar me-2" style="width: 50px; height: 50px;" />
            <div>
              <h5 class="mb-0">{{ $user->name }}</h5>
              <p class="text-muted small mb-0">{{ $user->email }}</p>
              <span class="badge bg-primary mt-1">
                @if($user->hasRole('admin'))
                  Admin
                @elseif($user->hasRole('staff'))
                  Staff
                @else
                  User
                @endif
              </span>
            </div>
          </div>
          <hr />
          <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 280px)">
            <a href="{{ route('profile.edit') }}" class="dropdown-item">
              <i class="ti ti-settings"></i>
              <span>Profile Settings</span>
            </a>
            <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal">
              <i class="ti ti-logout"></i>
              <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </div>
        </div>
      </div>
    </li>
  </ul>
</div>
</div>
</header>