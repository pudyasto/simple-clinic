$(function () {
    $(".btn-submit").click(function () {
        submit();
    });

    $("#prov_id").on("change", function () {
        getKota();
    });

    $("#kota_id").on("change", function () {
        getKecamatan();
    });

    $("#kec_id").on("change", function () {
        getKelurahan();
    });

    if ($("#prov_id").val()) {
        getKota();
    }
});

function getKota() {
    $.ajax({
        type: "GET",
        url: base_url('reference/getKota'),
        data: {
            "prov_id": $('#prov_id').val()
        },
        beforeSend: function () {
        },
        success: function (obj) {
            if (obj.metadata.code === 200) {
                $('#kota_id').html('<option value="">-- Pilih Kota/Kab --</option>');
                var response = obj.response;
                response.forEach(element => {
                    $('#kota_id').append($('<option>', {
                        value: element.kota_id,
                        text: element.kota_nama
                    }));
                });
                $('#kota_id').val(kota_id);
                getKecamatan();
            } else {
                toastbs(obj.metadata.message, 'Kesalahan', 'error');
            }
        },
        error: function (event, textStatus, errorThrown) {
            pharseError(event, errorThrown);
        }
    });
}

function getKecamatan() {
    $.ajax({
        type: "GET",
        url: base_url('reference/getKecamatan'),
        data: {
            "kota_id": $('#kota_id').val()
        },
        beforeSend: function () {
        },
        success: function (obj) {
            if (obj.metadata.code === 200) {
                $('#kec_id').html('<option value="">-- Pilih Kecamatan --</option>');
                var response = obj.response;
                response.forEach(element => {
                    $('#kec_id').append($('<option>', {
                        value: element.kec_id,
                        text: element.kec_nama,
                    }));
                });
                if (kec_id) {
                    $("#kec_id option").each(function () {
                        if (Number($(this).val()) == Number(kec_id)) {
                            $(this).attr("selected", "selected");
                        }
                    });
                }
                getKelurahan();
            } else {
                toastbs(obj.metadata.message, 'Kesalahan', 'error');
            }
        },
        error: function (event, textStatus, errorThrown) {
            pharseError(event, errorThrown);
        }
    });
}

function getKelurahan() {
    $.ajax({
        type: "GET",
        url: base_url('reference/getKelurahan'),
        data: {
            "kec_id": $('#kec_id').val()
        },
        beforeSend: function () {
        },
        success: function (obj) {
            if (obj.metadata.code === 200) {
                $('#kel_id').html('<option value="">-- Pilih Kelurahan --</option>');
                var response = obj.response;
                response.forEach(element => {
                    $('#kel_id').append($('<option>', {
                        value: element.kel_id,
                        text: element.kel_nama,
                        selected: (element.kel_id == kel_id) ? true : false,
                    }));
                });
                if (kel_id) {
                    $("#kel_id option").each(function () {
                        if (Number($(this).val()) == Number(kel_id)) {
                            $(this).attr("selected", "selected");
                        }
                    });
                }
            } else {
                toastbs(obj.metadata.message, 'Kesalahan', 'error');
            }
        },
        error: function (event, textStatus, errorThrown) {
            pharseError(event, errorThrown);
        }
    });
}

function submit() {
    $("#form_pasien").ajaxForm({
        type: "POST",
        url: $("#form_pasien").attr('action'),
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