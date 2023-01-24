<form name="form_add" id="form_add" autocomplete="off" method="POST" action="{{$url}}">
    @csrf
    <input type="hidden" name="id_asuransi" id="id_asuransi" value="{{ isset($data['id']) ? $data['id'] : '' }}">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Nama Asuransi</label>
                <input type="text" class="form-control" name="nama_asuransi" id="nama_asuransi" value="{{ isset($data['nama']) ? $data['nama'] : '' }}" required />
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Status Aktif</label>
                <select name="stat_asuransi" id="stat_asuransi" class="form-control ">
                    @foreach($stat as $val)
                    <option value="{{$val}}" {{(isset($data['stat']) && $val == $data['stat']) ? 'selected' : ''}}>{{$val}}</option>
                    @endforeach
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
<script src="{{ asset('/js/asuransi-form.js?v=') . rand(1,9) }}"></script>