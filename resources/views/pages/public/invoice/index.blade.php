@extends('master.public.index')

@section('title')
    <title>Kai Top Up - Invoice</title>
@endsection

@section('content')
    <div class="featured-games">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-9">
                    <div class="heading-section">
                        <h4><em>Invoice</em> ({{ $invoice }})</h4>
                    </div>
                </div>
                @if ($status == 'PAID')
                    <div class="col-md-3 text-center">
                        <div class="heading-section  text-end">
                            <h4 class="text-success">PAID</h4>
                        </div>
                    </div>
                @else
                    <div class="col-md-3 text-center">
                        <div class="heading-section  text-end">
                            <h4 class="text-warning">PENDING</h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-12">
            <h5>Rincian Pembelian</h5>
            <hr>
            <div class="row">
                <div class="col-md-12 pt-3">
                    <img src="{{ asset(Storage::url($gambar)) }}" style="width:100px;height:100px;">
                </div>
            </div>
            <div class="row pt-5">
                <div class="col-md-4">
                    <h6>Nama Item</h6>
                </div>
                <div class="col-md-4">
                    <h6>{{ $item }}</h6>
                </div>
                <div class="col-md-4 text-end">
                    <h6>Rp. {{ number_format($total, 0, ',', '.') }}</h6>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-md-4">
                    <h6>Metode Pembayaran</h6>
                </div>
                <div class="col-md-4">
                    <h6>Virtual Account BCA</h6>
                </div>
            </div>
        </div>
    </div>
    @if ($status == 'PAID')
    @else
        <div class="game-details">
            <div class="row">
                <div class="col-lg-12">
                    <div class="content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-border-button">
                                    <a href="{{ $invoice_url }}" id="checkout">Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
