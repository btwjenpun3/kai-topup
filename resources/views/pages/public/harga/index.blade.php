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
            <h4>Keuntungan Menjadi Member / Reseller</h4>
        </div>
        <div class="mb-4">
            <p class="text-light" style="font-size: 16px">Dengan mendaftar sebagai reseller di situs web kami, kamu akan
                mendapatkan manfaat eksklusif,
                termasuk harga
                spesial yang tidak dapat kamu temukan di tempat lain. Kami berkomitmen untuk memberikan penawaran terbaik
                kepada para mitra reseller kami.
                <br>
                <br>
                Untuk memastikan transparansi dan kepercayaan, kami telah menyusun tabel perbandingan harga yang
                memungkinkan kamu untuk melihat perbedaan antara harga reguler dan harga reseller kami. Dengan demikian,
                kamu dapat dengan mudah membandingkan dan memahami keuntungan yang kamu dapatkan dengan menjadi bagian dari
                jaringan reseller kami.
                <br>
                <br>
                Jangan ragu untuk mendaftar hari ini dan mulailah menikmati keuntungan dari harga terbaik yang kami
                tawarkan. Kami siap memberikan dukungan penuh untuk memastikan kesuksesan bisnis kamu. Bergabunglah dengan
                kami sekarang dan rasakan perbedaannya
            </p>
        </div>
        <div class="mt-4">
            <div class="heading-section text-center">
                <h4>Cara Mendaftar Member/ Reseller</h4>
            </div>
            <p class="text-light mb-2" style="font-size: 16px">Cara mendaftarnya cukup mudah! Ikuti langkah di bawah ini</p>
            <ul class="text-light" style="font-size: 14px">
                <li>1. Daftar melalui link <a href="{{ route('auth.index') }}">Klik Disini</a></li>
                <li>2. Klik Daftar atau jika kamu memiliki akun Google, maka klik "Masuk dengan Google"</li>
                <li>3. Voila, kamu telah menjadi Member / Reseller kami!</li>
                <li>4. Lakukan Isi Saldo untuk memulai transaksi pertama kamu!</li>
            </ul>
        </div>
        <div class="heading-section text-center mt-4">
            <h4>Perbandingan Harga</h4>
        </div>
        <div class="col-md-12">
            @foreach ($games as $game)
                <div class="table-responsive mb-4">
                    <div class="d-flex" style="padding:15px;background-color:rgb(5, 80, 179)">
                        <h3 class="text-light">{{ $game->nama }}</h3>
                    </div>
                    <table class="table table-nowrap text-dark bg-light">
                        <thead>
                            <th>Produk</th>
                            <th>Harga Normal</th>
                            <th>Harga Member / Reseller</th>
                            <th>Keuntungan</th>
                        </thead>
                        @php
                            $harga = $game->harga;
                        @endphp
                        @foreach ($harga->where('harga_jual', '>=', '0')->where('harga_jual_reseller', '>=', '0') as $h)
                            <tbody>
                                <td>{{ $h->nama_produk }}</td>
                                <td>{{ $formatHarga->rupiah($h->harga_jual) }}</td>
                                <td>{{ $formatHarga->rupiah($h->harga_jual_reseller) }}</td>
                                <td class="text-success">
                                    {{ $formatHarga->rupiah($h->harga_jual - $h->harga_jual_reseller) }}</td>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            @endforeach
        </div>
    </div>
    </div>
@endsection

@section('js')
@endsection
