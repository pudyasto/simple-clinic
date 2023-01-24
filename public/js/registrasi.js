$(function () {
    $("#pasien_id").select2({
        placeholder: 'Masukkan Nomor RM / Nama Pasien',
        allowClear: true,
        width: 'resolve',
        ajax: {
            url: base_url('reference/getPasien/'),
            type: 'GET',
            dataType: 'json',
            delay: 500,
            data: function (params) {
                var query = {
                    q: params.term,
                    page: params.page || 1,
                    limit: 10
                };
                return query;
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true,
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: formatResultPasien,
        templateSelection: formatSelection
    });

    $("#poli_id").select2({
        placeholder: 'Masukkan Nomor Poli',
        allowClear: true,
        width: '100%',
        ajax: {
            url: base_url('reference/getPoli/'),
            type: 'GET',
            dataType: 'json',
            delay: 500,
            data: function (params) {
                var query = {
                    q: params.term,
                    page: params.page || 1,
                    limit: 10
                };
                return query;
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true,
        },
        escapeMarkup: function (markup) {
            return markup;
        },
    });

    $("#pegawai_id").select2({
        placeholder: 'Masukkan Dokter',
        allowClear: true,
        width: '100%',
        ajax: {
            url: base_url('reference/getDokter/'),
            type: 'GET',
            dataType: 'json',
            delay: 500,
            data: function (params) {
                var query = {
                    q: params.term,
                    poli_id: $('#poli_id').val(),
                    page: params.page || 1,
                    limit: 10
                };
                return query;
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true,
        },
        escapeMarkup: function (markup) {
            return markup;
        },
    });

    getPoli(47);


    $(".btn-submit-registrasi").click(function () {
        submitRegistrasi();
    });

    tableMain = $('#tableMain').DataTable({
        bProcessing: true,
        bServerSide: true,
        columnDefs: [{
            "orderable": false,
            "targets": 6
        }],
        lengthMenu: [[10, 25, 50, 100, 250], [10, 25, 50, 100, 250]],
        columns: [
            { "data": "tgl_kunjungan" },
            { "data": "kode" },
            { "data": "pasien.no_rm" },
            { "data": "pasien.nama_pasien" },
            { "data": "pegawai.nama" },
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
            url: base_url('registrasi/tableMain'),
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

function submitRegistrasi() {
    $("#form_registrasi").ajaxForm({
        type: "POST",
        url: $("#form_registrasi").attr('action'),
        data: {
            "request": true
        },
        beforeSend: function (result) {
            disabled();
        },
        success: function (obj) {
            enabled();
            if (obj.metadata.code === 200) {
                swal({
                    title: "Berhasil",
                    text: obj.metadata.message,
                    icon: "success",
                });
                tableMain.ajax.reload();
                resetForm();
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

function getPasien(id) {
    if (id) {
        var pasien_id = $('#pasien_id');
        $.ajax({
            url: base_url('reference/getPasien/'),
            type: 'GET',
            dataType: 'json',
            delay: 250,
            data: {
                id: id
            },
            beforeSend: function () {

            },
        }).then(function (data) {

            // create the option and append to Select2
            $.each(data.results, function (i, val) {
                var option = new Option(val.text, val.id, true, true);
                pasien_id.append(option).trigger('change');
            });

            // manually trigger the `select2:select` event
            pasien_id.trigger({
                type: 'change.select2',
                params: {
                    data: data
                }
            });
        });
    }
}

function getPoli(id) {
    if (id) {
        var poli_id = $('#poli_id');
        $.ajax({
            url: base_url('reference/getPoli/'),
            type: 'GET',
            dataType: 'json',
            delay: 250,
            data: {
                id: id
            },
            beforeSend: function () {

            },
        }).then(function (data) {

            // create the option and append to Select2
            $.each(data.results, function (i, val) {
                var option = new Option(val.text, val.id, true, true);
                poli_id.append(option).trigger('change');
            });

            // manually trigger the `select2:select` event
            poli_id.trigger({
                type: 'change.select2',
                params: {
                    data: data
                }
            });
        });
    }
}

function getDokter(id) {
    if (id) {
        var pegawai_id = $('#pegawai_id');
        $.ajax({
            url: base_url('reference/getDokter/'),
            type: 'GET',
            dataType: 'json',
            delay: 250,
            data: {
                id: id
            },
            beforeSend: function () {

            },
        }).then(function (data) {

            // create the option and append to Select2
            $.each(data.results, function (i, val) {
                var option = new Option(val.text, val.id, true, true);
                pegawai_id.append(option).trigger('change');
            });

            // manually trigger the `select2:select` event
            pegawai_id.trigger({
                type: 'change.select2',
                params: {
                    data: data
                }
            });
        });
    }
}

function batalRegistrasi(id) {
    swal({
        title: "Konfirmasi",
        text: "Masukkan alasan pembatalan",
        icon: "info",
        content: "input",
        buttons: true,
        dangerMode: true,
    }).then((value) => {
        if (value == '') {
            swal({
                title: "Kesalahan",
                text: "Alasan pembatalan wajib diisi!",
                icon: "error",
            }).then((value) => {
                batalRegistrasi()
            });
        } else {
            
            if(value!==null){
                $.ajax({
                    type: "POST",
                    url: base_url('registrasi/batalRegistrasi'),
                    data: {
                        "id": id
                        , "keterangan_batal": value
                        , '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (obj) {
                        if (obj.metadata.code === 200) {
                            $(".btn-refresh").click();
                            toastbs(obj.metadata.message, 'Berhasil', 'success');
                            swal({
                                title: "Sukses",
                                text: "Pendaftaran berhasil dibatalkan!",
                                icon: "success",
                            });
                        } else {
                            toastbs(obj.metadata.message, 'Kesalahan', 'error');
                        }
                    },
                    error: function (event, textStatus, errorThrown) {
                        pharseError(event, errorThrown);
                    }
                });
            }
            
        }
    });
}

function resetForm(){
    $("#id").val('');
    $("#keluhan").val('');
    $("#pasien_id").val(null).trigger('change');
    $("#pegawai_id").val(null).trigger('change');
}