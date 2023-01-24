<form name="form_add" id="form_add" autocomplete="off" method="POST" action="{{$url}}">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ isset($data['id']) ? $data['id'] : '' }}">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" class="form-control" name="nama" id="nama" value="{{ isset($data['nama']) ? $data['nama'] : '' }}" required />
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group mb-3">
                <label class="form-label">Jenis Barang</label>
                <select name="barang_jenis_id" id="barang_jenis_id" class="form-select "></select>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group mb-3">
                <label class="form-label">Kategori Barang</label>
                <select name="barang_kategori_id" id="barang_kategori_id" class="form-select "></select>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group mb-3">
                <label class="form-label">Satuan Barang</label>
                <select name="satuan" id="satuan" class="form-select "></select>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group mb-3">
                <label class="form-label">Harga Beli</label>
                <input type="text" class="form-control money" name="harga_beli" id="harga_beli" value="{{ isset($data['harga_beli']) ? $data['harga_beli'] : '0' }}" required />
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group mb-3">
                <label class="form-label">Margin Jual (%)</label>
                <input type="text" class="form-control money" name="margin_jual" id="margin_jual" value="{{ isset($data['margin_jual']) ? $data['margin_jual'] : '0' }}" required />
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group mb-3">
                <label class="form-label">Pembulatan</label>
                <input type="text" class="form-control money" name="pembulatan" id="pembulatan" value="{{ isset($data['pembulatan']) ? $data['pembulatan'] : '0' }}" required />
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Harga Jual</label>
                <input type="text" class="form-control money" name="harga_jual" id="harga_jual" value="{{ isset($data['harga_jual']) ? $data['harga_jual'] : '0' }}" required />
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
    var barang_jenis_id = "{{ isset($data['barang_jenis_id']) ? $data['barang_jenis_id'] : '' }}";
    var barang_kategori_id = "{{ isset($data['barang_kategori_id']) ? $data['barang_kategori_id'] : '' }}";
    var satuan = "{{ isset($data['satuan']) ? $data['satuan'] : '' }}";
</script>
<script src="{{ asset('/js/barang-form.js?v=') . rand(1,9) }}"></script>