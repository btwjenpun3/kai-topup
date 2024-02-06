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
                                <th>Kode Reseller</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Saldo</th>
                                <th>Role</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->kode_reseller }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td class="text-info">Rp. {{ number_format($user->saldo, 0, ',', '.') }}</td>
                                    <td>{{ $user->role->description }}</td>
                                    @if ($user->role->name == 'reseller')
                                        <td><button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                data-bs-target="#modal-tambah-saldo"
                                                onclick="tambah({{ $user->id }})">Tambah Saldo</button></td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if (count($users) > 10)
                    <div class="pagination justify-content-end">
                        <ul class="pagination m-3">
                            <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $users->previousPageUrl() }}" tabindex="-1"
                                    aria-disabled="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M15 6l-6 6l6 6" />
                                    </svg>
                                    prev
                                </a>
                            </li>
                            @for ($i = 1; $i <= $users->lastPage(); $i++)
                                <li class="page-item {{ $users->currentPage() === $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $users->nextPageUrl() }}">
                                    next
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M9 6l6 6l-6 6" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif
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
                                <input type="number" name="phone" class="form-control"
                                    placeholder="Misal '628540000000" required />
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
    <script>
        var userId;

        function tambah(id) {
            userId = id;
            $.ajax({
                url: '/realm/user/show/' + userId,
                type: 'GET',
                success: function(response) {
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
                    $("#user-table").load(location.href + " #user-table");
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
    </script>
@endsection
