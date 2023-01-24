$(function () {
    $(".btn-submit").click(function () {
        submit();
    });

    $(".btn-refresh-detail").click(function () {
        tableDetail.ajax.reload();
        tableMain.ajax.reload();
    });

    tableDetail = $('#tableDetail').DataTable({
        bProcessing: true,
        bServerSide: true,
        columnDefs: [{
            "orderable": false,
            "targets": 2
        }],
        lengthMenu: [[10, 25, 50, 100, 250], [10, 25, 50, 100, 250]],
        columns: [
            {"data": "kode"},
            {"data": "nama"},
            {"data": "stat"},
            {"data": "btn"}
        ],
        order: [
            [0, "asc"],
        ],
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                if (tableDetail.hasOwnProperty('settings')) {
                    tableDetail.settings()[0].jqXHR.abort();
                }
            },
            url: base_url('poli/tableDetail'),
            data: function (d) {
                d.poli_id = $("#poli_id").val()
            },
            method: 'POST'
        },
        sDom: "<'row'<'col-sm-6 mb-0' l ><'col-sm-6 mb-0 text-end'>> t <'row'<'col-sm-6 mb-0' i><'col-sm-6 mb-0 text-end' p>> ",
        oLanguage: datatableLang
    });

    $('#tableDetail tfoot th').each(function () {
        var title = $('#tableDetail tfoot th').eq($(this).index()).text();
        if (title !== "ID") {
            $(this).html('<input type="text" class="form-control form-control-sm form-datatable" style="width:100%;border-radius: 0px;" placeholder="Cari ' + title + '" />');
        } else {
            $(this).html('');
        }
    });

    tableDetail.columns().every(function () {
        var that = this;
        $('input', this.footer()).on('keyup change', function (ev) {
            //if (ev.keyCode == 13) { //only on enter keypress (code 13)
            that
                .search(this.value)
                .draw();
            //}
        });
    });

    $('#tableDetail tbody').on('click', 'button.btn-edit-detail', function () {
        var data = tableDetail.row($(this).parents('tr')).data();
        $("#id").val(data.id);
        $("#kode").val(data.kode);
        $("#nama").val(data.nama);
        $("#stat").val(data.stat);
    });

    $('#tableDetail tbody').on('click', 'button.btn-delete-detail', function () {
        var data = tableDetail.row($(this).parents('tr')).data();
        deleteDetail(data.id);
    });

});

function submit() {
    $("#form_add").ajaxForm({
        type: "POST",
        url: $("#form_add").attr('action'),
        data: {
            "request": true
        },
        beforeSend: function (result) {
            disabled();
        },
        success: function (obj) {
            enabled();
            if (obj.metadata.code === 200) {
                toastbs(obj.metadata.message, 'Berhasil', 'success');
                tableDetail.ajax.reload();
                $("#id").val('');
                $("#kode").val('');
                $("#nama").val('');
                $("#stat").val('Aktif');
            } else {
                toastbs(obj.metadata.message, 'Kesalahan', 'error');
            }
        },
        error: function (event, textStatus, errorThrown) {
            enabled();
            pharseError(event, errorThrown);
        }
    });
}

function deleteDetail(id) {
    swal({
        title: "Konfirmasi Hapus",
        text: "Data yang dihapus, tidak dapat dikembalikan!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((result) => {
        if (result) {
            $.ajax({
                type: "POST",
                url: base_url('poli/deleteSubSpesialis'),
                data: {
                    "id": id
                    , "stat": "delete"
                    , '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (obj) {
                    if (obj.metadata.code === 200) {
                        $(".btn-refresh").click();
                        toastbs(obj.metadata.message, 'Berhasil', 'success');
                    } else {
                        toastbs(obj.metadata.message, 'Kesalahan', 'error');
                    }
                },
                error: function (event, textStatus, errorThrown) {
                    pharseError(event, errorThrown);
                }
            });
        }
    });
}