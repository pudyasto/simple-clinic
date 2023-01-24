<form name="form_add" id="form_add" autocomplete="off" method="POST" action="{{$url}}">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ isset($data['id']) ? $data['id'] : '' }}">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label class="form-label">Nama Group</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ isset($data['name']) ? $data['name'] : '' }}" required />
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea rows="4" class="form-control no-resize" name="description" id="description">{{ isset($data['description']) ? $data['description'] : '' }}</textarea>
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
<script src="{{ asset('/js/rbac/groupform.js?v=') . rand(1,9) }}"></script>