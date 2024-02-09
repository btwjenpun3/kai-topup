@extends('master.public.index')

@section('title')
    <title>Fumola Store - Invoice</title>
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
    <div class="heading-top-section text-center">
        <h4>Terimakasih sudah membeli.</h4>
    </div>
    <div class="invoice">
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
                <div class="col-md-12 pt-3">
                    <img src="{{ asset(Storage::url($invoice->game->url_gambar)) }}" style="width:100px;height:100px;">
                </div>
            </div>
            <div class="container mt-5">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <h6>User ID</h6>
                                </td>
                                <td> </td>
                                <td class="text-end">
                                    <h6>{{ $invoice->user_id }}</h6>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6>Server ID</h6>
                                </td>
                                <td> </td>
                                <td class="text-end">
                                    <h6>{{ $invoice->server_id }}</h6>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6>Telepon</h6>
                                </td>
                                <td> </td>
                                <td class="text-end">
                                    <h6>{{ $invoice->phone }}</h6>
                                </td>
                            </tr>
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
                                        <h6>Rp. {{ number_format($invoice->payment->admin_fee_fixed, 0, ',', '.') }}
                                        </h6>
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
    @if ($invoice->status == 'PENDING')
        <div class="invoice mt-4">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-lg-12 col-12 text-center">
                        <ul id="countdown">
                            <li id="days">
                                <div class="number text-secondary">00</div>
                                <div class="label text-sm">Days</div>
                            </li>
                            <li id="hours">
                                <div class="number text-secondary">00</div>
                                <div class="label text-sm">Hours</div>
                            </li>
                            <li id="minutes">
                                <div class="number text-secondary">00</div>
                                <div class="label text-sm">Minutes</div>
                            </li>
                            <li id="seconds">
                                <div class="number text-secondary">00</div>
                                <div class="label text-sm">Seconds</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($invoice->status == 'PAID' && $invoice->game->brand == 'PLN')
        @if (isset($invoice->digiflazz->sn))
            <div class="invoice">
                <div class="invoice-pln-paid">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="text-center">Kode Token Listrik Anda </h5>
                                <p class="text-light text-center">Kode listrik anda sebelum "/"</p>
                            </div>
                            <div class="pln">
                                <div class="col-lg-12">
                                    <h5 class="text-center text-light">
                                        {{ $invoice->digiflazz->sn }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="invoice">
                <div class="invoice-pln-paid">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <h6 class="text-center">Klik Tombol 'Muat Ulang' jika kamu belum menerima kode Token
                                </h6>
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="main-status-button text-center">
                                    <a href="#" style="width:100%;" onClick="window.location.reload();">
                                        Muat Ulang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @elseif($invoice->status == 'PAID' && $invoice->game->kategori == 'Voucher')
        @if (isset($invoice->digiflazz->sn))
            <div class="invoice">
                <div class="invoice-pln-paid">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="text-center">Kode Voucher Anda : </h5>
                                <p class="text-light text-center">Pilih salah satu dari baris angka di bawah ini</p>
                            </div>
                            <div class="pln">
                                <div class="col-lg-12">
                                    <h5 class="text-center text-light">
                                        {{ $invoice->digiflazz->sn }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="invoice">
                <div class="invoice-pln-paid">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <h6 class="text-center">Klik Tombol 'Muat Ulang' jika kamu belum menerima kode Token
                                </h6>
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="main-status-button text-center">
                                    <a href="#" style="width:100%;" onClick="window.location.reload();">
                                        Muat Ulang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @elseif($invoice->status == 'PAID')
    @else
        @if ($invoice->payment->payment_type == 'EWALLET')
            <div class="invoice">
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
                                            <td class="text-end">
                                                <h6 class="text-info">{{ $invoice->va->xendit_va_name }}</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6>Bank</h6>
                                            </td>
                                            <td class="text-end">
                                                <h6 class="text-info">{{ $invoice->payment->payment_method }}</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6>Nomor Virtual Account</h6>
                                            </td>
                                            <td class="text-end">
                                                <h6 class="text-warning" id="copyableNumber">
                                                    {{ $invoice->va->xendit_va_number }}</h6>
                                                <p id="copyMessage">Ketuk untuk Copy nomor Virtual Account</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6>Nominal</h6>
                                            </td>
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
        @elseif ($invoice->payment->payment_type == 'OUTLET')
            <div class="va-info">
                <div class="col-lg-12">
                    <div class="row">
                        <h4 class="text-info pt-4">Lakukan pembayaran ke {{ $invoice->payment->payment_method }}</h4>
                        <h6 class="text-muted pt-2">Dan infokan petugas kasir data pembayaran di bawah ini</h6>
                        <div class="container mt-5">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h6>Nama</h6>
                                            </td>
                                            <td class="text-end">
                                                <h6 class="text-info">{{ $invoice->outlet->name }}</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6>Kode Pembayaran</h6>
                                            </td>
                                            <td class="text-end">
                                                <h6 class="text-warning">{{ $invoice->outlet->payment_code }}</h6>
                                                <p>Infokan ke petugas kasir kode pembayaran ini</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6>Nominal</h6>
                                            </td>
                                            <td class="text-end">
                                                <h6 class="text-info">Rp.
                                                    {{ number_format($invoice->total, 0, ',', '.') }}</h6>
                                                <p>Belum termasuk biaya Admin</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <img class="barcode"
                                    src="data:image/png;base64,{{ DNS1D::getBarcodePNG($invoice->outlet->payment_code, 'C39') }}"
                                    alt="barcode" />
                                <p class="text-end">Atau gunakan Barcode ini untuk di Scan oleh petugas kasir</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection

@section('js')
    <script src="/assets/js/invoice_countdown.js"></script>
    <script>
        var targetDate = new Date("{{ $invoice->expired_at }}");

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

        document.getElementById('copyableNumber').addEventListener('click', function() {
            var copyableNumber = document.getElementById('copyableNumber').innerText;
            var tempInput = document.createElement('textarea');
            tempInput.value = copyableNumber;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');

            // Hapus elemen textarea sementara
            document.body.removeChild(tempInput);

            // Tampilkan pesan bahwa teks telah disalin
            document.getElementById('copyMessage').innerHTML =
                '<p class="text-success">Virtual Account berhasil di copy<p>';

            // Set timeout untuk mengembalikan pesan ke aslinya setelah beberapa detik (opsional)
            setTimeout(function() {
                document.getElementById('copyMessage').innerHTML =
                    '<p>Ketuk untuk Copy nomor Virtual Account<p>';
            }, 2000);
        });
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="/assets/css/invoice.css">
    <link rel="stylesheet" href="/assets/css/invoice_countdown.css">
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

        .barcode {
            background-color: white;
            /* Atur warna latar belakang halaman */
        }
    </style>
@endsection
