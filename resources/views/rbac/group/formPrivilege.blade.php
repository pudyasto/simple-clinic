<div class="form-group mb-3">
    <button type="button" class="btn btn-sm btn-dark" data-bs-dismiss="modal" aria-label="Close">
        Tutup
    </button>
    <button type="button" class="btn btn-sm btn-light btn-refresh-privilege">
        Refresh
    </button>
</div>
<input type="hidden" name="group_id" id="group_id" value="{{ isset($data->id) ? $data->id : '' }}">
<div class="table-responsive mb-3">
    <table class="table" id="tablePrivilege" style="width: 100%;">
        <thead>
            <tr>
                <th style="width: 100px;text-align: center;">Set Akses</th>
                <th style="text-align: center;">Main Menu</th>
                <th style="text-align: center;">Sub Menu</th>
                <th style="width: 100px;text-align: center;">Tambah</th>
                <th style="width: 100px;text-align: center;">Edit</th>
                <th style="width: 100px;text-align: center;">Hapus</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Main Menu</th>
                <th>Sub Menu</th>
                <th>ID</th>
                <th>ID</th>
                <th>ID</th>
            </tr>
        </tfoot>
        <tbody></tbody>
    </table>
</div>
<div class="form-group">
    <button type="button" class="btn btn-sm btn-dark" data-bs-dismiss="modal" aria-label="Close">
        Tutup
    </button>
    <button type="button" class="btn btn-sm btn-light btn-refresh-privilege">
        Refresh
    </button>
</div>
<script src="{{ asset('/js/rbac/groupformPrivilege.js?v=') . rand(1,9) }}"></script>