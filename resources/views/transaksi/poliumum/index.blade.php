@extends('layouts.main')

@push('style-default')
<link rel="stylesheet" type="text/css" href="{{ asset('/theme/cuba/assets/css/vendors/datatables.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label>Filter Tanggal</label>
                            <div class="input-group mb-3">
                                <input type="hidden" name="poli_id" id="poli_id" value="{{(isset($poli->id)) ? $poli->id : '' }}" />
                                <input class="form-control calendar" type="text" name="tgl_mulai" id="tgl_mulai" value="{{date('01-01-Y')}}" required>
                                <span class="input-group-text">S/D</span>
                                <input class="form-control calendar" type="text" name="tgl_selesai" id="tgl_selesai" value="{{date('d-m-Y')}}" required>
                                <button class="btn btn-light btn-refresh">Refresh</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tableMain" class="display">
                        <thead>
                            <tr>
                                <th style="width: 90px;">Tanggal</th>
                                <th style="width: 90px;">No. Reg</th>
                                <th style="width: 90px;">No. RM</th>
                                <th>Nama Pasien</th>
                                <th>Keluhan</th>
                                <th style="width: 120px;text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Tanggal</th>
                                <th>No. Reg</th>
                                <th>No. RM</th>
                                <th>Nama Pasien</th>
                                <th>Keluhan</th>
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
<script src="{{ asset('/js/poli-umum.js?v='.rand(1,999)) }}"></script>
@endpush