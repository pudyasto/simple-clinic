<form name="form_add" id="form_add" autocomplete="off" method="POST" action="{{$url}}">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ isset($data['id']) ? $data['id'] : '' }}">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Pilih data pegawai</label>
                <select class="form-control" name="pegawai_id" id="pegawai_id">
                    @foreach($pegawai_id as $val)
                    <option value="{{$val->id}}" {{ isset($data['pegawai_id']) && $data['pegawai_id']==$val->id ? 'selected' : '' }}>{{$val->nama}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label>Nama Lengkap</label>
                <div class="form-line">
                    <input type="text" class="form-control" name="name" id="name" value="{{ isset($data['name']) ? $data['name'] : '' }}"/>
                </div>
            </div>
            <div class="form-group mb-3">
                <label>Nama Pengguna</label>
                <div class="form-line">
                    <input type="text" class="form-control" name="username" id="username" value="{{ isset($data['username']) ? $data['username'] : '' }}" required/>
                </div>
            </div>
            <div class="form-group mb-3">
                <label>Alamat Email</label>
                <div class="form-line">
                    <input type="email" class="form-control" name="email" id="email" value="{{ isset($data['email']) ? $data['email'] : '' }}" required/>
                </div>
            </div>
            <div class="form-group mb-3">
                <label>Password</label>
                <div class="form-line">
                    <input type="password" class="form-control" name="password" id="password" />
                </div>
            </div>
            <div class="form-group mb-3">
                <label>Grup Pengguna</label>
                <div class="form-line">
                    <select class="form-control" name="group_id" id="group_id">
                    </select>
                </div>
            </div>
            <div class="form-group mb-3" style="display: none;">
                <label>Status Pengguna</label>
                <div class="form-line">
                    <select class="form-control" name="is_active" id="is_active">
                        @foreach($is_active as $key => $val)
                            <option value="{{$key}}">{{$val}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group mb-3">
        <button type="submit" class="btn btn-primary btn-sm btn-submit">
            Simpan
        </button>
        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal" aria-label="Close">
            Tutup
        </button>
    </div>
</form>
<script>
    var group_id = "{{(isset($data['group_id'])) ? $data['group_id'] : ''}}";
</script>
<script src="{{ asset('/js/rbac/userform.js?v=') . rand(1,9) }}"></script>