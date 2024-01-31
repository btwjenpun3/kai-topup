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
    <div id="payment-berhasil-di-update"></div>
    <div id="payment-gagal-di-update"></div>
@endsection

@section('content')
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table id="payment-table" class="table table-vcenter card-table table-striped">
                        <thead>
                            <tr>
                                <th class="w-1"></th>
                                <th class="w-7"></th>
                                <th>Nama</th>
                                <th>Tipe Pembayaran</th>
                                <th>Metode Pembayaran</th>
                                <th>Biaya Admin (%)</th>
                                <th>Biaya Admin (Rp.)</th>
                                <th>Status</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    @if ($data->status == 0)
                                        <td class="text-warning"><span class="badge bg-danger me-1"></span></td>
                                    @elseif ($data->status == 1)
                                        <td class="text-success"><span class="badge bg-success me-1"></span></td>
                                    @endif
                                    <td><img src="{{ asset(Storage::url($data->image)) }}"></td>
                                    <td><b>{{ $data->name }}</b></td>
                                    <td>{{ $data->payment_type }}</td>
                                    <td>{{ $data->payment_method }}</td>
                                    @if (isset($data->admin_fee))
                                        <td>{{ $data->admin_fee }}%</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                    @if (isset($data->admin_fee_fixed))
                                        <td>Rp. {{ number_format($data->admin_fee_fixed, 0, ',', '.') }}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                    <td><button class="btn" data-bs-toggle="modal" data-bs-target="#modal-edit"
                                            onclick="show({{ $data->id }})">Edit</button></td>
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
    <div class="modal modal-blur fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 align-items-end">
                        <label class="form-label" for="name">Nama</label>
                        <div class="input-group mb-3">
                            <input type="text" name="name" id="name" class="form-control" disabled />
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <label class="form-label" for="admin_fee">Biaya Admin (%)</label>
                        <div class="input-group mb-3">
                            <input type="text" name="admin_fee" id="admin_fee" class="form-control" />
                            <div class="input-group-append">
                                <div class="input-group-text">%</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <label class="form-label" for="admin_fee_fixed">Biaya Admin (Rp.)</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="text" name="admin_fee_fixed" id="admin_fee_fixed" class="form-control" />
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <label class="form-label" for="status">Status</label>
                        <div class="input-group mb-3">
                            <select name="status" id="status" class="form-control">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
                    <button id="paymentEditButton" type="submit" class="btn btn-primary">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var paymentId;

        function show(id) {
            paymentId = id;
            $.ajax({
                url: '/realm/payment/show/' + id,
                type: 'GET',
                success: function(response) {
                    document.getElementById('name').value = response.name;
                    document.getElementById('admin_fee').value = response.admin_fee;
                    document.getElementById('admin_fee_fixed').value = response.admin_fee_fixed;
                    document.getElementById('status').value = response.status;
                },
                error: function(xhr, error, status) {}
            });
        };

        $('#paymentEditButton').click(function() {
            $.ajax({
                url: '/realm/payment/update/' + paymentId,
                type: 'POST',
                data: {
                    name: $('#name').val(),
                    admin_fee: $('#admin_fee').val(),
                    admin_fee_fixed: $('#admin_fee_fixed').val(),
                    status: $('#status').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    var successMessage = document.createElement(
                        "div");
                    successMessage.className =
                        "alert alert-success";
                    successMessage.textContent = response.success;
                    $('#modal-edit').modal('hide');
                    $('#payment-berhasil-di-update').html(successMessage);
                    $("#payment-table").load(location.href + " #payment-table");
                },
                error: function(xhr, error) {
                    console.log(xhr);
                    var errorMessage = document.createElement(
                        "div");
                    errorMessage.className =
                        "alert alert-danger";
                    errorMessage.textContent = xhr.responseJSON.error;
                    $('#modal-edit').modal('hide');
                    $('#payment-gagal-di-update').html(errorMessage);
                }
            });
        });
    </script>
@endsection
