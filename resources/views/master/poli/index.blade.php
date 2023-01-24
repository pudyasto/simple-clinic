@extends('layouts.main')

@push('style-default')
<link rel="stylesheet" type="text/css" href="{{ asset('/theme/cuba/assets/css/vendors/datatables.css') }}">
@endpush

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="ml-1 mb-4">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-title="Tambah Data" data-post-id="" data-action-url="poli/formAdd" data-bs-target="#form-modal">
                        Tambah
                    </button>
                    <button class="btn btn-light btn-refresh">Refresh</button>
                </div>
                <div class="table-responsive">
                    <table id="tableMain" class="display">
                        <thead>
                            <tr>
                                <th style="width: 90px;text-align: center;">Kode Poli</th>
                                <th style="text-align: center;">Nama Poli</th>
                                <th style="width: 90px;text-align: center;">Status</th>
                                <th style="width: 200px;text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Kode Poli</th>
                                <th>Nama Poli</th>
                                <th>Status</th>
                                <th>ID</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-default')
<script src="{{ asset('/theme/cuba/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/poli.js') }}"></script>
@endpush