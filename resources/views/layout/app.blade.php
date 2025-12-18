<!doctype html>
<html lang="en">
<head>
    <title>Helpdesk</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Meta -->
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

       
        <!-- Footer -->
        @include('layout.footer')

    </div>

    <!-- Required JS -->
    @include('layout.requiredjs')

    <!-- Page Specific JS -->
    @include('layout.pagespesificjs')

    @stack('js')

</body>
</html>
