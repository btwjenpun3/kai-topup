@extends('master.private.index')

@section('title')
    <title>Fumola Realm - Invoice</title>
@endsection

@section('header')
    <h2 class="page-title">
        List Invoice - Web
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
                    <table id="invoices" class="table table-hover card-table table-striped table-nowrap">
                        @if (isset($invoices) && count($invoices) > 0)
                            <thead>
                                <tr>
                                    <th class="w-1"></th>
                                    <th></th>
                                    <th>Produk</th>
                                    <th>Nomor Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Harga Jual + Admin</th>
                                    <th>Profit</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
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
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal modal-blur fade" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Invoice</h5>
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
                        <div class="container-xl mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="datagrid">
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">SERIAL NUMBER</div>
                                            <div class="datagrid-content" id="serial-number"></div>
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
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#invoices').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,
                bInfo: false,
                order: [
                    [0, 'desc']
                ],
                ajax: '{{ route('datatable.invoice.web') }}',
                columns: [{
                        data: 'id',
                        render: function(data, type, row) {
                            if (row.status == 'PAID') {
                                return '<span class="badge bg-success me-1"></span>';
                            } else if (row.status == 'PENDING') {
                                return '<span class="badge bg-warning me-1"></span>';
                            } else if (row.status == 'EXPIRED') {
                                return '<span class="badge bg-danger me-1"></span>';
                            }
                        }
                    },
                    {
                        data: 'game.nama'
                    },
                    {
                        data: 'harga.nama_produk'
                    },
                    {
                        data: 'nomor_invoice',
                        render: function(data, type, row) {
                            return '<a href="/invoice/' + data + '" target="_blank">' + data + '</a'
                        }
                    },
                    {
                        data: 'created_at',
                        render: function(data, type, row) {
                            return konversiTanggal(data)
                        }
                    },
                    {
                        data: 'total',
                        render: function(data, type, row) {
                            return formatRupiah(data)
                        }
                    },
                    {
                        data: 'harga.profit',
                        render: function(data, type, row) {
                            return '<div class="text-success">' + formatRupiah(data) +
                                '</div>'
                        }
                    },
                    {
                        data: 'nomor_invoice',
                        render: function(data, type, row) {
                            return '<button class="btn btn-md" data-bs-toggle="modal" data-bs-target="#modal-detail" onclick="lihat(`' +
                            row.nomor_invoice + '`)">Detail</button>';
                        }
                    }
                ],
            });
        });
    </script>
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
                    document.getElementById('total').innerHTML = formatRupiah(response.total);
                    if (response.digiflazz && response.digiflazz.sn) {
                        document.getElementById('serial-number').innerHTML = response.digiflazz.sn;
                    } else {
                        document.getElementById('serial-number').innerHTML = 'Data SN tidak di temukan';
                    }
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
            return 'Rp. ' + rupiah;
        }
    </script>
@endsection

@section('css')
    <style>
        .dataTables_wrapper .dataTables_filter {
            float: right;
            margin: 10px;
        }

        .dataTables_wrapper .dataTables_paginate {
            float: right;
            margin: 10px;
        }
    </style>
@endsection
