@extends('master.private.index')

@section('title')
    <title>Kai Admin - Invoice</title>
@endsection

@section('header')
    <h2 class="page-title">
        List Invoice
    </h2>
@endsection

@section('button')
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
                        @if (isset($invoices) && count($invoices) > 0)
                            <thead>
                                <tr>
                                    <th class="w-7"></th>
                                    <th></th>
                                    <th>Produk</th>
                                    <th>User ID</th>
                                    <th>Server ID</th>
                                    <th>Nomor Invoice</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td><img src="{{ asset(Storage::url($invoice->game->url_gambar)) }}"></td>
                                        <td>{{ $invoice->game->nama }}</td>
                                        <td>{{ $invoice->harga->nama_produk }}</td>
                                        <td>{{ $invoice->user_id }}</td>
                                        <td>{{ $invoice->server_id }}</td>
                                        <td><a href="{{ route('invoice.index', ['id' => $invoice->nomor_invoice]) }}"
                                                target="_blank">{{ $invoice->nomor_invoice }}</a></td>
                                        <td>Rp. {{ number_format($invoice->harga->harga_jual, 0, ',', '.') }}</td>
                                        @if ($invoice->status == 'PENDING')
                                            <td class="text-warning"><span
                                                    class="badge bg-warning me-1"></span>{{ $invoice->status }}</td>
                                        @elseif ($invoice->status == 'PAID')
                                            <td class="text-success"><span
                                                    class="badge bg-success me-1"></span>{{ $invoice->status }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <tbody>
                                <tr>
                                    <td>Belum ada transaksi.
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
@endsection

@section('js')
@endsection
