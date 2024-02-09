@extends('master.private.index')

@section('title')
    <title>Fumola Realm - Profit Report</title>
@endsection

@section('header')
    <h2 class="page-title">
        Profit Report
    </h2>
@endsection

@section('button')
@endsection

@section('message')
@endsection

@section('content')
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tampilkan Report Profit</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-2 align-items-center">
                                <div class="col-12 col-xl-2 font-weight-semibold">Pilih Range Tanggal</div>
                                <div class="col-12">
                                    <input name="range-tanggal" id="range-tanggal" type="text" class="form-control"
                                        placeholder="-- Select Date Range --">
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" id="generate" onclick="generate()" style="width:100%;">
                                        <span id="btn-text">Generate</span>
                                        <div class="spinner-grow" id="loading" role="status" style="display:none;">
                                            <span class="sr-only"></span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-3" id="profit-table" style="display:none;">
                            <div class="row g-2 align-items-center">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-vcenter table-hover card-table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Pembelian dari Reseller ?</th>
                                                    <th>Nomor Invoice</th>
                                                    <th>Produk</th>
                                                    <th>Harga Jual</th>
                                                    <th>Harga Modal</th>
                                                    <th>Profit</th>
                                                </tr>
                                            </thead>
                                            <tbody id="result-profit">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 align-items-center text-center">
                                <h3 class="mt-4 text-center">Result</h3>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-vcenter table-hover card-table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Total Harga Jual</th>
                                                    <th>Total Modal</th>
                                                    <th>Total Profit</th>
                                                    <th>Total Profit/2</th>
                                                    <th>Total Transfer</th>
                                                </tr>
                                            </thead>
                                            <tbody id="result-hasil">
                                            </tbody>
                                        </table>
                                    </div>
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
@endsection

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $('input[name="range-tanggal"]').daterangepicker({
            timePicker: true,
            timePickerIncrement: 1, // Menit antara setiap jam
            locale: {
                format: 'YYYY-MM-DD HH:mm:ss'
            },
            startDate: moment().startOf('day'), // Mengatur waktu awal ke 00:00:00 hari ini
            endDate: moment().endOf('day') // Mengatur waktu akhir ke 23:59:59 hari ini
        });

        function generate() {
            var totalHargaModal = 0;
            var totalProfit = 0;
            var totalProfitReseller = 0;

            $('#profit-table').hide();
            $('#btn-text').hide();
            $('#loading').show();
            $('.btn').attr('disabled', true);
            $.ajax({
                url: "{{ route('report.generate.profit') }}",
                method: "GET",
                data: {
                    date: $('#range-tanggal').val()
                },
                success: function(response) {
                    $('#result-profit').empty();
                    $('#result-hasil').empty();
                    $('#profit-table').show();
                    $.each(response.data, function(index, item) {
                        var row = '<tr>';

                        if (item.user.role.name && item.user.role.name == 'reseller') {
                            row += '<td>Ya</td>';
                        } else {
                            row += '<td>-</td>';
                        }

                        row += '<td>' + item.nomor_invoice + '</td>' +
                            '<td>' + item.harga.nama_produk + '</td>';

                        if (item.user.role.name && item.user.role.name == 'reseller') {
                            row += '<td>Rp. ' + formatRupiah(item.harga.harga_jual_reseller) + '</td>' +
                                '<td>Rp. ' + formatRupiah(item.harga.modal) + '</td>' +
                                '<td>Rp. ' + formatRupiah(item.harga.profit_reseller) + '</td>' +
                                '</tr>';
                            totalProfitReseller += parseFloat(item.harga.profit_reseller);
                        } else {
                            row += '<td>Rp. ' + formatRupiah(item.harga.harga_jual) + '</td>' +
                                '<td>Rp. ' + formatRupiah(item.harga.modal) + '</td>' +
                                '<td>Rp. ' + formatRupiah(item.harga.profit) + '</td>' +
                                '</tr>';
                            totalProfit += parseFloat(item.harga.profit);
                        };

                        $('#result-profit').append(row);

                        totalHargaModal += parseFloat(item.harga.modal);

                    });

                    var row2 = '<tr>' +
                        '<td>Rp. ' + formatRupiah(totalHargaModal + totalProfit + totalProfitReseller) +
                        '</td>' +
                        '<td>Rp. ' + formatRupiah(totalHargaModal) + '</td>' +
                        '<td>Rp. ' + formatRupiah(totalProfit + totalProfitReseller) + '</td>' +
                        '<td class="text-info">Rp. ' + formatRupiah(Math.round((totalProfit +
                            totalProfitReseller) / 2)) + '</td>' +
                        '<td class="text-success">Rp. ' + formatRupiah(totalHargaModal + Math.round(
                            (totalProfit + totalProfitReseller) / 2)) +
                        '</td>' +
                        '</tr>';

                    $('#result-hasil').append(row2);

                    $('#btn-text').show();
                    $('#loading').hide();
                    $('.btn').attr('disabled', false);
                },
                error: function(xhr, status, error) {}
            });

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
        }
    </script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
