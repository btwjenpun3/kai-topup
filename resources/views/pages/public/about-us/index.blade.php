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
@endsection

@section('content')
    <div class="games">
        <div class="heading-section text-center">
            <h4>Tentang Kami</h4>
        </div>
        <div class="mb-4">
            <div class="col-md-12">
                <div class="text-center bg-light p-3" style="max-width:300px;border-radius:23px;">
                    <img src="/img/logo.png">
                </div>
            </div>
            <p class="text-light mt-3" style="font-size: 16px">
                Fumola Store adalah tempat / toko untuk top up ternyaman dan termudah game kesayangan kamu. Berdiri sejak
                2019, toko ini sudah di percaya oleh ratusan pelanggan karena harga yang murah, nyaman, proses cepat, dan
                mudah.
            </p>
            <h4 class="mt-4 mb-3">Kontak Kami</h4>
            <ul class="text-light" style="line-height: 30px">
                <li><b>Nomor Kontak :</b> 081223864722 (WhatsApp Only) </li>
                <li><b>Email :</b> helmibussiness@gmail.com </li>
                <li><b>Alamat :</b> Bumi Panyileukan J4 No. 7, RT 002 RW 009, Panyileukan, Cipadung Kidul, Kota Bandung</li>
            </ul>
        </div>
    </div>
    </div>
@endsection

@section('js')
@endsection
