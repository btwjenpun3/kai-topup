@extends('master.public.index')

@section('meta')
    <meta name="description"
        content="Tempat top up game termurah dan terpercaya di Indonesia. Kami menjamin keamanan dan kecepatan transaksi di Fumolastore.id!" />
@endsection

@section('title')
    <title>Fumola Store - Tempat Untuk Top Up Murah, Cepat, Aman dan Nyaman</title>
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
                    <img src="{{ asset(Storage::url('banner/banner-puasa.webp')) }}" alt="Top Up Game Termurah"
                        loading="lazy" style="max-width: 100%;">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="{{ asset(Storage::url('banner/banner.webp')) }}" alt="Top Up Game Termurah" loading="lazy"
                        style="max-width: 100%;">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="{{ asset(Storage::url('banner/banner2.webp')) }}" alt="Top Up Game Termurah" loading="lazy"
                        style="max-width: 100%;">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="{{ asset(Storage::url('banner/banner3.webp')) }}" alt="Top Up Game Termurah" loading="lazy"
                        style="max-width: 100%;">
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
                                        <img src="{{ asset(Storage::url($flashsale->harga->gambar)) }}" loading="lazy"
                                            style="max-width: 100%;">
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
            <h2>Games</h2>
        </div>
        <div class="flex-row">
            @foreach ($games as $game)
                <div class="flex-column item text-center">
                    <a href="{{ route('topup.index', ['slug' => $game->slug]) }}">
                        <img src="{{ asset(Storage::url($game->url_gambar)) }}"
                            alt="Top Up {{ $game->nama }} Termurah, Ternyaman, Tercepat dan Termudah" loading="lazy">
                        <h3 class="text-sm">{{ $game->nama }}</h3>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="games">
        <div class="heading-section text-center">
            <h2>Voucher</h2>
        </div>
        <div class="flex-row">
            @foreach ($vouchers as $voucher)
                <div class="flex-column item text-center">
                    <a href="{{ route('topup.index', ['slug' => $voucher->slug]) }}">
                        <img src="{{ asset(Storage::url($voucher->url_gambar)) }}"
                            alt="Isi Voucher {{ $game->nama }} Termurah, dan Ternyaman" loading="lazy"
                            style="max-width: 100%;">
                        <h3 class="text-sm">{{ $voucher->nama }}</h3>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="games">
        <div class="heading-section text-center">
            <h2>Pulsa & Paket Data</h2>
        </div>
        <div class="flex-row">
            @foreach ($pulsas as $pulsa)
                <div class="flex-column item text-center">
                    <a href="{{ route('topup.index', ['slug' => $pulsa->slug]) }}">
                        <img src="{{ asset(Storage::url($pulsa->url_gambar)) }}"
                            alt="Beli Pulsa dan Paket Data {{ $game->nama }} Termurah, Ternyaman, dan Tercepat"
                            loading="lazy" style="max-width: 100%;">
                        <h3 class="text-sm">{{ $pulsa->nama }}</h3>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="games">
        <div class="heading-section text-center">
            <h2>Listrik</h2>
        </div>
        <div class="flex-row">
            @foreach ($listriks as $listrik)
                <div class="flex-column item text-center">
                    <a href="{{ route('topup.index', ['slug' => $listrik->slug]) }}">
                        <img src="{{ asset(Storage::url($listrik->url_gambar)) }}"
                            alt="Beli {{ $game->nama }} Termurah, dan Ternyaman" loading="lazy"
                            style="max-width: 100%;">
                        <h3 class="text-sm">{{ $listrik->nama }}</h3>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('hero')
    <div class="hero mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="hero-title">
                        <h2>Tempat Top Up Ternyaman</h2>
                    </div>
                    <div class="hero-title">
                        <h3>Fumola Store dipercaya oleh para gamer sejak tahun 2019</h3>
                    </div>
                    <div class="hero-title">
                        <p>Fumola Store menyediakan layanan Top up game dan Reseller Voucher Game murah, cepat, aman, dan
                            nyaman untuk seluruh Indonesia!</p>
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
                                    <img src="{{ asset(Storage::url('banner/5stars.png')) }}" loading="lazy">
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
                                    <img src="{{ asset(Storage::url('banner/5stars.png')) }}" loading="lazy">
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
                                    <img src="{{ asset(Storage::url('banner/5stars.png')) }}" loading="lazy">
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

@section('additional_content')
    <div class="hero additional">
        <div class="container">
            <div class="row">
                <div class="additional-title">
                    <h2>Ingin Top Up Game Termurah? Fumola Store Jawabannya!</h2>
                    <p>
                        Hai, Gamer! Pernah merasa kesal karena kelewatan event menarik, karena kesulitan mendapatkan
                        koin/diamond murah? Atau jangan-jangan malah merasa dompet menjerit karena harga top up yang
                        melangit?
                        Tenang, <a href="{{ route('home') }}">Fumola Store</a> hadir sebagai jawaban dari segala
                        kerisauanmu. Dikenal sebagai tempat top
                        up game termurah, kami siap menyalakan semangat bermainmu tanpa harus menguras kantong!
                    </p>
                </div>
                <div class="text-center mt-3">
                    <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#description">
                        Baca Selengkapnya
                    </button>
                </div>
                <div class="collapse" id="description">
                    <div class="additional-title">
                        <h2>Kenapa Memilih Kami untuk Top Up Game?</h2>
                        <p>
                            Di era digital yang serba cepat ini, top up game bukan hanya tentang mengisi saldo. Ini tentang
                            kecepatan, keamanan, dan tentu saja harga yang ramah di kantong.
                            Fumola Store mengerti betul akan hal itu …
                            Sebagai agen top up game termurah, <b>kami menawarkan lebih dari sekedar top up!</b> Tapi, kami
                            juga
                            menawarkan pengalaman.
                        </p>
                        <h2>Keuntungan Top Up Game di Fumola Store:</h2>
                        <ul>
                            <li><b>1. Harga Bersahabat:</b> Kami percaya, bermain game adalah hak semua orang. Oleh karena
                                itu,
                                Fumola
                                Store menyediakan top up dengan harga yang tidak hanya murah, tapi juga adil.
                                Kami bekerja keras untuk memberikan penawaran terbaik, sehingga setiap gamer dapat terus
                                bermain tanpa beban.
                            </li>
                            <li>
                                <b>2. Kecepatan Layanan:</b> Kami mengerti, di dunia gaming, setiap detik sangatlah
                                berharga.
                                Keterlambatan top up bisa berarti kehilangan momen penting dalam game, baik kehabisan
                                kredit,
                                terlewatkan event menarik, dll.
                                Sebagai situs top up game termurah dan terpercaya, kami memberikan proses eksekusi yang
                                cepat
                                dan mudah.
                            </li>
                            <li>
                                <b>3. Keamanan Terjamin:</b> Dalam melakukan top up, keamanan data adalah prioritas. Fumola
                                Store
                                menggunakan sistem keamanan terkini untuk menjaga informasi pribadi dan transaksimu. Bermain
                                game jadi lebih nyaman tanpa kekhawatiran!
                            </li>
                        </ul>
                        <h2>Kamu Bisa Top Up dengan Harga Murah untuk Banyak Game!</h2>
                        <p>
                            Fumola Store tidak hanya situs top up game termurah, tapi juga terlengkap. Kami menyediakan
                            berbagai pilihan game populer, seperti:
                        </p>
                        <button class="btn btn-link" type="button" data-bs-toggle="collapse"
                            data-bs-target="#list-games">
                            Daftar Game
                        </button>
                        <div class="collapse" id="list-games">
                            <ol>
                                <li>Mobile Legends: Bang Bang</li>
                                <li>PUBG Mobile Indonesia</li>
                                <li>Free Fire</li>
                                <li>Call of Duty Mobile</li>
                                <li>League of Legends: Wild Rift</li>
                                <li>LifeAfter</li>
                                <li>Clash of Clans</li>
                                <li>Dragon Raja (SEA)</li>
                                <li>Eggy Party</li>
                                <li>Genshin Impact</li>
                                <li>Hay Day</li>
                                <li>Honkai Star Rail</li>
                                <li>Love Nikki</li>
                                <li>Ludo Club</li>
                                <li>Metal Slug Awakening</li>
                                <li>Ragnarok Origin</li>
                                <li>Sausage Man</li>
                                <li>Stumble Guys</li>
                                <li>Tower of Fantasy</li>
                                <li>Undawn</li>
                                <li>Valorant</li>
                                <li>Zepetto</li>
                                <li>Bigo Live</li>
                                <li>Lita</li>
                                <li>dll</li>
                            </ol>
                        </div>
                        <p>
                            Setiap game memiliki variasi top up yang bisa disesuaikan dengan kebutuhanmu, mulai dari nominal
                            kecil hingga paket besar.
                        </p>
                        <h2>Bagaimana Cara Mudah Top Up Game Murah di Fumola Store?</h2>
                        <p>Top up di Fumola Store itu gampang banget! Ikuti langkah simpel ini:</p>
                        <ul>
                            <li>1. Kunjungi website Fumola Store dan pilih game yang ingin di-top up.</li>
                            <li>2. Masukkan ID game dan pilih nominal top up.</li>
                            <li>3. Pilih metode pembayaran yang kamu inginkan. Kami menyediakan berbagai pilihan, dari
                                transfer bank maupun e-wallet.</li>
                            <li>4. Konfirmasi dan selesaikan pembayaran.</li>
                            <li>5. Saldo game kamu langsung terisi dan siap bertarung kembali!</li>
                        </ul>
                        <p>
                            <b>Gimana, cara top up game termurah itu gampang banget, kan?</b> Nggak nyampe 10 detik, saldo
                            game
                            kamu udah masuk.
                            Jadi, tak perlu ragu lagi, karena banyak gamer telah merasakan manfaat dari layanan Fumola
                            Store.
                            Dari kecepatan transaksi hingga support yang responsif, kami selalu berusaha memberikan yang
                            terbaik. <b>"Top up game termurah dan terpercaya,"</b> itu yang mereka katakan tentang kami.
                        </p>
                        <h2>Hati-Hati Penipuan!</h2>
                        <p>
                            Di tengah kemudahan top up game yang ditawarkan oleh agen top up game termurah, penting bagi
                            kita semua untuk tetap waspada terhadap berbagai bentuk penipuan yang marak terjadi.
                            Sebagai situs top up game termurah dan terpercaya, kami ingin memastikan pengalaman bermain game
                            kamu tidak hanya menyenangkan, tapi juga aman.
                            Berikut adalah beberapa hal yang perlu diwaspadai:
                        </p>
                        <h3>1. Phishing dan Perampasan Data</h3>
                        <p>
                            Salah satu metode penipuan yang sering terjadi adalah phishing, di mana pelaku mencoba
                            mendapatkan data sensitif seperti username, password, dan informasi pembayaran dengan menyamar
                            sebagai entitas terpercaya.
                            Ingat, Fumola Store tidak akan pernah meminta data pribadimu melalui email atau pesan tidak
                            resmi.
                        </p>
                        <h3>2. Situs Top Up Game Murah Palsu</h3>
                        <p>
                            Penipu seringkali membuat situs yang mirip dengan situs resmi untuk menipu pengguna. Pastikan
                            kamu selalu mengakses Fumola Store melalui alamat web resmi kami.
                            Periksa URL di browsermu dan pastikan tidak ada kesalahan ketik atau karakter yang mencurigakan.
                        </p>
                        <h3>3. Tawaran yang Terlalu Menggiurkan</h3>
                        <p>
                            Waspada terhadap tawaran top up game dengan harga yang tidak realistis. Jika sebuah tawaran
                            terdengar terlalu bagus untuk menjadi kenyataan, kemungkinan besar itu adalah penipuan.
                            Fumola Store menawarkan harga yang kompetitif dan transparan tanpa biaya tersembunyi.
                        </p>
                        <h3>4. Modus Penipuan Lainnya</h3>
                        <p>
                            Penipuan bisa datang dalam berbagai bentuk, termasuk namun tidak terbatas pada, penawaran
                            eksklusif melalui pesan pribadi, aplikasi top up palsu, atau bahkan melalui media sosial. Selalu
                            gunakan akal sehat dan lakukan verifikasi sebelum melakukan transaksi.
                        </p>
                        <h3>Gimana Sih, Tips Menghindari Penipuan Agen Top Up Game Termurah di Indonesia?</h3>
                        <ul>
                            <li><b>1. Gunakan Sumber Terpercaya:</b> Selalu lakukan top up melalui sumber yang terpercaya
                                seperti Fumola Store. Jangan tergiur dengan tawaran dari sumber tidak dikenal.</li>
                            <li><b>2. Periksa Keamanan Situs:</b> Pastikan website tempatmu melakukan top up menggunakan
                                protokol HTTPS untuk keamanan datamu.</li>
                            <li><b>3. Jangan Bagikan Informasi Pribadi:</b> Jaga kerahasiaan data pribadi dan informasi
                                pembayaranmu. Fumola Store tidak akan meminta informasi sensitif melalui kanal tidak resmi.
                            </li>
                            <li><b>4. Gunakan Password yang Kuat:</b> Pastikan akun game dan emailmu dilindungi dengan
                                password yang kuat dan unik.</li>
                            <li><b>5. Update Regular:</b> Pastikan software dan aplikasi game kamu selalu diperbarui untuk
                                menghindari celah keamanan.</li>
                        </ul>
                        <p>
                            Jadi, bermain game harusnya menyenangkan dan aman. Di Fumola Store, kami berkomitmen untuk
                            menyediakan layanan top up game yang tidak hanya murah dan cepat, tapi juga paling aman.
                        </p>
                        <mark>
                            Ingatlah selalu tips keamanan ini dan jadilah gamer yang cerdas. Jangan biarkan penipuan
                            mengganggu keseruan bermain game kamu. Bersama Fumola Store, nikmati permainan tanpa batas dan
                            tanpa rasa khawatir!
                        </mark>
                        <h2>Keamanan dan Kepercayaan Top Up di Fumola Store Sudah Tersertifikasi!</h2>
                        <p>
                            Di Fumola Store, kami tidak hanya berkomitmen untuk menyediakan layanan top up game termurah dan
                            proses yang cepat. Lebih dari itu, keamanan dan kepercayaan pelanggan adalah prioritas utama
                            kami.
                            Untuk itu, kami bangga mengumumkan bahwa Fumola Store memiliki sertifikasi keamanan digital yang
                            diakui, menegaskan komitmen kami dalam menjaga standar keamanan tertinggi.
                        </p>
                        <h3>Keamanan Transaksi Adalah Komitmen Utama Kami</h3>
                        <p>
                            Kami melakukan praktik keamanan yang ketat! Mulai dari enkripsi data hingga protokol keamanan
                            terbaru. Pokoknya semua aspek di Fumola Store dirancang untuk menjaga keamanan informasi pribadi
                            dan transaksi pelanggan.
                        </p>
                        <h3>Tanggung Jawab Penuh Atas Semua Transaksi</h3>
                        <p>
                            Lebih jauh, <b>kami bertanggung jawab penuh atas semua transaksi yang terjadi di
                                fumolastore.id.</b>
                            Setiap transaksi top up game murah yang kamu lakukan dijamin aman, dan kami siap
                            memberikan
                            dukungan penuh apabila terjadi masalah.
                            Tim dukungan pelanggan kami yang ramah dan profesional selalu siap membantumu 24/7,
                            memastikan
                            setiap isu yang muncul dapat segera diselesaikan.
                        </p>
                        <h2>Kepercayaan Pelanggan adalah Modal Kami</h2>
                        <p>
                            Kepercayaan pelanggan adalah aset terbesar kami. Fumola Store juga memahami bahwa dalam industri
                            top up game, kepercayaan pelanggan adalah kunci kesuksesan.
                            Oleh karena itu, kami berkomitmen untuk terus memperbarui dan meningkatkan sistem keamanan kami,
                            serta menjaga transparansi dalam setiap layanan yang kami tawarkan.
                        </p>
                        <mark>
                            <b>Kesimpulannya,</b> Fumola Store bukan hanya tentang top up game termurah atau layanan cepat.
                            Tapi
                            ini adalah tentang membangun hubungan kepercayaan dengan setiap gamer.
                        </mark>
                        <p>
                            Dengan sertifikasi keamanan yang diakui dan komitmen kami untuk bertanggung jawab penuh atas
                            setiap transaksi, kami berharap kamu bisa bertransaksi dengan penuh keyakinan.
                        </p>
                        <p>
                            Bergabunglah dengan ribuan gamer lain yang telah menjadikan Fumola Store sebagai pilihan utama
                            mereka untuk top up game. Rasakan sendiri keamanan, kenyamanan, dan kepuasan bertransaksi di
                            Fumola Store!
                        </p>
                        <p><b>Fumolastore.id, website top up game termurah dan terpercaya sejagat raya!</b></p>
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
