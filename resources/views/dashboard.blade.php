@extends('layout.app')
@section('content')

<div class="pc-container">
  <div class="pc-content">
    <div class="row">

      {{-- TOTAL TIKET --}}
      <div class="col-xl-4 col-md-6">
        <div class="card bg-secondary-dark dashnum-card text-white overflow-hidden">
          <span class="round small"></span>
          <span class="round big"></span>
          <div class="card-body">
            <div class="row">
              <div class="col">
                <div class="avtar avtar-lg">
                  <i class="text-white ti ti-ticket"></i>
                </div>
              </div>
            </div>
            <span class="text-white d-block f-34 f-w-500 my-2">
              {{ $totalTickets }}
              <i class="ti ti-arrow-up-right-circle opacity-50"></i>
            </span>
            <p class="mb-0 opacity-50">Total Tiket Masuk</p>
          </div>
        </div>
      </div>

      {{-- BULAN & TAHUN --}}
      <div class="col-xl-4 col-md-6">
        <div class="card bg-primary-dark dashnum-card text-white overflow-hidden">
          <span class="round small"></span>
          <span class="round big"></span>
          <div class="card-body">

            <div class="row">
              <div class="col">
                <div class="avtar avtar-lg">
                  <i class="text-white ti ti-chart-bar"></i>
                </div>
              </div>
              <div class="col-auto">
                <ul class="nav nav-pills justify-content-end mb-0">
                  <li class="nav-item">
                    <button class="nav-link text-white active" data-bs-toggle="pill" data-bs-target="#month">
                      Month
                    </button>
                  </li>
                  <li class="nav-item">
                    <button class="nav-link text-white" data-bs-toggle="pill" data-bs-target="#year">
                      Year
                    </button>
                  </li>
                </ul>
              </div>
            </div>

            <div class="tab-content">
              <div class="tab-pane show active" id="month">
                <div class="row">
                  <div class="col-6">
                    <span class="text-white d-block f-34 f-w-500 my-2">
                      {{ $ticketsThisMonth }}
                    </span>
                    <p class="mb-0 opacity-50">Tiket Bulan Ini</p>
                  </div>
                  <div class="col-6">
                    <div id="tab-chart-1"></div>
                  </div>
                </div>
              </div>

              <div class="tab-pane" id="year">
                <div class="row">
                  <div class="col-6">
                    <span class="text-white d-block f-34 f-w-500 my-2">
                      {{ $ticketsThisYear }}
                    </span>
                    <p class="mb-0 opacity-50">Tiket Tahun Ini</p>
                  </div>
                  <div class="col-6">
                    <div id="tab-chart-2"></div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      {{-- TIKET SELESAI & STAF --}}
      <div class="col-xl-4 col-md-12">
        <div class="card bg-primary-dark dashnum-card dashnum-card-small text-white overflow-hidden">
          <span class="round bg-primary small"></span>
          <span class="round bg-primary big"></span>
          <div class="card-body p-3">
            <div class="d-flex align-items-center">
              <div class="avtar avtar-lg">
                <i class="text-white ti ti-check"></i>
              </div>
              <div class="ms-2">
                <h4 class="text-white mb-1">{{ $completedTickets }}</h4>
                <p class="mb-0 opacity-75 text-sm">Tiket Selesai</p>
              </div>
            </div>
          </div>
        </div>

        <div class="card dashnum-card dashnum-card-small overflow-hidden">
          <span class="round bg-warning small"></span>
          <span class="round bg-warning big"></span>
          <div class="card-body p-3">
            <div class="d-flex align-items-center">
              <div class="avtar avtar-lg bg-light-warning">
                <i class="text-warning ti ti-users"></i>
              </div>
              <div class="ms-2">
                <h4 class="mb-1">{{ $totalStaff }}</h4>
                <p class="mb-0 opacity-75 text-sm">Total Staf</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- CHART --}}
      <div class="col-xl-8 col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row mb-3 align-items-center">
              <div class="col">
                <small class="text-muted">Total Growth</small>
                <h3>{{ $totalTickets }}</h3>
              </div>
            </div>
            <div id="growthchart"></div>
          </div>
        </div>
      </div>

      {{-- TIKET TERBARU --}}
      <div class="col-xl-4 col-md-12">
        <div class="card h-100">
          <div class="card-body d-flex flex-column">

            <div class="row mb-3 align-items-center">
              <div class="col">
                <h4 class="mb-0">Tiket Terbaru</h4>
                <small class="text-muted">Notifikasi tiket masuk</small>
              </div>
              <div class="col-auto">
                <a href="{{ route('admin.ticket.index') }}"
                   class="btn btn-sm btn-light-primary">
                  Lihat Semua
                </a>
              </div>
            </div>

            <div class="flex-grow-1 overflow-auto" style="max-height:380px">
              <ul class="list-group list-group-flush">
                @forelse ($latestTickets as $ticket)
                  <li class="list-group-item px-0">
                    <div class="d-flex align-items-start">
                      <div class="avtar avtar-s bg-light-primary me-3">
                        <i class="ti ti-ticket text-primary"></i>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-1">{{ $ticket->judul }}</h6>
                        <small class="text-muted">
                          {{ $ticket->created_at->diffForHumans() }}
                        </small>
                      </div>
                      <div class="ms-2 text-end">
                        <span class="badge bg-light-secondary text-secondary">
                          {{ $ticket->category->name ?? 'Tanpa Kategori' }}
                        </span>
                      </div>
                    </div>
                  </li>
                @empty
                  <li class="list-group-item text-center text-muted">
                    Belum ada tiket masuk
                  </li>
                @endforelse
              </ul>
            </div>

          </div>
        </div>
      </div>

    </div> {{-- PENUTUP .row --}}
  </div>   {{--PENUTUP .pc-content --}}
</div>     {{-- PENUTUP .pc-container --}}

@endsection

@push('js')
<script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/dashboard-default.js') }}"></script>
@endpush
