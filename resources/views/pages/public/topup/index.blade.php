@extends('master.public.index')

@section('title')
    <title>Kai Top Up - {{ $game->nama }}</title>
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
                                        <img src="{{ asset(Storage::url('/product/diamond.webp')) }}">
                                        <h4>{{ $h->nama_produk }}</h4>
                                        <span>Rp. {{ $h->harga_jual }}</span>
                                        <input id="itemId" type="hidden" value="{{ $h->id }}" />
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
                    <div class="row">
                        <div class="col-md-12">

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
        document.addEventListener('DOMContentLoaded', function() {
            var selectedPrice = null;

            function handleItemClick(item) {
                $('.clickable-item').removeClass('clicked');
                $(item).addClass('clicked');
                selectedPrice = $(item).find('span').text().trim();
                selectedItemId = $(item).find('input[type="hidden"]').val();
            }

            $('.clickable-item').click(function() {
                handleItemClick(this);
            });

            $('#checkout').click(function() {
                if (selectedPrice !== null) {
                    // Set data pada modal berdasarkan item yang dipilih
                    var itemName = $('.clicked h4').text().trim();
                    $('#itemName').text(itemName);
                    $('#itemPrice').text(selectedPrice);
                    $('#itemId').val(selectedItemId);
                    $('#userId').text($('#userIdInput').val()); // Gantilah dengan ID elemen form user id
                    $('#serverId').text($('#serverIdInput').val());

                    // Tampilkan modal
                    $('#checkoutModal').modal('show');
                } else {
                    alert('Silakan pilih harga terlebih dahulu.');
                }
            });

            $('#confirmCheckout').click(function() {
                var hargaAngka = parseInt(selectedPrice.replace(/[^0-9]/g, ''), 10);
                $.ajax({
                    url: '/topup/{{ $game->slug }}/process',
                    type: 'POST',
                    data: {
                        price: hargaAngka,
                        itemName: $('#itemName').text(),
                        userId: $('#userId').text(),
                        serverId: $('#serverId').text(),
                        itemId: $('#itemId').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        } else {
                            console.log(response)
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        // Tindakan lain untuk penanganan kesalahan
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
            /* Warna hijau */
            color: #white;
            /* Warna teks putih */
        }
    </style>
@endsection
