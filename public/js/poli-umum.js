$(function () {
    $(".btn-refresh").click(function () {
        setTimeout(function () {
            tableMain.ajax.reload();
        }, 100);
    });

    $('#tgl_mulai').on("selectDate", function (e) {
        $(".btn-refresh").click();
    });

    $('#tgl_selesai').on("selectDate", function (e) {
        $(".btn-refresh").click();
    });

    tableMain = $('#tableMain').DataTable({
        bProcessing: true,
        bServerSide: true,
        columnDefs: [{
            "orderable": false,
            "targets": 5
        }],
        lengthMenu: [[10, 25, 50, 100, 250], [10, 25, 50, 100, 250]],
        columns: [
            {
                "data": "tgl_kunjungan",
                render: function (data, type, row) {
                    return tgl_id_short(data);
                },
                className: 'text-center'
            },
            { "data": "kode" },
            { "data": "pasien.no_rm" },
            { "data": "pasien.nama_pasien" },
            { "data": "keluhan" },
            { "data": "btn" },
        ],
        order: [
            [0, "desc"],
            [1, "desc"],
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
            url: base_url('reference/getPoliRegistrasi'),
            method: 'POST',
            data: function (data) {
                data.tgl_mulai = $('#tgl_mulai').val();
                data.tgl_selesai = $('#tgl_selesai').val();
                data.poli_id = $('#poli_id').val();
            }
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


    $('#tableMain tbody').on('click', 'button.btn-edit', function () {
        var data = tableMain.row($(this).parents('tr')).data();
        console.log(data);
        getPasien(data.pasien_id);
        getPoli(data.poli_id);
        getDokter(data.pegawai_id);
        $("#id").val(data.id);
        $("#keluhan").val(data.keluhan);
    });
});