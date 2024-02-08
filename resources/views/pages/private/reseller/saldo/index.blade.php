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
                        <div class="col-md-6">
                            <h4>Bagaimana cara mengisi saldo ?</h4>
                            <ul>
                                <li>Silahkan Transfer ke BCA :
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-6">
                                            <b id="copy">4381443927</b> (MONICA ODILLA)
                                        </div>
                                        <span><small>Klik nomor untuk menyalin</small>
                                    </div>
                                </li>
                                <li class="text-warning">Nominal minimal Isi Saldo adalah Rp. 50.000</li>
                                <li>Kontak kami melalui WhatsApp melalui link ini <a
                                        href="https://wa.me/6281223864722/?text=Halo, saya {{ $user->name }} ingin melakukan Deposit dengan kode Reseller {{ $user->kode_reseller }}"
                                        target="_blank">KLIK DISINI</a></li>
                                <li>Silahkan kirim bukti transfer kamu</li>
                                <li>Harap tunggu beberapa saat hingga CS kami melakukan pengecekan</li>
                                <li>Apabila pengecekan sudah dilakukan maka saldo kamu akan kami tambah </li>
                            </ul>
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
    <script>
        $(document).ready(function() {
            $('#copy').click(function() {
                var textToCopy = $(this).text();
                navigator.clipboard.writeText(textToCopy).then(function() {
                    alert('Teks berhasil disalin ke clipboard: ' + textToCopy);
                }, function(err) {
                    alert('Gagal menyalin teks. Silakan coba lagi.');
                });
            });
        });
    </script>
@endsection
