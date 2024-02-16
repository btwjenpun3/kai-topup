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

                                @if ($game->kategori == 'Voucher')
                                    <div class="alert alert-info mt-3 text-dark" role="alert">
                                        <b>Kode Voucher akan tercetak pada SN di Invoice</b>
                                    </div>
                                @endif

                                @if ($game->slug == 'call-of-duty-mobile')
                                    <div class="alert alert-success mt-3 text-dark" role="alert">
                                        <b>Support All Bind! ✅ Facebook | ✅ Garena</b>
                                    </div>
                                @elseif($game->slug == 'undawn')
                                    <div class="alert alert-warning mt-3 text-dark" role="alert">
                                        <b>Produk Ini Tidak Support Bind Garena!</b>
                                        <p>Silahkan menuju halaman <a
                                                href="{{ route('realm.topup.index', ['slug' => 'undawn-all-bind']) }}">DISINI</a>
                                            jika ingin membeli yang support All Bind</p>
                                    </div>
                                @elseif($game->slug == 'undawn-all-bind')
                                    <div class="alert alert-success mt-3 text-dark" role="alert">
                                        <b>Support All Bind! ✅ Facebook | ✅ Garena | ✅ Google</b>
                                    </div>
                                @elseif($game->slug == 'clash-of-clans')
                                    <div class="alert alert-warning mt-3 text-dark" role="alert">
                                        <b>Akun WAJIB terhubung ke Supercell ID!</b>
                                    </div>
                                @elseif($game->slug == 'hay-day')
                                    <div class="alert alert-warning mt-3 text-dark" role="alert">
                                        <b>Akun WAJIB terhubung ke Supercell ID!</b>
                                    </div>
                                @endif

                                <div class="form-label mt-2 ">Pilih Produk</div>
                                <select class="form-select" id="product" name="product" required>
                                    <option value="" selected>-- Pilih Produk --</option>
                                    @foreach ($produk as $p)
                                        @if (auth()->user()->role->name == 'admin')
                                            @if ($p->status == 0 || $p->status == 3 || $p->harga_jual <= 0 || $p->harga_jual <= $p->modal)
                                                <option disabled>
                                                    (OFFLINE)
                                                    {{ $p->nama_produk }} (Rp.
                                                    {{ number_format($p->harga_jual, 0, ',', '.') }})
                                                </option>
                                            @else
                                                <option value="{{ $p->kode_produk }}">
                                                    {{ $p->nama_produk }} (Rp.
                                                    {{ number_format($p->harga_jual, 0, ',', '.') }})
                                                </option>
                                            @endif
                                        @elseif(auth()->user()->role->name == 'reseller')
                                            @if ($p->status == 0 || $p->status == 3 || $p->harga_jual_reseller <= 0 || $p->harga_jual_reseller <= $p->modal)
                                                <option disabled>
                                                    (OFFLINE) {{ $p->nama_produk }} (Rp.
                                                    {{ number_format($p->harga_jual_reseller, 0, ',', '.') }})
                                                </option>
                                            @else
                                                <option value="{{ $p->kode_produk }}">
                                                    {{ $p->nama_produk }} (Rp.
                                                    {{ number_format($p->harga_jual_reseller, 0, ',', '.') }})
                                                </option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                                @if ($game->slug == 'mobile-legend')
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">
                                            Masukkan User ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID --" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">Masukkan Server ID</div>
                                        <input type="text" id="serverid" name="serverid" class="form-control"
                                            placeholder="-- Server ID --" required>
                                    </div>
                                    @include('pages.private.topup.button_check_id')
                                @elseif($game->slug == 'free-fire')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">
                                            Masukkan User ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID --" required>
                                    </div>
                                    @include('pages.private.topup.button_check_id')
                                @elseif($game->slug == 'undawn')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">
                                            Masukkan User ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID --" required>
                                    </div>
                                @elseif($game->slug == 'undawn-all-bind')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">
                                            Masukkan User ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID --" required>
                                    </div>
                                @elseif($game->slug == 'lifeafter')
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">
                                            Masukkan User ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID --" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">Pilih Server</div>
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
                                        <div class="form-label mt-3">
                                            Masukkan User ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID --" required>
                                    </div>
                                @elseif($game->slug == 'hago')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">
                                            Masukkan User ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID --" required>
                                    </div>
                                @elseif($game->slug == 'valorant')
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">
                                            Masukkan User ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID --" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">Masukkan TAG (Tanpa #)</div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">#</span>
                                            </div>
                                            <input type="text" id="serverid" name="serverid" class="form-control"
                                                placeholder="-- User TAG --" required>
                                        </div>
                                    </div>
                                @elseif($game->slug == 'clash-of-clans')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">
                                            Masukkan User TAG (Tanpa #)
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">#</span>
                                            </div>
                                            <input type="text" id="userid" name="userid" class="form-control"
                                                placeholder="-- User TAG --" required>
                                        </div>
                                    </div>
                                @elseif($game->slug == 'pln')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">Masukkan Nomor Pelanggan</div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- Nomor Pelanggan --" required>
                                    </div>
                                @elseif($game->slug == 'bigo-live')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">Masukkan ID Pengguna</div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- ID Pengguna --" required>
                                    </div>
                                @elseif($game->slug == 'genshin-impact')
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">
                                            Masukkan User ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID --" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">Pilih Server</div>
                                        <select id="serverid" name="serverid" class="form-select" required>
                                            <option value="os_asia">Asia</option>
                                            <option value="os_usa">America</option>
                                            <option value="os_euro">Europe</option>
                                            <option value="os_cht">TW_HK_MO</option>
                                        </select>
                                    </div>
                                @elseif($game->slug == 'honkai-star-rail')
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">
                                            Masukkan User ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID --" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">Pilih Server</div>
                                        <select id="serverid" name="serverid" class="form-select" required>
                                            <option value="os_asia">Asia</option>
                                            <option value="os_usa">America</option>
                                            <option value="os_euro">Europe</option>
                                            <option value="os_cht">TW_HK_MO</option>
                                        </select>
                                    </div>
                                @elseif($game->slug == 'hay-day')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">
                                            Masukkan User TAG (Tanpa #)
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">#</span>
                                            </div>
                                            <input type="text" id="userid" name="userid" class="form-control"
                                                placeholder="-- User TAG --" required>
                                        </div>
                                    </div>
                                @elseif($game->slug == 'sausage-man')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">
                                            Masukkan User ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID --" required>
                                    </div>
                                @elseif($game->slug == 'league-of-legends-wild-rift')
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">
                                            Masukkan User ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID --" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">Masukkan TAG (Tanpa #)</div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">#</span>
                                            </div>
                                            <input type="text" id="serverid" name="serverid" class="form-control"
                                                placeholder="-- User TAG --" required>
                                        </div>
                                    </div>
                                    @include('pages.private.topup.button_check_id')
                                @elseif($game->slug == 'ragnarok-origin')
                                    <div class="col-md-4">
                                        <div class="form-label mt-3">
                                            Masukkan Secret Code
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- Secret Code --" required>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-label mt-3">Masukkan Nickname</div>
                                        <input type="text" id="usernickname" name="usernickname" class="form-control"
                                            placeholder="-- User Nickname --" required>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-label mt-3">Pilih Server</div>
                                        <select id="serverid" name="serverid" class="form-select" required>
                                            <optgroup label="Prontera">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}">Server ID : ({{ $i }})
                                                        Prontera-{{ $i }}
                                                    </option>
                                                @endfor
                                            </optgroup>
                                            <optgroup label="Izlude">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i + 10 }}">Server ID : ({{ $i + 10 }})
                                                        Izlude-{{ $i }}
                                                    </option>
                                                @endfor
                                            </optgroup>
                                            <optgroup label="Morroc">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i + 20 }}">Server ID : ({{ $i + 20 }})
                                                        Morroc-{{ $i }}
                                                    </option>
                                                @endfor
                                            </optgroup>
                                            <optgroup label="Geffen">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i + 30 }}">Server ID : ({{ $i + 30 }})
                                                        Geffen-{{ $i }}
                                                    </option>
                                                @endfor
                                            </optgroup>
                                            <optgroup label="Payon">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i + 40 }}">Server ID : ({{ $i + 40 }})
                                                        Payon-{{ $i }}
                                                    </option>
                                                @endfor
                                            </optgroup>
                                            <optgroup label="Poring Island">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i + 50 }}">Server ID : ({{ $i + 50 }})
                                                        Poring Island-{{ $i }}
                                                    </option>
                                                @endfor
                                            </optgroup>
                                            <optgroup label="Orc Village">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i + 60 }}">Server ID : ({{ $i + 60 }})
                                                        Orc Village-{{ $i }}
                                                    </option>
                                                @endfor
                                            </optgroup>
                                            <optgroup label="Shipwreck">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i + 70 }}">Server ID : ({{ $i + 70 }})
                                                        Shipwreck-{{ $i }}
                                                    </option>
                                                @endfor
                                            </optgroup>
                                            <optgroup label="Ant-Hell">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i + 80 }}">Server ID : ({{ $i + 80 }})
                                                        Ant-Hell-{{ $i }}
                                                    </option>
                                                @endfor
                                            </optgroup>
                                        </select>
                                    </div>
                                @elseif($game->slug == 'call-of-duty-mobile')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">
                                            Masukkan Player ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- Player ID --" required>
                                    </div>
                                    @include('pages.private.topup.button_check_id')
                                @elseif($game->slug == 'lita')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">
                                            Masukkan User ID LITA
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID LITA --" required>
                                    </div>
                                @elseif($game->slug == 'metal-slug-awakening')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">
                                            Masukkan User ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID --" required>
                                    </div>
                                @elseif($game->slug == 'ludo-club')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">
                                            Masukkan Player ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- Player ID --" required>
                                    </div>
                                @elseif($game->slug == 'dragon-raja-sea')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">
                                            Masukkan Player ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- Player ID --" required>
                                    </div>
                                @elseif($game->slug == 'zepeto')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">
                                            Masukkan Username (Tanpa @)
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">@</span>
                                            </div>
                                            <input type="text" id="userid" name="userid" class="form-control"
                                                placeholder="-- Username --" required>
                                        </div>
                                    </div>
                                @elseif($game->slug == 'love-nikki')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">
                                            Masukkan User ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID --" required>
                                    </div>
                                    @include('pages.private.topup.button_check_id')
                                @elseif($game->slug == 'eggy-party')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">
                                            Masukkan User ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID --" required>
                                    </div>
                                @elseif($game->slug == 'stumble-guys')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">
                                            Masukkan User ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID --" required>
                                    </div>
                                @elseif($game->slug == 'tower-of-fantasy')
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">
                                            Masukkan User ID
                                            <span>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image"
                                                    onclick="howto('{{ $game->slug }}')">
                                                    (?)
                                                </a>
                                            </span>
                                        </div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- User ID --" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label mt-3">Pilih Server</div>
                                        <select id="serverid" name="serverid" class="form-select" required>
                                            <optgroup label="Asia Pasific">
                                                <option value="11001">Asia Pasific-Eden</option>
                                                <option value="11002">Asia Pasific-Fate</option>
                                                <option value="11003">Asia Pasific-Nova</option>
                                                <option value="11004">Asia Pasific-Ruby</option>
                                                <option value="11005">Asia Pasific-Babel</option>
                                                <option value="11006">Asia Pasific-Gomap</option>
                                                <option value="11007">Asia Pasific-Pluto</option>
                                                <option value="11008">Asia Pasific-Sushi</option>
                                                <option value="11009">Asia Pasific-Venus</option>
                                                <option value="11010">Asia Pasific-Galaxy</option>
                                                <option value="11011">Asia Pasific-Memory</option>
                                                <option value="11012">Asia Pasific-Oxygen</option>
                                                <option value="11013">Asia Pasific-Sakura</option>
                                                <option value="11014">Asia Pasific-Seeker</option>
                                                <option value="11015">Asia Pasific-Shinya</option>
                                                <option value="11016">Asia Pasific-Stella</option>
                                                <option value="11017">Asia Pasific-Uranus</option>
                                                <option value="11018">Asia Pasific-Utopia</option>
                                                <option value="11019">Asia Pasific-Jupiter</option>
                                                <option value="11020">Asia Pasific-Sweetie</option>
                                                <option value="11021">Asia Pasific-Atlantis</option>
                                                <option value="11022">Asia Pasific-Daybreak</option>
                                                <option value="11023">Asia Pasific-Takoyaki</option>
                                                <option value="11024">Asia Pasific-Adventure</option>
                                                <option value="11025">Asia Pasific-Yggdrasil</option>
                                                <option value="11026">Asia Pasific-Cocoaiteruyo</option>
                                                <option value="11027">Asia Pasific-Food fighter</option>
                                                <option value="11028">Asia Pasific-Mars</option>
                                                <option value="11029">Asia Pasific-Vega</option>
                                                <option value="11030">Asia Pasific-Neptune</option>
                                                <option value="11031">Asia Pasific-Tenpura</option>
                                                <option value="11032">Asia Pasific-Moon</option>
                                                <option value="11033">Asia Pasific-Mihashira</option>
                                                <option value="11034">Asia Pasific-Cocokonderu</option>
                                            </optgroup>
                                            <optgroup label="Europe">
                                                <option value="13001">Europe-Aimanium</option>
                                                <option value="13002">Europe-Alintheus</option>
                                                <option value="13003">Europe-Andoes</option>
                                                <option value="13004">Europe-Anomora</option>
                                                <option value="13005">Europe-Astora</option>
                                                <option value="13006">Europe-Valstamm</option>
                                                <option value="13007">Europe-Blumous</option>
                                                <option value="13008">Europe-Celestialrise</option>
                                                <option value="13009">Europe-Cosmos</option>
                                                <option value="13010">Europe-Dyrnwyn</option>
                                                <option value="13011">Europe-Elypium</option>
                                                <option value="13012">Europe-Excalibur</option>
                                                <option value="13013">Europe-Espoir IV</option>
                                                <option value="13014">Europe-Estrela</option>
                                                <option value="13015">Europe-Ether</option>
                                                <option value="13016">Europe-Ex Nihilor</option>
                                                <option value="13017">Europe-Futuria</option>
                                                <option value="13018">Europe-Hephaestus</option>
                                                <option value="13019">Europe-Midgard</option>
                                                <option value="13020">Europe-Iter</option>
                                                <option value="13021">Europe-Kuura</option>
                                                <option value="13022">Europe-Lycoris</option>
                                                <option value="13023">Europe-Lyramiel</option>
                                                <option value="13024">Europe-Magenta</option>
                                                <option value="13025">Europe-Magia Przygoda Aida</option>
                                                <option value="13026">Europe-Olivine</option>
                                                <option value="13027">Europe-Omnium Prime</option>
                                                <option value="13028">Europe-Turmus</option>
                                                <option value="13029">Europe-Transport Hub</option>
                                                <option value="13030">Europe-The Lumina</option>
                                                <option value="13031">Europe-Seaforth Dock</option>
                                                <option value="13032">Europe-Silvercoast Lab</option>
                                                <option value="13033">Europe-Karst Cave</option>
                                            </optgroup>
                                            <optgroup label="North America">
                                                <option value="12001">North America-The Glades</option>
                                                <option value="12002">North America-Nightfall</option>
                                                <option value="12003">North America-Frontier</option>
                                                <option value="12004">North America-Libera</option>
                                                <option value="12005">North America-Solaris</option>
                                                <option value="12006">North America-Freedom-Oasis</option>
                                                <option value="12007">North America-The worlds between</option>
                                                <option value="12008">North America-Radiant</option>
                                                <option value="12009">North America-Tempest</option>
                                                <option value="12010">North America-New Era</option>
                                                <option value="12011">North America-Observer</option>
                                                <option value="12012">North America-Lunalite</option>
                                                <option value="12013">North America-Starlight</option>
                                                <option value="12014">North America-Myriad</option>
                                                <option value="12015">North America-Lighthouse</option>
                                                <option value="12016">North America-Oumuamua</option>
                                                <option value="12017">North America-Eternium Phantasy</option>
                                                <option value="12018">North America-Sol-III</option>
                                                <option value="12019">North America-Silver Bridge</option>
                                                <option value="12020">North America-Azure Plane</option>
                                                <option value="12021">North America-Nirvana</option>
                                                <option value="12022">North America-Ozera</option>
                                                <option value="12023">North America-Polar</option>
                                                <option value="12024">North America-Oasis</option>
                                            </optgroup>
                                            <optgroup label="South America">
                                                <option value="15001">South America-Orion</option>
                                                <option value="15002">South America-Luna Azul</option>
                                                <option value="15003">South America-Tiamat</option>
                                                <option value="15004">South America-Hope</option>
                                                <option value="15005">South America-Tanzanite</option>
                                                <option value="15006">South America-Calodesma Seven</option>
                                                <option value="15007">South America-Antlia</option>
                                                <option value="15008">South America-Pegasus</option>
                                                <option value="15009">South America-Phoenix</option>
                                                <option value="15010">South America-Centaurus</option>
                                                <option value="15011">South America-Cepheu</option>
                                                <option value="15012">South America-Columba</option>
                                                <option value="15013">South America-Corvus</option>
                                                <option value="15014">South America-Cygnus</option>
                                                <option value="15015">South America-Grus</option>
                                                <option value="15016">South America-Hydra</option>
                                                <option value="15017">South America-Lyra</option>
                                                <option value="15018">South America-Ophiuchus</option>
                                                <option value="15019">South America-Pyxis</option>
                                            <optgroup label="Southeast Asia">
                                                <option value="16001">Southeast Asia-Phantasia</option>
                                                <option value="16002">Southeast Asia-Mechafield</option>
                                                <option value="16003">Southeast Asia-Ethereal Dream</option>
                                                <option value="16004">Southeast Asia-Odyssey</option>
                                                <option value="16005">Southeast Asia-Aestral-Noa</option>
                                                <option value="16006">Southeast Asia-Osillron</option>
                                                <option value="16007">Southeast Asia-Chandra</option>
                                                <option value="16008">Southeast Asia-Saeri</option>
                                                <option value="16009">Southeast Asia-Aeria</option>
                                                <option value="16010">Southeast Asia-Scarlet</option>
                                                <option value="16011">Southeast Asia-Gumi Gumi</option>
                                                <option value="16012">Southeast Asia-Fantasia</option>
                                                <option value="16013">Southeast Asia-Oryza</option>
                                                <option value="16014">Southeast Asia-Stardust</option>
                                                <option value="16015">Southeast Asia-Arcania</option>
                                                <option value="16016">Southeast Asia-Animus</option>
                                                <option value="16017">Southeast Asia-Mistilteinn</option>
                                                <option value="16018">Southeast Asia-Valhalla</option>
                                                <option value="16019">Southeast Asia-Illyrians</option>
                                                <option value="16020">Southeast Asia-Florione</option>
                                                <option value="16021">Southeast Asia-Oneiros</option>
                                                <option value="16022">Southeast Asia-Famtosyana</option>
                                                <option value="16023">Southeast Asia-Edenia</option>
                                                <option value="16024">Southeast Asia-Tore de Utopia</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                @elseif($game->slug == 'telkomsel')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">Masukkan Nomor Telepon</div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- Nomor Telepon --" required>
                                    </div>
                                @elseif($game->slug == 'indosat')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">Masukkan Nomor Telepon</div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- Nomor Telepon --" required>
                                    </div>
                                @elseif($game->slug == 'axis')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">Masukkan Nomor Telepon</div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- Nomor Telepon --" required>
                                    </div>
                                @elseif($game->slug == 'smartfren')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">Masukkan Nomor Telepon</div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- Nomor Telepon --" required>
                                    </div>
                                @elseif($game->slug == 'xl')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">Masukkan Nomor Telepon</div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- Nomor Telepon --" required>
                                    </div>
                                @elseif($game->slug == 'tri')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">Masukkan Nomor Telepon</div>
                                        <input type="text" id="userid" name="userid" class="form-control"
                                            placeholder="-- Nomor Telepon --" required>
                                    </div>
                                @elseif($game->slug == 'razer-gold')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">Masukkan Nomor Telepon</div>
                                        <input type="number" id="userid" name="userid" class="form-control"
                                            placeholder="-- Telepon --" required>
                                    </div>
                                @elseif($game->slug == 'garena-shell')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">Masukkan Nomor Telepon</div>
                                        <input type="number" id="userid" name="userid" class="form-control"
                                            placeholder="-- Telepon --" required>
                                    </div>
                                @elseif($game->slug == 'unipin')
                                    <div class="col-md-12">
                                        <div class="form-label mt-3">Masukkan Nomor Telepon</div>
                                        <input type="number" id="userid" name="userid" class="form-control"
                                            placeholder="-- Telepon --" required>
                                    </div>
                                @else
                                @endif


                                <div id="username_alert" class="alert alert-dismissible fade show" role="alert"
                                    style="display:none;">
                                    <div class="d-flex">
                                        <div id="username_result"></div>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                        data-bs-target="#modal-customer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M9 6l11 0" />
                                            <path d="M9 12l11 0" />
                                            <path d="M9 18l11 0" />
                                            <path d="M5 6l0 .01" />
                                            <path d="M5 12l0 .01" />
                                            <path d="M5 18l0 .01" />
                                        </svg>
                                        Daftar Customer
                                    </button>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <input type="checkbox" id="customer_checkbox">
                                    <label for="customer">Simpan Data Customer</label>
                                    <div id="customer_field" style="display: none;">
                                        <input type="text" id="customer" name="customer" class="form-control mt-3"
                                            placeholder="-- Nama Customer --">
                                        <span><small>Data customer akan tersimpan saat pembelian di lakukan. Jika data
                                                customer kamu belum muncul, harap refresh halaman ini.</small></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    @if (isset(auth()->user()->google_id) && auth()->user()->password_changed == 0)
                                        <div class="form-label mt-3">Masukkan Password Akun Realm Kamu </div>
                                        <p>
                                            <small>(Khusus untuk pengguna Google) Password kamu adalah Kode Reseller kamu.
                                                Jika kamu
                                                ingin merubah Password ini silahkan menuju ke halaman
                                                Profile.
                                            </small>
                                        </p>
                                        <p>
                                            <small>
                                                Jika kamu belum merubah password kamu, maka password di bawah ini sudah
                                                otomatis terisi dan bisa langsung melakukan Top Up
                                            </small>
                                        </p>
                                        <input type="password" id="password" name="password" class="form-control"
                                            placeholder="-- Password Kamu --" value="{{ auth()->user()->kode_reseller }}"
                                            disabled>
                                    @else
                                        <div class="form-label mt-3">Masukkan Password Akun Realm Kamu</div>
                                        <input type="password" id="password" name="password" class="form-control"
                                            placeholder="-- Password Kamu --" required>
                                    @endif

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

    <div class="modal modal-blur fade" id="modal-customer" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body py-4">
                    <h3> Daftar Customer - {{ $game->nama }}</h3>
                    <div class="table-responsive">
                        <table class="table table-nowrap table-hover">
                            <thead>
                                <th>Nama</th>
                                <th class="w-1"></th>
                            </thead>
                            @foreach ($customers as $customer)
                                <tbody>
                                    <td>{{ $customer->name }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-success"
                                            onclick="fill({{ $customer->id }})">
                                            Pilih
                                        </button>
                                    </td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-image" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body py-4">
                    <div id="howto"></div>
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
        window.Echo.channel('my-channel{{ auth()->id() }}')
            .listen('TopUpEvent', (event) => {
                $('#success').hide();
                $('#btn-text').show();
                $('#loading').hide();
                $('#btn-beli').attr('disabled', false);
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

        window.Echo.channel('top-up-fail{{ auth()->id() }}')
            .listen('TopUpFailEvent', (event) => {
                $('#success').hide();
                $('#btn-text').show();
                $('#loading').hide();
                $('#btn-beli').attr('disabled', false);
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

            $('#customer_checkbox').change(function() {
                if ($(this).is(':checked')) {
                    $('#customer_field').show();
                } else {
                    $('#customer_field').hide();
                }
            });
        });

        function fill(id) {
            $.ajax({
                url: '/realm/topup/fill/' + id,
                method: 'GET',
                success: function(response) {
                    $('#modal-customer').modal('hide');
                    $('#userid').val(response.user);
                    if (response.server) {
                        $('#serverid').val(response.server);
                    }
                    if (response.nickname) {
                        $('#usernickname').val(response.nickname);
                    }
                },
                error: function(xhr, error) {

                }
            });
        }

        function process() {
            $('#btn-text').hide();
            $('#loading').show();
            $('#btn-beli').attr('disabled', true);
            var serveridVal = $('#serverid').val() || '';
            var usernickname = $('#usernickname').val() || '';
            var customer = $('#customer').val() || '';
            $.ajax({
                url: "/realm/topup/process",
                method: "POST",
                data: {
                    product: $('#product').val(),
                    userId: $('#userid').val(),
                    serverId: serveridVal,
                    userNickname: usernickname,
                    customer: customer,
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

                }
            });
        }

        function successAlert(message) {
            var successAlert = '<div class="alert alert-success" role="alert">' +
                '<div class="d-flex justify-content-between">' +
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

        function howto(slug) {
            if (slug == 'call-of-duty-mobile') {
                var image = '<img src="{{ asset(Storage::url('howto/call-of-duty-mobile.webp')) }}">';
            } else if (slug == 'mobile-legend') {
                var image = '<img src="{{ asset(Storage::url('howto/mobile-legend.webp')) }}">';
            } else if (slug == 'free-fire') {
                var image = '<img src="{{ asset(Storage::url('howto/free-fire.webp')) }}">';
            } else if (slug == 'clash-of-clans') {
                var image = '<img src="{{ asset(Storage::url('howto/clash-of-clans.gif')) }}">';
            } else if (slug == 'dragon-raja-sea') {
                var image = '<img src="{{ asset(Storage::url('howto/dragon-raja-sea.webp')) }}">';
            } else if (slug == 'eggy-party') {
                var image = '<img src="{{ asset(Storage::url('howto/eggy-party.webp')) }}">';
            } else if (slug == 'genshin-impact') {
                var image = '<img src="{{ asset(Storage::url('howto/genshin-impact.webp')) }}">';
            } else if (slug == 'hago') {
                var image = '<img src="{{ asset(Storage::url('howto/hago.webp')) }}">';
            } else if (slug == 'hay-day') {
                var image = '<img src="{{ asset(Storage::url('howto/hay-day.webp')) }}">';
            } else if (slug == 'honkai-star-rail') {
                var image = '<img src="{{ asset(Storage::url('howto/honkai-star-rail.webp')) }}">';
            } else if (slug == 'league-of-legends-wild-rift') {
                var image = '<img src="{{ asset(Storage::url('howto/league-of-legends-wild-rift.webp')) }}">';
            } else if (slug == 'lifeafter') {
                var image = '<img src="{{ asset(Storage::url('howto/lifeafter.webp')) }}">';
            } else if (slug == 'lita') {
                var image = '<img src="{{ asset(Storage::url('howto/lita.webp')) }}">';
            } else if (slug == 'love-nikki') {
                var image = '<img src="{{ asset(Storage::url('howto/love-nikki.webp')) }}">';
            } else if (slug == 'ludo-club') {
                var image = '<img src="{{ asset(Storage::url('howto/ludo-club.webp')) }}">';
            } else if (slug == 'metal-slug-awakening') {
                var image = '<img src="{{ asset(Storage::url('howto/metal-slug-awakening.webp')) }}">';
            } else if (slug == 'pubg') {
                var image = '<img src="{{ asset(Storage::url('howto/pubg.webp')) }}">';
            } else if (slug == 'ragnarok-origin') {
                var image = '<img src="{{ asset(Storage::url('howto/ragnarok-origin.webp')) }}">';
            } else if (slug == 'sausage-man') {
                var image = '<img src="{{ asset(Storage::url('howto/sausage-man.webp')) }}">';
            } else if (slug == 'stumble-guys') {
                var image = '<img src="{{ asset(Storage::url('howto/stumble-guys.gif')) }}">';
            } else if (slug == 'tower-of-fantasy') {
                var image = '<img src="{{ asset(Storage::url('howto/tower-of-fantasy.webp')) }}">';
            } else if (slug == 'undawn' || slug == 'undawn-all-bind') {
                var image = '<img src="{{ asset(Storage::url('howto/undawn.webp')) }}">';
            } else if (slug == 'valorant') {
                var image = '<img src="{{ asset(Storage::url('howto/valorant.webp')) }}">';
            } else if (slug == 'zepeto') {
                var image = '<img src="{{ asset(Storage::url('howto/zepeto.webp')) }}">';
            }
            $('#howto').html(image);
        }

        function checkId(slug) {
            $('#username_check_button').attr('disabled', true);
            $('#nickname_text').hide();
            $('#username_loading').show();
            $('#username_alert').hide();
            resetClass();
            var serveridVal = $('#serverid').val() || '';
            var usernickname = $('#usernickname').val() || '';
            $.ajax({
                url: "/global/check-id/" + slug,
                method: "GET",
                dataType: 'json',
                data: {
                    userId: $('#userid').val(),
                    serverId: serveridVal,
                    userNickname: usernickname,
                },
                success: function(response) {
                    if (response.status != '400') {
                        $('#username_alert').addClass('alert-success');
                        $('#username_result').text('Nickname : ' + response.nickname)
                    } else {
                        $('#username_alert').addClass('alert-danger');
                        $('#username_result').text('Player Not Found!');
                    }
                },
                error: function(xhr, status, error) {

                },
                complete: function() {
                    $('#username_loading').hide();
                    $('#nickname_text').show();
                    $('#username_alert').show();
                    $('#username_check_button').attr('disabled', false);
                }
            });
        }

        function resetClass() {
            $('#username_alert').attr('class', 'alert');
        }
    </script>
@endsection

@section('css')
@endsection
