@extends('layouts.main')

@push('style-default')
<link rel="stylesheet" type="text/css" href="{{ asset('/theme/cuba/assets/css/vendors/datatables.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <form name="form_assesment" id="form_assesment" autocomplete="off" method="POST" action="{{$url}}">
            @csrf
            <div class="card">
                <div class="job-search">
                    <input type="hidden" name="registrasi_id" id="registrasi_id" value="{{ isset($register->id) ? $register->id : '' }}">
                    <input type="hidden" name="kode_booking" id="kode_booking" value="{{ isset($register->kode_booking) ? $register->kode_booking : '' }}">
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
                                    <br>
                                    Alamat : {{$register->pasien->alamat}}
                                </p>
                            </div>
                        </div>

                        <div class="job-description">
                            <div class="table-responsive mb-4">
                                <table id="tableMain" class="display table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Jenis Pelayanan</th>
                                            <th>Daftar Pelayanan</th>
                                            <th style="width: 100px;">Harga</th>
                                            <th style="width: 70px;">Qty</th>
                                            <th style="width: 100px;">Subtotal</th>
                                            <th style="width: 120px;text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-7">
                                </div>
                                <div class="col-5">
                                    <div class="row">
                                        <div class="col-4">
                                            <label class="form-label">Subtotal</label>
                                        </div>
                                        <div class="col-8 form-group mb-3">
                                            <input type="text" class="form-control right money" id="h_subtotal" name="h_subtotal" value="0" readonly>
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">Bayar</label>
                                        </div>
                                        <div class="col-8 form-group mb-3">
                                            <input type="text" class="form-control right money" id="h_bayar" name="h_bayar" value="0" required>
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">Kembali</label>
                                        </div>
                                        <div class="col-8 form-group mb-3">
                                            <input type="text" class="form-control right money" id="h_kembali" name="h_kembali" value="0" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary btn-bayar" type="button">Bayar</button>
                        <a class="btn btn-light" href="{{url('/kasir/')}}">Tutup</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script-default')
<script>

</script>
<script src="{{ asset('/theme/cuba/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/kasir-form.js?v='.rand(1,999)) }}"></script>
@endpush