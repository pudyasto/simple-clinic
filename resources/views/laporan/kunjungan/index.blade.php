@extends('layouts.main')

@push('style-default')
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            <form name="form_print" id="form_print" autocomplete="off" target="_blank" method="GET" action="{{url('kunjungan/printData')}}">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label>Filter Tanggal</label>
                            <div class="input-group mb-3">
                                <input class="form-control calendar" type="text" name="tgl_mulai" id="tgl_mulai" value="{{date('01-01-Y')}}" required>
                                <span class="input-group-text">S/D</span>
                                <input class="form-control calendar" type="text" name="tgl_selesai" id="tgl_selesai" value="{{date('d-m-Y')}}" required>
                                <button type="button" class="btn btn-light btn-preview">Preview</button>
                                <button type="submit" class="btn btn-danger btn-print">Cetak</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 mt-5 preview-data table-responsive">
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-default')
<script src="{{ asset('/js/rptkunjungan.js?v='.rand(1,999)) }}"></script>
@endpush