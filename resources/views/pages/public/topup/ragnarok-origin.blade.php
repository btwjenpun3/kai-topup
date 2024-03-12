@extends('master.public.index')

@section('meta')
    <meta name="description"
        content="Tempat top up game termurah dan terpercaya di Indonesia. Kami menjamin keamanan dan kecepatan transaksi di Fumolastore.id!" />
@endsection

@section('title')
    <title>Fumola Store - {{ $game->nama }}</title>
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
                                    <li>1. Pilih Produk yang Ingin di Beli</li>
                                    <li>2. Masukkan Secret Code, Nickname, dan Pilih Server</li>
                                    <li>3. Pilih Metode Pembayaran</li>
                                    <li>4. Masukkan Nomor Whatsapp atau Telepon Kamu </li>
                                    <li>5. Klik Konfirmasi Top Up & Melakukan Pembayaran </li>
                                    <li>6. Tunggu Beberapa Saat Produk Akan Otomatis Masuk Ke Akun Anda.</li>
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
                                <h5>🍒 Nyan Berry</h5>
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
                                <div class="col-md-4 col-sm-12">
                                    <div class="data-input">
                                        <input id="userIdInput" type="text" placeholder="Masukkan Secret Code"
                                            required />
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="data-input">
                                        <input id="userNicknameInput" type="text" placeholder="Masukkan Nickname"
                                            required />
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="data-input">
                                        <select id="serverIdInput" class="form-select" required>
                                            <optgroup label="Prontera">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}">Server ID : ({{ $i }})
                                                        Prontera-{{ $i }}
                                                    </option>
                                                @endfor
                                            </optgroup>
                                            <optgroup label="Izlude">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i + 10 }}">Server ID : ({{ $i + 10 }})
                                                        Izlude-{{ $i }}
                                                    </option>
                                                @endfor
                                            </optgroup>
                                            <optgroup label="Morroc">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i + 20 }}">Server ID : ({{ $i + 20 }})
                                                        Morroc-{{ $i }}
                                                    </option>
                                                @endfor
                                            </optgroup>
                                            <optgroup label="Geffen">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i + 30 }}">Server ID : ({{ $i + 30 }})
                                                        Geffen-{{ $i }}
                                                    </option>
                                                @endfor
                                            </optgroup>
                                            <optgroup label="Payon">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i + 40 }}">Server ID : ({{ $i + 40 }})
                                                        Payon-{{ $i }}
                                                    </option>
                                                @endfor
                                            </optgroup>
                                            <optgroup label="Poring Island">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i + 50 }}">Server ID : ({{ $i + 50 }})
                                                        Poring Island-{{ $i }}
                                                    </option>
                                                @endfor
                                            </optgroup>
                                            <optgroup label="Orc Village">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i + 60 }}">Server ID : ({{ $i + 60 }})
                                                        Orc Village-{{ $i }}
                                                    </option>
                                                @endfor
                                            </optgroup>
                                            <optgroup label="Shipwreck">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i + 70 }}">Server ID : ({{ $i + 70 }})
                                                        Shipwreck-{{ $i }}
                                                    </option>
                                                @endfor
                                            </optgroup>
                                            <optgroup label="Ant-Hell">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i + 80 }}">Server ID : ({{ $i + 80 }})
                                                        Ant-Hell-{{ $i }}
                                                    </option>
                                                @endfor
                                            </optgroup>
                                        </select>
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
                            <small>Secret Code</small>
                            <small><span id="userId"></span></small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small>Nickname</small>
                            <small><span id="userNickname"></span></small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small>Server ID</small>
                            <small><span id="serverId"></span></small>
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
                var serverIdInputValue = $('#serverIdInput').val();
                var nicknameInputValue = $('#userNicknameInput').val();
                var userPhoneInputValue = $('#userPhoneInput').val();

                if (userIdInputValue.trim() === '' || serverIdInputValue.trim() === '') {
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
                    $('#userNickname').text(nicknameInputValue);
                    $('#serverId').text(serverIdInputValue);
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
                        userNickname: $('#userNickname').text(),
                        serverId: $('#serverId').text(),
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
