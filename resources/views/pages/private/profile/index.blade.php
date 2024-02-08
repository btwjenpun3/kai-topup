@extends('master.private.index')

@section('title')
    <title>Fumola Realm - Profile</title>
@endsection

@section('header')
    <h2 class="page-title">
        Profile
    </h2>
@endsection

@section('button')
@endsection

@section('message')
@endsection

@section('content')
    <div class="row row-cards">
        @if (session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @elseif(session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-12">
                            <div class="form-label">Email</div>
                            <input class="form-control" type="text" placeholder="-- Email --" value="{{ $user->email }}"
                                disabled>
                        </div>
                        <form action="{{ route('profile.update') }}" method="post">
                            @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-label mt-4">Nama</div>
                                        <input class="form-control" type="text" name="name" placeholder="-- Nama --"
                                            value="{{ $user->name }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label mt-4">Telepon</div>
                                        <input class="form-control" type="number" name="phone"
                                            placeholder="-- Telepon --" value="{{ $user->phone }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                        <form action="{{ route('profile.update.password') }}" method="post">
                            @csrf
                            <div class="col-md-12 mt-4">
                                <div class="alert alert-info" role="alert">
                                    Apabila kamu mendaftar menggunakan akun Google, harap hubungi Admin untuk merubah
                                    Password kamu!
                                </div>
                                <div class="form-label">Password Lama</div>
                                <input class="form-control" type="password" name="old_password" placeholder="-- Password --"
                                    required>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-label mt-4">Password Baru</div>
                                        <input class="form-control" type="password" name="password"
                                            placeholder="-- Password --" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label mt-4">Verifikasi Password Baru</div>
                                        <input class="form-control" type="password" name="password_confirmation"
                                            placeholder="-- Password --" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <button type="submit" class="btn btn-warning">Ubah Password</button>
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
