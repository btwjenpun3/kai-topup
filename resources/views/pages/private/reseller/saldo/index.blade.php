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
                    <div class="row align-items-end">
                        <div class="col-md-12 text-center p-3 mb-4" style="border: solid black 1px;border-radius:23px;">
                            <h4>Kode Reseller</h4>
                            <h1>{{ $user->kode_reseller }}</h1>
                        </div>
                        <div class="col-md-12">
                            <h4>Bagaimana cara mengisi saldo ?</h4>
                            <ul>
                                <li>Silahkan Transfer ke BCA : <b> 013 2020 220 (Muhamad Helmi)</b> dengan nominal
                                    minimal Rp. 50.000</li>
                                <li>Kontak kami melalui WhatsApp melalui link ini <a
                                        href="https://wa.me/6285740196222/?text=Halo, saya {{ $user->name }} ingin melakukan Deposit dengan kode Reseller {{ $user->kode_reseller }}"
                                        target="_blank">Klik Disini</a></li>
                                <li>Silahkan kirim bukti transfer kamu beserta Kode Reseller kamu</li>
                                <li>Harap tunggu beberapa saat hingga CS kami melakukan pengecekan</li>
                                <li>Apabila pengecekan sudah dilakukan maka saldo kamu akan kami tambah </li>
                            </ul>
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
