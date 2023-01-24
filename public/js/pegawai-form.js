$(function () {
    $(".btn-submit").click(function () {
        submit();
    });

    $('#jenis_pegawai_id').on('change', function () {
        cekPoli();
    });

    $("#poli_id").select2({
        placeholder: 'Masukkan Nama Poli',
        allowClear: true,
        width: '100%',
        dropdownParent: $('#form-modal'),
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

    $("#poli_sub_id").select2({
        placeholder: 'Masukkan Nama Sub Spesialis',
        allowClear: true,
        width: '100%',
        dropdownParent: $('#form-modal'),
        ajax: {
            url: base_url('reference/getPoliSub/'),
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

    if (poli_id) {
        getPoli(poli_id);
    }

    if (poli_sub_id) {
        getPoliSub(poli_sub_id)
    }
    
    cekPoli();
});

function cekPoli() {
    var jenis_pegawai = $("#jenis_pegawai_id option:selected").text();
    if (jenis_pegawai.toLowerCase() == 'dokter') {
        if (poli_id) {
            getPoli(poli_id);
        } else {
            getPoli(47);
        }

        if (poli_sub_id) {
            getPoliSub(poli_sub_id)
        } else {
            getPoliSub(201)
        }

        $('.poli').show('fast');
    } else {

        $('.poli').hide('fast');
        $('#poli_id').val(null).trigger('change');
        $('#poli_sub_id').val(null).trigger('change');
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

function getPoliSub(id) {
    if (id) {
        var poli_sub_id = $('#poli_sub_id');
        $.ajax({
            url: base_url('reference/getPoliSub/'),
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
                poli_sub_id.append(option).trigger('change');
            });

            // manually trigger the `select2:select` event
            poli_sub_id.trigger({
                type: 'change.select2',
                params: {
                    data: data
                }
            });
        });
    }
}

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
                tableMain.ajax.reload();
                $('#form-modal').modal("hide");
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