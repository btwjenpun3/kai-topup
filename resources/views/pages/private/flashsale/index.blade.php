@extends('master.private.index')

@section('title')
    <title>Kai Admin - Flashsale</title>
@endsection

@section('header')
    <h2 class="page-title">
        List Flashsale
    </h2>
@endsection

@section('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css">
@endsection

@section('button')
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            <span class="d-none d-sm-inline">
                <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#modal-pengaturan">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                    </svg>
                    Pengaturan
                </a>
            </span>
            <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                data-bs-target="#modal-flash-sale">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 5l0 14" />
                    <path d="M5 12l14 0" />
                </svg>
                Tambah
            </a>
        </div>
    </div>
@endsection

@section('message')
    <div id="flashsale-berhasil-di-update"></div>
    <div id="flashsale-berhasil-di-hapus"></div>
    <div id="flashsale-gagal-di-update"></div>
    <div id="flashsale-gagal-di-hapus"></div>
@endsection

@section('content')
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table id="flashsale-table" class="table table-vcenter text-nowrap card-table table-striped">
                        @if (isset($flashsales) && count($flashsales) > 0)
                            <thead>
                                <tr>
                                    <th class="w-1"></th>
                                    <th class="w-7"></th>
                                    <th>Nama Produk</th>
                                    <th>Modal Awal</th>
                                    <th>Harga Jual Awal</th>
                                    <th>Diskon</th>
                                    <th>Harga Flashsale</th>
                                    <th>Profit</th>
                                    <th>Stok</th>
                                    <th>Berakhir</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($flashsales as $flashsale)
                                    <tr>
                                        @if ($flashsale->status == 1)
                                            <td> <span class="badge bg-success me-1"></span></td>
                                        @else
                                            <td><span class="badge bg-danger me-1"></span></td>
                                        @endif
                                        <td><img src="{{ asset(Storage::url($flashsale->harga->gambar)) }}"></td>
                                        <td>{{ $flashsale->harga->nama_produk }}</td>
                                        <td>Rp. {{ number_format($flashsale->harga->modal, 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format($flashsale->harga->harga_jual, 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format($flashsale->discount, 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format($flashsale->final_price, 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format($flashsale->profit, 0, ',', '.') }}</td>
                                        <td>{{ $flashsale->stock }}</td>
                                        <td>{{ $flashsale->expired_at }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle align-text-top"
                                                    data-bs-toggle="dropdown">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modal-edit">
                                                        Edit </a>
                                                    <a class="dropdown-item
                                                        text-danger"
                                                        href="#" data-bs-toggle="modal" data-bs-target="#modal-hapus"
                                                        onclick="hapus({{ $flashsale->id }})">
                                                        Hapus </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <tbody>
                                <tr>
                                    <td>Tidak ada Data. Harap menambah Flashsale melalui tombol <code>Tambah</code>
                                        di atas.
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
    <div class="modal modal-blur fade" id="modal-flash-sale" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Flashsale</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 align-items-end">
                        <label class="form-label" for="produk">Pilih Produk</label>
                        <div class="input-group">
                            <select class="form-select" id="product" name="produk">
                                <option value="" selected>-- Pilih Produk --</option>
                                @foreach ($hargas as $harga)
                                    <option value="{{ $harga->id }}" data-modal="{{ $harga->modal }}"
                                        data-sell="{{ $harga->harga_jual }}"
                                        @if ($harga->status == '0') disabled @endif>
                                        {{ $harga->nama_produk }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="price" style="display: none;">
                            <label class="form-label mt-3" for="modal">Harga Modal</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" name="modal" class="form-control" id="priceValue" disabled />
                            </div>
                            <label class="form-label mt-3" for="jual">Harga Jual</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" name="jual" class="form-control" id="sellValue" disabled />
                            </div>
                            <label class="form-label mt-3" for="diskon">Harga Setelah Diskon</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" name="diskon" class="form-control" id="discountValue"
                                    placeholder="Masukkan Harga Setelah Diskon" />
                            </div>
                            <label class="form-label mt-3" for="profit">Profit</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" name="profit" class="form-control" id="profitValue" disabled />
                            </div>
                            <label class="form-label mt-3" for="stok">Stok</label>
                            <div class="input-group">
                                <input type="text" name="stok" class="form-control" id="stockValue"
                                    placeholder="Masukkan Stok" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
                        <button id="tambah" class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-pengaturan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pengaturan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 align-items-end">
                        <label class="form-label" for="produk">Tanggal Expired</label>
                        <div class="input-icon">
                            <span
                                class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                    <path d="M16 3v4" />
                                    <path d="M8 3v4" />
                                    <path d="M4 11h16" />
                                    <path d="M11 15h1" />
                                    <path d="M12 15v3" />
                                </svg>
                            </span>
                            <input class="form-control" type="text" placeholder="Select a date" id="datepicker" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
                        <button id="simpan" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="modal modal-blur fade" id="modal-hapus" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body text-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                        <path d="M12 9v4" />
                        <path d="M12 17h.01" />
                    </svg>
                    <h3>Apa kamu yakin?</h3>
                    <div class="text-muted">Kamu yakin ingin menghapus Flashsale ini ? Flashsale yang di hapus tidak
                        akan
                        dapat di kembalikan!</div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn w-100" data-bs-dismiss="modal">
                                    Batal
                                </a>
                            </div>
                            <div class="col">
                                <a href="#" id="btn-hapus" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                    Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/dist/libs/tom-select/dist/js/tom-select.base.min.js?1684106062" defer></script>
    <script src="/dist/libs/litepicker/dist/litepicker.js?1684106062" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.js">
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            $("#datepicker").datetimepicker({
                format: 'Y-m-d H:i:s',
            });
        });
        document.getElementById('product').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];

            var modalValue = selectedOption.dataset.modal;
            var sellValue = selectedOption.dataset.sell;

            var priceValueInput = document.getElementById('priceValue');
            priceValueInput.value = modalValue;

            var sellValueInput = document.getElementById('sellValue');
            sellValueInput.value = sellValue;

            var purchaseForm = document.getElementById('price');
            purchaseForm.style.display = 'block';
        });

        document.addEventListener("DOMContentLoaded", function() {
            var el;
            var tomSelect = new TomSelect(el = document.getElementById('product'), {
                copyClassesToDropdown: false,
                controlInput: '<input>',
                render: {
                    item: function(data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data
                                .customProperties + '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                    option: function(data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data
                                .customProperties + '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                },
            });
        });

        document.getElementById('discountValue').addEventListener('input', hitungProfit);

        function hitungProfit() {
            var modal = parseFloat(document.getElementById('priceValue').value.replace(/[^\d]/g, '')) || 0;
            var hargaJual = parseFloat(document.getElementById('discountValue').value.replace(/[^\d]/g, '')) || 0;
            var profit = hargaJual - modal;
            document.getElementById('profitValue').value = profit;
        }

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

        $('#simpan').click(function() {
            $.ajax({
                url: '/realm/flashsale/expired/',
                type: 'POST',
                data: {
                    expired_at: $('#datepicker').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    var successMessage = document.createElement(
                        "div");
                    successMessage.className =
                        "alert alert-success";
                    successMessage.textContent = response.success;
                    $('#modal-pengaturan').modal('hide');
                    $('#flashsale-berhasil-di-update').html(successMessage);
                    $("#flashsale-table").load(location.href + " #flashsale-table");
                },
                error: function(xhr, error) {
                    var errorMessage = document.createElement(
                        "div");
                    errorMessage.className =
                        "alert alert-danger";
                    errorMessage.textContent = xhr.responseJSON.message;
                    $('#modal-pengaturan').modal('hide');
                    $('#flashsale-gagal-di-update').html(errorMessage);
                }
            });
        });

        $('#tambah').click(function() {
            $.ajax({
                url: '/realm/flashsale',
                type: 'POST',
                data: {
                    harga_id: $('#product').val(),
                    discount: $('#sellValue').val() - $('#discountValue').val(),
                    final_price: $('#discountValue').val(),
                    profit: $('#profitValue').val(),
                    stock: $('#stockValue').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    var successMessage = document.createElement(
                        "div");
                    successMessage.className =
                        "alert alert-success";
                    successMessage.textContent = response.success;
                    $('#modal-flash-sale').modal('hide');
                    $('#flashsale-berhasil-di-update').html(successMessage);
                    $("#flashsale-table").load(location.href + " #flashsale-table");
                },
                error: function(xhr, error) {
                    var errorMessage = document.createElement(
                        "div");
                    errorMessage.className =
                        "alert alert-danger";
                    errorMessage.textContent = xhr.responseJSON.message;
                    $('#modal-flashsale').modal('hide');
                    $('#flashsale-gagal-di-update').html(errorMessage);
                }
            });
        });

        function hapus(id) {
            $('#btn-hapus').on('click', function() {
                $.ajax({
                    type: 'DELETE',
                    url: '/realm/flashsale/destroy/' + id,
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        var successMessage = document.createElement(
                            "div");
                        successMessage.className =
                            "alert alert-success";
                        successMessage.textContent = response.success;
                        $('#flashsale-berhasil-di-hapus').html(successMessage);
                        $("#flashsale-table").load(location.href + " #flashsale-table");
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = document.createElement(
                            "div");
                        errorMessage.className =
                            "alert alert-danger";
                        errorMessage.textContent = response.responseJSON.message;
                        $('#flashsale-gagal-di-hapus').html(errorMessage);
                        $("#flashsale-table").load(location.href + " #flashsale-table");
                    }
                });
            });
        }
    </script>
@endsection
