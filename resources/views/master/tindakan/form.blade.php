<form name="form_add" id="form_add" autocomplete="off" method="POST" action="{{$url}}">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ isset($data['id']) ? $data['id'] : '' }}">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Nama Tindakan</label>
                <input type="text" class="form-control" name="nama" id="nama" value="{{ isset($data['nama']) ? $data['nama'] : '' }}" required />
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Kode ICD9 <small>(Opsional)</small></label>
                <select name="icd9" id="icd9" class="form-select ">
                </select>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Tarif</label>
                <input type="text" class="form-control qty" name="tarif" id="tarif" value="{{ isset($data['tarif']) ? number_format($data['tarif'],0) : '' }}" />
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Status Aktif</label>
                <select name="stat" id="stat" class="form-select ">
                @foreach($stat as $val)
                    <option value="{{$val}}" {{(isset($data['stat']) && $val == $data['stat']) ? 'selected' : ''}}>{{$val}}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-12 lokasi-pusat" style="display: none;">
            <div class="form-group mb-3">
                <label class="form-label">Lokasi Pusat</label>
                <select name="main_id" id="main_id" class="form-control ">
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
    var icd9 = "{{ isset($data['icd9']) ? $data['icd9'] : '' }}";
</script>
<script src="{{ asset('/js/tindakan-form.js?v=') . rand(1,9) }}"></script>