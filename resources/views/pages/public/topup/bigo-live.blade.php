@extends('master.public.index')

@section('meta')
    <meta name="description"
        content="Top up Diamond Bigo Live tanpa ribet! Cukup masukkan ID pengguna dan bayar pakai E-Wallet atau virtual account." />
@endsection

@section('title')
    <title>Fumola Store - Top Up Diamond Bigo Live Murah dan Proses Cepat</title>
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
                                    <li>2. Masukkan ID Pengguna </li>
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
                <div class="item-parent mb-4">
                    <div class="col-md-12">
                        <div class="row align-items-center mb-4">
                            <div class="col">
                                <h5>💎 Diamond</h5>
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
                                        <input id="userIdInput" type="text" placeholder="Masukkan ID Pengguna"
                                            required />
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
    <hr>
    <div class="content">
        <div class="additional-title">
            <h2>Temukan Kenyamanan Top Up Diamond Bigo Live Hanya di Fumola Store!</h2>
            <p>
                Di zaman yang serba digital ini, Bigo Live telah menjadi salah satu platform favorit untuk live
                streaming, berbagi momen, dan mengekspresikan diri. Makanya, Fumola Store hadir untuk melayani top
                up diamond bigo secara instan!
                Kenapa harus top up? Seperti yang kita tahu, pengalamanmu di Bigo Live akan jadi lebih seru kalau
                punya diamond yang cukup. Karena ada banyak hal yang bisa kamu lakukan dan lebih akrab dengan
                streamer maupun penonton lainnya melalui gift/hadiah.
            </p>
        </div>
        <div class="text-center mt-3">
            <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#description">
                Baca Selengkapnya
            </button>
        </div>
        <div class="collapse" id="description">
            <div class="additional-title">
                <h2>
                    Memangnya, Apa yang Didapat Ketika Memberikan Gift ke Streamer di Bigo Live?
                </h2>
                <p>
                    Jadi, ketika kamu top up diamond bigo live dan mengirimkan gift ke streamer, kamu bakal dapet banyak
                    hal, seperti:
                </p>
                <ul>
                    <li>
                        <b>Pengakuan:</b> Streamer biasanya akan ngucapin terima kasih atau menyebut nama kamu secara
                        langsung
                        selama live stream. Ini bisa jadi semacam shoutout yang bikin kamu dikenal sama penonton lain.
                    </li>
                    <li>
                        <b>Interaksi Lebih Dekat:</b> Dengan memberi gift, kamu bisa jadi lebih diperhatikan lieh streamer.
                        Ini
                        bisa buka kesempatan buat interaksi yang lebih personal, apalagi kalo kamu jadi salah satu top
                        gifter.
                    </li>
                    <li>
                        <b>Level Up:</b> Di Bigo Live, ada sistem level buat pengguna. Semakin banyak kamu memberi hadiah,
                        semakin
                        banyak pula poin yang kamu dapat buat naikin level. Karena begini, level yang lebih tinggi
                        seringkali dikaitkan sama status dan akses ke fitur eksklusif.
                    </li>
                    <li>
                        <b>Dukungan:</b> Lebih dari semua itu, ketika memberi gift itu bisa berarti kamu menunjukkan
                        dukungan ke
                        streamer idolamu. Secara tidak langsung, kamu bakalan membantu mereka buat terus berkarya atau
                        bahkan bisa jadi sumber penghasilan mereka.
                    </li>
                    <li>
                        <b>Komunitas:</b> Sering melakukan top up diamonds dan terlibat aktif di Bigo Live, termasuk dengan
                        memberikan gift, bisa membuat kamu menjadi bagian dari komunitas. Sehingga, kamu bisa jadi lebih
                        dekat dengan grup penonton atau penggemar streamer tersebut
                    </li>
                </ul>
                <mark>
                    Jadi, walaupun secara fisik kamu nggak dapet apa-apa, tapi secara online, kamu bisa dapet pengalaman
                    sosial yang unik, kesenangan, dan rasa kebersamaan di komunitas Bigo Live.
                    Plus, kamu juga bisa bantu streamer favoritmu untuk terus menghasilkan konten yang menarik agar bisa
                    dinikmati.
                </mark>
                <p>
                    <b>Tapi, ingat!</b> Kalau mau top up diamond Bigo murah dan aman, cuma di Fumolastore.id, ya! Jangan
                    sampai tertipu iming-iming diamond murah tapi tidak amanah.
                </p>
                <h2>
                    Kenapa Harus Top Up Diamond Bigo Live di Fumola Store?
                </h2>
                <p>
                    Pernah nggak sih, kamu merasa kesal karena proses top up yang ribet atau harga diamond yang bikin
                    kantong jebol? Di Fumola Store, kami mengerti banget perasaan itu.
                    Makanya, kami datang dengan solusi top up diamond Bigo yang tidak hanya mudah dan cepat tapi juga ramah
                    di kantong. Ini dia beberapa alasan kenapa Fumola Store wajib jadi pilihanmu:
                </p>
                <ul>
                    <li>
                        <b>Proses Mudah dan Instan:</b> Kami tahu, waktumu itu berharga. Oleh karena itu, Fumola Store
                        menyederhanakan proses top up diamonds aplikasi Bigo menjadi sangat mudah dan cepat. Cuma butuh
                        beberapa klik dan beberapa detik, diamond-mu langsung terisi. Simple, kan?
                    </li>
                    <li>
                        <b>Harga Bersahabat:</b> Kami menawarkan harga top up Bigo Live yang kompetitif. Dengan berbagai
                        pilihan
                        paket diamond, kamu bisa pilih sesuai dengan kebutuhan dan budgetmu. Jadi, sudah nggak perlu
                        khawatir lagi deh soal harga.
                    </li>
                    <li>
                        <b>CS Ramah dan Cepat:</b> Ada masalah atau pertanyaan seputar top up Diamonds Bigo? Tim support
                        kami siap
                        sedia membantumu dengan respons yang cepat dan solusi yang tepat. Kami ingin memastikan pengalamanmu
                        di Fumola Store itu menyenangkan.
                    </li>
                    <li>
                        <b>Keamanan Terjamin:</b> Di Fumola Store, keamanan transaksimu adalah prioritas kami. Semua data
                        pribadi
                        dan transaksi kamu dijamin aman. Jadi, kamu bisa top up dengan nyaman tanpa perlu khawatir.
                    </li>
                </ul>
                <h3>
                    Bagaimana Cara Top Up Diamond Bigo di Fumola Store?
                </h3>
                <p>
                    Top up diamonds Bigo di Fumola Store itu gampang banget, lho. Ikuti langkah-langkah simpel ini:
                </p>
                <ul>
                    <li>1.Buka website <a href="{{ route('home') }}">Fumolastore.id.</a></li>
                    <li>2.Klik kategori <a href="{{ route('topup.index', ['slug' => 'bigo-live']) }}">Bigo Live.</a></li>
                    <li>3.Pilih paket diamond Bigo Live yang kamu inginkan.</li>
                    <li>4.Masukkan ID pengguna Bigo Live kamu.</li>
                    <li>5.Pilih metode pembayaran yang kamu prefer.</li>
                    <li>6.Selesaikan pembayaran, dan segera <b>diamond akan bertambah di akun Bigo Live kamu dalam hitungan
                            detik.</b></li>
                </ul>
                <p>
                    Mudah kan? Kamu gak perlu lagi bingung atau khawatir saat ingin menambah diamond di akun Bigo Live-mu.
                    Jadi, tunggu apa lagi? Yuk, tingkatkan pengalamanmu bermain Bigo Live dengan top up diamond di Fumola
                    Store.
                    Kami percaya, dengan dukungan diamond yang cukup, kamu bisa lebih menikmati setiap momen dan interaksi
                    di Bigo Live.
                    Ayo, buat pengalaman bermainmu jadi lebih berwarna dengan top up diamond Bigo Live di Fumola Store. Kami
                    di sini, siap membantumu kapan saja. Happy streaming, Sobat Bigo!
                </p>
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
