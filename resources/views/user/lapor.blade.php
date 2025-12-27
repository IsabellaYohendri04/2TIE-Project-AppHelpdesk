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
                    <form method="POST">
                        @csrf

                        <input class="form-control mb-3" placeholder="NIM">
                        <input class="form-control mb-3" placeholder="Nama">
                        <input class="form-control mb-3" placeholder="Judul Permasalahan">

                        <textarea class="form-control mb-3"
                                  rows="4"
                                  placeholder="Detail Permasalahan"></textarea>

                        <input type="date" class="form-control mb-3">
                        <input class="form-control mb-4" placeholder="Lokasi Kejadian">

                        <div class="text-end">
                            <button class="btn btn-danger fw-bold px-4">
                                LAPOR!
                            </button>
                        </div>
                    </form>
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
