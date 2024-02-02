<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    @yield('title')
    <!-- CSS files -->
    <link href="/dist/css/tabler.min.css?1684106062" rel="stylesheet" />
    <link href="/dist/css/tabler-flags.min.css?1684106062" rel="stylesheet" />
    <link href="/dist/css/tabler-payments.min.css?1684106062" rel="stylesheet" />
    <link href="/dist/css/tabler-vendors.min.css?1684106062" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
    @yield('css')
</head>

<body>
    <script src="/dist/js/demo-theme.min.js?1684106062"></script>
    <div class="page">
        <header class="navbar navbar-expand-md d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                    aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">

                </h1>
                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                            aria-label="Open user menu">
                            <span class="avatar avatar-sm"
                                style="background-image: url(./static/avatars/000m.jpg)"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div>Paweł Kuna</div>
                                <div class="mt-1 small text-muted">UI Designer</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <form action="{{ route('auth.logout') }}" method="POST">
                                @csrf
                                <button class="btn btn-link" type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Menu Partial Layout -->
        @include('partials.private.menu')
        <!-- Menu Partial Layout -->
        <div class="page-wrapper">
            <!-- Page header -->
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <!-- Page pre-title -->
                            <div class="page-pretitle">
                                Overview
                            </div>
                            @yield('header')
                        </div>
                        <!-- Page title actions -->
                        <div class="col-auto ms-auto d-print-none">
                            <div class="btn-list">
                                @yield('button')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                    <!-- Preloader -->
                    <div id="preloader">
                        <div class="text-muted mb-3">Sedang memuat halaman</div>
                        <div class="progress progress-sm">
                            <div class="progress-bar progress-bar-indeterminate"></div>
                        </div>
                    </div>
                    <div id="page-content">
                        @yield('message')
                        @yield('content')
                    </div>
                </div>
            </div>
            @yield('modal')
            <!-- Footer Layout -->
            @include('partials.private.footer')
            <!-- Footer Layout -->
        </div>
    </div>
    <!-- Tabler Core -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="/dist/js/tabler.min.js?1684106062" defer></script>
    <script src="/dist/js/demo.min.js?1684106062" defer></script>
    <script>
        // Fungsi untuk menunjukkan elemen preloader
        function showPreloader() {
            $('#page-content').hide();
            $('#preloader').show();
        }

        function hidePreloader() {
            $('#page-content').show();
            $('#preloader').hide();
        }

        showPreloader();

        $(window).on('load', function() {
            hidePreloader();
        });
    </script>
    @yield('js')
</body>

</html>
