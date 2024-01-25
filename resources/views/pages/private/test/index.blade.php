@extends('master.private.index')

@section('title')
    <title>Kai Admin - Testing Area</title>
@endsection

@section('header')
    <h2 class="page-title">
        Developer Test
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
@endsection

@section('content')
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <a href="{{ route('testing.shopeePay') }}" class="btn btn-primary d-none d-sm-inline-block">
                    Test Shopee Pay
                </a>
            </div>
        </div>
    </div>
    <h6>Result :</h6>
    @if (isset($response))
        {{ $response }}
    @endif
@endsection

@section('js')
@endsection
