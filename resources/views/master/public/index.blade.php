<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="Selamat datang di Fumola Store, tujuan utama Anda untuk top up game dengan harga murah. Dapatkan pengalaman top up yang nyaman, cepat, dan aman bersama kami. Jelajahi koleksi kami dan nikmati harga yang tak tertandingi, layanan yang ramah, serta proses pembayaran yang cepat dan aman." />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    @yield('title')
    @yield('css')
    <link rel="icon" type="image/x-icon" href="{{ asset(Storage::url('assets/favicon.ico')) }}">
    <!-- Bootstrap core CSS -->
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="/assets/css/fontawesome.css">
    <link rel="stylesheet" href="/assets/css/templatemo-cyborg-gaming.css">
    <link rel="stylesheet" href="/assets/css/owl.css">
    {{-- <link rel="stylesheet" href="/assets/css/animate.css"> --}}
    <link rel="stylesheet" href="/assets/css/flexbox.css">
    <link rel="stylesheet" href="/assets/css/slider-background.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
</head>

<body>
    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- ***** Navbar Area Start ***** -->
    @include('partials.public.navbar')
    <!-- ***** Navbar Area End ***** -->
    @yield('loading')

    <!-- ***** Slider Start ***** -->
    @yield('slider')
    <!-- ***** Slider End ***** -->
    <ul class="background">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-content">
                    <!-- ***** Content Start ***** -->
                    @yield('content')
                    <!-- ***** Content End ***** -->
                </div>
            </div>
        </div>
    </div>

    <a href="https://wa.me/6281223864722/" class="float" target="_blank">
        <i class="fa-brands fa-whatsapp my-float"></i>
    </a>

    @yield('hero')

    @yield('message')
    @yield('modal')
    @include('partials.public.footer')

    <!-- Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

    <script src="/assets/js/isotope.min.js"></script>
    <script src="/assets/js/owl-carousel.js"></script>
    <script src="/assets/js/tabs.js"></script>
    <script src="/assets/js/popup.js"></script>
    <script src="/assets/js/custom.js"></script>
    <script></script>
    @yield('js')
</body>

</html>
