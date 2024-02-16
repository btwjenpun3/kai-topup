@extends('master.private.index')

@section('title')
    <title>Fumola Realm - Log</title>
@endsection

@section('header')
    <h2 class="page-title">
        List Log
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
                    <table id="log-table" class="table table-hover table-nowrap card-table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Aksi</th>
                                <th>Log</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#log-table').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,
                bInfo: false,
                order: [
                    [0, 'desc']
                ],
                ajax: '{{ route('datatable.log') }}',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'action',
                        render: function(data, type, row) {
                            if (data == 'store') {
                                return '<div class="badge text-bg-info">' + data + '</div'
                            } else if (data == 'update') {
                                return '<div class="badge text-bg-success">' + data + '</div'
                            } else if (data == 'error') {
                                return '<div class="badge text-bg-danger">' + data + '</div'
                            }
                        }
                    },
                    {
                        data: 'content'
                    },
                    {
                        data: 'created_at',
                        render: function(data, type, row) {
                            return konversiTanggal(data)
                        }
                    }
                ],
            });
        });

        function konversiTanggal(isoString) {
            var tanggalTerformat = moment(isoString).format('DD MMMM YYYY, HH:mm:ss');
            return tanggalTerformat + ' WIB';
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
