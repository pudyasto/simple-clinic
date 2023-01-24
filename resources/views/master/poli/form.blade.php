<form name="form_add" id="form_add" autocomplete="off" method="POST" action="{{$url}}">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ isset($data['id']) ? $data['id'] : '' }}">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Kode</label>
                <input type="text" class="form-control" name="kode" id="kode" value="{{ isset($data['kode']) ? $data['kode'] : '' }}" />
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Nama Poli</label>
                <input type="text" class="form-control" name="nama" id="nama" value="{{ isset($data['nama']) ? $data['nama'] : '' }}" required />
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Status</label>
                <select class="form-control" name="stat" id="stat">
                    @foreach($stat as $val)
                    <option value="{{$val}}" {{ isset($data['stat']) && $data['stat']==$val ? 'selected' : '' }}>{{$val}}</option>
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
<script src="{{ asset('/js/poli-form.js?v=') . rand(1,9) }}"></script>