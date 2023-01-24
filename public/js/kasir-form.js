$(function () {
    $(".btn-refresh").click(function () {
        tableMain.ajax.reload();
    });

    tableMain = $('#tableMain').DataTable({
        bProcessing: true,
        bServerSide: true,
        paging: false,
        searching: false,
        columnDefs: [
            {
                "visible": false,
                "targets": 0
            },
            {
                "orderable": false,
                "targets": 4
            },
            {
                "visible": false,
                "targets": 5
            },
        ],
        "drawCallback": function (settings) {
            var api = this.api();
            var rows = api.rows({ page: 'current' }).nodes();
            var last = null;

            api.column(0, { page: 'current' }).data().each(function (group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                        '<tr class="group"><td colspan="5"><strong>' + group + '</strong></td></tr>'
                    );

                    last = group;
                }
            });
        },
        orderFixed: [0, 'desc'],
        order: [[1, 'asc']],
        lengthMenu: [[10, 25, 50, 100, 250], [10, 25, 50, 100, 250]],
        columns: [
            { "data": "jenis_pelayanan" },
            { "data": "nama" },
            {
                "data": "tarif",
                render: function (data, type, row) {
                    return numeral(data).format('0,0');
                }
            },
            {
                "data": "qty",
                render: function (data, type, row) {
                    return numeral(data).format('0,0');
                }
            },
            {
                "data": "subtotal",
                render: function (data, type, row) {
                    return numeral(data).format('0,0');
                }
            },
            { "data": "btn" },
        ],
        lengthMenu: [[-1], ['All']],
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                if (tableMain.hasOwnProperty('settings')) {
                    tableMain.settings()[0].jqXHR.abort();
                }
            },
            url: base_url('kasir/tablePembayaran'),
            method: 'POST',
            data: function (data) {
                data.registrasi_id = $('#registrasi_id').val();
            }
        },
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api();

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            console.log(total);
            $('#h_subtotal').val(numeral(total).format('0,0.00'));
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

    $('#h_bayar').on('keyup', function () {
        calcBayar();
    });

    $('.btn-bayar').on('click', function () {
        submitKasir();
    });
});

function calcBayar() {
    var subtotal = $('#h_subtotal').val();
    var bayar = $('#h_bayar').val();
    var kembali = numeral(bayar).value() - numeral(subtotal).value();
    $('#h_kembali').val(numeral(kembali).format('0,0.00'));
}

function submitKasir() {

    var registrasi_id = $('#registrasi_id').val();
    var kode_booking = $('#kode_booking').val();
    var subtotal = $('#h_subtotal').val();
    var bayar = $('#h_bayar').val();
    var kembali = $('#h_kembali').val();
    if(numeral(bayar).value()==0){
        toastbs('Jumlah pembayaran belum di isi', 'Kesalahan', 'error');
        return false;
    }
    swal({
        title: "Konfirmasi Pembayaran",
        text: "Lanjutkan pembayaran transaksi!",
        icon: "info",
        buttons: true,
        dangerMode: true,
    }).then((result) => {
        if (result) {
            $.ajax({
                type: "POST",
                url: base_url('kasir/submitKasir'),
                data: {
                    "registrasi_id": registrasi_id
                    , "subtotal": numeral(subtotal).value()
                    , "bayar": numeral(bayar).value()
                    , "kembali": numeral(kembali).value()
                    , '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (obj) {
                    if (obj.metadata.code === 200) {
                        window.open(base_url('kasir/print?id=' + registrasi_id + '&kode=' + kode_booking + ''));
                        location.replace(base_url('kasir'));
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