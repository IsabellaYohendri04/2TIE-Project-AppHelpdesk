<!doctype html>
<html lang="en">
<head>
    <title>Helpdesk</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" />

    <!-- BOOTSTRAP (DARI PERINTAH NO 1) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Berry CSS -->
    <link rel="icon" href="{{ asset('assets/logo/logo1.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/themes/dark.css') }}" />

    <!-- CUSTOM CSS LAPOR -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('css')
</head>

<body>

<!-- Loader -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>

<!-- Sidebar -->
@include('layout.sidebar')

<!-- Wrapper -->
<div class="pc-wrapper">

    <!-- Header -->
    @include('layout.headertopbar')

    <!-- CONTENT -->
    <div class="pc-content">
        @yield('content')
    </div>

    <!-- Footer -->
    @include('layout.footer')

</div>

<!-- JS -->
@include('layout.requiredjs')
@include('layout.pagespesificjs')


@stack('js')

<!-- LOGOUT MODAL -->
@include('layout.logoutmodal')

</body>
</html>
