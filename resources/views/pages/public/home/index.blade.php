@extends('master.public.index')

@section('title')
    <title>Fumola Store - Beranda</title>
@endsection

@section('css')
    <link rel="stylesheet" href="/assets/css/flashsale.css">
    <link rel="stylesheet" href="/assets/css/games.css">
    <link rel="stylesheet" href="/assets/css/button-home.css">
    <link rel="stylesheet" href="/assets/css/hero.css">
@endsection

@section('slider')
    <div class="main-banner text-center">
        <div id="main-slider" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="5000">
                    <img src="{{ asset(Storage::url('banner/slider2.webp')) }}" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="{{ asset(Storage::url('banner/slider.webp')) }}" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#main-slider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#main-slider" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
@endsection

@section('content')
    @if (count($flashsales) > 0)
        <div class="flash-sale">
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <div class="heading-section mb-4">
                                    <button class='glowing-btn'>
                                        <span class='glowing-txt'>⚡ Flash<span class="faulty-letter"> Sale</span> ⚡</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        @foreach ($flashsales as $flashsale)
                            <div class="col-lg-2 col-sm-6 col-6 col-md-6">
                                <div class="item text-center">
                                    <a href="{{ route('topup.index', ['slug' => $flashsale->harga->game->slug]) }}">
                                        <img src="{{ asset(Storage::url($flashsale->harga->gambar)) }}">
                                        <h4>{{ $flashsale->harga->nama_produk }}</h4>
                                        <span class="text-danger"><s>Rp.
                                                {{ number_format($flashsale->harga->harga_jual, 0, ',', '.') }}</s></span>
                                        <span>Rp.
                                            {{ number_format($flashsale->final_price, 0, ',', '.') }}</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="games">
        <div class="heading-section text-center">
            <h4>Games</h4>
        </div>
        <div class="flex-row">
            @foreach ($games as $game)
                <div class="flex-column item text-center">
                    <a href="{{ route('topup.index', ['slug' => $game->slug]) }}">
                        <img src="{{ asset(Storage::url($game->url_gambar)) }}" alt="">
                        <h4 class="text-sm">{{ $game->nama }}</h4>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="games">
        <div class="heading-section text-center">
            <h4>Pulsa & Paket Data</h4>
        </div>
        <div class="flex-row">
            @foreach ($pulsas as $pulsa)
                <div class="flex-column item text-center">
                    <a href="{{ route('topup.index', ['slug' => $pulsa->slug]) }}">
                        <img src="{{ asset(Storage::url($pulsa->url_gambar)) }}" alt="">
                        <h4 class="text-sm">{{ $pulsa->nama }}</h4>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="games">
        <div class="heading-section text-center">
            <h4>Listrik</h4>
        </div>
        <div class="flex-row">
            @foreach ($listriks as $listrik)
                <div class="flex-column item text-center">
                    <a href="{{ route('topup.index', ['slug' => $listrik->slug]) }}">
                        <img src="{{ asset(Storage::url($listrik->url_gambar)) }}" alt="">
                        <h4 class="text-sm">{{ $listrik->nama }}</h4>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('hero')
    <div class="hero">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="hero-title">
                        <h5>Di Percaya oleh Ribuan User</h5>
                    </div>
                    <div class="hero-title">
                        <h4>Fumola Store dipercaya oleh Para gamers profesional</h4>
                    </div>
                    <div class="hero-title">
                        <p>Fumola Store menyediakan layanan Top up game dan Reseller Voucher Game termurah dan terpercaya di
                            Indonesia.</p>
                    </div>
                    <div class="sales-container">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-6">
                                <div class="sales-flex">
                                    <div class="sales">
                                        <h4>157+</h4>
                                        <h5>Pengguna</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-6">
                                <div class="sales-flex">
                                    <div class="sales">
                                        <h4>73+</h4>
                                        <h5>Games</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-6">
                                <div class="sales-flex">
                                    <div class="sales">
                                        <h4>567+</h4>
                                        <h5>Produk</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-6">
                                <div class="sales-flex">
                                    <div class="sales">
                                        <h4>1179+</h4>
                                        <h5>Transaksi</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="sales-review-container">
                        <div class="owl-carousel owl-theme">
                            <div class="item" style="width:250px">
                                <div class="sales-review">
                                    <img src="{{ asset(Storage::url('banner/5stars.png')) }}">
                                    <h5>Undawn</h5>
                                    <div class="sales-review-p">
                                        <p>Mantab</p>
                                    </div>
                                    <div class="sales-user-p">
                                        <p>Pengguna</p>
                                    </div>
                                </div>
                            </div>
                            <div class="item" style="width:250px">
                                <div class="sales-review">
                                    <img src="{{ asset(Storage::url('banner/5stars.png')) }}">
                                    <h5>LifeAfter</h5>
                                    <div class="sales-review-p">
                                        <p>Mantab</p>
                                    </div>
                                    <div class="sales-user-p">
                                        <p>Pengguna</p>
                                    </div>
                                </div>
                            </div>
                            <div class="item" style="width:250px">
                                <div class="sales-review">
                                    <img src="{{ asset(Storage::url('banner/5stars.png')) }}">
                                    <h5>Mobile Legend</h5>
                                    <div class="sales-review-p">
                                        <p>Mantab</p>
                                    </div>
                                    <div class="sales-user-p">
                                        <p>Pengguna</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                items: 3, // Jumlah item per slide
                loop: true, // Putar secara terus menerus
                autoWidth: true,
                loop: true,
                autoplay: true,
                autoplayTimeout: 2000,
            });
        });
    </script>
@endsection
