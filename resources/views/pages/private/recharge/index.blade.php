@extends('master.private.index')

@section('title')
    <title>Fumola Realm - Recharge</title>
@endsection

@section('header')
    <h2 class="page-title">
        Recharge
    </h2>
@endsection

@section('button')
@endsection

@section('message')
    @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
@endsection

@section('content')
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <span>Ini adalah menu yang digunakan untuk mengisi ulang saldo Digiflazz tanpa harus login ke akun
                        Digiflazz kamu. <code>Minimal Rp. 200.000</code></span>
                    <form action="{{ route('recharge.proses') }}" method="post">
                        @csrf
                        <div class="row mb-3 align-items-end mt-4">
                            <div class="col-md-6">
                                <label class="form-label">Nominal</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="nominal">Rp.</span>
                                    </div>
                                    <input type="text" name="nominal" class="form-control" placeholder="Misal '200000'"
                                        aria-label="Username" aria-describedby="nominal" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Metode Pembayaran</label>
                                <div class="input-group">
                                    <select class="form-control" name="bank">
                                        <option value="BCA">BCA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label class="form-label">Nama Pemilik Rekening</label>
                                <div class="input-group">
                                    <input type="text" name="nama" class="form-control"
                                        placeholder="Misal 'Muhamad Helmi" required />
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    Proses
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
@endsection

@section('js')
@endsection
