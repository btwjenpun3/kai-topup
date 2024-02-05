@extends('master.private.index')

@section('title')
    <title>Fumola Realm - Invoice</title>
@endsection

@section('header')
    <h2 class="page-title">
        List Invoice
    </h2>
@endsection

@section('button')
@endsection

@section('message')
    @if (session()->has('game-berhasil-di-buat'))
        <div class="alert alert-success" role="alert">
            {{ session('game-berhasil-di-buat') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

@section('content')
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover table-vcenter card-table table-striped table-nowrap">
                        @if (isset($invoices) && count($invoices) > 0)
                            <thead>
                                <tr>
                                    <th class="w-1"></th>
                                    <th class="w-7"></th>
                                    <th></th>
                                    <th>Produk</th>
                                    <th>Nomor Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Profit</th>
                                    <th>Total</th>
                                    <th>User</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        @if ($invoice->status == 'PENDING')
                                            <td class="text-warning"><span class="badge bg-warning me-1"></span></td>
                                        @elseif ($invoice->status == 'PAID')
                                            <td class="text-success"><span class="badge bg-success me-1"></span></td>
                                        @elseif ($invoice->status == 'EXPIRED')
                                            <td class="text-danger"><span class="badge bg-danger me-1"></span></td>
                                        @endif
                                        <td><img src="{{ asset(Storage::url($invoice->game->url_gambar)) }}"></td>
                                        <td>{{ $invoice->game->nama }}</td>
                                        <td>{{ $invoice->harga->nama_produk }}</td>
                                        <td><a href="{{ route('invoice.index', ['id' => $invoice->nomor_invoice]) }}"
                                                target="_blank">{{ $invoice->nomor_invoice }}</a></td>
                                        <td>{{ \Carbon\Carbon::parse($invoice->created_at)->isoFormat('dddd, D MMMM YYYY, HH:mm:ss') }}
                                            WIB
                                        </td>
                                        @if ($invoice->status == 'PAID')
                                            <td class="text-success">Rp. {{ number_format($invoice->profit, 0, ',', '.') }}
                                            </td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        <td>Rp. {{ number_format($invoice->total, 0, ',', '.') }}</td>
                                        @if (isset($invoice->realm_user_id))
                                            <td>{{ $invoice->user->name }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        <td> <button class="btn btn-md" data-bs-toggle="modal"
                                                data-bs-target="#modal-detail"
                                                onclick="lihat('{{ $invoice->nomor_invoice }}')">Detail</button> </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <tbody>
                                <tr>
                                    <td>Belum ada transaksi.
                                    </td>
                                </tr>
                            </tbody>
                        @endif
                    </table>
                </div>
                <div class="pagination justify-content-end">
                    <ul class="pagination m-3">
                        <li class="page-item {{ $invoices->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $invoices->previousPageUrl() }}" tabindex="-1"
                                aria-disabled="true">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M15 6l-6 6l6 6" />
                                </svg>
                                prev
                            </a>
                        </li>
                        @for ($i = 1; $i <= $invoices->lastPage(); $i++)
                            <li class="page-item {{ $invoices->currentPage() === $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $invoices->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item {{ $invoices->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $invoices->nextPageUrl() }}">
                                next
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M9 6l6 6l-6 6" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal modal-blur fade" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="loading">
                        <div class="text-muted mb-3">Memuat data</div>
                        <div class="progress progress-sm">
                            <div class="progress-bar progress-bar-indeterminate"></div>
                        </div>
                    </div>
                    <div id="invoice-content">
                        <div class="container-xl">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title" id="nomor-invoice"></h3>
                                </div>
                                <div class="card-body">
                                    <div class="datagrid">
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Nama Game</div>
                                            <div class="datagrid-content" id="nama-game"></div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Nama Item</div>
                                            <div class="datagrid-content" id="nama-item"></div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Tipe Pembayaran</div>
                                            <div class="datagrid-content" id="tipe-pembayaran"></div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">User ID</div>
                                            <div class="datagrid-content" id="user-id"></div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Server ID</div>
                                            <div class="datagrid-content" id="server-id"></div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Metode Pembayaran</div>
                                            <div class="datagrid-content" id="metode-pembayaran"></div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Status</div>
                                            <div class="datagrid-content" id="status"></div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Waktu Expired</div>
                                            <div class="datagrid-content" id="expired"></div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Waktu di Bayar</div>
                                            <div class="datagrid-content" id="di-bayar"></div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Total</div>
                                            <div class="datagrid-content" id="total"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var invoiceId;

        function lihat(id) {
            invoiceId = id;
            $('#loading').show();
            $('#invoice-content').hide();
            $.ajax({
                url: '/realm/invoice/show/' + id,
                type: 'GET',
                success: function(response) {
                    document.getElementById('nomor-invoice').innerHTML = 'Invoice (' + response.nomor_invoice +
                        ')';
                    document.getElementById('nama-game').innerHTML = response.game.nama;
                    document.getElementById('nama-item').innerHTML = response.harga.nama_produk;
                    document.getElementById('tipe-pembayaran').innerHTML = response.payment.payment_type;
                    document.getElementById('user-id').innerHTML = response.user_id;
                    document.getElementById('server-id').innerHTML = response.server_id;
                    document.getElementById('metode-pembayaran').innerHTML = response.payment.payment_method;
                    if (response.status == 'PENDING') {
                        document.getElementById('status').innerHTML =
                            '<span class="badge bg-warning me-1 text-warning"></span>' + response.status +
                            '</td>';
                        document.getElementById('expired').innerHTML = konversiTanggal(response.expired_at) +
                            ' WIB';
                        document.getElementById('di-bayar').innerHTML = '-';
                    } else if (response.status == 'PAID') {
                        document.getElementById('status').innerHTML =
                            '<span class="badge bg-success me-1 text-success"></span>' + response.status +
                            '</td>';
                        document.getElementById('expired').innerHTML = '-';
                        document.getElementById('di-bayar').innerHTML = konversiTanggal(response.updated_at) +
                            ' WIB';
                    } else if (response.status == 'EXPIRED') {
                        document.getElementById('status').innerHTML =
                            '<span class="badge bg-danger me-1 text-danger"></span>' + response.status +
                            '</td>';
                        document.getElementById('expired').innerHTML = konversiTanggal(response.expired_at) +
                            ' WIB';
                        document.getElementById('di-bayar').innerHTML = '-';
                    }
                    document.getElementById('total').innerHTML = 'Rp. ' + formatRupiah(response.total);
                    $('#invoice-content').show();
                    $('#loading').hide();
                },
                error: function(xhr, error, status) {
                    $('#loading').hide();
                    $('#invoice-content').show();
                }
            });
        }

        function konversiTanggal(isoString) {
            var tanggalTerformat = moment(isoString).format('DD MMMM YYYY HH:mm:ss');
            return tanggalTerformat;
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
    </script>
@endsection
