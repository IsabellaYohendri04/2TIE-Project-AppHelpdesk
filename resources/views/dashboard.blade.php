<!doctype html>
<html lang="en">
  <head>
    <title>Berry HTML Admin Template | Berry Dashboard Template</title>

    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="description"
      content="Berry is trending dashboard template made using Bootstrap 5 design framework. Berry is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies."
    />
    <meta
      name="keywords"
      content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard"
    />
    <meta name="author" content="codedthemes" />

    <!-- [Favicon] -->
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />

    <!-- [Page specific CSS] -->
    <link href="{{ asset('assets/css/plugins/animate.min.css') }}" rel="stylesheet" />

    <!-- [Google Font] -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" id="main-font-link" />

    <!-- [Icons] -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}" />

    <!-- [Template CSS] -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}" />

    <!-- Landing Page CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}" />
  </head>

  <body class="landing-page">

    <!-- [ Pre-loader ] -->
    <div class="loader-bg">
      <div class="loader-track">
        <div class="loader-fill"></div>
      </div>
    </div>

    <!-- [ Navbar ] -->
    <nav class="navbar navbar-expand-md navbar-light default">
      <div class="container">
        <a class="navbar-brand" href="#">
          <img src="{{ asset('assets/images/logo-dark.svg') }}" alt="logo" class="img-fluid" />
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerDemo01"
                aria-controls="navbarTogglerDemo01"
                aria-expanded="false"
                aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link text-dark active" href="#home">Home</a>
            </li>

            <li class="nav-item">
              {{-- Jika dashboard pakai route --}}
              {{-- <a class="nav-link text-dark" href="{{ route('dashboard') }}">Dashboard</a> --}}

              {{-- Jika dashboard pakai URL biasa --}}
              <a class="nav-link text-dark" href="{{ url('dashboard') }}">Dashboard</a>
            </li>

            <li class="nav-item">
              <a class="btn btn-secondary" target="_blank"
                href="https://codedthemes.com/item/berry-bootstrap-5-admin-template/">
                Purchase Now
              </a>
            </li>
          </ul>
        </div>

      </div>
    </nav>

    <!-- [ Header ] -->
    <header id="home">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">
          <div class="col-lg-9 col-xl-6">
            <h1 class="mt-sm-3 mb-sm-4 f-w-600 wow fadeInUp" data-wow-delay="0.2s">
              Build Your Next Project With <span class="text-primary">Berry</span>
            </h1>

            <h4 class="mb-sm-4 text-muted wow fadeInUp" data-wow-delay="0.4s">
              Berry is React based admin template which helps you to build faster and beautiful web applications.
            </h4>

            <div class="my-3 my-xl-5 wow fadeInUp" data-wow-delay="0.6s">
              <a href="{{ url('dashboard') }}" class="btn btn-secondary me-2">Live Demo</a>
              <a href="https://codedthemes.com/item/berry-bootstrap-5-admin-template/"
                 class="btn btn-link-primary" target="_blank">Purchase Now</a>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- [ Scripts ] -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

    <script>
      layout_change('light');
      font_change('Roboto');
      change_box_container('false');
      layout_caption_change('true');
      layout_rtl_change('false');
      preset_change('preset-1');
    </script>

    <!-- [ Scroll Nav Behavior ] -->
    <script>
      let ost = 0;
      document.addEventListener('scroll', function () {
        let cOst = document.documentElement.scrollTop;
        if (cOst == 0) {
          document.querySelector('.navbar').classList.add('top-nav-collapse');
        } else if (cOst > ost) {
          document.querySelector('.navbar').classList.add('top-nav-collapse');
          document.querySelector('.navbar').classList.remove('default');
        } else {
          document.querySelector('.navbar').classList.add('default');
          document.querySelector('.navbar').classList.remove('top-nav-collapse');
        }
        ost = cOst;
      });
    </script>

  </body>
</html>
