<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta19
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="icon" type="image/x-icon" href="{{ asset(Storage::url('assets/favicon.ico')) }}">
    <title>Login ke Realm.</title>
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
</head>

<body class=" d-flex flex-column">
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <a href="." class="navbar-brand navbar-brand-autodark"><img src="/img/logo.png" height="45"
                        alt=""></a>
            </div>

            @yield('content')

        </div>
    </div>
    <script src="/dist/js/tabler.min.js?1684106062" defer></script>
</body>

</html>
