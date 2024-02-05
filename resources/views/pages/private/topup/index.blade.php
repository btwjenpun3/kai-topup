@extends('master.private.index')

@section('title')
    <title>Fumola Realm - Top Up</title>
@endsection

@section('header')
    <h2 class="page-title">
        Top Up - {{ $game->nama }}
    </h2>
@endsection

@section('button')
@endsection

@section('message')
    <div id="success"></div>
    <div id="failed"></div>
    <div id="notification"></div>
    <div id="notification-failed"></div>
    <div class="alert alert-success" role="alert">
        <div class="d-flex justify-content-between">
            <div class="text-secondary">Mohon tunggu</div>
            <span>
                <div class="spinner-grow" role="status">
                    <span class="sr-only"></span>
                </div>
            </span>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Top Up</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-2 align-items-center">
                                @if (auth()->user()->role->name == 'reseller')
                                    <h4>Saldo : Rp. {{ number_format(auth()->user()->saldo, 0, ',', '.') }}</h4>
                                @endif
                                <span>Note : Jika produk <code>Tidak Aktif / Offline</code> atau <code>Harga Jual Rp. 0 atau
                                        Kurang</code>, maka produk tidak
                                    bisa dipilih</span>
                                <span>Jika kamu Reseller maka harap hubungi Admin jika kamu ingin menyalakan produk yang
                                    ingin kamu beli.</span>
                                <div class="form-label mt-5">Pilih Produk</div>
                                <select class="form-select" id="product" name="product" required>
                                    <option value="" selected>-- Pilih Produk --</option>
                                    @foreach ($produk as $p)
                                        @if (auth()->user()->role->name == 'admin')
                                            <option value="{{ $p->kode_produk }}"
                                                @if ($p->status == 0 || $p->status == 3 || $p->harga_jual <= 0) disabled @endif>
                                                {{ $p->nama_produk }} (Rp. {{ number_format($p->harga_jual, 0, ',', '.') }})
                                            </option>
                                        @elseif(auth()->user()->role->name == 'reseller')
                                            <option value="{{ $p->kode_produk }}"
                                                @if ($p->status == 0 || $p->status == 3 || $p->harga_jual_reseller <= 0) disabled @endif>
                                                {{ $p->nama_produk }} (Rp.
                                                {{ number_format($p->harga_jual_reseller, 0, ',', '.') }})
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($game->slug == 'mobile-legend')
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">Masukkan User ID</div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID Kamu --" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">Masukkan Server ID</div>
                                        <input type="text" id="serverid" name="serverid" class="form-control"
                                            placeholder="-- Server ID Kamu --" required>
                                    </div>
                                @elseif($game->slug == 'free-fire')
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">Masukkan User ID</div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID Kamu --" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">Masukkan Server ID</div>
                                        <input type="text" id="serverid" name="serverid" class="form-control"
                                            placeholder="-- Server ID Kamu --" required>
                                    </div>
                                @elseif($game->slug == 'undawn')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">Masukkan User ID</div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID Kamu --" required>
                                    </div>
                                @elseif($game->slug == 'lifeafter')
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">Masukkan User ID</div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID Kamu --" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">Masukkan Server ID</div>
                                        <select id="serverid" name="serverid" class="form-select" required>
                                            <optgroup label="SEA">
                                                <option value="520001">NancyCity (520001)</option>
                                                <option value="520002">CharlesTown (520002)</option>
                                                <option value="520003">SnowHighlands (520003)</option>
                                                <option value="520004">Santopany (520004)</option>
                                                <option value="520005">LevinCity (520005)</option>
                                                <option value="520006">MileStone (520006)</option>
                                                <option value="520007">ChaosCity (520007)</option>
                                                <option value="520008">TwinIslands (520008)</option>
                                                <option value="520009">HopeWall (520009)</option>
                                                <option value="520010">LabyrinthSea (520010)</option>
                                            </optgroup>
                                            <optgroup label="NA">
                                                <option value="500001">MiskaTown (500001)</option>
                                                <option value="500002">SandCastle (500002)</option>
                                                <option value="500003">MouthSwamp (500003)</option>
                                                <option value="500004">RedwoodTown (500004)</option>
                                                <option value="500005">Obelisk (500005)</option>
                                                <option value="500006">NewLand (500006)</option>
                                                <option value="500007">ChaosOutpost (500007)</option>
                                                <option value="500008">IronStride (500008)</option>
                                                <option value="500009">CrystalthornSea (500009)</option>
                                            </optgroup>
                                            <optgroup label="AU">
                                                <option value="510001">FallForest (510001)</option>
                                                <option value="510002">MountSnow (510002)</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                @elseif($game->slug == 'pubg')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">Masukkan User ID</div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID Kamu --" required>
                                    </div>
                                @elseif($game->slug == 'hago')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">Masukkan User ID</div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID Kamu --" required>
                                    </div>
                                @else
                                @endif
                                <div class="col-md-12">
                                    <div class="form-label mt-3">Masukkan Password Akun Realm Kamu</div>
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="-- Password Kamu --" required>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <button id="btn-beli" class="btn btn-primary form-control" data-bs-toggle="modal"
                                        data-bs-target="#modal-submit">
                                        <span id="btn-text">Beli</span>
                                        <div class="spinner-grow text-light" id="loading" role="status"
                                            style="display:none;">
                                            <span class="sr-only"></span>
                                        </div>
                                    </button>
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
    <div class="modal modal-blur fade" id="modal-submit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-warning"></div>
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
                    <div class="text-muted">Pastikan data yang kamu isi sudah benar, karena kami belum memiliki sistem
                        untuk
                        pengecekan UserID!</div>
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
                                <a href="#" id="btn-submit" class="btn btn-success w-100" data-bs-dismiss="modal"
                                    onclick="process()">
                                    Proses
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
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.2/dist/echo.iife.js"></script>
    <script>
        var pusher = new Pusher('d4afa1b27ea54cbf1546', {
            cluster: 'ap1'
        });

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: 'd4afa1b27ea54cbf1546',
            cluster: 'ap1',
            encrypted: true
        });
        window.Echo.channel('my-channel')
            .listen('TopUpEvent', (event) => {
                $('#success').hide();
                var notificationAlert = '<div class="alert alert-success alert-dismissible" role="alert">' +
                    '<div class="d-flex">' +
                    '<div>' +
                    '<h4 class="alert-title">Berhasil!</h4>' +
                    '<div class="text-secondary"> ' + event.message + ' </div>' +
                    '</div>' +
                    '</div>' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>';

                $('#notification').html(notificationAlert);
            });

        window.Echo.channel('top-up-fail')
            .listen('TopUpFailEvent', (event) => {
                $('#success').hide();
                var notificationAlert = '<div class="alert alert-danger alert-dismissible" role="alert">' +
                    '<div class="d-flex">' +
                    '<div>' +
                    '<h4 class="alert-title">Gagal!</h4>' +
                    '<div class="text-secondary"> ' + event.message + ' </div>' +
                    '</div>' +
                    '</div>' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>';

                $('#notification-failed').html(notificationAlert);
            });
    </script>
    <script>
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

        function process() {
            $('#btn-text').hide();
            $('#loading').show();
            $('#btn-beli').attr('disabled', true);
            var serveridVal = $('#serverid').val() || '';
            $.ajax({
                url: "/realm/topup/process",
                method: "POST",
                data: {
                    product: $('#product').val(),
                    userid: $('#userid').val(),
                    serverid: serveridVal,
                    password: $('#password').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.berhasil) {
                        successAlert(response.berhasil);
                    } else {
                        failedAlert(response.unaccepted);
                    }
                },
                error: function(xhr, status, error) {
                    if (error.unaccepted) {
                        failedAlert(xhr.responseJSON.unaccepted);
                    } else {
                        failedAlert(xhr.responseJSON.unaccepted);
                    }
                },
                complete: function() {
                    $('#btn-text').show();
                    $('#loading').hide();
                    $('#btn-beli').attr('disabled', false);
                }
            });
        }

        function successAlert(message) {
            var successAlert = '<div class="alert alert-success" role="alert">' +
                '<div class="d-flex">' +
                '<div class="text-secondary">' + message + '</div>' +
                '<span>' +
                '<div class="spinner-grow" role="status">' +
                '<span class="sr-only"></span>' +
                '</div>' +
                '</span>' +
                '</div>' +
                '</div>';

            $('#success').html(successAlert);
        }

        function failedAlert(message) {
            var failedAlert = '<div class="alert alert-danger alert-dismissible" role="alert">' +
                '<div class="d-flex">' +
                '<div>' +
                '<h4 class="alert-title">Gagal!</h4>' +
                '<div class="text-secondary">' + message + '</div>' +
                '</div>' +
                '</div>' +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                '</div>';

            $('#failed').html(failedAlert);
        }
    </script>
@endsection

@section('css')
@endsection
