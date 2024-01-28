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
                                    <h6>Rp. {{ number_format($invoice->harga->harga_jual, 0, ',', '.') }}</h6>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6>Tipe Pembayaran</h6>
                                </td>
                                <td>
                                    <h6>{{ $invoice->payment->payment_type }}</h6>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <h6>Metode Pembayaran</h6>
                                </td>
                                <td>
                                    <h6>{{ $invoice->payment->payment_method }}</h6>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <h6>Admin Fee</h6>
                                </td>
                                <td></td>
                                <td class="text-end">
                                    @if ($invoice->payment->payment_type == 'EWALLET' || $invoice->payment->payment_type == 'QRIS')
                                        <h6>{{ $invoice->payment->admin_fee }}%</h6>
                                    @elseif ($invoice->payment->payment_type == 'VA')
                                        <h6>Rp. {{ number_format($invoice->payment->admin_fee_fixed, 0, ',', '.') }}</h6>
                                    @endif
                                </td>
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
                            @if (isset($invoice->qr->xendit_qr_string))
                                @if ($invoice->status == 'PAID')
                                @else
                                    <tr>
                                        <td>
                                            <h6 class="text-info">QR Code</h6>
                                        </td>
                                        <td></td>
                                        <td class="text-end">
                                            {{ QrCode::size(200)->generate($invoice->qr->xendit_qr_string) }}
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if ($invoice->status == 'PAID')
    @else
        @if ($invoice->payment->payment_type == 'EWALLET')
            <div class="game-details">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-border-button">
                                        <a href="#" id="cekStatus"
                                            onclick="cekStatus('{{ $invoice->nomor_invoice }}')"><span id="loadingIcon"
                                                style="display: none;"><i class="fas fa-spinner fa-spin"></i></span> Cek
                                            Status
                                            Pembayaran</a>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="main-status-button">
                                        <a href="{{ $invoice->ewallet->xendit_invoice_url }}" id="checkout">Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($invoice->payment->payment_type == 'VA')
            <div class="va-info">
                <div class="col-lg-12">
                    <div class="row">
                        <h5 class="text-info pt-4">Lakukan pembayaran ke :</h5>
                        <div class="container mt-5">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h6>Nama</h6>
                                            </td>
                                            <td></td>
                                            <td class="text-end">
                                                <h6 class="text-info">{{ $invoice->va->xendit_va_name }}</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6>Bank</h6>
                                            </td>
                                            <td></td>
                                            <td class="text-end">
                                                <h6 class="text-info">{{ $invoice->payment->payment_method }}</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6>Nomor Virtual Account</h6>
                                            </td>
                                            <td></td>
                                            <td class="text-end">
                                                <h6 class="text-info">{{ $invoice->va->xendit_va_number }}</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6>Nominal</h6>
                                            </td>
                                            <td></td>
                                            <td class="text-end">
                                                <h6 class="text-info">Rp.
                                                    {{ number_format($invoice->total, 0, ',', '.') }}</h6>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                        <a href="#" id="simulasiVa"
                                            onclick="simulasiVa('{{ $invoice->nomor_invoice }}')"><span id="loadingIcon"
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
                        showStatus('Pembayaran belum berhasil');
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

        function simulasiVa(id) {
            $('#cekStatus').prop('disabled', true);
            $('#loadingIcon').show();
            $.ajax({
                url: '/simulate/va/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#stickyAlert').addClass('alert-success');
                    showStatus(response.success);
                },
                error: function(xhr, error) {
                    $('#stickyAlert').addClass('alert-danger');
                    showStatus(xhr.responseJSON.message);
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
            max-width: 450px;
            /* Atur lebar sesuai kebutuhan Anda */
        }
    </style>
@endsection
