<form name="form_pasien" id="form_pasien" autocomplete="off" method="POST" action="{{$url}}">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ isset($data['id']) ? $data['id'] : '' }}">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Nama Pasien</label>
                <input type="text" class="form-control" name="nama_pasien" id="nama_pasien" value="{{ isset($data['nama_pasien']) ? $data['nama_pasien'] : '' }}" required />
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">No. KTP</label>
                <input type="text" class="form-control" name="no_identitas" id="no_identitas" value="{{ isset($data['no_identitas']) ? $data['no_identitas'] : '' }}" />
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" name="tmp_lahir" id="tmp_lahir" value="{{ isset($data['tmp_lahir']) ? ($data['tmp_lahir']) : '' }}" />
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="text" class="form-control date-mask" name="tgl_lahir" id="tgl_lahir" value="{{ isset($data['tgl_lahir']) ? dateconvert($data['tgl_lahir']) : '' }}" required />
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select class="form-select" name="jenis_kelamin" id="jenis_kelamin">
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    @foreach($jenis_kelamin as $val)
                    <option value="{{$val}}" {{ isset($data['jenis_kelamin']) && $data['jenis_kelamin']==$val ? 'selected' : '' }}>{{$val}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">Agama</label>
                <select class="form-select" name="agama" id="agama">
                    <option value="">-- Pilih Agama --</option>
                    @foreach($agama as $val)
                    <option value="{{$val}}" {{ isset($data['agama']) && $data['agama']==$val ? 'selected' : '' }}>{{$val}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">Pekerjaan</label>
                <select class="form-select" name="pekerjaan" id="pekerjaan">
                    <option value="">-- Pilih Pekerjaan --</option>
                    @foreach($pekerjaan as $val)
                    <option value="{{$val}}" {{ isset($data['pekerjaan']) && $data['pekerjaan']==$val ? 'selected' : '' }}>{{$val}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">Golongan Darah</label>
                <select class="form-select" name="gol_darah" id="gol_darah">
                    <option value="">-- Pilih Golongan Darah --</option>
                    @foreach($gol_darah as $val)
                    <option value="{{$val}}" {{ isset($data['gol_darah']) && $data['gol_darah']==$val ? 'selected' : '' }}>{{$val}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Alamat</label>
                <textarea rows="3" class="form-control" name="alamat" id="alamat">{{ isset($data['alamat']) ? $data['alamat'] : '' }}</textarea>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group mb-3">
                <label class="form-label">Provinsi</label>
                <select class="form-select" name="prov_id" id="prov_id">
                    <option value="">-- Pilih Provinsi --</option>
                    @foreach($prov_id as $val)
                    <option value="{{$val->prov_id}}" {{ isset($data['prov_id']) && $data['prov_id']==$val->prov_id ? 'selected' : '' }}>{{$val->prov_nama}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group mb-3">
                <label class="form-label">Kota</label>
                <select class="form-select" name="kota_id" id="kota_id">
                    <option value="">-- Pilih Kota/Kab --</option>
                </select>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group mb-3">
                <label class="form-label">Kecamatan</label>
                <select class="form-select" name="kec_id" id="kec_id">
                    <option value="">-- Pilih Kecamatan --</option>
                </select>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group mb-3">
                <label class="form-label">Kelurahan</label>
                <select class="form-select" name="kel_id" id="kel_id">
                    <option value="">-- Pilih Kelurahan --</option>
                </select>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">No. Telp</label>
                <input type="text" class="form-control" name="no_telp" id="no_telp" value="{{ isset($data['no_telp']) ? ($data['no_telp']) : '' }}" />
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ isset($data['email']) ? ($data['email']) : '' }}" />
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">Riwayat Alergi</label>
                <textarea rows="2" class="form-control" name="alergi" id="alergi">{{ isset($data['alergi']) ? $data['alergi'] : '' }}</textarea>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label">Riwayat Penyakit</label>
                <textarea rows="2" class="form-control" name="penyakit" id="penyakit">{{ isset($data['penyakit']) ? $data['penyakit'] : '' }}</textarea>
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
    var kota_id = "{{ isset($data['kota_id']) ? ($data['kota_id']) : '' }}";
    var kec_id  = "{{ isset($data['kec_id']) ? ($data['kec_id']) : '' }}";
    var kel_id  = "{{ isset($data['kel_id']) ? ($data['kel_id']) : '' }}";
</script>
<script src="{{ asset('/js/pasien-form.js?v=') . rand(1,9) }}"></script>