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
    <link href="/dist/css/demo.min.css?1684106062" rel="stylesheet" />
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
                    @yield('message')
                    @yield('content')
                </div>
            </div>
            @yield('modal')
            <!-- Footer Layout -->
            @include('partials.private.footer')
            <!-- Footer Layout -->
        </div>
    </div>
    <!-- Tabler Core -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="/dist/js/tabler.min.js?1684106062" defer></script>
    <script src="/dist/js/demo.min.js?1684106062" defer></script>
    @yield('js')
</body>

</html>
