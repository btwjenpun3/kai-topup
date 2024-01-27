@extends('master.private.index')

@section('title')
    <title>Kai Admin - List Games</title>
@endsection

@section('header')
    <h2 class="page-title">
        List Games
    </h2>
@endsection

@section('button')
    <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-game-buat">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 5l0 14" />
            <path d="M5 12l14 0" />
        </svg>
        Buat
    </a>
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
                    <table class="table table-vcenter card-table table-striped">
                        @if (isset($games) && count($games) > 0)
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Kode</th>
                                    <th>URL Gambar</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($games as $game)
                                    <tr>
                                        <td>{{ $game->nama }}</td>
                                        <td class="text-muted"> {{ $game->kode }} </td>
                                        <td>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modal-gambar-game"
                                                onclick="tampilkanGambar('{{ asset(Storage::url($game->url_gambar)) }}')">
                                                {{ str_replace('games/', '', $game->url_gambar) }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle align-text-top"
                                                    data-bs-toggle="dropdown">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item"
                                                        href="{{ route('harga.index', ['id' => $game->id]) }}"> Set Harga
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
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
    <div class="modal modal-blur fade" id="modal-game-buat" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Game Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('games.store') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="row mb-3 align-items-end">
                            <div class="col">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control"
                                    placeholder="Misal 'Mobile Legend'" required />
                            </div>
                        </div>
                        <div class="row mb-3 align-items-end">
                            <div class="col">
                                <label class="form-label">Kode</label>
                                <input type="text" name="kode" class="form-control" placeholder="Misal 'ml'"
                                    required />
                            </div>
                        </div>
                        <div class="row mb-3 align-items-end">
                            <div class="col">
                                <label class="form-label">Upload Gambar</label>
                                <input name="gambar" type="file" class="form-control" required />
                                <span class="text-danger small lh-base">
                                    <ul>
                                        <li>Ukuran yang disarankan 512x512 px</li>
                                        <li>Ukuran file maksimal 2048 kbps</li>
                                        <li>Format harus berupa : <i>jpeg,png,jpg,webp</i></li>
                                    </ul>
                                </span>
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

    <div class="modal modal-blur fade" id="modal-gambar-game" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="" class="img-fluid" id="gambarModal" alt="Gambar Game">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function tampilkanGambar(url) {
            var gambarModal = document.getElementById('gambarModal');
            gambarModal.src = url;
        }
    </script>
@endsection
