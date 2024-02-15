@extends('master.public.index')

@section('title')
    <title>Fumola Store - Beranda</title>
@endsection

@section('css')
    <link rel="stylesheet" href="/assets/css/games.css">
@endsection

@section('content')
    <div class="games">
        <div class="heading-section text-center">
            <h2>Hasil Pencarian "{{ $keyword }}"</h2>
        </div>
        @if (count($games) > 0)
            <div class="flex-row mt-4">
                @foreach ($games as $game)
                    <div class="flex-column item text-center">
                        <a href="{{ route('topup.index', ['slug' => $game->slug]) }}">
                            <img src="{{ asset(Storage::url($game->url_gambar)) }}"
                                alt="Top Up {{ $game->nama }} Termurah, Ternyaman, Tercepat dan Termudah">
                            <h3 class="text-sm">{{ $game->nama }}</h3>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center mt-4">
                <h3 style="font-size:12px;">Game tidak ditemukan</h3>
            </div>
        @endif
    </div>
@endsection

@section('js')
@endsection
