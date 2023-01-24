@extends('layouts.main')

@push('style-default')
<link rel="stylesheet" type="text/css" href="{{ asset('/theme/cuba/assets/css/vendors/datatables.css') }}">
@endpush

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="ml-1 mb-4">
                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-title="Tambah Data" data-post-id="" data-action-url="menu/formAdd" data-bs-target="#form-modal">
                        Tambah
                    </button>
                    <button type="button" class="btn btn-light btn-refresh">
                        Refresh
                    </button>
                </div>
                <div class="table-responsive">
                    <table id="tableMain" class="display">
                    <thead>
                        <tr>
                            <th>Nama Menu</th>
                            <th>Sub Menu</th>
                            <th>Keterangan</th>
                            <th style="width: 10px;text-align: center;">Status</th>
                            <th style="width: 100px;text-align: center;"><i class="lni lni-grid-alt"></i></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nama Menu</th>
                            <th>Sub Menu</th>
                            <th>Keterangan</th>
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
<script src="{{ asset('/js/rbac/menu.js?v=') . rand(1,9) }}"></script>
@endpush