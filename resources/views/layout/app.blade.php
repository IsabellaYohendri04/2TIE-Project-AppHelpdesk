<!doctype html>
<html lang="en">
  <!-- [Head] start -->
  <head>
    <title>Helpdesk</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="description" content="Berry is trending dashboard template made using Bootstrap 5 design framework." />
    <meta name="keywords" content="Bootstrap admin template, Dashboard UI Kit" />
    <meta name="author" content="codedthemes" />

    <!-- [Favicon] -->
    <link rel="icon" href="../assets/images/favicon.svg" type="image/x-icon" />

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" />
    <link rel="stylesheet" href="../assets/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="../assets/fonts/feather.css" />
    <link rel="stylesheet" href="../assets/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../assets/fonts/material.css" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/style-preset.css" />
  </head>
  <!-- [Head] end -->

  <!-- [Body] Start -->
  <body>

    <!-- Preloader -->
    <div class="loader-bg">
      <div class="loader-track">
        <div class="loader-fill"></div>
      </div>
    </div>

    {{-- Sidebar --}}
    @include('layout.sidebar')

    <!-- 🔴 WRAPPER WAJIB -->
    <div class="pc-wrapper">

        {{-- Header --}}
        @include('layout.headertopbar')

        <!-- 🔴 CONTENT UTAMA -->
        <div class="pc-content">
            @yield('content')
        </div>

    </div>

    {{-- JS --}}
    <script src="../assets/js/plugins/popper.min.js"></script>
    <script src="../assets/js/plugins/simplebar.min.js"></script>
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
    <script src="../assets/js/icon/custom-font.js"></script>
    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script src="../assets/js/plugins/feather.min.js"></script>

    <script>
      layout_change('light');
      font_change('Roboto');
      change_box_container('false');
      layout_caption_change('true');
      layout_rtl_change('false');
      preset_change('preset-1');
    </script>

    <!-- Page Specific JS -->
    <script src="../assets/js/plugins/apexcharts.min.js"></script>
    <script src="../assets/js/pages/dashboard-default.js"></script>

  </body>
  <!-- [Body] end -->
</html>
