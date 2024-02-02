@extends('master.private.index')

@section('title')
    <title>Kai Admin - Set Harga {{ $game->nama }}</title>
@endsection

@section('header')
    <h2 class="page-title">
        Set Harga - {{ $game->nama }} (<code>{{ $game->kode }}</code>)
    </h2>
@endsection

@section('button')
    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            <span class="d-none d-sm-inline">
                <a href="{{ route('games.index') }}" class="btn">
                    Kembali
                </a>
            </span>
            <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                data-bs-target="#modal-harga-buat">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 5l0 14" />
                    <path d="M5 12l14 0" />
                </svg>
                Tambah Produk
            </a>
            <a href="#" class="btn btn-info d-none d-sm-inline-block" data-bs-toggle="modal"
                data-bs-target="#modal-import">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="24"
                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                    <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                </svg>
                Sync
            </a>
        </div>
    </div>
@endsection

@section('message')
    @if (session()->has('produk-berhasil-di-buat'))
        <div class="alert alert-success" role="alert">
            {{ session('produk-berhasil-di-buat') }}
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
    <div id="import-berhasil"></div>
    <div id="import-gagal"></div>
    <div id="produk-berhasil-di-hapus"></div>
    <div id="produk-berhasil-di-update"></div>
@endsection

@section('content')
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table id="table-harga" class="table table-vcenter text-nowrap card-table">
                        @if (isset($harga) && count($harga) > 0)
                            <thead>
                                <tr>
                                    <th class="w-1"></th>
                                    <th class="w-7"></th>
                                    <th>Nama Produk</th>
                                    <th>Tipe</th>
                                    <th>Kode Produk</th>
                                    <th>Modal</th>
                                    <th>Harga Jual</th>
                                    <th>Profit</th>
                                    <th>Start Cut Off</th>
                                    <th>End Cut Off</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($harga as $h)
                                    <tr @if ($h->harga_jual <= '0') class="bg-danger text-light" @else @endif>
                                        @if ($h->status == 1)
                                            <td> <span class="badge bg-success me-1"></span></td>
                                        @else
                                            <td><span class="badge bg-danger me-1"></span></td>
                                        @endif
                                        <td><img src="{{ asset(Storage::url($h->gambar)) }}"></td>
                                        <td>{{ $h->nama_produk }}</td>
                                        <td>{{ $h->tipe }}</td>
                                        <td>{{ $h->kode_produk }}</td>
                                        <td>Rp. {{ number_format($h->modal, 0, ',', '.') }}</td>
                                        @if (isset($h->flashsale->final_price))
                                            <td><s class="text-danger">Rp.
                                                    {{ number_format($h->harga_jual, 0, ',', '.') }}</s>
                                                Rp. {{ number_format($h->flashsale->final_price, 0, ',', '.') }}
                                            </td>
                                        @else
                                            <td>Rp. {{ number_format($h->harga_jual, 0, ',', '.') }}</td>
                                        @endif
                                        @if (isset($h->flashsale->profit))
                                            @if ($h->flashsale->profit > 0)
                                                <td class="text-success">
                                                    <s class="text-danger">Rp.
                                                        {{ number_format($h->profit, 0, ',', '.') }}</s>
                                                    Rp. {{ number_format($h->flashsale->profit, 0, ',', '.') }}
                                                </td>
                                            @elseif($h->flashsale->profit < 0)
                                                <td class="text-danger">
                                                    <s class="text-danger">Rp.
                                                        {{ number_format($h->profit, 0, ',', '.') }}</s>
                                                    Rp. {{ number_format($h->flashsale->profit, 0, ',', '.') }}
                                                </td>
                                            @else
                                                <td class="text-secondary">Rp.
                                                    <s class="text-danger">Rp.
                                                        {{ number_format($h->profit, 0, ',', '.') }}</s>
                                                    Rp. {{ number_format($h->flashsale->profit, 0, ',', '.') }}
                                                </td>
                                            @endif
                                        @else
                                            @if ($h->profit > 0)
                                                <td class="text-success">Rp. {{ number_format($h->profit, 0, ',', '.') }}
                                                </td>
                                            @elseif($h->profit < 0)
                                                <td class="text-danger">Rp. {{ number_format($h->profit, 0, ',', '.') }}
                                                </td>
                                            @else
                                                <td class="text-secondary">Rp. {{ number_format($h->profit, 0, ',', '.') }}
                                                </td>
                                            @endif
                                        @endif
                                        <td>{{ \Carbon\Carbon::parse($h->start_cut_off)->format('H:i') }} WIB</td>
                                        <td>{{ \Carbon\Carbon::parse($h->end_cut_off)->format('H:i') }} WIB</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle align-text-top"
                                                    data-bs-toggle="dropdown">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modal-edit" onclick="show({{ $h->id }})">
                                                        Edit </a>
                                                    <a class="dropdown-item
                                                        text-danger"
                                                        href="#" data-bs-toggle="modal" data-bs-target="#modal-hapus"
                                                        onclick="hapus({{ $h->id }})">
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
                                    <td>Tidak ada Data. Harap menambah Harga baru melalui tombol <code>Tambah Harga</code>
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
    <div class="modal modal-blur fade" id="modal-harga-buat" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Produk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('harga.store', ['id' => $game->id]) }}"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="row mb-3 align-items-end">
                            <label class="form-label" for="nama_produk">Nama Produk</label>
                            <div class="input-group mb-3">
                                <input type="text" name="nama_produk" id="nama_produk" class="form-control"
                                    placeholder="Misal 'Diamond 500'" aria-describedby="kode_prepend" required />
                            </div>
                        </div>
                        <div class="row mb-3 align-items-end">
                            <label class="form-label" for="kode_produk">Kode Produk</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="kode_prepend">{{ $game->kode }} -</span>
                                </div>
                                <input type="text" name="kode_produk" id="kode_produk" class="form-control"
                                    placeholder="Misal '00001'" aria-describedby="kode_prepend" required />
                            </div>
                        </div>
                        <div class="row mb-3 align-items-end">
                            <label class="form-label" for="modal">Modal</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="modal_prepend">Rp.</span>
                                </div>
                                <input type="text" name="modal" id="modal" class="form-control"
                                    placeholder="Misal '15000'" aria-describedby="modal_prepend" required />
                            </div>
                        </div>
                        <div class="row mb-3 align-items-end">
                            <label class="form-label" for="harga_jual">Harga Jual</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="modal_prepend">Rp.</span>
                                </div>
                                <input type="text" name="harga_jual" id="harga_jual" class="form-control"
                                    placeholder="Misal '16500'" aria-describedby="modal_prepend" required />
                            </div>
                        </div>
                        <div class="row mb-3 align-items-end">
                            <label class="form-label" for="profit">Profit</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="modal_prepend">Rp.</span>
                                </div>
                                <input type="text" name="profit" id="profit" class="form-control"
                                    aria-describedby="modal_prepend" disabled />
                            </div>
                        </div>
                        <div class="row mb-3 align-items-end">
                            <label class="form-label" for="gambar">Gambar</label>
                            <div class="input-group mb-3">
                                <input type="file" name="gambar" id="gambar" class="form-control" />
                            </div>
                            <span class="text-danger small lh-base">
                                <ul>
                                    <li>Ukuran yang disarankan 512x512 px</li>
                                    <li>Ukuran file maksimal 2048 kbps</li>
                                    <li>Format harus berupa : <i>jpeg,png,jpg,webp</i></li>
                                </ul>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Buat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="produk-gagal-di-update"></div>
                    <div class="row mb-3 align-items-end">
                        <label class="form-label" for="nama_produk">Nama Produk</label>
                        <div class="input-group mb-3">
                            <input type="text" name="nama_produk" id="edit_nama_produk" class="form-control"
                                placeholder="Misal 'Diamond 500'" aria-describedby="kode_prepend" required />
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <label class="form-label" for="kode_produk">Kode Produk</label>
                        <div class="input-group mb-3">
                            <input type="text" name="kode_produk" id="edit_kode_produk" class="form-control"
                                placeholder="Misal '00001'" disabled />
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <label class="form-label" for="modal">Modal</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="modal_prepend">Rp.</span>
                            </div>
                            <input type="text" name="modal" id="edit_modal" class="form-control"
                                placeholder="Misal '15000'" aria-describedby="modal_prepend" disabled />
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <label class="form-label" for="harga_jual">Harga Jual</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="modal_prepend">Rp.</span>
                            </div>
                            <input type="text" name="harga_jual" id="edit_harga_jual" class="form-control"
                                placeholder="Misal '16500'" aria-describedby="modal_prepend" required />
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <label class="form-label" for="profit">Profit</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="modal_prepend">Rp.</span>
                            </div>
                            <input type="text" name="profit" id="edit_profit" class="form-control"
                                aria-describedby="modal_prepend" disabled />
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <label class="form-label" for="gambar">Gambar</label>
                        <div class="input-group mb-3">
                            <input type="file" name="gambar" id="edit_gambar" class="form-control"
                                aria-describedby="modal_prepend" />
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <label class="form-label" for="edit_status">Status</label>
                        <div class="input-group mb-3">
                            <select class="form-select" name="edit_status" id="edit_status">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
                    <button id="update" type="button" class="btn btn-primary">Edit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-import" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-info"></div>
                <div class="modal-body text-center py-4">
                    <div id="import_loading" style="display: none;">
                        <div class="text-muted mb-3">Data sedang di sinkronisasi</div>
                        <div class="progress progress-sm">
                            <div class="progress-bar progress-bar-indeterminate"></div>
                        </div>
                    </div>
                </div>
                <div id="import">
                    <div class="modal-body text-center py-4">
                        <div class="text-muted">Kamu yakin ingin sinkronisasi data game dari Digiflazz ?</div>
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
                                    <a href="#" id="btn-import" class="btn btn-success w-100"
                                        onclick="importHarga({{ $game->id }})">
                                        Iya
                                    </a>
                                </div>
                            </div>
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
                    <div class="text-muted">Kamu yakin ingin menghapus produk ini ? Data produk yang di hapus tidak akan
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
    <script>
        var produkId;
        // Fungsi untuk menghitung profit
        function hitungProfit() {
            var modal = parseFloat(document.getElementById('modal').value) || 0;
            var hargaJual = parseFloat(document.getElementById('harga_jual').value) || 0;
            var profit = hargaJual - modal;
            document.getElementById('profit').value = profit;
        }
        document.getElementById('modal').addEventListener('input', hitungProfit);
        document.getElementById('harga_jual').addEventListener('input', hitungProfit);

        //Fungsi hitung profit di edit
        function hitungProfitEdit() {
            var modal = parseFloat(document.getElementById('edit_modal').value) || 0;
            var hargaJual = parseFloat(document.getElementById('edit_harga_jual').value) || 0;
            var profit = hargaJual - modal;
            document.getElementById('edit_profit').value = profit;
        }
        document.getElementById('edit_modal').addEventListener('input', hitungProfitEdit);
        document.getElementById('edit_harga_jual').addEventListener('input', hitungProfitEdit);

        //Fungsi untuk melihat data yang akan di edit
        function show(id) {
            produkId = id;
            $.ajax({
                url: '/realm/set-harga/show/' + id,
                type: 'GET',
                success: function(response) {
                    document.getElementById('edit_nama_produk').value = response.nama_produk;
                    document.getElementById('edit_kode_produk').value = response.kode_produk;
                    document.getElementById('edit_modal').value = response.modal;
                    document.getElementById('edit_harga_jual').value = response.harga_jual;
                    document.getElementById('edit_profit').value = response.profit;
                    document.getElementById('edit_gambar').value = null;
                },
                error: function(xhr, error, status) {}
            });
        }

        $(document).ready(function() {
            var gameId = '{{ $game->id }}';
            $('#update').click(function() {
                var editGambar = $('#edit_gambar')[0].files[0];
                var formData = new FormData($('#myForm')[0]);

                formData.append('edit_nama_produk', $('#edit_nama_produk').val());
                formData.append('edit_kode_produk', $('#edit_kode_produk').val());
                formData.append('edit_modal', $('#edit_modal').val());
                formData.append('edit_gambar', editGambar);
                formData.append('edit_harga_jual', $('#edit_harga_jual').val());
                formData.append('edit_status', $('#edit_status').val());
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '/realm/set-harga/update/' + gameId + '/' + produkId,
                    type: 'POST',
                    processData: false, // Set to false because we are using FormData
                    contentType: false, // Set to false because we are using FormData
                    data: formData, // Pass FormData directly
                    success: function(response) {
                        var successMessage = document.createElement(
                            "div");
                        successMessage.className =
                            "alert alert-success";
                        successMessage.textContent = response.success;
                        $('#modal-edit').modal('hide');
                        $('#produk-berhasil-di-update').html(successMessage);
                        $("#table-harga").load(location.href + " #table-harga");
                    },
                    error: function(xhr, error, status) {
                        var errorMessage = document.createElement(
                            "div");
                        errorMessage.className = "alert alert-danger";
                        errorMessage.textContent = xhr.responseJSON.failed;
                        $('#produk-gagal-di-update').html(errorMessage);
                    }
                });
            });
        });

        function importHarga(id) {
            $('#import_loading').show();
            $('#import').hide();
            $.ajax({
                type: 'POST',
                url: '/realm/set-harga/import/' + id,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    var successMessage = document.createElement(
                        "div");
                    successMessage.className =
                        "alert alert-success";
                    successMessage.textContent = response.success;
                    $('#import-berhasil').html(successMessage);
                    $('#import_loading').hide();
                    $('#modal-import').modal('hide');
                    $('#import').show();
                    $("#table-harga").load(location.href + " #table-harga");
                },
                error: function(xhr, status, error) {
                    var errorMessage = document.createElement(
                        "div");
                    errorMessage.className =
                        "alert alert-danger";
                    errorMessage.textContent = xhr.responseJSON.message;
                    $('#import-gagal').html(errorMessage);
                    $('#import_loading').hide();
                    $('#import').show();
                    $('#modal-import').modal('hide');
                }
            });
        }

        function hapus(id) {
            $('#btn-hapus').on('click', function() {
                $.ajax({
                    type: 'DELETE',
                    url: '/realm/set-harga/' + id,
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        var successMessage = document.createElement(
                            "div");
                        successMessage.className =
                            "alert alert-success";
                        successMessage.textContent = response.success;
                        $('#produk-berhasil-di-hapus').html(successMessage);
                        $("#table-harga").load(location.href + " #table-harga");
                    },
                    error: function(xhr, status, error) {}
                });
            });
        }
    </script>
@endsection
