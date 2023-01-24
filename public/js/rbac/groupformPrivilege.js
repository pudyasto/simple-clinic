
$(function () {
    $(".btn-refresh-privilege").click(function () {
        tablePrivilege.ajax.reload();
    });

    tablePrivilege = $('#tablePrivilege').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [[-1], ['all']],
        columns: [
            { "data": "set_access","orderable": false, },
            { "data": "menu_name" },
            { "data": "submenu" },
            { "data": "insert" ,"orderable": false,},
            { "data": "update","orderable": false, },
            { "data": "delete" ,"orderable": false,}
        ],
        orderFixed: [
            [1, "asc"], [2, "asc"],
        ],
        order: [
            [1, "asc"], [2, "asc"],
        ],
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                if (tablePrivilege.hasOwnProperty('settings')) {
                    tablePrivilege.settings()[0].jqXHR.abort();
                }
            },
            url: base_url('group/tablePrivilege'),
            data: function (d) {
                d.group_id = $("#group_id").val()
            },
            method: 'POST'
        },
        sDom: "<'row'<'col-sm-6 mb-0' ><'col-sm-6 mb-0 text-end'>> t <'row'<'col-sm-6 mb-0' i><'col-sm-6 mb-0 text-end' p>> ",
        oLanguage: datatableLang
    });


    $('#tablePrivilege tfoot th').each(function () {
        var title = $('#tablePrivilege tfoot th').eq($(this).index()).text();
        if (title !== "ID") {
            $(this).html('<input type="text" class="form-control form-control-sm" placeholder="Cari ' + title + '" />');
        } else {
            $(this).html('');
        }
    });

    tablePrivilege.columns().every(function () {
        var that = this;
        $('input', this.footer()).on('keyup change', function (ev) {
            that
                .search(this.value)
                .draw();
        });
    });
});

function set_submenu(menu_id) {
    var group_id = $("#group_id").val();
    var submit = base_url('group/insertGroupAccess');
    $.ajax({
        type: "POST",
        url: submit,
        data: {
            "group_id": group_id, "menu_id": menu_id
            , "privilege": "1,1,1", "stat": "submenu"
            , "_token": $('meta[name="csrf-token"]').attr('content')
        },
        success: function (obj) {
            if (obj.metadata.code === 200) {
                toastbs(obj.metadata.message, 'Berhasil', 'success');
            } else {
                toastbs(obj.metadata.message, 'Kesalahan', 'error');
            }
            tablePrivilege.ajax.reload();
        }
    });

}

function set_access(menu_id) {
    var group_id = $("#group_id").val();
    var submit = base_url('group/insertGroupAccess');
    var T = "";
    var E = "";
    var H = "";
    var privilege = "0,0,0";
    if ($("#T" + menu_id).prop("checked")) {
        T = "1";
    } else {
        T = "0";
    }
    if ($("#E" + menu_id).is(":checked")) {
        E = "1";
    } else {
        E = "0";
    }
    if ($("#H" + menu_id).is(":checked")) {
        H = "1";
    } else {
        H = "0";
    }
    privilege = T + "," + E + "," + H;
    $.ajax({
        type: "POST",
        url: submit,
        data: {
            "group_id": group_id, "menu_id": menu_id
            , "privilege": privilege, "stat": "access"
            , "_token": $('meta[name="csrf-token"]').attr('content')
        },
        success: function (obj) {
            if (obj.metadata.code === 200) {
                toastbs(obj.metadata.message, 'Berhasil', 'success');
            } else {
                toastbs(obj.metadata.message, 'Kesalahan', 'error');
            }
            tablePrivilege.ajax.reload();
        }
    });
}   