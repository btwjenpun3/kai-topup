@extends('master.private.index')

@section('title')
    <title>Fumola Realm - Product</title>
@endsection

@section('header')
    <h2 class="page-title">
        List Product
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
    {{ $product }}
@endsection

@section('modal')
@endsection

@section('js')
@endsection
