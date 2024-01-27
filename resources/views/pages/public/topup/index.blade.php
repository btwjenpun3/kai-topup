@extends('master.public.index')

@section('title')
    <title>Kai Top Up - {{ $game->nama }}</title>
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
    <div class="featured-games">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-3">
                    <img src="{{ asset(Storage::url($game->url_gambar)) }}">
                </div>
                <div class="col-md-9">
                    <div class="heading-section">
                        <h4><em>Cara Top Up</em> {{ $game->nama }}</h4>
                        <p>Cara Top Up Mobile Legends Murah</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="most-popular">
        <div class="row">
            <div class="container">
                <div class="heading-section">
                    <h4><em>Pilih</em> Produk dan Nominal</h4>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        @foreach ($harga as $h)
                            @if ($h->status == 1)
                                <div class="col-lg-2 col-sm-6 col-md-4 col-6">
                                    <div class="item text-center clickable-item">
                                        <img src="{{ asset(Storage::url($h->gambar)) }}">
                                        <h4>{{ $h->nama_produk }}</h4>
                                        <span>Rp. {{ number_format($h->harga_jual, 0, ',', '.') }}</span>
                                        <input id="getItemId-{{ $h->id }}" type="hidden"
                                            value="{{ $h->id }}" />
                                        <input id="getItemPrice-{{ $h->id }}" type="hidden"
                                            value="{{ $h->harga_jual }}" />
                                        <input id="getItemName-{{ $h->id }}" type="hidden"
                                            value="{{ $h->nama_produk }}" />
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="most-popular">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading-section">
                    <h4><em>Masukkan</em> Data Kamu</h4>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="data-input">
                                <input id="userIdInput" type="text" placeholder="Masukkan User ID" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="data-input">
                                <input id="serverIdInput" type="text" placeholder="Masukkan Server ID" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="most-popular">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading-section">
                    <h4><em>Pilih Metode</em> Pembayaran</h4>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="row">
                            @foreach ($ewallets as $ewallet)
                                <div class="col-lg-2 col-sm-6 col-md-4 col-6">
                                    <div class="item payment text-center clickable-payment">
                                        <img src="{{ asset(Storage::url($ewallet->image)) }}">
                                        <h4>{{ $ewallet->name }}</h4>
                                        <p>Biaya Admin {{ $ewallet->admin_fee }}%</p>
                                        <input id="{{ $ewallet->payment_method }}" type="hidden"
                                            value="{{ $ewallet->payment_method }}">
                                        <input class="getPaymentType" type="hidden" value="{{ $ewallet->payment_type }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="row">
                            @foreach ($qris as $q)
                                <div class="col-lg-2 col-sm-6 col-md-4 col-6">
                                    <div class="item payment text-center clickable-payment">
                                        <img src="{{ asset(Storage::url($q->image)) }}">
                                        <h4>{{ $q->name }}</h4>
                                        <p>Biaya Admin {{ $q->admin_fee }}%</p>
                                        <input id="{{ $q->payment_method }}" type="hidden"
                                            value="{{ $q->payment_method }}">
                                        <input class="getPaymentType" type="hidden" value="{{ $q->payment_type }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="row">
                            @foreach ($vas as $va)
                                <div class="col-lg-2 col-sm-6 col-md-4 col-6">
                                    <div class="item payment text-center clickable-payment">
                                        <img src="{{ asset(Storage::url($va->image)) }}">
                                        <h4>{{ $va->name }}</h4>
                                        <p>Biaya Admin Rp. {{ $va->admin_fee_fixed }}</p>
                                        <input id="{{ $va->payment_method }}" type="hidden"
                                            value="{{ $va->payment_method }}">
                                        <input class="getPaymentType" type="hidden" value="{{ $va->payment_type }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="game-details">
        <div class="row">
            <div class="col-lg-12">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-border-button">
                                <a href="#" id="checkout">Konfirmasi Top Up</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Checkout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tampilkan data item, harga, dan form user id dan server id di sini -->
                    <p><strong>Nama Item:</strong> <span id="itemName"></span></p>
                    <p><strong>Harga:</strong> <span id="itemPrice"></span></p>
                    <p><strong>Tipe Pembayaran:</strong> <span id="paymentType"></span></p>
                    <p><strong>Metode Pembayaran:</strong> <span id="paymentMethod"></span></p>
                    <p><strong>User ID:</strong> <span id="userId"></span></p>
                    <p><strong>Server ID:</strong> <span id="serverId"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="confirmCheckout">OK</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            function showError(message) {
                $('#errorMessage').text(message);
                $('#stickyAlert').fadeIn('slow');
                setTimeout(function() {
                    $('#stickyAlert').fadeOut('slow');
                }, 7000);
            }

            // Fungsi untuk menyembunyikan alert
            function hideError() {
                $('#stickyAlert').fadeOut('slow');
            }

            var selectedPrice = null;

            function handleItemClick(item) {
                $('.clickable-item').removeClass('clicked');
                $(item).addClass('clicked');
                selectedPrice = $(item).find('[id^="getItemPrice-"]').val();
                selectedItemId = $(item).find('[id^="getItemId-"]').val();
                selectedItemName = $(item).find('[id^="getItemName-"]').val();
            }

            $('.clickable-item').click(function() {
                handleItemClick(this);
            });

            function handlePaymentClick(item) {
                $('.clickable-payment').removeClass('clicked');
                $(item).addClass('clicked');
                getPaymentMethodValue = $(item).find('input[type="hidden"]').val();
                paymentTypeValue = $(item).find('.getPaymentType').val();
            }

            $('.clickable-payment').click(function() {
                handlePaymentClick(this);
            });


            $('#checkout').click(function() {
                // Mengambil nilai dari input
                var userIdInputValue = $('#userIdInput').val();
                var serverIdInputValue = $('#serverIdInput').val();

                // Pemeriksaan apakah input sudah diisi
                if (userIdInputValue.trim() === '' || serverIdInputValue.trim() === '') {
                    showError('Harap isi semua Data kamu!');
                    return; // Hentikan proses jika input belum diisi
                }
                if (selectedPrice !== null) {
                    // Set data pada modal berdasarkan item yang dipilih
                    $('#itemName').text(selectedItemName);
                    $('#itemPrice').text(selectedPrice);
                    $('#itemId').val(selectedItemId);
                    $('#userId').text($('#userIdInput').val());
                    $('#serverId').text($('#serverIdInput').val());
                    $('#paymentType').text(paymentTypeValue);
                    $('#paymentMethod').text(getPaymentMethodValue);

                    // Tampilkan modal
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
                        serverId: $('#serverId').text(),
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

                // Tutup modal setelah mengklik "OK"
                $('#checkoutModal').modal('hide');
            });
        });
    </script>
@endsection

@section('css')
    <style>
        .clickable-item {
            cursor: pointer;
        }

        .most-popular .item.clicked {
            background-color: #28a745;
            color: #white;
        }

        .clickable-payment {
            cursor: pointer;
        }

        .most-popular .clickable-payment.clicked {
            background-color: #28a745;
            color: white;
        }

        .most-popular .clickable-payment.clicked p {
            color: white;
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
    </style>
@endsection
