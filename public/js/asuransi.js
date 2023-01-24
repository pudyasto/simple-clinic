
$(function () {
    $(".btn-refresh").click(function () {
        tableMain.ajax.reload();
    });

    tableMain = $('#tableMain').DataTable({
        bProcessing: true,
        bServerSide: true,
        columnDefs: [{
            "orderable": false,
            "targets": 3
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
                if (tableMain.hasOwnProperty('settings')) {
                    tableMain.settings()[0].jqXHR.abort();
                }
            },
            url: base_url('asuransi/tableMain'),
            method: 'POST'
        },
        sDom: "<'row'<'col-sm-6 mb-0' l ><'col-sm-6 mb-0 text-end'>> t <'row'<'col-sm-6 mb-0' i><'col-sm-6 mb-0 text-end' p>> ",
        oLanguage: datatableLang
    });


    $('#tableMain tfoot th').each(function () {
        var title = $('#tableMain tfoot th').eq($(this).index()).text();
        if (title !== "ID") {
            $(this).html('<input type="text" class="form-control form-control-sm form-datatable" style="width:100%;border-radius: 0px;" placeholder="Cari ' + title + '" />');
        } else {
            $(this).html('');
        }
    });
    tableMain.columns().every(function () {
        var that = this;
        $('input', this.footer()).on('keyup change', function (ev) {
            //if (ev.keyCode == 13) { //only on enter keypress (code 13)
            that
                .search(this.value)
                .draw();
            //}
        });
    });
});


function deleteData(id) {
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
                url: base_url('asuransi/deleteData'),
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