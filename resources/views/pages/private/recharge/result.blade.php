@extends('master.private.index')

@section('title')
    <title>Fumola Realm - Result</title>
@endsection

@section('header')
    <h2 class="page-title">
        Recharge Result
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
                            <h1>Rp. {{ number_format($data->nominal, 0, ',', '.') }}</h1>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mt-4">
                                <h3>Nama Tujuan </h3>
                                <h4>Digiflazz Interkoneksi Indonesia</h4>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <h3>Tujuan Transfer </h3>
                                <h4>6042888890</h4>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <h3>Nominal Transfer </h3>
                                <h4>Rp. {{ number_format($data->nominal, 0, ',', '.') }}</h4>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <h3>Berita </h3>
                                <h4>{{ $data->note }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-center mt-4">
                        <h4>Note</h4>
                        <p>Setelah melakukan Transfer harap kembali ke menu Home untuk mengecek saldo kamu. </p>
                        <p>Jika saldo belum bertambah harap Refresh halaman Home atau menunggu beberapa menit.</p>
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
