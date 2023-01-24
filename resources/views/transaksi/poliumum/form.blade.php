@extends('layouts.main')

@push('style-default')
<link rel="stylesheet" type="text/css" href="{{ asset('/theme/cuba/assets/css/vendors/datatables.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-9">

        <form name="form_assesment" id="form_assesment" autocomplete="off" method="POST" action="{{$url}}">
            @csrf
            <div class="card">
                <div class="job-search">
                    <input type="hidden" name="id" id="id" value="{{ isset($data['id']) ? $data['id'] : '' }}">
                    <input type="hidden" name="registrasi_id" id="registrasi_id" value="{{ isset($register->id) ? $register->id : '' }}">
                    <div class="card-body pb-0">
                        <div class="media">
                            <div class="media-body">
                                <h6 class="f-w-600">
                                    <a href="#">{{$register->pasien->nama_pasien}}</a>
                                </h6>
                                <p>
                                    No. RM : {{$register->pasien->no_rm}}
                                    / Gol Darah : {{($register->pasien->gol_darah)}}
                                    / {{($register->pasien->jenis_kelamin)}}
                                    / Usia : {{hitung_umur($register->pasien->tgl_lahir, $register->tgl_kunjungan)}}
                                </p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            @if($register->pasien->alergi)
                            <div class="col-6">
                                <div class="alert alert-info">
                                    Riwayat Alergi :<br>
                                    {{$register->pasien->alergi}}
                                </div>
                            </div>
                            @endif
                            @if($register->pasien->penyakit)
                            <div class="col-6">
                                <div class="alert alert-info">
                                    Riwayat Penyakit :<br>
                                    {{$register->pasien->penyakit}}
                                </div>
                            </div>
                            @endif

                            @if($register->keluhan)
                            <div class="col-12 mt-3">
                                <div class="alert alert-primary">
                                    Keluhan / Keperluan :<br>
                                    <strong>{{$register->keluhan}}</strong>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="job-description">
                            <h6 class="mb-1">Pemeriksaan Fisik</h6>
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-4">
                                        <label class="form-label" for="fisik_td_mm">Tekanan Darah :</label>
                                        <div class="input-group mb-3">
                                            @php
                                                if(isset($poli->fisik_td)){
                                                    $td = explode("/", $poli->fisik_td);
                                                }
                                            @endphp
                                            <input class="form-control" type="text" name="fisik_td_mm" id="fisik_td_mm" value="{{ isset($td[0]) ? $td[0] : '' }}">
                                            <span class="input-group-text">/</span>
                                            <input class="form-control" type="text" name="fisik_td_hg" id="fisik_td_hg" value="{{ isset($td[1]) ? $td[1] : '' }}">
                                            <span class="input-group-text">mmHg</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-4">
                                        <label class="form-label" for="fisik_nadi">Denyut Nadi :</label>
                                        <div class="input-group mb-3">
                                            <input class="form-control" type="text" name="fisik_nadi" id="fisik_nadi" value="{{ isset($poli->fisik_nadi) ? $poli->fisik_nadi : '' }}">
                                            <span class="input-group-text">x/menit</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-4">
                                        <label class="form-label" for="fisik_nafas">Pernafasan :</label>
                                        <div class="input-group mb-3">
                                            <input class="form-control" type="text" name="fisik_nafas" id="fisik_nafas" value="{{ isset($poli->fisik_nafas) ? $poli->fisik_nafas : '' }}">
                                            <span class="input-group-text">x/menit</span>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-4">
                                    <div class="mb-4">
                                        <label class="form-label" for="fisik_suhu">Suhu Tubuh :</label>
                                        <div class="input-group mb-3">
                                            <input class="form-control" type="text" name="fisik_suhu" id="fisik_suhu" value="{{ isset($poli->fisik_suhu) ? $poli->fisik_suhu : '' }}">
                                            <span class="input-group-text">°C</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-4">
                                        <label class="form-label" for="fisik_tb">Tinggi Badan :</label>
                                        <div class="input-group mb-3">
                                            <input class="form-control" type="text" name="fisik_tb" id="fisik_tb" value="{{ isset($poli->fisik_tb) ? $poli->fisik_tb : '' }}">
                                            <span class="input-group-text">cm</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-4">
                                        <label class="form-label" for="fisik_bb">Berat Badan :</label>
                                        <div class="input-group mb-3">
                                            <input class="form-control" type="text" name="fisik_bb" id="fisik_bb" value="{{ isset($poli->fisik_bb) ? $poli->fisik_bb : '' }}">
                                            <span class="input-group-text">Kg</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-4">
                                        <label class="form-label" for="diagnosa_utama">Diagnosa Primer :</label>
                                        <select name="diagnosa_utama" id="diagnosa_utama" class="form-select ">
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-4">
                                                <label class="form-label" for="diagnosa_sekunder_1">Diagnosa Sekunder 1 :</label>
                                                <select name="diagnosa_sekunder_1" id="diagnosa_sekunder_1" class="form-select ">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-4">
                                                <label class="form-label" for="diagnosa_sekunder_2">Diagnosa Sekunder 2 :</label>
                                                <select name="diagnosa_sekunder_2" id="diagnosa_sekunder_2" class="form-select ">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-6">
                                    <div class="mb-4">
                                        <label class="form-label" for="ringkasan">Ringkasan riwayat penyakit dan pemeriksaan fisik :</label>
                                        <textarea rows="3" name="ringkasan" id="ringkasan" class="form-control " required>{{ isset($poli->ringkasan) ? $poli->ringkasan : '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-4">
                                        <label class="form-label" for="ket_diagnosa_sekunder">Keterangan Diagnosa Sekunder :</label>
                                        <textarea rows="3" name="ket_diagnosa_sekunder" id="ket_diagnosa_sekunder" class="form-control ">{{ isset($poli->ket_diagnosa_sekunder) ? $poli->ket_diagnosa_sekunder : '' }}</textarea>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <hr>
                                    <div class="mb-4">
                                        <label class="form-label" for="tindakan_id">Tindakan/Prosedur :</label>
                                        <div class="row">
                                            <div class="col-9">
                                                <input type="hidden" name="poli_tindakan_id" id="poli_tindakan_id" value="">
                                                <select name="tindakan_id" id="tindakan_id" class="form-select ">
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <div class="d-grid gap-2">
                                                    <button type="button" class="btn btn-info btn-block btn-tambah-tindakan">Tambah</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="table-responsive mb-4">
                                        <table id="tableTindakan" class="display table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Tindakan</th>
                                                    <th style="width: 90px;">Tarif</th>
                                                    <th style="width: 120px;text-align: center;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr>
                                    <div class="mb-4">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-label" for="barang_id">Terapi Obat :</label>
                                                <input type="hidden" name="poli_resep_id" id="poli_resep_id" value="">
                                                <select name="barang_id" id="barang_id" class="form-select ">
                                                </select>
                                            </div>
                                            <div class="col-3">
                                            <label class="form-label" for="barang_id">Jumlah :</label>
                                                <div class="input-group mb-3">
                                                    <input class="form-control" type="text" name="qty" id="qty">
                                                    <span class="input-group-text satuan-barang">-</span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="d-grid gap-2 mt-4 pt-2">
                                                    <button type="button" class="btn btn-secondary btn-block btn-tambah-barang">Tambah</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="table-responsive mb-4">
                                        <table id="tableBarang" class="display table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama Obat</th>
                                                    <th style="width: 90px;">Jumlah</th>
                                                    <th style="width: 120px;text-align: center;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>



                                <div class="col-12">
                                    <hr>
                                    <div class="mb-4">
                                        <label class="form-label" for="nama_file">Data Pendukung :</label>
                                        <div class="row">
                                            <div class="col-9">
                                                <input type="hidden" name="poli_penunjang_id" id="poli_penunjang_id" value="">
                                                <input type="file" name="nama_file" id="nama_file" />
                                            </div>
                                            <div class="col-3">
                                                <div class="d-grid gap-2">
                                                    <button type="submit" class="btn btn-dark btn-block btn-tambah-penunjang">Upload File</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="table-responsive mb-4">
                                        <table id="tablePenunjang" class="display table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>File Pendukung</th>
                                                    <th style="width: 120px;text-align: center;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary btn-submit-dokumen" type="submit">Simpan Dokumen</button>
                        <a class="btn btn-light" href="{{url('/poli-umu/')}}">Tutup</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2 mb-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-title="Profil - {{$register->pasien->nama_pasien}}" data-post-id="{{$register->pasien_id}}" data-action-url="assesment/pasien" data-bs-target="#form-modal">
                        Profil Pasien
                    </button>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-dark" data-bs-toggle="modal" data-title="Riwayat Medis - {{$register->pasien->nama_pasien}}" data-post-id="{{$register->pasien_id . '-' . $register->id}}" data-action-url="assesment/riwayat" data-bs-target="#form-modal">
                        Riwayat Medis
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-default')
<script>
    var diagnosa_utama = "{{ isset($poli->diagnosa_utama) ? $poli->diagnosa_utama : '' }}";
    var diagnosa_sekunder_1 = "{{ isset($poli->diagnosa_sekunder_1) ? $poli->diagnosa_sekunder_1 : '' }}";
    var diagnosa_sekunder_2 = "{{ isset($poli->diagnosa_sekunder_2) ? $poli->diagnosa_sekunder_2 : '' }}";
</script>
<script src="{{ asset('/theme/cuba/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/poli-umum-form.js?v='.rand(1,999)) }}"></script>
@endpush