@extends('master.private.index')

@section('title')
    <title>Fumola Realm - User</title>
@endsection

@section('header')
    <h2 class="page-title">
        List User
    </h2>
@endsection

@section('button')
    <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
        data-bs-target="#modal-user-tambah">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 5l0 14" />
            <path d="M5 12l14 0" />
        </svg>
        Tambah
    </a>
@endsection

@section('message')
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
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
    <div id="saldo"></div>
@endsection

@section('content')
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table id="user-table" class="table table-hover table-nowrap table-vcenter card-table table-striped">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Role</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users->where('role.name', 'admin') as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->role->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mt-4">
                <div class="table-responsive">
                    <table id="reseller" class="table table-hover table-nowrap card-table table-striped">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Kode Reseller</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Saldo</th>
                                <th>Role</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal modal-blur fade" id="modal-user-tambah" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User / Reseller</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('user.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3 align-items-end">
                            <div class="col">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control" placeholder="Misal 'Kaia'"
                                    required />
                            </div>
                        </div>
                        <div class="row mb-3 align-items-end">
                            <div class="col">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    placeholder="Misal 'namakamu@gmail.com'" required />
                            </div>
                        </div>
                        <div class="row mb-3 align-items-end">
                            <div class="col">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required />
                            </div>
                        </div>
                        <div class="row mb-3 align-items-end">
                            <div class="col">
                                <label class="form-label">Telepon</label>
                                <input type="number" name="phone" class="form-control" placeholder="Misal '628540000000"
                                    required />
                            </div>
                        </div>
                        <div class="row mb-3 align-items-end">
                            <div class="col">
                                <label class="form-label">Role</label>
                                <select class="form-control" name="role_id">
                                    <option value="1">Administrator</option>
                                    <option value="2" selected>Reseller</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Buat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-tambah-saldo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Saldo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col text-center" style="">
                            <h3 id="nama_reseller"></h3>
                            <h3 id="kode_reseller"></h3>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <div class="col">
                            <label class="form-label">Saldo Awal</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="number" id="saldo_awal" class="form-control" disabled />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <div class="col">
                            <label class="form-label">Nominal</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="number" id="nominal" class="form-control" placeholder="Misal '50000'"
                                    required />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <div class="col">
                            <label class="form-label">Saldo Setelah di Tambah</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="number" id="saldo_total" class="form-control" disabled />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
                    <button id="button-tambah-saldo" class="btn btn-primary">Buat</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#reseller').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,
                bInfo: false,
                order: [
                    [6, 'asc']
                ],
                ajax: '{{ route('datatable.user.reseller') }}',
                columns: [{
                        data: 'name'
                    },
                    {
                        data: 'kode_reseller'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'saldo',
                        render: function(data, type, row) {
                            if (data) {
                                return '<div class="text-info">' + formatRupiah(data) + '</div>'
                            } else {
                                return '<div class="text-info">' + formatRupiah(0) + '</div>'
                            }
                        }
                    },
                    {
                        data: 'role.description'
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            return '<button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal-tambah-saldo" onclick = "tambah(' +
                                data + ')"> Tambah Saldo </button>'
                        }
                    }
                ],
            });
        });
    </script>
    <script>
        var userId;

        function tambah(id) {
            userId = id;
            $.ajax({
                url: '/realm/user/show/' + userId,
                type: 'GET',
                success: function(response) {
                    document.getElementById('nama_reseller').textContent = response.name;
                    document.getElementById('kode_reseller').textContent = response.kode_reseller;
                    document.getElementById('saldo_awal').value = response.saldo;
                },
            });
        };

        function hitungTotalSaldo() {
            var saldoAwal = parseFloat(document.getElementById('saldo_awal').value) || 0;
            var nominal = parseFloat(document.getElementById('nominal').value) || 0;
            var saldoTotal = saldoAwal + nominal;
            document.getElementById('saldo_total').value = saldoTotal;
        }
        document.getElementById('nominal').addEventListener('input', hitungTotalSaldo);

        $('#button-tambah-saldo').click(function() {
            $.ajax({
                url: '/realm/user/tambah/' + userId,
                type: 'POST',
                data: {
                    saldo: $('#nominal').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    var successMessage = document.createElement(
                        "div");
                    successMessage.className =
                        "alert alert-success alert-dismissable";
                    successMessage.textContent = response.success;
                    $('#modal-tambah-saldo').modal('hide');
                    $('#saldo').html(successMessage);
                    $('#reseller').DataTable().ajax.reload();
                },
                error: function(xhr, error) {
                    console.log(xhr);
                    var errorMessage = document.createElement(
                        "div");
                    errorMessage.className =
                        "alert alert-danger";
                    errorMessage.textContent = xhr.responseJSON.unaccepted;
                    $('#saldo').html(errorMessage);
                    $('#modal-tambah-saldo').modal('hide');
                }
            });
        });

        function formatRupiah(angka) {
            var number_string = angka.toString();
            var split = number_string.split(',');
            var sisa = split[0].length % 3;
            var rupiah = split[0].substr(0, sisa);
            var ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return 'Rp. ' + rupiah;
        }
    </script>
@endsection

@section('css')
    <style>
        .dataTables_wrapper .dataTables_filter {
            float: right;
            margin: 10px;
        }

        .dataTables_wrapper .dataTables_paginate {
            float: right;
            margin: 10px;
        }
    </style>
@endsection
