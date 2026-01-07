@extends('layout.user')

@section('title', 'Layanan Pengaduan')

@section('content')

<div class="lapor-page">

    <!-- HERO -->
    <section class="lapor-hero js-hero text-white text-center">
        <div class="container position-relative">

            <h1 class="fw-bold">
                Layanan dan Pengaduan Online Mahasiswa
            </h1>

            <p class="mt-2">
                Sampaikan laporan Anda langsung kepada instansi
            </p>

            <div class="divider"></div>

            <!-- CTA -->
            <div class="hero-cta">
                <a href="#"
                   class="btn-hero"
                   data-bs-toggle="modal"
                   data-bs-target="#infoModal">
                    Pelajari Lebih Lanjut
                </a>
            </div>

        </div>
    </section>

    <!-- BACKGROUND PUTIH -->
    <section class="lapor-bg">

        <!-- FORM -->
        <section class="container lapor-form" id="lapor-form">
            <div class="card shadow-lg border-0">

                <div class="card-header lapor-header">
                    Sampaikan Laporan Anda
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="ti ti-check me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('lapor.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIM</label>
                                <input type="text" 
                                       name="nim" 
                                       class="form-control" 
                                       value="{{ old('nim') }}" 
                                       placeholder="Contoh: 123456789">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Mahasiswa</label>
                                <input type="text" 
                                       name="nama_mahasiswa" 
                                       class="form-control" 
                                       value="{{ old('nama_mahasiswa') }}" 
                                       placeholder="Nama lengkap">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Judul Permasalahan <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="judul" 
                                   class="form-control" 
                                   value="{{ old('judul') }}" 
                                   required 
                                   placeholder="Contoh: Lupa Password SIAK">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                                <option value="" disabled {{ old('category_id') === '' ? 'selected' : '' }}>-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Detail Permasalahan</label>
                            <textarea name="deskripsi" 
                                      class="form-control" 
                                      rows="4" 
                                      placeholder="Ceritakan kronologi singkat masalah yang terjadi...">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-danger fw-bold px-4">
                                <i class="ti ti-send me-1"></i> Submit!
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </section>

        <!-- RIWAYAT LAPORAN (HANYA TAMPAK DI GUEST) -->
        <section class="container mt-4 mb-5" id="history-section">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-info text-white">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div>
                            <h5 class="mb-0 fw-bold">
                                <i class="ti ti-history me-2"></i>Riwayat Laporan
                            </h5>
                            <small class="opacity-75">Hanya ditampilkan untuk pengunjung</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($tickets->isEmpty())
                        <div class="text-center py-5">
                            <i class="ti ti-inbox" style="font-size: 3rem; color: #ddd;"></i>
                            <p class="mb-0 text-muted mt-3">Belum ada laporan yang tercatat.</p>
                        </div>
                    @else
                        <!-- SEARCH DAN FILTER -->
                        <div class="row mb-4 g-2 g-md-3 align-items-stretch">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ti ti-search"></i>
                                    </span>
                                    <input type="text" 
                                           id="searchInput" 
                                           class="form-control border-start-0" 
                                           placeholder="Cari judul, detail, atau staf...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select id="statusFilter" class="form-select">
                                    <option value="">Semua Status</option>
                                    @foreach($statusLabels as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 col-md-3 d-grid">
                                <button type="button" id="resetFilter" class="btn btn-outline-secondary w-100">
                                    <i class="ti ti-refresh me-1"></i>Reset
                                </button>
                            </div>
                            
                        </div>

                        <!-- INFO HASIL FILTER -->
                        <div id="filterInfo" class="alert alert-info d-none mb-3">
                            <i class="ti ti-info-circle me-2"></i>
                            <span id="filterText"></span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="ticketsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">Judul</th>
                                        <th class="fw-semibold">Detail</th>
                                        <th class="fw-semibold">Status</th>
                                        <th class="fw-semibold">Staf</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tickets as $ticket)
                                        <tr class="ticket-row" 
                                            data-judul="{{ strtolower($ticket->judul) }}"
                                            data-detail="{{ strtolower($ticket->deskripsi ?? '') }}"
                                            data-status="{{ $ticket->status }}"
                                            data-staf="{{ strtolower($ticket->staff?->name ?? '') }}">
                                            <td class="fw-semibold">{{ $ticket->judul }}</td>
                                            <td class="text-muted">{{ \Illuminate\Support\Str::limit($ticket->deskripsi, 70) ?: '-' }}</td>
                                            <td>
                                                @php
                                                    $statusClass = match($ticket->status) {
                                                        'baru' => 'bg-info text-white',
                                                        'proses' => 'bg-warning text-dark',
                                                        'selesai' => 'bg-success text-white',
                                                        'ditolak' => 'bg-danger text-white',
                                                        default => 'bg-secondary text-white'
                                                    };
                                                @endphp
                                                <span class="badge {{ $statusClass }} px-3 py-2">
                                                    {{ $statusLabels[$ticket->status] ?? ucfirst($ticket->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($ticket->staff)
                                                    <span class="badge bg-light-primary text-primary px-3 py-2">
                                                        <i class="ti ti-user me-1"></i>{{ $ticket->staff->name }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- PESAN TIDAK ADA HASIL -->
                        <div id="noResults" class="text-center py-5 d-none">
                            <i class="ti ti-search-off" style="font-size: 3rem; color: #ddd;"></i>
                            <p class="mb-0 text-muted mt-3">Tidak ada laporan yang sesuai dengan filter.</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>

    </section>

    <!-- STEP -->
    <section class="lapor-steps container text-center">
        <div class="row g-4">

            <div class="col">
                <div class="step active">✍️</div>
                <h6>Tulis Laporan</h6>
                <p>Laporkan keluhan atau aspirasi</p>
            </div>

            <div class="col">
                <div class="step">🔄</div>
                <h6>Verifikasi</h6>
                <p>Laporan diverifikasi</p>
            </div>

            <div class="col">
                <div class="step">💬</div>
                <h6>Tindak Lanjut</h6>
                <p>Instansi merespons</p>
            </div>

            <div class="col">
                <div class="step">✔</div>
                <h6>Selesai</h6>
                <p>Laporan dituntaskan</p>
            </div>

        </div>
    </section>

</div>

<!-- ======================
     MODAL INFO
     ====================== -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    Tentang Layanan Pengaduan
                </h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center px-5 py-4">
                <p class="mb-3">
                    Layanan Pengaduan Online Mahasiswa digunakan untuk
                    menyampaikan keluhan, aspirasi, dan laporan secara resmi.
                </p>

                <p class="mb-0">
                    Setiap laporan akan diverifikasi dan ditindaklanjuti
                    oleh pihak terkait secara transparan.
                </p>
            </div>

        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #f44336 0%, #e53935 100%);
    }
    
    .bg-light-primary {
        background-color: #fdecea;
        color: #c62828;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .table thead th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    
    .badge {
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .card-header {
        border-bottom: none;
    }
    
    #ticketsTable tbody tr {
        transition: all 0.2s ease;
    }
    
    #ticketsTable tbody tr:not(.d-none):nth-child(even) {
        background-color: #f8f9fa;
    }
    
    .input-group-text {
        border-color: #ced4da;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const resetFilter = document.getElementById('resetFilter');
    const searchButton = document.getElementById('searchButton');
    const filterInfo = document.getElementById('filterInfo');
    const filterText = document.getElementById('filterText');
    const noResults = document.getElementById('noResults');
    const ticketRows = document.querySelectorAll('.ticket-row');
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const statusValue = statusFilter.value;
        let visibleCount = 0;
        let hiddenCount = 0;
        
        ticketRows.forEach(row => {
            const judul = row.getAttribute('data-judul');
            const detail = row.getAttribute('data-detail');
            const status = row.getAttribute('data-status');
            const staf = row.getAttribute('data-staf');
            
            const matchesSearch = !searchTerm || 
                judul.includes(searchTerm) || 
                detail.includes(searchTerm) || 
                staf.includes(searchTerm);
            
            const matchesStatus = !statusValue || status === statusValue;
            
            if (matchesSearch && matchesStatus) {
                row.classList.remove('d-none');
                visibleCount++;
            } else {
                row.classList.add('d-none');
                hiddenCount++;
            }
        });
        
        // Tampilkan pesan jika tidak ada hasil
        if (visibleCount === 0 && ticketRows.length > 0) {
            document.getElementById('ticketsTable').classList.add('d-none');
            noResults.classList.remove('d-none');
        } else {
            document.getElementById('ticketsTable').classList.remove('d-none');
            noResults.classList.add('d-none');
        }
        
        // Tampilkan info filter jika ada filter aktif
        if (searchTerm || statusValue) {
            let infoText = 'Menampilkan ' + visibleCount + ' dari ' + ticketRows.length + ' laporan';
            if (searchTerm) {
                infoText += ' dengan kata kunci "' + searchTerm + '"';
            }
            if (statusValue) {
                const statusLabel = statusFilter.options[statusFilter.selectedIndex].text;
                infoText += ' dengan status "' + statusLabel + '"';
            }
            filterText.textContent = infoText;
            filterInfo.classList.remove('d-none');
        } else {
            filterInfo.classList.add('d-none');
        }
    }
    
    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
    searchButton.addEventListener('click', filterTable);
        
    resetFilter.addEventListener('click', function() {
        searchInput.value = '';
        statusFilter.value = '';
        filterTable();
    });
});
</script>
@endpush
