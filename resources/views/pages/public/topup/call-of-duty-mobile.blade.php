@extends('master.public.index')

@section('meta')
    <meta name="description"
        content="Beli CP atau top up CODM murah dan terpercaya tanpa ribet! Bayar pakai E-Wallet, Bank, atau QRIS." />
@endsection


@section('title')
    <title>Top Up CODM Murah dan Instan - Call of Duty Mobile</title>
@endsection

@section('message')
    <div class="alert alert-danger" role="alert" id="stickyAlert" style="display:none;">
        <span id="errorMessage"></span>
    </div>
@endsection

@section('loading')
    <div id="loadingOverlay" style="display:none;">
        <h4>Mohon di tunggu</h4>
        <h6>Invoice kamu sedang di proses</h6>
        <div id="loadingSpinner"></div>
    </div>
@endsection

@section('content')
    <div class="product-header">
        <div class="container">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-3">
                        <img src="{{ asset(Storage::url($game->url_gambar)) }}" class="img-fluid">
                    </div>
                    <div class="col-md-9">
                        <div class="heading-section text-center">
                            <h4>Cara Top Up {{ $game->nama }}</h4>
                        </div>
                        <div class="col-md-12">
                            <div class="description">
                                <p>Cara Top Up {{ $game->nama }} Murah, Mudah, dan Nyaman</p>
                                <ul>
                                    <li>1. Pilih Jumlah Nominal Diamond</li>
                                    <li>2. Masukkan Player ID </li>
                                    <li>3. Pilih Metode Pembayaran</li>
                                    <li>4. Masukkan Nomor Whatsapp atau Telepon Kamu </li>
                                    <li>5. Klik Konfirmasi Top Up & Melakukan Pembayaran </li>
                                    <li>6. Tunggu Beberapa Saat Diamond Akan Otomatis Masuk Ke Akun Anda.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="products">
        <div class="row">
            <div class="container">
                <div class="heading-section text-center">
                    <h4>Pilih Produk dan Nominal</h4>
                </div>
                <div class="alert-undawn">
                    <div class="alert alert-success text-center" role="alert">
                        <h6 class="text-dark">Support <b>SEMUA</b> bind! Garena ✅ | Facebook ✅</h6>
                    </div>
                </div>
                <div class="item-parent mb-4">
                    <div class="col-md-12">
                        <div class="row align-items-center mb-4">
                            <div class="col">
                                <h5>📀 CP</h5>
                            </div>
                        </div>
                        @include('pages.public.topup.product.umum')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="data">
        <div class="row">
            <div class="container">
                <div class="col-lg-12">
                    <div class="heading-section text-center">
                        <h4>Masukkan Data Kamu</h4>
                    </div>
                    <div class="data-parent">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="data-input">
                                        <input id="userIdInput" type="text" placeholder="Masukkan Player ID" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('pages.public.topup.payment.index')

    <div class="data">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading-section text-center">
                    <h4>Masukkan Telepon Kamu</h4>
                </div>
                <div class="data-parent">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="data-input">
                                    <input id="userPhoneInput" type="number" placeholder="62857xxx (Tanpa Tanda Plus)" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="data">
        <div class="row">
            <div class="col-lg-12">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="data-parent">
                                <div class="main-status-button text-center">
                                    <a href="#" id="checkout">Konfirmasi Top Up</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="additional-title">
            <h2>Mau Top Up CODM Murah dan Aman? Fumola Store Jawabannya!</h2>
            <p>
                Di era gaming yang semakin maju ini, Call of Duty Mobile (CODM) telah menjadi salah satu game yang paling
                banyak dimainkan di seluruh dunia. Belum lagi, harga top up CODM murah dan sering banyak diskon.
                <b>Hah, Top up …?</b>
            </p>
            <div class="text-center mt-3">
                <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#description">
                    Baca Selengkapnya
                </button>
            </div>
            <div class="collapse" id="description">
                <div class="additional-title">
                    <p>
                        Ya, game ini tidak hanya menawarkan aksi yang seru, tapi juga grafik yang memukau dan gameplay yang
                        menantang.
                        Dibalik semua itu, untuk mendapatkan pengalaman bermain yang maksimal, kamu memerlukan COD Points
                        (CP). Biar nggak ambigu, biar kami jelaskan sampai tuntas!
                    </p>
                    <h2>
                        Kenapa Sih, Top Up CP Itu Penting dalam CODM?
                    </h2>
                    <p>
                        Sebelum membahas lebih jauh, penting bagi pemain baru untuk mengerti mengapa CP (COD Points) sangat
                        penting dalam Call of Duty Mobile. Jadi, <b>CP adalah mata uang dalam game yang memungkinkan pemain
                            untuk membeli item premium, seperti skin senjata, karakter, dan Battle Pass.</b>
                    </p>
                    <p>
                        Dengan item-item ini, tidak hanya penampilan karakter kamu yang menjadi lebih keren, tapi juga bisa
                        menambah semangat dan motivasi dalam bermain.
                    </p>
                    <p>
                        Nah, disitulah Fumola Store berperan. Kami hadir untuk memudahkan kamu melakukan top up CODM dengan
                        harga murah, proses cepat, dan tentunya aman.
                    </p>
                    <h2>
                        Memangnya, Apa Saja Keuntungan Top Up CODM di Fumola Store?
                    </h2>
                    <p>
                        Fumola Store bukan sembarang tempat top up Call of Duty Mobile! Kami menawarkan berbagai keunggulan
                        yang membuat kamu tidak perlu lagi mencari tempat lain untuk kebutuhan top up CODM-mu:
                    </p>
                    <ul>
                        <li>
                            <b>1. Harga Bersahabat:</b> Di Fumola Store, kami menawarkan harga top up CODM murah dan
                            bersahabat.
                            Karena kami benar-benar memahami kebutuhan para gamers yang ingin berhemat tanpa mengurangi
                            keseruan bermain.
                        </li>
                        <li>
                            <b>2. Proses Mudah dan Cepat:</b> Kami mengerti waktu adalah hal yang berharga bagi setiap
                            gamer. Oleh
                            karena itu, proses top up game CODM di Fumola Store dirancang agar mudah dan cepat, sehingga CP
                            kamu bisa segera terisi dan kamu bisa kembali beraksi.
                        </li>
                        <li>
                            <b>3. Keamanan Transaksi:</b> Keamanan transaksi adalah prioritas kami. Fumola Store menggunakan
                            sistem
                            pembayaran yang aman dan terpercaya untuk menjamin keamanan dana dan data pribadi kamu.
                        </li>
                        <li>
                            <b>4. Pelayanan Pelanggan:</b> Tim support kami siap melayani pertanyaan atau masalah yang
                            mungkin kamu
                            hadapi selama proses top up CODM. Kami berkomitmen untuk memberikan pengalaman terbaik bagi
                            pelanggan.
                        </li>
                    </ul>
                    <p>
                        Gimana? Kurang apa coba? Udah biaya top up CODM murah, cepat, aman, dan selalu ada support, lagi!
                    </p>
                    <h3>
                        Gimana? Kurang apa coba? Udah biaya top up CODM murah, cepat, aman, dan selalu ada support, lagi!
                    </h3>
                    <p>
                        Kamu pengen top up CODM murah dan simple? Ikuti langkah-langkah berikut ini:
                    </p>
                    <ul>
                        <li>
                            <b>1. Kunjungi Website:</b> Pertama, buka website Fumola Store. Interface yang ramah pengguna
                            akan memudahkan kamu menavigasi situs kami.
                        </li>
                        <li>
                            <b>2. Pilih Paket:</b> Kami menyediakan berbagai pilihan paket CP yang bisa kamu pilih sesuai
                            dengan kebutuhan dan budgetmu.
                        </li>
                        <li>
                            <b>3. Masukkan Detail Akun:</b> Setelah memilih paket, masukkan ID pengguna CODM-mu. Pastikan ID
                            yang kamu masukkan sudah benar untuk menghindari kesalahan pengisian.
                        </li>
                        <li>
                            <b>4. Pilih Metode Pembayaran:</b> Kami menyediakan berbagai metode pembayaran, mulai dari
                            transfer bank,
                            e-wallet, QRIS, hingga via outlet. Pokoknya, pilih aja yang paling nyaman untukmu.
                        </li>
                        <li>
                            <b>5. Konfirmasi dan Tunggu:</b> Setelah pembayaran dikonfirmasi, CP akan segera ditambahkan ke
                            akun
                            CODM-mu. Proses ini tidak akan memakan waktu lama, kok! Cukup beberapa detik saja, CP sudah
                            masuk ke akunmu
                        </li>
                    </ul>
                    <h2>
                        Jangan Boros! Ikuti Tips Menggunakan CP dengan Bijak dari Fumola Store
                    </h2>
                    <p>
                        Setelah berhasil melakukan top up CODM murah di Fumola Store, menggunakan CP dengan bijak adalah
                        kunci untuk meningkatkan pengalaman bermainmu. Berikut beberapa tips dari kami:
                    </p>
                    <h3>
                        1. Investasikan pada Battle Pass
                    </h3>
                    <p>
                        Dengan Battle Pass, kamu bisa mendapatkan berbagai item eksklusif yang <b>tidak hanya meningkatkan
                            penampilan karaktermu, tapi juga bisa memberikan keuntungan dalam permainan.</b>
                    </p>
                    <h3>
                        2. Perhatikan Bundle dan Promo
                    </h3>
                    <p>
                        Fumola Store <b>seringkali menawarkan bundle dan promo eksklusif.</b> Jadi, selalu perhatikan
                        penawaran
                        yang kami berikan untuk mendapatkan deal terbaik. Kalau kamu langganan top up CODM di Fumola Store,
                        pasti nanti bakalan dapat promo.
                    </p>
                    <h3>
                        3. Prioritaskan Kebutuhan
                    </h3>
                    <p>
                        Meskipun tergoda untuk membeli banyak item, <b>prioritaskan pembelian berdasarkan kebutuhan dalam
                            game.</b>
                        Misalnya, jika kamu sering bermain mode tertentu, belilah item yang mendukung mode tersebut.
                    </p>
                    <p>
                        Nah, tiga tips di atas dapat kamu terapkan, supaya tidak menyia-nyiakan CP yang sudah kamu beli. Ya
                        tau sendiri lah, penyesalan itu datang di akhir!
                    </p>
                    <p>
                        <b>Kesimpulannya,</b> top up Call of Duty Mobile bisa kamu dapatkan di Fumola Store. Dengan layanan
                        yang
                        mudah, cepat, aman, dan harga yang bersahabat, kamu bisa mendapatkan CP dan meningkatkan
                        pengalaman bermain CODM-mu tanpa khawatir.
                    </p>
                    <p>
                        Jangan lewatkan kesempatan untuk menjadi yang terbaik di Call of Duty Mobile dengan dukungan penuh
                        dari layanan top up CODM murah Fumola Store. Selamat bermain, dan temukan keseruan tak terhingga di
                        setiap pertempuran yang kamu hadapi!
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="checkoutModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body ">
                    <div class="px-4 py-5">
                        <h4 class="mt-5 theme-color mb-5">Terimakasih.</h4>
                        <span class="theme-color">Cek data kamu sebelum proses pembelian.</span>
                        <div class="mb-3">
                            <hr class="new1">
                        </div>
                        <div class="d-flex justify-content-between">
                            <small>User ID</small>
                            <small><span id="userId"></span></small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small>Telepon</small>
                            <small><span id="userPhoneNumber"></span></small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small>Item</small>
                            <small><span id="itemName"></span></small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small>Tipe Pembayaran</small>
                            <small><span id="paymentType"></span></small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small>Metode Pembayaran</small>
                            <small><span id="paymentMethod"></span></small>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <span class="font-weight-bold">Total</span>
                            <span class="font-weight-bold theme-color" id="itemPrice"></span>
                        </div>
                        <div class="d-flex justify-content-end">
                            <small class="note">*Belum termasuk biaya Admin</small>
                        </div>
                        <div class="text-center mt-5">
                            <button class="btn btn-primary" id="confirmCheckout">Konfirmasi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script>
        var selectedPrice = null;
        var selectedItemName = null;
        var selectedItemId = null;
        var getPaymentMethodValue = null;
        var paymentTypeValue = null;

        $(document).ready(function() {

            function showError(message) {
                $('#errorMessage').text(message);
                $('#stickyAlert').fadeIn('slow');
                setTimeout(function() {
                    $('#stickyAlert').fadeOut('slow');
                }, 7000);
            }

            function hideError() {
                $('#stickyAlert').fadeOut('slow');
            }

            function handleItemClick(item) {
                $('.clickable-item').removeClass('clicked');
                $(item).addClass('clicked');
                selectedPrice = $(item).find('[id^="getItemPrice-"]').val();
                selectedItemId = $(item).find('[id^="getItemId-"]').val();
                selectedItemName = $(item).find('[id^="getItemName-"]').val();
            }

            function handlePaymentClick(item) {
                $('.clickable-payment').removeClass('clicked');
                $(item).addClass('clicked');
                getPaymentMethodValue = $(item).find('input[type="hidden"]').val();
                paymentTypeValue = $(item).find('.getPaymentType').val();
            }

            function formatRupiah(angka) {
                var number_string = angka.toString();
                var split = number_string.split(',');
                var sisa = split[0].length % 3;
                var rupiah = split[0].substr(0, sisa);
                var ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                return rupiah;
            }

            $('.clickable-item').click(function() {
                handleItemClick(this);
            });

            $('.clickable-payment').click(function() {
                handlePaymentClick(this);
            });

            $('#checkout').click(function() {
                var userIdInputValue = $('#userIdInput').val();
                var userPhoneInputValue = $('#userPhoneInput').val();

                if (userIdInputValue.trim() === '') {
                    showError('Harap isi semua Data kamu!');
                    return;
                }

                if (userPhoneInputValue.trim() === '') {
                    showError('Harap isi nomor telepon kamu!');
                    return;
                }

                if (!paymentTypeValue || paymentTypeValue.trim() === '') {
                    showError('Pilih metode pembayaran terlebih dahulu.');
                    return;
                }

                if (selectedPrice !== null) {
                    $('#userPhoneNumber').text(userPhoneInputValue);
                    $('#itemName').text(selectedItemName);
                    $('#itemPrice').text('Rp. ' + formatRupiah(selectedPrice));
                    $('#itemId').val(selectedItemId);
                    $('#userId').text(userIdInputValue);
                    $('#paymentType').text(paymentTypeValue);
                    $('#paymentMethod').text(getPaymentMethodValue);

                    $('#checkoutModal').modal('show');
                } else {
                    showError('Silakan pilih harga terlebih dahulu.');
                }
            });

            $('#confirmCheckout').click(function() {
                $('#loadingOverlay').show();
                $.ajax({
                    url: '/topup/{{ $game->slug }}/process',
                    type: 'POST',
                    data: {
                        price: selectedPrice,
                        itemName: selectedItemName,
                        userId: $('#userId').text(),
                        userPhone: $('#userPhoneInput').val(),
                        itemId: selectedItemId,
                        paymentType: paymentTypeValue,
                        paymentMethod: getPaymentMethodValue,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        } else {
                            $('#loadingOverlay').hide();
                            showError(response.unaccepted);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#loadingOverlay').hide();
                        showError(error.unaccepted);
                    }
                });

                $('#checkoutModal').modal('hide');
            });
        });
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="/assets/css/accordion.css">
    <link rel="stylesheet" href="/assets/css/products.css">
    <link rel="stylesheet" href="/assets/css/payment.css">
    <link rel="stylesheet" href="/assets/css/data.css">
    <link rel="stylesheet" href="/assets/css/product-header.css">
    <link rel="stylesheet" href="/assets/css/contents.css">
    <style>
        .clickable-item {
            cursor: pointer;
        }

        .products .item.clicked {
            background-color: #92f7aa;
            color: #fff;
        }

        .clickable-payment {
            cursor: pointer;
        }

        .payments .clickable-payment.clicked {
            background-color: #92f7aa;
            color: #fff;
        }

        .payments .clickable-payment.clicked p {
            color: #fff;
        }

        #stickyAlert {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            width: 350px;
            /* Atur lebar sesuai kebutuhan Anda */
        }

        #loadingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(47, 61, 145, 0.7);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        #loadingOverlay h4 {
            margin-bottom: 10px;
        }

        #loadingOverlay h6 {
            margin-bottom: 20px;
        }

        #loadingSpinner {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .modal-body {
            background-color: #fff;
            border-color: #fff;
        }

        .modal-body .note {
            color: rgb(164, 169, 173);
            font-size: 10px;
        }

        .theme-color {

            color: #004cb9;
        }

        hr.new1 {
            border-top: 2px dashed #fff;
            margin: 0.4rem 0;
        }


        .btn-primary {
            color: #fff;
            background-color: #004cb9;
            border-color: #004cb9;
            padding: 12px;
            padding-right: 30px;
            padding-left: 30px;
            border-radius: 1px;
            font-size: 17px;
        }


        .btn-primary:hover {
            color: #fff;
            background-color: #004cb9;
            border-color: #004cb9;
            padding: 12px;
            padding-right: 30px;
            padding-left: 30px;
            border-radius: 1px;
            font-size: 17px;
        }

        .payments .item img {
            background-color: #fff;
        }
    </style>
@endsection
