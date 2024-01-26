@extends('master.public.index')

@section('title')
    <title>Kai Top Up - Invoice</title>
@endsection

@section('message')
    <div class="alert" role="alert" id="stickyAlert" style="display:none;">
        <span id="statusMessage"></span>
    </div>
@endsection

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-warning" role="alert">
            {{ session('message') }}
        </div>
    @endif
    <div class="featured-games">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-9">
                    <div class="heading-section">
                        <h4><em>Invoice</em> ({{ $invoice->nomor_invoice }})</h4>
                    </div>
                </div>
                @if ($invoice->status == 'PAID')
                    <div class="col-md-3 text-center">
                        <div class="heading-section  text-end">
                            <h4 class="text-success">PAID</h4>
                        </div>
                    </div>
                @else
                    <div class="col-md-3 text-center">
                        <div class="heading-section  text-end">
                            <h4 class="text-warning">PENDING</h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-12">
            <h5>Rincian Pembelian</h5>
            <hr>
            <div class="row">
                <div class="col-md-9 pt-3">
                    <img src="{{ asset(Storage::url($invoice->game->url_gambar)) }}" style="width:100px;height:100px;">
                </div>

            </div>
            <div class="container mt-5">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <h6>Nama Item</h6>
                                </td>
                                <td>
                                    <h6>{{ $invoice->harga->nama_produk }}</h6>
                                </td>
                                <td class="text-end">
                                    <h6>Rp. {{ number_format($invoice->total, 0, ',', '.') }}</h6>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6>Tipe Pembayaran</h6>
                                </td>
                                <td>
                                    <h6>{{ $invoice->payment_type }}</h6>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <h6>Metode Pembayaran</h6>
                                </td>
                                <td>
                                    <h6>{{ $invoice->payment_method }}</h6>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <h6 class="text-success">TOTAL</h6>
                                </td>
                                <td></td>
                                <td class="text-end">
                                    <h6 class="text-success">Rp. {{ number_format($invoice->total, 0, ',', '.') }}</h6>
                                </td>
                            </tr>
                            @if (isset($invoice->xendit_qr_string))
                                <tr>
                                    <td>
                                        <h6 class="text-info">QR Code</h6>
                                    </td>
                                    <td></td>
                                    <td class="text-end">
                                        {{ QrCode::size(200)->generate($invoice->xendit_qr_string) }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if ($invoice->status == 'PAID')
    @else
        @if ($invoice->payment_type == 'EWALLET')
            <div class="game-details">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-border-button">
                                        <a href="#" id="cekStatus"
                                            onclick="simulasi('{{ $invoice->nomor_invoice }}')"><span id="loadingIcon"
                                                style="display: none;"><i class="fas fa-spinner fa-spin"></i></span> Cek
                                            Status
                                            Pembayaran</a>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="main-border-button">
                                        <a href="{{ $invoice->xendit_invoice_url }}" id="checkout">Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($invoice->payment_type == 'QRIS')
            <div class="game-details">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-border-button">
                                        <a href="#" id="cekStatus"
                                            onclick="simulate('{{ $invoice->nomor_invoice }}')"><span id="loadingIcon"
                                                style="display: none;"><i class="fas fa-spinner fa-spin"></i></span>
                                            Simulasi
                                            Pembayaran</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection

@section('js')
    <script>
        function showStatus(message) {
            $('#statusMessage').text(message);
            $('#stickyAlert').fadeIn('slow');
            setTimeout(function() {
                $('#stickyAlert').fadeOut('slow');
            }, 7000);
        }

        function cekStatus(id) {
            $('#cekStatus').prop('disabled', true);
            $('#loadingIcon').show();
            $.ajax({
                url: '/invoice/status/' + id,
                type: 'GET',
                success: function(response) {
                    if (response.status == 'SUCCEEDED') {
                        $('#stickyAlert').addClass('alert-success');
                        showStatus('Pembayaran berhasil, harap tunggu kami akan memuat ulang halaman ini.');
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    } else {
                        $('#stickyAlert').addClass('alert-warning');
                        showStatus('Pembayaran kamu belum berhasil.');
                    }
                },
                error: function(xhr, error) {
                    $('#stickyAlert').addClass('alert-danger');
                    showStatus('Terdapat kesalahan, harap tunggu beberapa saat atau hubungi Customer Service');
                },
                complete: function() {
                    $('#loadingIcon').hide();
                    $('#cekStatusButton').prop('disabled', false);
                }
            });
        };

        function simulate(id) {
            $('#cekStatus').prop('disabled', true);
            $('#loadingIcon').show();
            $.ajax({
                url: '/invoice/status/' + id,
                type: 'POST',
                data: {
                    'amount': {{ intval($invoice->total) }},
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status == 'SUCCEEDED') {
                        console.log(response)
                        $('#stickyAlert').addClass('alert-success');
                        showStatus('Pembayaran berhasil, harap tunggu kami akan memuat ulang halaman ini.');
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    } else {
                        console.log(response)
                        $('#stickyAlert').addClass('alert-warning');
                        showStatus('Pembayaran kamu belum berhasil.');
                    }
                },
                error: function(xhr, error) {
                    $('#stickyAlert').addClass('alert-danger');
                    console.log(xhr);
                    showStatus('Terdapat kesalahan, harap tunggu beberapa saat atau hubungi Customer Service');
                },
                complete: function() {
                    $('#loadingIcon').hide();
                    $('#cekStatusButton').prop('disabled', false);
                }
            });
        };
    </script>
@endsection

@section('css')
    <style>
        #stickyAlert {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            width: 450px;
            /* Atur lebar sesuai kebutuhan Anda */
        }
    </style>
@endsection
