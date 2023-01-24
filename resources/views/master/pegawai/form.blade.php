<form name="form_add" id="form_add" autocomplete="off" method="POST" action="{{$url}}">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ isset($data['id']) ? $data['id'] : '' }}">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Lokasi Cabang</label>
                <select class="form-control" name="cabang_id" id="cabang_id">
                    @foreach($cabang_id as $val)
                    <option value="{{$val->id}}" {{ isset($data['cabang_id']) && $data['cabang_id']==$val->id ? 'selected' : '' }}>{{$val->nama}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-12" style="display: none;">
            <div class="form-group mb-3">
                <label class="form-label">Kode</label>
                <input type="text" class="form-control" name="kode" id="kode" value="{{ isset($data['kode']) ? $data['kode'] : '' }}" />
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Nama Pegawai</label>
                <input type="text" class="form-control" name="nama" id="nama" value="{{ isset($data['nama']) ? $data['nama'] : '' }}" required />
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">No. Telp</label>
                <input type="text" class="form-control" name="telp" id="telp" value="{{ isset($data['telp']) ? $data['telp'] : '' }}" />
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Alamat</label>
                <textarea rows="3" class="form-control" name="alamat" id="alamat">{{ isset($data['alamat']) ? $data['alamat'] : '' }}</textarea>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Jenis Pegawai</label>
                <select class="form-control" name="jenis_pegawai_id" id="jenis_pegawai_id">
                    <option value="">-- Pilih Jenis Pegawai --</option>
                    @foreach($jenis_pegawai_id as $val)
                    <option value="{{$val->id}}" {{ isset($data['jenis_pegawai_id']) && $data['jenis_pegawai_id']==$val->id ? 'selected' : '' }}>{{$val->nama}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-6 poli" style="display: none;">
            <div class="form-group mb-3">
                <label class="form-label">Poli Spesialis</label>
                <select class="form-control" name="poli_id" id="poli_id">
                </select>
            </div>
        </div>
        <div class="col-sm-6 poli" style="display: none;">
            <div class="form-group mb-3">
                <label class="form-label">Sub Spesialis</label>
                <select class="form-control" name="poli_sub_id" id="poli_sub_id">
                </select>
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
<script>
    var poli_id = "{{ isset($data['poli_id']) ? $data['poli_id'] : '' }}";
    var poli_sub_id = "{{ isset($data['poli_sub_id']) ? $data['poli_sub_id'] : '' }}";
</script>
<script src="{{ asset('/js/pegawai-form.js?v=') . rand(1,9) }}"></script>