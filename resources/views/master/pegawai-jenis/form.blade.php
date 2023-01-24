<form name="form_add" id="form_add" autocomplete="off" method="POST" action="{{$url}}">
    @csrf
    <input type="hidden" name="id_jenis_pegawai" id="id_jenis_pegawai" value="{{ isset($data['id']) ? $data['id'] : '' }}">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Nama Jenis Pegawai</label>
                <input type="text" class="form-control" name="nama_jenis_pegawai" id="nama_jenis_pegawai" value="{{ isset($data['nama']) ? $data['nama'] : '' }}" required />
            </div>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-sm btn-submit">
            Simpan
        </button>
        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal" aria-label="Close">
            Tutup
        </button>
    </div>
</form>
<script src="{{ asset('/js/pegawai-jenis-form.js?v=') . rand(1,9) }}"></script>