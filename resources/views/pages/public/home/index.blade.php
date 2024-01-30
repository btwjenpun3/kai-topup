@extends('master.public.index')

@section('title')
    <title>Kai Top Up</title>
@endsection

@section('slider')
    <div class="main-banner">
        <div class="row">
            <div class="col-lg-7">
                <div class="header-text">
                    <h4><em>Selamat Datang</em> di Kai Top Up</h4>
                    <h6>Nikmati Segala Kemudahan Untuk Top Up Game Kesayangan Kalian</h6>
                    <div class="main-button">
                        <a href="browse.html">Browse Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="most-popular">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading-section">
                    <h4><em>List</em> Games</h4>
                </div>
                <div class="row">
                    @foreach ($games as $game)
                        <div class="col-lg-3 col-sm-6 col-6 col-md-6">
                            <div class="item text-center">
                                <a href="{{ route('topup.index', ['slug' => $game->slug]) }}">
                                    <img src="{{ asset(Storage::url($game->url_gambar)) }}" alt="">
                                    <h4>{{ $game->nama }}</h4>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
