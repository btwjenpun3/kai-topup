@extends('master.private.index')

@section('title')
    <title>Kai Admin - Payment Method</title>
@endsection

@section('header')
    <h2 class="page-title">
        List Payments
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
                        <thead>
                            <tr>
                                <th class="w-7"></th>
                                <th>Nama</th>
                                <th>Tipe Pembayaran</th>
                                <th>Metode Pembayaran</th>
                                <th>Biaya Admin</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td><img src="{{ asset(Storage::url($data->image)) }}"></td>
                                    <td><b>{{ $data->name }}</b></td>
                                    <td>{{ $data->payment_type }}</td>
                                    <td>{{ $data->payment_method }}</td>
                                    <td>{{ $data->admin_fee }}%</td>
                                    @if ($data->status == 0)
                                        <td class="text-warning"><span class="badge bg-danger me-1"></span>TIDAK AKTIF</td>
                                    @elseif ($data->status == 1)
                                        <td class="text-success"><span class="badge bg-success me-1"></span>AKTIF</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
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
