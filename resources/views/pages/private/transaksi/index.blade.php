@extends('master.private.index')

@section('title')
    <title>Fumola Realm - Transaksi</title>
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
                    <table id="payment-table" class="table table-hover table-nowrap table-vcenter card-table table-striped">
                        @if (count($transactions) > 0)
                            <thead>
                                <tr>
                                    <th class="w-1"></th>
                                    <th>Invoice</th>
                                    <th>TRX ID</th>
                                    <th>Nama</th>
                                    <th>Kode Produk</th>
                                    <th>Saldo Terakhir</th>
                                    <th>Saldo Terpotong</th>
                                    <th>SN</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        @if (isset($data->digiflazz->status) && $data->digiflazz->status == 'Pending')
                                            <td class="text-warning text-center"><span class="badge bg-warning me-1"></span>
                                            </td>
                                        @elseif (isset($data->digiflazz->status) && $data->digiflazz->status == 'Sukses')
                                            <td class="text-success text-center"><span class="badge bg-success me-1"></span>
                                            </td>
                                        @elseif (isset($data->digiflazz->status) && $data->digiflazz->status == 'Gagal')
                                            <td class="text-danger text-center"><span class="badge bg-danger me-1"></span>
                                            </td>
                                        @else
                                            <td class="text-secondary text-center"><span
                                                    class="badge bg-secondary me-1"></span>
                                            </td>
                                        @endif
                                        <td>{{ $data->nomor_invoice }}</td>
                                        @if (isset($data->digiflazz->trx_id))
                                            <td>{{ $data->digiflazz->trx_id }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        <td>{{ $data->harga->nama_produk }}</td>
                                        <td>{{ $data->harga->kode_produk }}</td>
                                        @if (isset($data->digiflazz->saldo_terakhir) && $data->status == 'PAID')
                                            <td class="text-success">Rp.
                                                {{ number_format($data->digiflazz->saldo_terakhir, 0, ',', '.') }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        @if (isset($data->digiflazz->saldo_terpotong) && $data->status == 'PAID')
                                            <td class="text-danger">Rp.
                                                {{ number_format($data->digiflazz->saldo_terpotong, 0, ',', '.') }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        @if (isset($data->digiflazz->sn))
                                            <td>{{ $data->digiflazz->sn }}</td>
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
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <tbody>
                                <tr>
                                    <td>Belum ada transaksi. </td>
                                </tr>
                            </tbody>
                        @endif
                    </table>
                </div>
                <div class="pagination justify-content-end">
                    <ul class="pagination m-3">
                        <li class="page-item {{ $datas->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $datas->previousPageUrl() }}" tabindex="-1" aria-disabled="true">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M15 6l-6 6l6 6" />
                                </svg>
                                prev
                            </a>
                        </li>

                        @php
                            $start = max(1, $datas->currentPage() - 4);
                            $end = min($datas->lastPage(), $start + 9);
                            $extraPages = 0;
                            if ($datas->currentPage() > 4 && $datas->lastPage() > 10) {
                                $extraPages = min(2, $datas->currentPage() - 4);
                                $start -= $extraPages;
                            }
                        @endphp

                        @if ($datas->lastPage() > 10)
                            @for ($i = 1; $i <= 4; $i++)
                                <li class="page-item {{ $datas->currentPage() === $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $datas->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            @if ($start > 1)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif

                            @for ($i = $start; $i <= $end; $i++)
                                <li class="page-item {{ $datas->currentPage() === $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $datas->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            @if ($datas->currentPage() < $datas->lastPage() - 4)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif

                            @for ($i = $datas->lastPage() - 3; $i <= $datas->lastPage(); $i++)
                                <li class="page-item {{ $datas->currentPage() === $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $datas->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                        @else
                            @for ($i = 1; $i <= $datas->lastPage(); $i++)
                                <li class="page-item {{ $datas->currentPage() === $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $datas->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                        @endif

                        <li class="page-item {{ $datas->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $datas->nextPageUrl() }}">
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
