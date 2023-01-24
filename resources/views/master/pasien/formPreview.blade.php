<div class="row">
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label class="form-label">Nama Pasien</label>
            <div class="form-control">{{ isset($data['nama_pasien']) ? $data['nama_pasien'] : '' }}</div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label class="form-label">No. KTP</label>
            <div class="form-control">{{ isset($data['no_identitas']) ? $data['no_identitas'] : '' }}</div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-3">
            <label class="form-label">Tempat Lahir</label>
            <div class="form-control">{{ isset($data['tmp_lahir']) ? ($data['tmp_lahir']) : '' }}</div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-3">
            <label class="form-label">Tanggal Lahir</label>
            <div class="form-control">{{ isset($data['tgl_lahir']) ? dateconvert($data['tgl_lahir']) : '' }}</div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <div class="form-control">{{ isset($data['jenis_kelamin']) ? ($data['jenis_kelamin']) : '' }}</div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-3">
            <label class="form-label">Agama</label>
            <div class="form-control">{{ isset($data['agama']) ? ($data['agama']) : '' }}</div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-3">
            <label class="form-label">Pekerjaan</label>
            <div class="form-control">{{ isset($data['pekerjaan']) ? ($data['pekerjaan']) : '' }}</div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-3">
            <label class="form-label">Golongan Darah</label>
            <div class="form-control">{{ isset($data['gol_darah']) ? ($data['gol_darah']) : '' }}</div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label class="form-label">Alamat</label>
            <div class="form-control">{{ isset($data['alamat']) ? ($data['alamat']) : '' }}</div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-3">
            <label class="form-label">No. Telp</label>
            <div class="form-control">{{ isset($data['no_telp']) ? ($data['no_telp']) : '' }}</div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-3">
            <label class="form-label">Email</label>
            <div class="form-control">{{ isset($data['email']) ? ($data['email']) : '' }}</div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-3">
            <label class="form-label">Riwayat Alergi</label>
            <div class="form-control" style="min-height: 50px;">{{ isset($data['alergi']) ? ($data['alergi']) : '' }}</div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group mb-3">
            <label class="form-label">Riwayat Penyakit</label>
            <div class="form-control" style="min-height: 50px;">{{ isset($data['penyakit']) ? ($data['penyakit']) : '' }}</div>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal" aria-label="Close">
        Tutup
    </button>
</div>