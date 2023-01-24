<form name="form_add" id="form_add" autocomplete="off" method="POST" action="{{$url}}">
    @csrf
    <input type="hidden" name="poli_id" id="poli_id" value="{{ isset($poli_id) ? $poli_id : '' }}">
    <input type="hidden" name="id" id="id" value="">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Kode Sub Spesialis</label>
                <input type="text" class="form-control" name="kode" id="kode" value="" />
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Nama Sub Spesialis</label>
                <input type="text" class="form-control" name="nama" id="nama" value="" required />
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
        <button type="button" class="btn btn-light btn-refresh-detail">Refresh</button>
    </div>
</form>

<div class="table-responsive mt-3">
    <table id="tableDetail" class="display">
        <thead>
            <tr>
                <th style="width: 90px;text-align: center;">Kode</th>
                <th style="text-align: center;">Nama Sub Spesialis</th>
                <th style="width: 90px;text-align: center;">Status</th>
                <th style="width: 200px;text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Kode Sub Spesialis</th>
                <th>Nama Sub Spesialis</th>
                <th>Status</th>
                <th>ID</th>
            </tr>
        </tfoot>
        <tbody>
        </tbody>
    </table>
</div>
<script src="{{ asset('/js/poli-form-subspesialis.js?v=') . rand(1,9) }}"></script>