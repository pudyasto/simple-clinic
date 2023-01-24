<form name="form_add" id="form_add" autocomplete="off" method="POST" action="{{$url}}">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ isset($data['id']) ? $data['id'] : '' }}">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="col-form-label pt-0">Nama Menu</label>
                <input class="form-control " type="text" name="menu_name" id="menu_name" value="{{ isset($data['menu_name']) ? $data['menu_name'] : '' }}" required>
            </div>
            <div class="form-group mb-3">
                <input type="checkbox" id="chk_main_menu" name="chk_main_menu" class="filled-in" {{ (!isset($data['link']) || (isset($data['link']) && ($data['link']=='#' || $data['menu_header']!==''))) ? 'checked' : '' }}>
                <label for="chk_main_menu">Menu Utama ( Centang jika ini adalah menu utama )</label>
            </div>
            <div class="form-group mb-3 header-menu">
                <label class="col-form-label pt-0">Nama Menu Header</label>
                <input class="form-control " type="text" name="menu_header" id="menu_header" value="{{ isset($data['menu_header']) ? $data['menu_header'] : '' }}">
            </div>
            <div class="form-group mb-3 form-mainmenu">
                <label class="col-form-label pt-0">Parent Menu</label>
                <div class="form-line">
                    <select class="form-select " name="main_id" id="main_id"></select>
                </div>
            </div>
            <div class="form-group mb-3">
                <label class="col-form-label pt-0">Urutan Menu</label>
                <input class="form-control " type="text" name="menu_order" id="menu_order" value="{{ isset($data['menu_order']) ? $data['menu_order'] : '' }}">
            </div>
            <div class="form-group mb-3">
                <label class="col-form-label pt-0">Class Menu</label>
                <input class="form-control " type="text" name="link" id="link" value="{{ isset($data['link']) ? $data['link'] : '' }}" required>
            </div>
            <div class="form-group mb-3">
                <label class="col-form-label pt-0">Icon Menu</label>
                <input class="form-control " type="text" name="icon" id="icon" value="{{ isset($data['icon']) ? $data['icon'] : '-' }}" required>
            </div>
            <div class="form-group mb-3">
                <label class="col-form-label pt-0">Keterangan</label>
                <textarea rows="4" class="form-control no-resize" name="description" id="description" placeholder="Deskripsi">{{ isset($data['description']) ? $data['description'] : '' }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label class="col-form-label pt-0">Status Menu</label>
                <select class="form-select" name="is_active" id="is_active">
                    @foreach($is_active as $key => $val)
                    <option value="{{$key}}" {{ isset($data['is_active']) && $data['is_active']==$key ? 'selected' : '' }}>{{$val}}</option>
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

<script>
    var main_id = "{{(isset($data['main_id'])) ? $data['main_id'] : ''}}";
    var link = "{{(isset($data['link'])) ? $data['link'] : ''}}";
</script>
<script src="{{ asset('/js/rbac/menuform.js?v=') . rand(1,9) }}"></script>