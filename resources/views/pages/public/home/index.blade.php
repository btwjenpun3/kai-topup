@extends('master.public.index')

@section('title')
    <title>Fumola Store - Beranda</title>
@endsection

@section('css')
    <link rel="stylesheet" href="/assets/css/flashsale.css">
    <link rel="stylesheet" href="/assets/css/games.css">
    <link rel="stylesheet" href="/assets/css/button-home.css">
@endsection

@section('slider')
    <div class="main-banner text-center">
        <img src="/img/slider.webp" class="img-fluid">
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

@section('js')
    <script></script>
@endsection
