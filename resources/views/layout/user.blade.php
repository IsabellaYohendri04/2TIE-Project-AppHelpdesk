<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','LAPOR')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/lapor.css') }}">
</head>
<body>

<div class="user-scope">

    <!-- NAVBAR -->
    <nav class="lapor-navbar js-navbar">
    <div class="container lapor-nav-inner">

        <!-- KIRI -->
        <div class="lapor-left">
            <div class="lapor-logo">LAPOR!</div>

            <div class="lapor-left-menu">
                <a href="#" class="lapor-nav-link">Tentang Lapor</a>
                <a href="#" class="lapor-nav-link">Statistik</a>
            </div>
        </div>

        <!-- KANAN -->
        <div class="lapor-right">
            <a href="#" class="lapor-lang">🌐</a>
            <a href="#" class="lapor-nav-link">Masuk</a>
            <a href="#" class="lapor-btn-daftar">Daftar</a>
        </div>

    </div>
</nav>



    <main>
        @yield('content')
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- ===== HERO SCROLL EFFECT (POINT 3) ===== -->
<script>
    const hero = document.querySelector('.js-hero');

    window.addEventListener('scroll', () => {
        if (!hero) return;

        if (window.scrollY > 80) {
            hero.classList.add('shrink');
        } else {
            hero.classList.remove('shrink');
        }
    });
</script>
<script>
let lastScroll = 0;
const navbar = document.querySelector('.js-navbar');

window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;

    if (currentScroll <= 0) {
        navbar.classList.remove('nav-hide');
        navbar.classList.add('nav-show');
        return;
    }

    if (currentScroll > lastScroll) {
        // scroll ke bawah
        navbar.classList.add('nav-hide');
        navbar.classList.remove('nav-show');
    } else {
        // scroll ke atas
        navbar.classList.remove('nav-hide');
        navbar.classList.add('nav-show');
    }

    lastScroll = currentScroll;
});
</script>

</body>
</html>
