@extends('master.private.index')

@section('title')
    <title>Kai Admin - Transaksi</title>
@endsection

@section('header')
    <h2 class="page-title">
        List Transaksi
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
                <div class="table-responsive">
                    <table id="payment-table" class="table table-vcenter card-table table-striped">
                        @if (count($transactions) > 0)
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>TRX ID</th>
                                    <th>Nama</th>
                                    <th>Kode Produk</th>
                                    <th>Saldo Terakhir</th>
                                    <th>Saldo Terpotong</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td>{{ $data->nomor_invoice }}</td>
                                        @if (isset($data->digiflazz->trx_id))
                                            <td>{{ $data->digiflazz->trx_id }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        <td>{{ $data->harga->nama_produk }}</td>
                                        <td>{{ $data->harga->kode_produk }}</td>
                                        @if (isset($data->digiflazz->saldo_terakhir) && isset($data->digiflazz->saldo_terpotong))
                                            <td class="text-success">Rp.
                                                {{ number_format($data->digiflazz->saldo_terakhir, 0, ',', '.') }}</td>
                                            <td class="text-danger">Rp.
                                                {{ number_format($data->digiflazz->saldo_terpotong, 0, ',', '.') }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        @if (isset($data->digiflazz->created_at))
                                            <td>{{ \Carbon\Carbon::parse($data->digiflazz->created_at)->isoFormat('dddd, D MMMM YYYY, HH:mm:ss') }}
                                                WIB
                                            </td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        @if (isset($data->digiflazz->status) && $data->digiflazz->status == 'Pending')
                                            <td class="text-warning"><span
                                                    class="badge bg-warning me-1"></span>{{ $data->digiflazz->status }}</td>
                                        @elseif (isset($data->digiflazz->status) && $data->digiflazz->status == 'Sukses')
                                            <td class="text-success"><span
                                                    class="badge bg-success me-1"></span>{{ $data->digiflazz->status }}</td>
                                        @elseif (isset($data->digiflazz->status) && $data->digiflazz->status == 'Gagal')
                                            <td class="text-danger"><span
                                                    class="badge bg-danger me-1"></span>{{ $data->digiflazz->status }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        <td><button class="btn">Edit</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <tbody>
                                <tr>
                                    <td>Tidak ada Data. Harap menambah Game baru melalui tombol <code>Buat</code> di atas.
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
@endsection

@section('js')
    <script>
        var paymentId;

        function show(id) {
            paymentId = id;
            $.ajax({
                url: '/realm/payment/show/' + id,
                type: 'GET',
                success: function(response) {
                    document.getElementById('name').value = response.name;
                    document.getElementById('admin_fee').value = response.admin_fee;
                    document.getElementById('admin_fee_fixed').value = response.admin_fee_fixed;
                    document.getElementById('status').value = response.status;
                },
                error: function(xhr, error, status) {}
            });
        };

        $('#paymentEditButton').click(function() {
            $.ajax({
                url: '/realm/payment/update/' + paymentId,
                type: 'POST',
                data: {
                    name: $('#name').val(),
                    admin_fee: $('#admin_fee').val(),
                    admin_fee_fixed: $('#admin_fee_fixed').val(),
                    status: $('#status').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    var successMessage = document.createElement(
                        "div");
                    successMessage.className =
                        "alert alert-success";
                    successMessage.textContent = response.success;
                    $('#modal-edit').modal('hide');
                    $('#payment-berhasil-di-update').html(successMessage);
                    $("#payment-table").load(location.href + " #payment-table");
                },
                error: function(xhr, error) {
                    console.log(xhr);
                    var errorMessage = document.createElement(
                        "div");
                    errorMessage.className =
                        "alert alert-danger";
                    errorMessage.textContent = xhr.responseJSON.error;
                    $('#modal-edit').modal('hide');
                    $('#payment-gagal-di-update').html(errorMessage);
                }
            });
        });
    </script>
@endsection
