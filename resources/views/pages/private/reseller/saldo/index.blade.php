@extends('master.private.index')

@section('title')
    <title>Fumola Realm - Isi Saldo</title>
@endsection

@section('header')
    <h2 class="page-title">
        Isi Saldo
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
                <div class="card-body">
                    <div class="row mb-3 align-items-end mt-4">
                        <div class="col-md-12 text-center">
                            <h4>Kode Reseller</h4>
                            <h1>{{ $user->kode_reseller }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
@endsection

@section('js')
@endsection
