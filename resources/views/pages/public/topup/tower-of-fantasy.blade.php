@extends('master.public.index')

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
                                    <li>2. Masukkan User ID dan Pilih Server</li>
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
                                <h5>📀 Tanium</h5>
                            </div>
                        </div>
                        <div class="flex-row">
                            @foreach ($harga as $h)
                                @if ($h->status == 1 && $h->tipe == 'Umum')
                                    @php
                                        $flashsale = $h->flashsale;
                                    @endphp
                                    @if ($flashsale && $flashsale->status == 1 && $flashsale->stock > 0 && $flashsale->expired_at > $now)
                                        <div class="flex-column item text-center clickable-item">
                                            <img src="{{ asset(Storage::url($h->gambar)) }}" class="img-fluid">
                                            <h4 class="text-md">{{ $h->nama_produk }}</h4>
                                            <span class="text-danger"><s>Rp.
                                                    {{ number_format($h->harga_jual, 0, ',', '.') }}</s></span>
                                            <span>Rp.
                                                {{ number_format($h->flashsale->final_price, 0, ',', '.') }}</span>
                                            <input id="getItemId-{{ $h->id }}" type="hidden"
                                                value="{{ $h->id }}" />
                                            <input id="getItemPrice-{{ $h->id }}" type="hidden"
                                                value="{{ $h->flashsale->final_price }}" />
                                            <input id="getItemName-{{ $h->id }}" type="hidden"
                                                value="{{ $h->nama_produk }}" />
                                        </div>
                                    @else
                                        <div class="flex-column item text-center clickable-item">
                                            <img src="{{ asset(Storage::url($h->gambar)) }}" class="img-fluid">
                                            <h4 class="text-md">{{ $h->nama_produk }}</h4>
                                            <span>Rp. {{ number_format($h->harga_jual, 0, ',', '.') }}</span>
                                            <input id="getItemId-{{ $h->id }}" type="hidden"
                                                value="{{ $h->id }}" />
                                            <input id="getItemPrice-{{ $h->id }}" type="hidden"
                                                value="{{ $h->harga_jual }}" />
                                            <input id="getItemName-{{ $h->id }}" type="hidden"
                                                value="{{ $h->nama_produk }}" />
                                        </div>
                                    @endif
                                @elseif($h->status == 3 && $h->tipe == 'Umum')
                                    <div class="flex-column item text-center offline">
                                        <img src="{{ asset(Storage::url($h->gambar)) }}" class="img-fluid">
                                        <h4 class="text-md">{{ $h->nama_produk }}</h4>
                                        <span>Rp. {{ number_format($h->harga_jual, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="item-parent mb-4">
                    <div class="col-md-12">
                        <div class="row align-items-center mb-4">
                            <div class="col">
                                <h5>✨ Subscription</h5>
                            </div>
                        </div>
                        <div class="flex-row">
                            @foreach ($harga as $h)
                                @if ($h->status == 1 && $h->tipe == 'Membership')
                                    @php
                                        $flashsale = $h->flashsale;
                                    @endphp
                                    @if ($flashsale && $flashsale->status == 1 && $flashsale->stock > 0 && $flashsale->expired_at > $now)
                                        <div class="flex-column item text-center clickable-item">
                                            <img src="{{ asset(Storage::url($h->gambar)) }}" class="img-fluid">
                                            <h4 class="text-md">{{ $h->nama_produk }}</h4>
                                            <span class="text-danger"><s>Rp.
                                                    {{ number_format($h->harga_jual, 0, ',', '.') }}</s></span>
                                            <span>Rp.
                                                {{ number_format($h->flashsale->final_price, 0, ',', '.') }}</span>
                                            <input id="getItemId-{{ $h->id }}" type="hidden"
                                                value="{{ $h->id }}" />
                                            <input id="getItemPrice-{{ $h->id }}" type="hidden"
                                                value="{{ $h->flashsale->final_price }}" />
                                            <input id="getItemName-{{ $h->id }}" type="hidden"
                                                value="{{ $h->nama_produk }}" />
                                        </div>
                                    @else
                                        <div class="flex-column item text-center clickable-item">
                                            <img src="{{ asset(Storage::url($h->gambar)) }}" class="img-fluid">
                                            <h4 class="text-md">{{ $h->nama_produk }}</h4>
                                            <span>Rp. {{ number_format($h->harga_jual, 0, ',', '.') }}</span>
                                            <input id="getItemId-{{ $h->id }}" type="hidden"
                                                value="{{ $h->id }}" />
                                            <input id="getItemPrice-{{ $h->id }}" type="hidden"
                                                value="{{ $h->harga_jual }}" />
                                            <input id="getItemName-{{ $h->id }}" type="hidden"
                                                value="{{ $h->nama_produk }}" />
                                        </div>
                                    @endif
                                @elseif($h->status == 3 && $h->tipe == 'Membership')
                                    <div class="flex-column item text-center offline">
                                        <img src="{{ asset(Storage::url($h->gambar)) }}" class="img-fluid">
                                        <h4 class="text-md">{{ $h->nama_produk }}</h4>
                                        <span>Rp. {{ number_format($h->harga_jual, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
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
                                <div class="col-md-6 col-sm-12">
                                    <div class="data-input">
                                        <input id="userIdInput" type="text" placeholder="Masukkan User ID" required />
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="data-input">
                                        <select id="serverIdInput" class="form-select" required>
                                            <optgroup label="Asia Pasific">
                                                <option value="11001">Asia Pasific-Eden</option>
                                                <option value="11002">Asia Pasific-Fate</option>
                                                <option value="11003">Asia Pasific-Nova</option>
                                                <option value="11004">Asia Pasific-Ruby</option>
                                                <option value="11005">Asia Pasific-Babel</option>
                                                <option value="11006">Asia Pasific-Gomap</option>
                                                <option value="11007">Asia Pasific-Pluto</option>
                                                <option value="11008">Asia Pasific-Sushi</option>
                                                <option value="11009">Asia Pasific-Venus</option>
                                                <option value="11010">Asia Pasific-Galaxy</option>
                                                <option value="11011">Asia Pasific-Memory</option>
                                                <option value="11012">Asia Pasific-Oxygen</option>
                                                <option value="11013">Asia Pasific-Sakura</option>
                                                <option value="11014">Asia Pasific-Seeker</option>
                                                <option value="11015">Asia Pasific-Shinya</option>
                                                <option value="11016">Asia Pasific-Stella</option>
                                                <option value="11017">Asia Pasific-Uranus</option>
                                                <option value="11018">Asia Pasific-Utopia</option>
                                                <option value="11019">Asia Pasific-Jupiter</option>
                                                <option value="11020">Asia Pasific-Sweetie</option>
                                                <option value="11021">Asia Pasific-Atlantis</option>
                                                <option value="11022">Asia Pasific-Daybreak</option>
                                                <option value="11023">Asia Pasific-Takoyaki</option>
                                                <option value="11024">Asia Pasific-Adventure</option>
                                                <option value="11025">Asia Pasific-Yggdrasil</option>
                                                <option value="11026">Asia Pasific-Cocoaiteruyo</option>
                                                <option value="11027">Asia Pasific-Food fighter</option>
                                                <option value="11028">Asia Pasific-Mars</option>
                                                <option value="11029">Asia Pasific-Vega</option>
                                                <option value="11030">Asia Pasific-Neptune</option>
                                                <option value="11031">Asia Pasific-Tenpura</option>
                                                <option value="11032">Asia Pasific-Moon</option>
                                                <option value="11033">Asia Pasific-Mihashira</option>
                                                <option value="11034">Asia Pasific-Cocokonderu</option>
                                            </optgroup>
                                            <optgroup label="Europe">
                                                <option value="13001">Europe-Aimanium</option>
                                                <option value="13002">Europe-Alintheus</option>
                                                <option value="13003">Europe-Andoes</option>
                                                <option value="13004">Europe-Anomora</option>
                                                <option value="13005">Europe-Astora</option>
                                                <option value="13006">Europe-Valstamm</option>
                                                <option value="13007">Europe-Blumous</option>
                                                <option value="13008">Europe-Celestialrise</option>
                                                <option value="13009">Europe-Cosmos</option>
                                                <option value="13010">Europe-Dyrnwyn</option>
                                                <option value="13011">Europe-Elypium</option>
                                                <option value="13012">Europe-Excalibur</option>
                                                <option value="13013">Europe-Espoir IV</option>
                                                <option value="13014">Europe-Estrela</option>
                                                <option value="13015">Europe-Ether</option>
                                                <option value="13016">Europe-Ex Nihilor</option>
                                                <option value="13017">Europe-Futuria</option>
                                                <option value="13018">Europe-Hephaestus</option>
                                                <option value="13019">Europe-Midgard</option>
                                                <option value="13020">Europe-Iter</option>
                                                <option value="13021">Europe-Kuura</option>
                                                <option value="13022">Europe-Lycoris</option>
                                                <option value="13023">Europe-Lyramiel</option>
                                                <option value="13024">Europe-Magenta</option>
                                                <option value="13025">Europe-Magia Przygoda Aida</option>
                                                <option value="13026">Europe-Olivine</option>
                                                <option value="13027">Europe-Omnium Prime</option>
                                                <option value="13028">Europe-Turmus</option>
                                                <option value="13029">Europe-Transport Hub</option>
                                                <option value="13030">Europe-The Lumina</option>
                                                <option value="13031">Europe-Seaforth Dock</option>
                                                <option value="13032">Europe-Silvercoast Lab</option>
                                                <option value="13033">Europe-Karst Cave</option>
                                            </optgroup>
                                            <optgroup label="North America">
                                                <option value="12001">North America-The Glades</option>
                                                <option value="12002">North America-Nightfall</option>
                                                <option value="12003">North America-Frontier</option>
                                                <option value="12004">North America-Libera</option>
                                                <option value="12005">North America-Solaris</option>
                                                <option value="12006">North America-Freedom-Oasis</option>
                                                <option value="12007">North America-The worlds between</option>
                                                <option value="12008">North America-Radiant</option>
                                                <option value="12009">North America-Tempest</option>
                                                <option value="12010">North America-New Era</option>
                                                <option value="12011">North America-Observer</option>
                                                <option value="12012">North America-Lunalite</option>
                                                <option value="12013">North America-Starlight</option>
                                                <option value="12014">North America-Myriad</option>
                                                <option value="12015">North America-Lighthouse</option>
                                                <option value="12016">North America-Oumuamua</option>
                                                <option value="12017">North America-Eternium Phantasy</option>
                                                <option value="12018">North America-Sol-III</option>
                                                <option value="12019">North America-Silver Bridge</option>
                                                <option value="12020">North America-Azure Plane</option>
                                                <option value="12021">North America-Nirvana</option>
                                                <option value="12022">North America-Ozera</option>
                                                <option value="12023">North America-Polar</option>
                                                <option value="12024">North America-Oasis</option>
                                            </optgroup>
                                            <optgroup label="South America">
                                                <option value="15001">South America-Orion</option>
                                                <option value="15002">South America-Luna Azul</option>
                                                <option value="15003">South America-Tiamat</option>
                                                <option value="15004">South America-Hope</option>
                                                <option value="15005">South America-Tanzanite</option>
                                                <option value="15006">South America-Calodesma Seven</option>
                                                <option value="15007">South America-Antlia</option>
                                                <option value="15008">South America-Pegasus</option>
                                                <option value="15009">South America-Phoenix</option>
                                                <option value="15010">South America-Centaurus</option>
                                                <option value="15011">South America-Cepheu</option>
                                                <option value="15012">South America-Columba</option>
                                                <option value="15013">South America-Corvus</option>
                                                <option value="15014">South America-Cygnus</option>
                                                <option value="15015">South America-Grus</option>
                                                <option value="15016">South America-Hydra</option>
                                                <option value="15017">South America-Lyra</option>
                                                <option value="15018">South America-Ophiuchus</option>
                                                <option value="15019">South America-Pyxis</option>
                                            <optgroup label="Southeast Asia">
                                                <option value="16001">Southeast Asia-Phantasia</option>
                                                <option value="16002">Southeast Asia-Mechafield</option>
                                                <option value="16003">Southeast Asia-Ethereal Dream</option>
                                                <option value="16004">Southeast Asia-Odyssey</option>
                                                <option value="16005">Southeast Asia-Aestral-Noa</option>
                                                <option value="16006">Southeast Asia-Osillron</option>
                                                <option value="16007">Southeast Asia-Chandra</option>
                                                <option value="16008">Southeast Asia-Saeri</option>
                                                <option value="16009">Southeast Asia-Aeria</option>
                                                <option value="16010">Southeast Asia-Scarlet</option>
                                                <option value="16011">Southeast Asia-Gumi Gumi</option>
                                                <option value="16012">Southeast Asia-Fantasia</option>
                                                <option value="16013">Southeast Asia-Oryza</option>
                                                <option value="16014">Southeast Asia-Stardust</option>
                                                <option value="16015">Southeast Asia-Arcania</option>
                                                <option value="16016">Southeast Asia-Animus</option>
                                                <option value="16017">Southeast Asia-Mistilteinn</option>
                                                <option value="16018">Southeast Asia-Valhalla</option>
                                                <option value="16019">Southeast Asia-Illyrians</option>
                                                <option value="16020">Southeast Asia-Florione</option>
                                                <option value="16021">Southeast Asia-Oneiros</option>
                                                <option value="16022">Southeast Asia-Famtosyana</option>
                                                <option value="16023">Southeast Asia-Edenia</option>
                                                <option value="16024">Southeast Asia-Tore de Utopia</option>
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
                                    <input id="userPhoneInput" type="text"
                                        placeholder="62857xxx (Tanpa Tanda Plus)" />
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
