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
    <div id="produk-berhasil-di-hapus"></div>
    <div id="produk-berhasil-di-update"></div>
@endsection

@section('content')
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table id="table-harga" class="table table-vcenter card-table table-striped">
                        @if (isset($harga) && count($harga) > 0)
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Kode Produk</th>
                                    <th>Modal</th>
                                    <th>Harga Jual</th>
                                    <th>Profit</th>
                                    <th>Status</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($harga as $h)
                                    <tr>
                                        <td>{{ $h->nama_produk }}</td>
                                        <td>{{ $game->kode }}-{{ $h->kode_produk }}</td>
                                        <td>Rp. {{ $h->modal }}</td>
                                        <td>Rp. {{ $h->harga_jual }}</td>
                                        <td>Rp. {{ $h->profit }}</td>
                                        @if ($h->status === 1)
                                            <td> <span class="badge bg-success me-1"></span>Aktif</td>
                                        @else
                                            <td><span class="badge bg-danger me-1"></span>Tidak Aktif</td>
                                        @endif
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
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="kode_prepend">{{ $game->kode }} -</span>
                            </div>
                            <input type="text" name="kode_produk" id="edit_kode_produk" class="form-control"
                                placeholder="Misal '00001'" aria-describedby="kode_prepend" required />
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <label class="form-label" for="modal">Modal</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="modal_prepend">Rp.</span>
                            </div>
                            <input type="text" name="modal" id="edit_modal" class="form-control"
                                placeholder="Misal '15000'" aria-describedby="modal_prepend" required />
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
    <div class="modal modal-blur fade" id="modal-team" tabindex="-1" role="dialog" aria-hidden="true">
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
                    url: '/set-harga/show/' + id,
                    type: 'GET',
                    success: function(response) {
                        document.getElementById('edit_nama_produk').value = response.nama_produk;
                        document.getElementById('edit_kode_produk').value = response.kode_produk;
                        document.getElementById('edit_modal').value = response.modal;
                        document.getElementById('edit_harga_jual').value = response.harga_jual;
                        document.getElementById('edit_profit').value = response.profit;
                    },
                    error: function(xhr, error, status) {}
                });
            }

            $(document).ready(function() {
                var gameId = '{{ $game->id }}';
                $('#update').click(function() {
                    $.ajax({
                        url: '/set-harga/update/' + gameId + '/' + produkId,
                        type: 'POST',
                        data: {
                            edit_nama_produk: $('#edit_nama_produk').val(),
                            edit_kode_produk: $('#edit_kode_produk').val(),
                            edit_modal: $('#edit_modal').val(),
                            edit_harga_jual: $('#edit_harga_jual').val(),
                            edit_status: $('#edit_status').val(),
                            _token: '{{ csrf_token() }}'
                        },
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
                            errorMessage.textContent = xhr.responseJSON.error;
                            $('#produk-gagal-di-update').html(errorMessage);
                        }
                    });
                });
            });

            //Fungsi untuk menghapus Harga
            function hapus(id) {
                $('#btn-hapus').on('click', function() {
                    $.ajax({
                        type: 'DELETE',
                        url: '/set-harga/' + id,
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
