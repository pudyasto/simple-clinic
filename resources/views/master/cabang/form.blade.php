<form name="form_add" id="form_add" autocomplete="off" method="POST" action="{{$url}}">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ isset($data['id']) ? $data['id'] : '' }}">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" name="nama" id="nama" value="{{ isset($data['nama']) ? $data['nama'] : '' }}" required />
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">No. Telp</label>
                <input type="text" class="form-control" name="no_telp" id="no_telp" value="{{ isset($data['no_telp']) ? $data['no_telp'] : '' }}" />
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ isset($data['email']) ? $data['email'] : '' }}" />
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Alamat</label>
                <textarea class="form-control" name="alamat" id="alamat">{{ isset($data['alamat']) ? $data['alamat'] : '' }}</textarea>
            </div>
        </div>
        <div class="col-sm-12" style="display: none;">
            <div class="form-group mb-3">
                <label class="form-label">Jenis Cabang</label>
                <select name="jenis_cabang" id="jenis_cabang" class="form-control ">
                @foreach($jenis_cabang as $val)
                    <option value="{{$val}}" {{(isset($data['jenis_cabang']) && $val == $data['jenis_cabang']) ? 'selected' : ''}}>{{$val}}</option>
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
<script src="{{ asset('/js/cabang-form.js?v=') . rand(1,9) }}"></script>