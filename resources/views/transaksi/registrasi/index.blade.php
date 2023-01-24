@extends('layouts.main')

@push('style-default')
<link rel="stylesheet" type="text/css" href="{{ asset('/theme/cuba/assets/css/vendors/datatables.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-info">
                    <strong>Informasi</strong>
                    Jika ada pasien baru, klik pada tombol Pasien baru untuk menambah data pasien.
                </div>
                <form name="form_registrasi" id="form_registrasi" autocomplete="off" method="POST" action="{{$url}}">
                    @csrf
                    <input type="hidden" name="id" id="id" value="{{ isset($data['id']) ? $data['id'] : '' }}">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label class="form-label">Cari Nomor RM/Nama Pasien <button type="button" class="btn btn-xs btn-primary" data-bs-toggle="modal" data-title="Tambah Data" data-post-id="" data-action-url="pasien/formAdd" data-bs-target="#form-modal">Pasien Baru</button></label>
                                <select name="pasien_id" id="pasien_id" class="form-select ">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label class="form-label">Poli</label>
                                <select name="poli_id" id="poli_id" class="form-select ">
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label class="form-label">Dokter</label>
                                <select name="pegawai_id" id="pegawai_id" class="form-select ">
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label class="form-label">Keluhan / Keperluan Pasien</label>
                                <textarea rows="3" name="keluhan" id="keluhan" class="form-control "></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group right">
                        <button type="submit" class="btn btn-primary btn-sm btn-submit-registrasi">
                            Simpan
                        </button>
                        <a href="{{url('registrasi')}}" class="btn btn-light btn-sm">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tableMain" class="display">
                        <thead>
                            <tr>
                                <th style="width: 90px;">Tanggal</th>
                                <th style="width: 90px;">No. Reg</th>
                                <th style="width: 90px;">No. RM</th>
                                <th>Nama Pasien</th>
                                <th>Nama Dokter</th>
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
                                <th>Nama Dokter</th>
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
<script src="{{ asset('/js/registrasi.js?v='.rand(1,999)) }}"></script>
@endpush